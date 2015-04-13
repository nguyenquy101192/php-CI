<script>
    function check_delete(){
        press = confirm("Do you want to delete ?");
        if(press == true)
            return true;
        else return false;
    }
    var base_url = "http://localhost/FR06/Mock/";
    $(document).ready(function(){
    	$('#per_page_brands').change(function(){
    		var per_page = this.value;
            $.ajax({
    	        url: base_url + "admin/config/config_brands",
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
	$current_url = base_url() . 'admin/brands/index/';
	if($this->session->userdata("config_brands")){
		$select_value = $this->session->userdata("config_brands");
	}
	else
		$select_value = 5;
?>

<div class="info-button">
    <div class="count-record">
        Per page: <span>
	        		  	<select name='per_page' id='per_page_brands' class="config-per-page">
	        		  		<option value='2' <?php if($select_value==2) echo "selected";?>>2</option>
	        		  		<option value='3' <?php if($select_value==3) echo "selected";?>>3</option>
	        		  		<option value='5' <?php if($select_value==5) echo "selected";?>>5</option>
	        		  		<option value='7' <?php if($select_value==7) echo "selected";?>>7</option>
	        		  		<option value='10' <?php if($select_value==10) echo "selected";?>>10</option>
	        		  	</select>
        		  </span> 
        Total records: <?php
                            if(isset($total)){
                                echo "<b>" . $total . "</b>";
                            }
                        ?>
    </div>
    
    <div class="button">
        <a href="<?php echo base_url();?>admin/brands/insert"><button class="insert fa fa-plus">&nbsp;Add brand</button></a>
    </div>
</div>

<div class="search-bar">
    <form accept-charset="utf-8" method="post" action="<?php echo base_url();?>admin/brands/search">
    	<input type="text" id="search" name="search" 
            placeholder="<?php echo isset($no_query) ? $no_query : '';?>" 
            value='<?php 
        		if(isset($keywords)){
        			echo $keywords;
        		}else{
        			echo"";
        		}
    		?>'/>
    	<input type="submit" name="submit" value="Search" id="search-button"/>
    </form>
</div>

<div class="table-center">
    <table class="result-table" border='1'>
        <tr class="title-table">
            <td>No</td>
            <td>Brand name&nbsp;<a href="<?php echo $current_url . $page_number . '/brand_name/' . $next_order; ?>" class="fa fa-sort"></a></td>
            <td colspan="2">Action</td>
        </tr>
        
        <?php
            if(isset($listBrand) && count($listBrand) != 0){
                foreach($listBrand as $key=>$value) {
                    echo "<tr>";
                        echo "<td class='align'>" . $stt . "</td>";
                        echo "<td>" . $value['brand_name'] . "</td>";
                        echo "<td class='align' style='width: 80px;'><a href='". base_url() . "admin/brands/update/". $value['brand_id'] ."' class='fa fa-pencil'></a></td>";
                        echo "<td class='align' style='width: 80px;'><a href='". base_url() . "admin/brands/delete/". $value['brand_id'] ."' onclick='if(check_delete() == false) return false' class='fa fa-trash-o'></a></td>";
                    echo "</tr>";
                    $stt++;
                }
            }
            else if(!isset($listBrand) || count($listBrand) == 0){
                echo "<tr>";
                    echo "<td colspan='4' class='align'>No data !</td>";
                echo "</tr>";
            }
        ?>
    </table>
    <div class="pagination">
    <?php
        if(isset($pages)){
            echo $pages;
        }
    ?>
</div>
</div>
