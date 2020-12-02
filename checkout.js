const form = document.getElementById('hikashop_checkout_form');
const log = document.getElementById('hikabtn_checkout_next');
form.addEventListener('submit', (event) => {

    log.textContent = `Form Submitted! Time stamp: ${event.timeStamp}`;
    event.preventDefault();

    var mainDiv = document.getElementById('hikashop_checkout');
    if (mainDiv)
        this.setLoading(mainDiv, true);

    /* get all form inputs */

    let formData = new FormData();
    for (var i = 0; i < document.hikashop_checkout_form.elements.length; i++) {
        var fieldName = document.hikashop_checkout_form.elements[i].name;
        var fieldValue = document.hikashop_checkout_form.elements[i].value;
        if (fieldName) {
            formData.append(fieldName, fieldValue);
        }
        // use the fields, put them in a array, etc.

        // or, add them to a key-value pair strings, 
        // as in regular POST

        //params += fieldName + '=' + fieldValue + '&';
    }
    // Display the keys
    let data = Array();

    for (var key of formData.keys()) {

        data[key] = formData.get(key);
    }
    // console.log(Object.assign({}, data));
    console.log(data)
        // console.log(window.hkjQuery.ajax);
    console.log(window.jQuery('form').html())
        /* end get all from inputs */
        /*ajax request*/
    console.log(document.baseURI + './index.php');
    let FetchPosturl = "http://fishopping.ir/index.php/2020-10-19-10-49-33/checkout/cid-1";

    window.jQuery.ajax(FetchPosturl, {
            method: "POST",
            //body: Object.assign({}, data),

            data: formData,
            processData: false,
            contentType: false,


        }).then(
            response => {
                let htmlResponse = response.toString();
                if ((htmlResponse.indexOf('با تشکر از خريد شما')) && (htmlResponse.indexOf('You can now access your order'))) {
                    //user order was successful saved
                    window.location.href = "http://fishopping.ir/index.php?option=com_content&view=article&id=45"
                } else {
                    //use order does not saved
                    window.location.reload()

                }
            } // .json(), etc.
            // same as function(response) {return response.text();}
        )
        // el.form.submit()
        // 		return false;
});

},