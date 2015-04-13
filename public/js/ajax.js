$(document).ready(function() {
	var base_url = "http://localhost/FR06/Mock/";
	
	/*sort items in page*/
	$("#sort_field").change(function() {
		if (this.value != 0) {
			var field = this.value;
			var type = $("#sort_type").val();
			var current_page = $('#current_page').val();
			$.ajax({
				url : base_url + "default/home/sort_filter_cate/" + current_page,
				type : 'POST',
				data : {
					'field' : field,
					'type' : type,
					'page' : current_page
				},
				success : function(data) {
					$("#list-products").html(data);
				},
				error : function(data) {
					console.log(data);
				}
			});
		}
	});

	$("#sort_type").change(function() {
		if (this.value != 0) {
			var type = this.value;
			var field = $("#sort_field").val();
			var current_page = $('#current_page').val();
			$.ajax({
				url : base_url + "default/home/sort_filter_cate/" + current_page,
				type : 'POST',
				data : {
					'type' : type,
					'field' : field,
					'page' : current_page
				},
				success : function(data) {
					$("#list-products").html(data);
				},
				error : function(data) {
					console.log(data);
				}
			});
		}
	});
	
    /*filter by brand*/
	var brand = new Array();
	var num = 0;
    var click_event = 1;
	for(i=0; i<14; i++){
		$("input#filter"+num).click(function(){
			if( $(this).is(':checked') ){
				brand.push(this.value);
			}
			else{
				var removeItems = this.value;
				brand = jQuery.grep(brand, function(value){
					return value != removeItems;
				});
			}
            console.log(brand);
			var current_page = $('#current_page').val();
			$.ajax({
				url : base_url + "default/home/sort_filter_cate/" + current_page,
				type : 'POST',
				data : {'brand': brand,
						'page' : current_page,
                        'click': click_event
						},
				success : function(data) {
					$("#list-products").html(data);
				},
				error : function(data) {
					console.log(data);
				}
			});
		});
		num++;
	}
    
    
    /*filter by price*/
    $(function() {
        $( "#slider-3" ).slider({
        range:true,
        min: 0,
        max: 30000,
        step: 5,
        values: [ 0, 30000 ],
        slide: function( event, ui ) {
           $( "#price" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
        },
        change: function(event, ui){
            var low_price = ui.values[0];
            var heigh_price = ui.values[1];
            var current_page = $('#current_page').val();
            
            $.ajax({
                url: base_url + "default/home/sort_filter_cate/",
                type: "POST",
                data: {'low': low_price, 'heigh': heigh_price},
                success: function(data){
                    $("#list-products").html(data);
                },
                error: function(data){
                    console.log(data);
                }
            });
        }
    });
    $( "#price" ).val( "$" + $( "#slider-3" ).slider( "values", 0 ) +
     " - $" + $( "#slider-3" ).slider( "values", 1 ) );
    });
    
    
    /*list product by category*/
    $(".li-cate").click(function(){
        $("#slider").fadeOut(500);
	    $("#feature").fadeOut(500);
        var cate_id = $(this).attr('id');
        console.log(cate_id);
        var name = $(this).attr('cate_name');
        var current_page = $('#current_page').val();
        $("#title-cate").html("HOME / " + name + " / ");
        $.ajax({
            url: base_url + 'default/home/sort_filter_cate' + current_page,
            type: "POST",
            data: {'cate_id': cate_id,
                   'page': current_page,
                   'cate_name': name},
            success: function(data){
                $("#list-products").html(data);
            },
            error: function(data){
                console.log(data);
            }
        });
    });
});