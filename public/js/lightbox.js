function openFancybox() {
    setTimeout(function () {
        $('#lightbox').trigger('click');
    }, 500);
};
$(document).ready(function () {
    var visited = $.cookie('visited');
    if (visited == 'yes') {
        return false; // second page load, cookie active
    } else {
        openFancybox(); // first page load, launch fancybox
    }
    $.cookie('visited', 'yes', {
        expires: 7 // the number of days cookie  will be effective
    });
    $("#lightbox").click(function () {
        $.fancybox({
            href: base_url + "public/images/lightbox.jpg",
            type: "image"
        });
        return false;
    });
});