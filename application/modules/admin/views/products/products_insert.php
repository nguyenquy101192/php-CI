<meta charset="UTF-8" />
<title>Insert Products</title>
<form action="" method="post" enctype="multipart/form-data">
   	<label>Name</label>
   	<input type="text" name="pro_name" value="" placeholder="Product name" size="30" /><br />
    <span class="error"><?php echo form_error("pro_name"); ?></span>
    <br />
    
    <label>List price</label>
   	<input type="text" name="pro_list_price" value="" placeholder="Product list price" size="30" /><br />
    <span class="error"><?php echo form_error("pro_list_price"); ?></span>
    <br />
    
   	<label>Sale price</label>
    <input type="text" name="pro_sale_price" value="" placeholder="Product sale price" size="30" /><br />
    <span class="error"><?php echo form_error("pro_sale_price"); ?></span>
    <br />
    
   	<label>Description</label>
    <input type="text" name="pro_desc" value="" placeholder="Product description" size="30" /><br />
    <span class="error"><?php echo form_error("pro_desc"); ?></span>
    <br />
    
   	<label>Origin</label>
    <input type="text" name="pro_country" value="" placeholder="Product Origin" size="30" /><br />
    <span class="error"><?php echo form_error("pro_country"); ?></span>
    <br />  
    
    <label>Brand</label>
    <select name="pro_brand">
    	<?php 
    		foreach ($brands as $key=>$value){
				echo "<option value='".$value['brand_id']."'>".$value['brand_name']."</option>";
			}
    	?>
    </select>
    <br /><br />
    
    <label>Feature</label>
    Yes&nbsp;<input type="radio" name="feature" value="1" checked="checked" />
    No&nbsp;<input type="radio" name="feature" value="0"  /><br />    
    <br />
    
    <label>Category</label><br />
    	<table border='1' id="tbl-category">                        
            <?php
                foreach($category as $key=>$value){
                    $margin = "";
                    echo "<tr>";
                        echo "<td>";
                            for($i=1; $i<=$value['level'];$i++){
                                $margin .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            }
                            echo $margin . "<span class='fa fa-caret-right'></span>&nbsp;" . $value['cate_name'];
                        echo "</td>";
                        echo "<td><center><input type='checkbox' name='pro_cate[]' value='".$value['cate_id']."' /></center></td>";
                        
                    echo "</tr>";
                }
            ?>
        </table>
    <br />
    
    <label>Images</label>
    <input type="file" name="main_img" />
    <span class="error"><?php if(isset($error_main_img))echo $error_main_img; ?></span>
    <br />
    <br />
    <br />
        
    <label>Thumb</label>
    <input type='file' name='thumb_img[]' value='' multiple="true" />
    <span class="error"><?php if(isset($error_thumb_img)) foreach($error_thumb_img as $value) echo $value."<br>"; ?></span>
    <br />
    <br />
    <br />
    <div>

    <input type="submit" name="insert" value="Insert" class="insert-cancel" /><input type="submit" name="cancel" value="Cancel" class="insert-cancel" />
    </div>                                
</form>
