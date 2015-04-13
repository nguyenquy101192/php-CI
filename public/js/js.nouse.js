
		function addSort($pro_id,$img_id,$pro_name,$order){
			if (!$order){
				$order = $("#slider-sort-container li").length + 1;
			}
			var $a = "<li pro='"+ $pro_id +
					 "' img='"+ $img_id + 
					 "' id='" + $order+
					 "' class='slider-item'>"+ $pro_name + "</li>";
			$("#slider-sort-container").append($a);
		}

		function deleteSort($pro_id){
			$("#slider-sort-container").each(function(){
				$(this).find("li").each(function(){
					var current = $(this);
					if (current.attr("pro") == $pro_id){
						current.remove();
					}
				});
			});
		}
		
	    function getOrder(){
	    	var out = [],
			count=1;
			$("#slider-sort-container").each(function(){
				$(this).find("li").each(function(){
					var current = $(this);
					tmp = '{' +  
						   '"pro_id":"' + current.attr('pro') + '",' +
						   '"img_id":"' + current.attr('img') + '",' +
						   '"img_order":"' + count++ +
						  '"}';
					tmp = JSON.parse(tmp);
					out.push(tmp);
					
				});
				//tmp=tmp.slice(0,tmp.length - 1) + "}";
				//console.log(out);
				//console.log(JSON.parse(tmp));
			});
			return out;
	    }

	    function update(){
	    	$json = getOrder();
	      	$.ajax({
				type:"POST",
				url:"sliders/setOrder",
				data:{data: $json},
				success:function(e){
					console.log(e);
				}
			});
	    }

	    $("#slider-select-pro").each(function(){
			$(this).find("input").each(function(){
				var current = $(this);
				if (current.attr("checked") == "checked"){
					addSort(current.attr('pro'),current.attr('img'),current.attr('proname'),current.attr('order'));
				}
			});
			$("#slider-sort-container li").sort(function (a, b) {
		        return parseInt(a.id) > parseInt(b.id);
		    }).each(function(){
		        var elem = $(this);
		        elem.remove();
		        $(elem).appendTo("#slider-sort-container");
		    });
		});

	    
	    
	    $( "#slider-sort-container" ).sortable({
		      stop: function(){
			      	update();
		      }
		    });

		$( "#slider-sort-container" ).disableSelection();

		$("input").change(function(){
			var current = $(this);
			if (current.is(":checked")){
				addSort(current.attr('pro'),current.attr('img'),current.attr('proname'));
			}
			else deleteSort(current.attr('pro'));
			update();
		});
