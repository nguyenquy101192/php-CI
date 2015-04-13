<script>
    function check_delete(){
        press = confirm("Do you want to delete?");
        return press;
    }
    
    var base_url = "http://localhost/FR06/Mock/";
    $(document).ready(function(){
    	$('#per_page_products').change(function(){
    		var per_page = this.value;
            $.ajax({
    	        url: base_url + "admin/config/config_products",
    	        type: "POST",
    	        data: {'per_page': per_page},
    	        success: function(data){
        	        $(".table-center").html(data);
    	        },
    	        error: function(data){
    	        	console.log(data);
    	        }
    	    });
        });
    });
</script>

<?php 
	$next_order = ($order == 'ASC') ? 'DESC' : 'ASC';
	$current_url = base_url() . 'admin/products/index/';
    if($this->session->userdata("config_products")){
		$select_value = $this->session->userdata("config_products");
	}
	else
		$select_value = 5;
?>

<div class="info-button">
    <div class="count-record">
        Per page: <b>5</b> | <!--<span>
	        		  	<select name='per_page' id='per_page_products' class="config-per-page">
	        		  		<option value='2' <?php if($select_value==2) echo "selected";?>>2</option>
	        		  		<option value='3' <?php if($select_value==3) echo "selected";?>>3</option>
	        		  		<option value='5' <?php if($select_value==5) echo "selected";?>>5</option>
	        		  		<option value='7' <?php if($select_value==7) echo "selected";?>>7</option>
	        		  		<option value='10' <?php if($select_value==10) echo "selected";?>>10</option>
	        		  	</select>
        		  </span>-->
        Total records: <?php
                            if(isset($total)){
                                echo "<b>" . $total . "</b>";
                            }
                        ?>
    </div>
    
    <div class="button">
        <a href="<?php echo base_url();?>admin/products/insert"><button class="insert fa fa-plus">&nbsp;Add product</button></a>
    </div>
    <div class="search-bar">
        <form accept-charset="utf-8" method="post" action="<?php echo base_url();?>admin/products/search">
            <input type="text" id="search" name="search" 
                placeholder="<?php echo isset($no_query) ? $no_query : '';?>" 
                value='<?php 
            		if(isset($keywords)){
            			echo $keywords;
            		}else{
            			echo"";
            		}
            	?>'/>
            <select name="search_type" id="select-pro">
                <option value="1" <?php if(isset($search_type)&&$search_type==1){echo "selected";}?>>Search by name</option>
            	<option value="2" <?php if(isset($search_type)&&$search_type==2){echo "selected";}?>>Search by id</option>
            	<option value="3" <?php if(isset($search_type)&&$search_type==3){echo "selected";}?>>Search by brand</option>
            </select>
            <input type="submit" name="submit" value="Search" id="search-button" />
        </form>
    </div>
</div>

<div class="table-center">
<table border='1' id="tbl-product" class="result-table">
	<tr class="title-table">
        <td>No</td>
        <td>Slider</td>
		<td>Product image</td>
		<td>Product name&nbsp;<a href="<?php echo $current_url . $page_number . '/pro_name/' . $next_order; ?>" class="fa fa-sort"></a></td>
		<td>List price&nbsp;<a href="<?php echo $current_url . $page_number . '/pro_list_price/' . $next_order; ?>" class="fa fa-sort"></a></td>
		<td>Sale price&nbsp;<a href="<?php echo $current_url . $page_number . '/pro_sale_price/' . $next_order; ?>" class="fa fa-sort"></a></td>
		<td>Description</td>
		<td>Brand&nbsp;<a href="<?php echo $current_url . $page_number . '/brand_id/' . $next_order; ?>" class="fa fa-sort"></a></td>
		<td>Origin&nbsp;<a href="<?php echo $current_url . $page_number . '/pro_origin/' . $next_order; ?>" class="fa fa-sort"></a></td>
		<td colspan="2">Action</td>
	</tr>
    <?php
        if(!isset($listProduct) || $listProduct == null){
            echo "
                <tr>
                    <td colspan='10' class='align'>No data !</td>
                </tr>
                ";
        }
		foreach ( $listProduct as $key => $value ) {
	?>
    <tr>
        <td class='align'><?php echo $stt;?></td>
        <td class='align'><input 	type=checkbox <?php foreach ($listSlider as $key=>$slider){
        							if($value['pro_id']==$slider['pro_id']){echo "checked";}}?> 
        							onclick="window.location='<?php echo base_url()?>admin/sliders/add_delete_slider?product_id=<?php echo $value['pro_id'];?>'; return true;"/></td>
		<td class="align">
			<img alt="IMAGE" src="<?php echo base_url()."public/images/products/".$value["pro_images"]?>" width='50' height='50'/>
		</td>
		<td style="font-weight: bold;">
			<?php echo $value["pro_name"];?>
		</td>
		<td class="align" style="color: #ff3333;">
			<?php echo number_format($value["pro_list_price"], "0", "", ".")."&nbsp;<span class='fa fa-dollar'></span>";?>
		</td>
		<td class="align" style="color: #ff3333;">
			<?php echo number_format($value["pro_sale_price"], "0", "", ".")."&nbsp;<span class='fa fa-dollar'></span>";?>
		</td>
		<td>
			<?php echo $value["pro_desc"];?>
		</td>
		<td>
			<?php echo $value["brand_name"];?>
		</td>
		<td>
			<?php echo $value["pro_country"];?>
		</td>
		<td class='align' style='width: 50px;'><a href="<?php echo base_url();?>admin/products/update/<?php echo $value['pro_id'];?>" class="fa fa-pencil"></a></td>
		<td class='align' style='width: 50px;'><a href="<?php echo base_url();?>admin/products/delete/<?php echo $value['pro_id'];?>" class="fa fa-trash-o" onclick="if(check_delete()==false) return false"></a></td>
	</tr><?php $stt++;}?>    
</table>

<div class="pagination">
<?php echo $pages;?>
</div>
</div>

