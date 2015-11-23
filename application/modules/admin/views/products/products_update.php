<form action="" method="POST" enctype="multipart/form-data">
    <label><b>Product Name</b></label>
    <input type="text" name="pro_name" size="50" value="<?php echo $infoProduct['pro_name']; ?>"/>
    <span class="error"><i><?php echo form_error("pro_name"); ?></i></span>
    <br/>

    <label><b>Product Price</b></label>
    <input type="text" class="input-short" name="pro_list_price" value="<?php echo $infoProduct['pro_list_price']; ?>"/>
    <span class="error"><i><?php echo form_error("pro_list_price"); ?></i></span>
    <br/>

    <label><b>Price sale</b></label>
    <input type="text" class="input-short" name="pro_sale_price" value="<?php echo $infoProduct['pro_sale_price']; ?>"/>
    <span class="error"><i><?php echo form_error("pro_sale_price"); ?></i></span>
    <br/>

    <label><b>Category</b></label>

    <div class="category_list">
        <?php
        $stt = 1;
        foreach ($listCatergory as $key => $val) {
            if (in_array($val['cate_id'], $listCateid)) {
                $checked = "checked='checked'";
            } else {
                $checked = "";
            }
            $name = array();
            $name = '<input type="text" value="' . $val['cate_name'] . '" /><input ' . $checked . ' type="checkbox" name="category[]" value="' . $val['cate_id'] . '" id="input_cate"/>';

            echo $name;
        }
        ?>
    </div>
    <label><b>Description</b></label><br/>
    <textarea name="pro_desc" id="input-short"><?php echo $infoProduct['pro_desc']; ?></textarea>
    <br/>

    <label><b>Product Country</b></label>
    <input type="text" name="pro_country" value="<?php echo $infoProduct['pro_country']; ?>"/>
    <br/>

    <div id="brand">
        <label><b>Brand</b></label>
        <select name="brand_id">
            <option value="">Select brand</option>
            <?php
            if (isset($listBrand) && $listBrand != null) {
                foreach ($listBrand as $brand) {
                    if ($infoProduct['brand_id'] == $brand['brand_id']) {
                        $selected = "selected='selected'";
                    } else {
                        $selected = "";
                    }
                    echo "<option $selected value='" . $brand['brand_id'] . "'>" . $brand    ['brand_name'] . "</option>";
                }
            }
            ?>
        </select>
    </div>
    <br/>

    <label><b>Product images</b></label>

    <div id="mainImagie">
        <?php
        if ($infoProduct['pro_images'] != null) {
            echo "<img src='" . base_url() . "/public/images/products/" . $infoProduct['pro_images'] . "' width='100' />";
        }
        ?>
        <input type="file" name="images" value="<?php echo $infoProduct['pro_images']; ?>"/>
    </div>


    <div id="thumb_images">
        <label><b>Product Thumb</b></label>
        <?php
        $id = $this->uri->segment(4);
        echo "<input type='file' name='imgs[]' value='' multiple><br/>";
        if (isset($listThumb)) {
            echo "<ul>";
            foreach ($listThumb as $value) {
                echo "<li class='list_thumb'>";
                echo "<img src='" . base_url() . "/public/images/products/" . $value['img_link'] . "' width='100' />";
                echo "<a href='" . base_url() . "admin/products/deleteThumb/" . $id . "/" . $value['img_link'] . "'><img src='" . base_url() . "/public/images/icon/delete.png' width='20' height='20'/></a>";
                echo "</li>";
            }
            echo "</ul>";
        }
        ?>
    </div>
    <br/>

    <div id="update-cancel"><input type="submit" name="update" value="Update" class="update-cancel"/>&nbsp;<input
            type="submit" name="cancel" value="Cancel" class="update-cancel"/></div>
</form>