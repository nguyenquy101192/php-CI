<meta charset="UTF-8" />
<title>Update Categories</title>
<form action="" method="post">	
<div id="categories">
<label><b>Category name</b></label>
	 <label>Choose menu</label>
    <select name="sec">
        <option value="0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--select category--</option>
        <?php
            foreach($listCate as $key=>$value){
                $margin = "";
                for($i=1; $i<=$value['level'];$i++){
                    $margin .= "-----";
                }
                echo "<option value='" . $value['cate_id'] . "'>" . $margin . $value['cate_name'] . "</option>";
            }
        ?>
    </select>
    </br>
	<input type="text" name="cate_name" value="<?php echo $cateInfor['cate_name']; ?>" size="20">
	<span class="error"><i><?php echo form_error("cate_name"); ?></i></span>
	<br />

	<div><input type="submit" name="update" value="Update" class="insert-cancel" />&nbsp;<input type="submit" name="cancel" value="Cancel" class="insert-cancel" /></div>
</form>