<form action="" method="post" id="insert">
    <label><b>Brand name</b></label>
    <input type="text" name="brand_name" value="<?php echo $brandInfor['brand_name']; ?>" size="30"/>
    <span class="error"><i><?php echo form_error("brand_name"); ?></i></span>
    <br/><br/>

    <div><input type="submit" name="update" value="Update" class="insert-cancel"/>&nbsp;<input type="submit"
                                                                                               name="cancel"
                                                                                               value="Cancel"
                                                                                               class="insert-cancel"/>
    </div>
</form>