function change_cate(id, catename){
    var base_url = "http://localhost/FR06/Mock/";
	$("#slider").hide();
	$("#feature").hide();
    var pathArray = window.location.pathname.split( '/' );
    var current_page = pathArray[4];
    $("#title-cate").text("HOME / "+catename);
    if(current_page==null || current_page<0) current_page = 1;
    $.ajax({
		url: base_url + "default/home/cate/" + id + "/" + current_page,
		type: 'POST',
		data: {'id': id, 'page': current_page},
		success: function(data){
			$("#list-products").html(data);
		},
		error: function(data){
			console.log(data)
		}
	});
    
    return true;
}

