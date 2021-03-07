var settings = {
    url: "..php/actions.php",
    type:"POST",
    data: JSON.stringify({action: 'get_Template'})
};

let templates = doAjax(settings);
    templates.then(resp => {
        let data = JSON.parse(resp);

        if(!data.status){
            console.error('something went wrong');
        } else {
            console.log(data.response);
        }
    });

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