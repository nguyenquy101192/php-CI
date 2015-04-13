<form action="" method="post" id="insert">
    <label><b>Brand name</b></label>
    <input type="text" name="brand_name" size="30" />
    <span class="error"><i><?php echo form_error("brand_name"); ?></i></span>
    <br /><br />    
    
    <label>&nbsp;</label>
    <input type="submit" name="insert" value="Insert" class="insert-cancel" />&nbsp;<input type="submit" name="cancel" value="Cancel" class="insert-cancel" />
</form>