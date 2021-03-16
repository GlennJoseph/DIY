var settings;

// GET TEMPLATES
if(window.location.pathname.includes('preview-template')){
    // initializing settings
    settings = {
        url: "../php/actions.php",
        type:"POST",
        data: JSON.stringify({action: 'get_Templates'})
    };
    // run templates
    let templates = doAjax(settings);
        templates.then(resp => {
            let data = JSON.parse(resp);
            if(data.status){
                displayTemplates(data.response);
            } else {
                console.error(data.response);
            }
        });
}

if(window.location.pathname.includes('sign-up')){
    displayForm();
    // upon clicking submit
    $('.signUpForm-button').click(function(e){
        e.preventDefault();
        // initializing settings
        settings = {
            url: "../php/actions.php",
            type:"POST",
            data: JSON.stringify({
                action: "sign_Up",
                account_name: $('.signUpForm').find('.email input').val(),
                first_name: $('.signUpForm').find('.first_name input').val(),
                last_name: $('.signUpForm').find('.last_name input').val(),
                lang: "en",
                email: $('.signUpForm').find('.email input').val(),
                template_id: getQuery('template-id'),
                permissions: [
                    "STATS_TAB",
                    "EDIT",
                    "DEV_MODE"
                ],
                site_data:{
                    external_uid: "GLENNSAMPLE",
                    site_seo: {
                        og_image: "https://irp-cdn.multiscreensite.com/38e420a5/dms3rep/multi/46090973_1947701631975735_1914562907203436544_n.jpg",
                        title: "Example Title",
                        description: "Example description. Should be around 155 characters long, but can be upto 320."
                    }
                }
            })
        };
        // run sign up flow
        let signUp = doAjax(settings);
        Swal.fire({
            title: 'Submitting data...',
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
                signUp.then(resp => {
                    let data = JSON.parse(resp);
                    if(data.status){
                        Swal.close();
                        Swal.fire({
                            title: 'Success!',
                            icon: 'success',
                            text: 'Redirecting..'
                        });
                        window.location.href = data.sso_link;
                    } else {
                        Swal.close();
                        Swal.fire({
                            title: 'Error!',
                            icon: 'error',
                            text: data.response
                        })
                    }
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    });
}

// DISPLAY TEMPLATES
function displayTemplates(data){
    $('.gridTemplateView').html('');
    data.map(i => {
        $('.gridTemplateView').append(`
            <div class="templateItem" data-template-id="${i.template_id}">
                <div class="templateItem-preview" style="background-image:url('${i.thumbnail_url}')">
                    <div class="templatePreview-overlay"></div>
                    <div class="templatePreview-buttons">
                        <a class="templateButtons-createSite" href="${window.location.origin}/CamelDev/DIY/views/sign-up.html?template-id=${i.template_id}">
                            <span class="text">Create Site</span>
                        </a>
                        <a class="templateButtons-Preview" href="${i.preview_url}" target="_blank">
                            <span class="text">Preview</span>
                        </a>
                    </div>
                </div>
                <div class="templateItem-name">${i.template_name}</div>
            </div>
        `);
    })
}

// DISPLAY FORM
function displayForm(){
    $('.signUpView').html(`
        <div class="signUpForm">
            <div class="signUpForm-fields">
                <div class="first_name">
                    <label for class="first_name">First Name</label>
                    <input type="text" name="First Name">
                </div>
                <div class="last_name">
                    <label for class="last_name">Last Name</label>
                    <input type="text" name="Last Name">
                </div>
                <div class="email">
                    <label for class="email">Account Name / Email</label>
                    <input type="text" name="Email">
                </div>
            </div>
            <input type="button" class="signUpForm-button" value="Submit">
        </div>
    `);
}

// GET TEMPLATE ID FROM URL
function getQuery(param){
    let url = window.location.href;
    let getQuery = getParameterByName(param, url);

    return getQuery;
}

// GET PARAMETER (QUERY FROM URL)
function getParameterByName(name, url){
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

/**
 * @param settings
 * Reusable Async AJAX
 * eg: let a = doAjax({
        url: ajaxurl,
        type: 'POST',
        data: args
    })
    Callback : a.then(data => {
        console.log(data)
    })
 */
async function doAjax(settings) {
    let result
    try {
        result = await $.ajax(settings);
        return result;
    } catch (error) {
        console.log(error)
    }
}
