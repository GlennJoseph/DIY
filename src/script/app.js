var settings;

// GET TEMPLATES
if ($('.gridTemplateView').length !== 0){
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

if ($('.signUpView').length !== 0){
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
                        // redirect to the sso link
                        // window.location.href = data.sso_link;

                        // redirect to the checkout page
                        setTimeout(function(){
                            window.location.href = `/CamelDev/DIY/views/checkout.html?account_name=${data.account_name}&site_name=${data.site_name}&name=${data.first_name} ${data.last_name}`
                        }, 2000);
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

if ($('.checkoutView').length !== 0){
    var stripe = Stripe('pk_test_vfWE7xrduv8Avh6SCr5NOqvn00JMQLksHM');

    // CHANGE PRICE VALUE ACCORDING TO INTERVAL
    let price = '';
    $('.checkout-internal-button').click(function(){
        $('.checkout-internal-button.active').removeClass('active');
        $(this).addClass('active');
        $('.checkout-recurring-value').html($('.checkout-annual-button').hasClass('active') ? '$480.00/year' : '$48.00/month');
    });

    $('.checkout-subscribe').click(function(){
        settings = {
            url: "../php/actions.php",
            type:"POST",
            data: JSON.stringify({
                action: 'subscribe',
                account_name: getQuery('account_name'),
                site_name: getQuery('site_name'),
                name: getQuery('name').replace(/%20/g, ' '),
                success_url: `${window.location.origin}/CamelDev/DIY/views/checkout-success.html`,
                cancel_url: `${window.location.origin}/CamelDev/DIY/views/checkout.html`,
                price: $('.checkout-annual-button').hasClass('active') ? 'price_1IWMUiHdOsfAiyOE16cYwxsz' : 'price_1IWLCBHdOsfAiyOEmFlklSqw'
            })
        };
        // RUN CHECKOUT
        let checkout = doAjax(settings);
        checkout.then(resp => {
            let data = JSON.parse(resp);
            if(data.status){
                stripe.redirectToCheckout({
                    sessionId: data.response.id
                }).then(data.response);
            } else {
                console.error(data.response);
            }
        });
    })
}

if ($('.checkoutSuccessView').length !== 0){
    // SHOW SUCCESS POPUP
    // Swal.fire({
    //     title: 'Site Published!',
    //     icon: 'success'
    // })

    settings = {
        url: "../php/webhook-stripe.php",
        type:"GET"
    };

    // RUN AJAX
    let webhook = doAjax(settings);
    webhook.then(resp => {
        let data = JSON.parse(resp);
        if(data.status){
            console.log(data.response);
        } else {
            console.error(data.response);
        }
    });

    $('.customer-portal').click(function(){
        settings = {
            url: "../php/actions.php",
            type:"POST",
            data: JSON.stringify({
                action: 'billing_Portal',
                customer: getQuery('customer'),
                return_url: `${window.location.origin}/CamelDev/DIY/views/checkout-success.html`
            })
        };

        // RUN AJAX
        let billingPortal = doAjax(settings);
        billingPortal.then(resp => {
            let data = JSON.parse(resp);
            if(data.status){
                window.location.href = data.response.url;
            } else {
                console.error(data.response);
            }
        });
    })
}

// if ($('.customerPortalView').length !== 0){
//     settings = {
//         url: "../php/actions.php",
//         type:"POST",
//         data: JSON.stringify({
//             action: 'billing_Portal',
//             customer: '',
//             return_url: `${window.location.origin}/CamelDev/DIY/views/preview-template.html`
//         })
//     };
// }

if ($('.legacyCheckoutView').length !== 0){
    var stripe = Stripe('pk_test_vfWE7xrduv8Avh6SCr5NOqvn00JMQLksHM');
    var elements = stripe.elements();
    // card
    var cardElement = elements.create('card');
    cardElement = elements.getElement('card');
    cardElement.mount('#card-element');

    // CHANGE PRICE VALUE ACCORDING TO INTERVAL
    let price = '';
    $('.checkout-internal-button').click(function(){
        $('.checkout-internal-button.active').removeClass('active');
        $(this).addClass('active');
        $('.checkout-price-amount').html($('.checkout-annual-button').hasClass('active') ? '$480.00/year' : '$48.00/month');
    });

    // RUN WHEN CARD ELEMENT HAS BEEN ENTERED
    cardElement.on('change', function(event) {
        if (event.complete) {
            $('.checkout-card_error').html('');
            // UPON CLICKING PAYMENT BUTTON
            $('.checkout-submit_payment').click(function(){
                // GENERATE A TOKEN/SOURCE
                stripe.createToken(cardElement).then(function(result) {
                    settings = {
                        url: "../php/actions.php",
                        type:"POST",
                        data: JSON.stringify({
                            action: 'subscribe_Legacy',
                            name: `${$('.checkout-first_name input').val()} ${$('.checkout-last_name input').val()}`,
                            email: $('.checkout-email input').val(),
                            coupon_code: $('.checkout-coupon_code input').val(),
                            source: result.token.id,
                            price: $('.checkout-annual-button').hasClass('active') ? 'price_1IWMUiHdOsfAiyOE16cYwxsz' : 'price_1IWLCBHdOsfAiyOEmFlklSqw'
                        })
                    };
                    // RUN CHECKOUT
                    let checkout = doAjax(settings);
                    checkout.then(resp => {
                        let data = JSON.parse(resp);
                        if(data.status){
                            Swal.fire({
                                title: 'Payment Successful!',
                                icon: 'success'
                            });
                        } else {
                            Swal.fire({
                                title: 'Payment Unsuccessful!',
                                icon: 'error',
                                text: data.response
                            });
                        }
                    });
                });
            });
            
        } else if (event.error) {
            $('.checkout-card_error').html(event.error.message);
        }
    });

}

if ($('.testCheckoutView').length !== 0){
    var stripe = Stripe('pk_test_vfWE7xrduv8Avh6SCr5NOqvn00JMQLksHM');

    // CHANGE PRICE VALUE ACCORDING TO INTERVAL
    let price = '';
    $('.product-interval-button').click(function(){
        $('.product-interval-button.active').removeClass('active');
        $(this).addClass('active');
        $('.product-item.recurring .product-details-price').each(function(){
            let priceText = $('.product-interval-button.active').hasClass('annual') ? $(this).attr('data-annual') : $(this).attr('data-monthly');
            $(this).html(priceText);
        });
    });

    // SELECT ITEM
    $('.product-item').click(function(){
        $(this).toggleClass('selected');
    });

    // ON CLICK PAYMENT BUTTON
    $('.payment-button').click(function(){
        let button = $(this);

        
        if (button.hasClass('recurring')){
            // ADD ACTIVE PRICE ATTRIBUTE TO RECURRING ITEMS
            $('.product-item.selected').each(function(){
                let recurringActivePrice = $('.product-interval-button.active').hasClass('annual') ? $(this).attr('data-annual-id') : $(this).attr('data-monthly-id');
                $(this).attr('data-active-price', recurringActivePrice);
            });

            // IF NONE ARE SELECTED, ALERT
            if ($('.selected.recurring').length == 0){
                alert('No items selected!');
                return 0;
            }
        } else {
            // IF NONE ARE SELECTED, ALERT
            if ($('.selected.one-time').length == 0){
                alert('No items selected!');
                return 0;
            }
        }

        // SET PRICE LIST ARRAY
        let priceList = [];
        if (button.hasClass('recurring')){
            $('.product-item.selected.recurring').each(function(){
                priceList.push({
                    price: $(this).attr('data-active-price'),
                    quantity: 1
                });
            })
        } else {
            $('.product-item.selected.one-time').each(function(){
                priceList.push({
                    price: $(this).attr('data-active-price'),
                    quantity: 1
                });
            })
        }

        settings = {
            url: "../php/test.php",
            type:"POST",
            data: JSON.stringify({
                action: 'create_Session',
                mode: button.hasClass('recurring') ? 'subscription' : 'payment',
                line_items: priceList
            })
        };

        // RUN CHECKOUT
        let checkout = doAjax(settings);
        checkout.then(resp => {
            let data = JSON.parse(resp);
            if(data.status){
                stripe.redirectToCheckout({
                    sessionId: data.response.id
                }).then(data.response);
            } else {
                console.error(data.response);
            }
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
