function add_cart(pro_id, pro_price) {
    $.ajax({
        url: base_url + "default/cart/add",
        type: 'POST',
        data: {'pro_id': pro_id, 'pro_price': pro_price},
        success: function (data) {
            if (data == "Error: request add fail! ") alert(data);
            else $("#header-cart a").html(data);
        },
        error: function (data) {
            console.log(data)
        }
    });

    return true;
}
