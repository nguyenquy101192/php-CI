
$(function(){
	$("#slideshow .slider-info:gt(0)").hide();

	setInterval(function(){
		$('.slider-info:first-child').fadeOut()
		.next('.slider-info').fadeIn()
		.end().appendTo("#slideshow");}, 4000
	);
});

$(function(){
	var $list_image = $("#slideshow").children();
	var $count = $('.slider-info').length;
	$("#slider").append(
						"<div id='prev'><span class='fa fa-chevron-left'></span></div>" +
						"<div id='next'><span class='fa fa-chevron-right'></span></div>"
					);
	$current_img = 0;
	$list_image.attr("id", function(arr){
		return "item" + arr;
	});
	
	$('#prev').click(function () {
		if ($current_img > 0) {
	        prevImg($current_img);
	        $current_img = $current_img - 1;
		}
        else{
            $current_img = $count - 1;
            prevImg($current_img);
        }
	});
    
	$('#next').click(function () {
	    if ($current_img < $count - 1) {
	        nextImg($current_img);
	        $current_img = $current_img + 1;
	    }
        else {
            $current_img = 0;
            nextImg($current_img);
        }
	});
	
	function nextImg($img) {
        $n_img = $img + 1;
        $('#item' + $img).fadeOut();
        $('#item' + $n_img).fadeIn();
	}
	
	function prevImg($img) {
		$p_img = $img - 1;
        $('#item' + $img).fadeOut();
        $('#item' + $p_img).fadeIn();
	}
});