<!-- feature -->
<div id='feature'>
    <div class="title-category">
        <h4>FEATURE PRODUCTS</h4>
    </div>

    <ul>
        <?php
        if (isset($listSlider)) {
            foreach ($listSlider as $key => $value) {
                echo "
                                        <li>
                                            <div class='feature-pro'>
                                                <div class='feature-pro-title'>";
                echo "<a href='" . base_url() . "default/home/detail/" . $value['pro_id'] . "'>" . $value['pro_name'] . "</a>";
                echo "</div>";

                echo "<img src='" . base_url() . "public/images/icon/bestbuy.png' id='feature-bestbuy'/>";

                echo "<div class='feature-pro-desc'>";
                echo $value['pro_desc'];
                echo "</div>
                                                
                                                <div class='feature-pro-img'>
                                                    <a href='" . base_url() . "default/home/detail/" . $value['pro_id'] . "'><img src='" . base_url() . "public/images/products/" . $value['pro_images'] . "' /></a>
                                                </div>
                                                
                                                <div class='feature-pro-add-cart'>
                		                            <a href='#' onclick='if(add_cart(" . $value['pro_id'] . ", " . $value['pro_sale_price'] . ")) return false;'><span class='fa fa-shopping-cart'></span>&nbsp;Add to cart</a>
                		                        </div>
                                            </div>
                                        </li>
                                        ";
            }
        }
        ?>
    </ul>
</div>
<!-- End feature -->