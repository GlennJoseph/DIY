var settings;
if(window.location.pathname.includes('preview-template')){
    settings = {
        url: "../php/actions.php",
        type:"GET",
        data: JSON.stringify({
            action: "get_Templates"
        })
    };
}

if(window.location.pathname.includes('sign-up')){
    settings = {
        url: "../php/actions.php",
        type:"POST",
        data: JSON.stringify({
            action: "sign_Up",
            account_name: "glennjosephdl@gmail.com",
            first_name: "Glenn",
            last_name: "Deleon",
            lang: "en",
            email:"glennjosephdl@gmail.com",
            template_id: 1000440,
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
}

let templates = doAjax(settings);
    console.log(settings.data);
    templates.then(resp => {
        let data = JSON.parse(resp);
        if(data.status){
            console.log(data.response);
        } else {
            console.error(data.response);
        }
    });

function displayTemplates(data){
    $('.gridTemplateView').html('');
    data.map(i => {
        $('.gridTemplateView').append(`
            <div class="templateItem">
                <span data-id="${i.template_id}">${i.template_name}</span>
            </div>
        `);
    })
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
