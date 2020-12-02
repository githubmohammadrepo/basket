submitStep: function(el) {
    if (window.checkout.onFormSubmit && !window.checkout.onFormSubmit(el.form, el))
        return false;
    var mainDiv = document.getElementById('hikashop_checkout');
    if (mainDiv)
        this.setLoading(mainDiv, true);
    el.form.submit();
    return false;
},