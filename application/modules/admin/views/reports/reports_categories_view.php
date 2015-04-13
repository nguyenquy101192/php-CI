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
<form action="<?php echo base_url()?>admin/reports/report_category" method="POST">
	Report by 
	<select id="option">
		<option onclick="location.href='<?php echo base_url();?>admin/reports'">Product</option>
		<option onclick="location.href='<?php echo base_url();?>admin/reports/category'" selected="selected">Category</option>
	</select>
	<br />
	<div id="date-time">
		From: <input type="text" class="datepicker" name="from_date" value="<?php if (isset($from_date)){echo $from_date;}else{echo date("Y/m/d");}?>"> To: <input
			type="text" class="datepicker" name="to_date"value="<?php if (isset($to_date)){echo $to_date;}else{echo date("Y/m/d");}?>">
		<input type="submit" name="btnReport" value="Report">
	</div>
</form>
<?php 
if(isset($cates) && count($cates) > 0) {
?>

<!-- result table -->
<table class="result-table" border='1'>
    <thead>
        <tr class="title-table">
            <th>Order</th>
            <th>ID</th>
            <th>Category Name</th>
            <th>Number of Purchasing</th>
            <th>Products Quantity</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        foreach ($cates as $cate) {
            echo "<tr>";
            echo "<td>{$cate['order']}</td>";
                echo "<td>{$cate['cate_id']}</td>";
                echo "<td>{$cate['cate_name']}</td>";
                echo "<td>{$cate['count']}</td>";
                echo "<td>{$cate['quantity']}</td>";
            echo "</tr>";
        }
    ?>
    </tbody>
</table>

<?php
} else {
    echo "<p class='col-sm-offset-2 col-sm-10'>There is no purchasing in this time range.</p>";
}
?>