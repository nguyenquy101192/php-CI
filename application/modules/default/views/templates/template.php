<div id="all-products">
    <div class="title-category">
        <span id='title-cate'>ALL PRODUCTS</span>
    </div>
    <div id="temp-sort">
        <?php
        if ($this->session->userdata("set_sort_field")) {
            $select_field = $this->session->userdata("set_sort_field");
        } else
            $select_field = "pro_name";

        if ($this->session->userdata("set_sort_type")) {
            $select_type = $this->session->userdata("set_sort_type");
        } else
            $select_type = "ASC";
        ?>
        BY:&nbsp;<select name="sort_field" id='sort_field'>
            <option value="pro_name" <?php if ($select_field == 'pro_name') echo "selected"; ?>>&nbsp;&nbsp;Name
            </option>
            <option value="pro_sale_price" <?php if ($select_field == 'pro_sale_price') echo "selected"; ?>>&nbsp;&nbsp;Price</option>
        </select>

        <select name="sort_type" id='sort_type'>
            <option value="ASC" <?php if ($select_type == 'ASC') echo "selected"; ?>>ASC</option>
            <option value="DESC" <?php if ($select_type == 'DESC') echo "selected"; ?>>DESC</option>
        </select>

        <input type='hidden' value='<?php echo $current_page; ?>' id='current_page'/>
    </div>

    <div id='list-products'>
        <ul>
            <?php foreach ($listProduct as $key => $value) { ?>
                <li>
                    <div class="product">
                        <div class="pro-info">
                            <div class="pro-image">
                                <a href='<?php echo base_url() . 'default/home/detail/' . $value['pro_id']; ?>'><img
                                        src="<?php echo base_url() . 'public/images/products/' . $value['pro_images']; ?>"/></a>
                            </div>
                            <div class="pro-name">
                                <a href="<?php echo base_url() . 'default/home/detail/' . $value['pro_id']; ?>"><?php echo strtoupper($value['pro_name']); ?></a>
                            </div>
                            <div class="pro-price">
                                <?php
                                if ($value['pro_sale_price'] < $value['pro_list_price']) {
                                    echo "<s>" . number_format($value["pro_list_price"], "0", "", ",") . "&nbsp;$</s>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                    echo "<img src='" . base_url() . "public/images/icon/sale.png" . "' id='product-sale'/>";
                                }
                                echo "<span style='color: #ff3333;'>" . number_format($value["pro_sale_price"], "0", "", ",") . "&nbsp;$</span>";?>
                            </div>
                        </div>
                        <div class="cart-detail">
                            <div class="cart">
                                <a href="#"
                                   onclick="if(add_cart(<?php echo $value['pro_id'] . ", " . $value['pro_sale_price']; ?>)) return false;"><span
                                        class="fa fa-shopping-cart"></span>&nbsp;Add to cart</a>
                            </div>
                            <div class="detail">
                                <a href='<?php echo base_url() . 'default/home/detail/' . $value['pro_id']; ?>'>Detail</a>
                            </div>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
        <div class="pagination">
            <?php echo $pages; ?>
        </div>
    </div>
</div>
</div>