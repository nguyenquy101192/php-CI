<title>Insert Category</title>
<form action="" method="POST" id="insert">
    <label>Category name</label>
    <input type="text" name="catename" />
    <span class="error"><i><?php echo form_error("catename"); ?></i></span>
    <br />
    
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
    <br />
    <br />
    
    <label>&nbsp;</label>
    <input type="submit" name="insert" value="Insert" />&nbsp;<input type="submit" name="cancel" value="Cancel" />
</form>