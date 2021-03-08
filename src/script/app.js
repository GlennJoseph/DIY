var settings = {
    url: "../php/actions.php",
    type:"POST",
    data: JSON.stringify({
        action: 'sign_Up',
        accountName: 'glennjosephdl@gmail.com',
        templateID: 1000440,
        permissions: [
            "STATS_TAB",
            "EDIT",
            "DEV_MODE"
        ]
    })
};

let templates = doAjax(settings);
    templates.then(resp => {
        let data = JSON.parse(resp);
        if(!data){
            console.error('something went wrong');
        } else {
            console.log(data);
        }
    });

function displayTemplates(data){
    $('.gridTemplateView').html('');
    data.map(i => {
        $('.gridTemplateView').append(`
            <div class="templateItem">
                
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
