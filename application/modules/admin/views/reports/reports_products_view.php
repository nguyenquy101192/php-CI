<style>
<!--
</style>
<script>
$(function() {
$( ".datepicker" ).datepicker({
    dateFormat: "yy/mm/dd"
});
});
</script>
<form action="<?php echo base_url()?>admin/reports/report_product"
	method="POST">
	Report by <select id="option">
		<option
			onclick="location.href='<?php echo base_url();?>admin/reports'"
			selected="selected">Product</option>
		<option
			onclick="location.href='<?php echo base_url();?>admin/reports/category'">Category</option>
	</select> <br />
	<div id="date-time">
		From: <input type="text" class="datepicker" name="from_date" value="<?php if (isset($from_date)){echo $from_date;}else{echo date("Y/m/d");}?>"> To: <input
			type="text" class="datepicker" name="to_date"value="<?php if (isset($to_date)){echo $to_date;}else{echo date("Y/m/d");}?>">
		<input type="submit" name="btnReport" value="Report">
	</div>
</form>
<?php 
if(isset($products) && count($products) > 0) {
?>

<!-- result table -->
<table class="result-table" border='1'>
    <thead>
        <tr class="title-table">
            <th>Order</th>
            <th>ID</th>
            <th>Product Name</th>
            <th>Number of Purchasing</th>
            <th>Quantity</th>
            <th>Sale Price</th>
            <th>List Price</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        foreach ($products as $product) {
            echo "<tr>";
            echo "<td>{$product['order']}</td>";
                echo "<td>{$product['pro_id']}</td>";
                echo "<td>{$product['pro_name']}</td>";
                echo "<td>{$product['count']}</td>";
                echo "<td>{$product['quantity']}</td>";
                echo "<td>{$product['pro_list_price']} USD</td>";
                echo "<td>{$product['pro_sale_price']} USD</td>";
            echo "</tr>";
        }
    ?>
    </tbody>
</table>
<div class="pagination">
    <?php
        if(isset($pages)){
            echo $pages;
        }
    ?>
<?php
} else {
    echo "<p class='col-sm-offset-2 col-sm-10'>There is no purchasing in this time range.</p>";
}
?>