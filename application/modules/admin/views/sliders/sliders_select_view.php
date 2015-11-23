<title>Slider manager</title>
<div id="slider-main-container">
    <div id="slider-sort" class="dd">
        <?php
        $folder = "public/images/products/";
        if (empty($order)) {
            echo "<h4>Back to product list to add to the banner</h4>";
        } else {
            echo '<ul id="slider-sort-container">';
            foreach ($order as $key => $value) {
                echo "<li pro='" . $value['pro_id'] . "' img='" . $value['img_link'] . "' id='" . $value['img_order'] . "' class='slider-item'>";
                echo "<img src='" . base_url($folder . $value['img_link']) . "' height='60' width='60'>";
                echo "<p>" . $value['pro_name'] . "</p>";
                echo "<div class='slider-delete' pro='" . $value['pro_id'] . "'>Delete</div>";
                echo "</li>";
            }
            echo '</ul>';
        }
        ?>
    </div>
</div>