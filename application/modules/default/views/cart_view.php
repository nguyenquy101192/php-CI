<script>
    function checkDelete() {
        press = confirm("Bạn có chắc chắn xóa?")
        if(press == true)
            return true;
        else return false;
    }
    
</script>

<div id='my-cart'>
	<div class='contact-title'>YOUR CART</div>
	<hr/>
	<div id='my-cart-table'>
		<table border='1' class='cart-table'>
			<tr class='title-table'>
				<td width='30px'>No</td>
				<td width='600px'>Product</td>
				<td width='100px'>Quantity</td>
				<td width='100px'>Price</td>
				<td colspan='2'>Delete</td>
			</tr>
            <?php
            $i = 0; 
            //echo "<pre>"; print_r($listProduct); die();
            if($listProduct=='') : ?>
            <tr>
				<td colspan='6' style='text-align: center;'>No item in cart</td>
            </tr>
            <?php 
            else:
            foreach($cart as $id=>$pro): ?>
            <tr style='text-align: center;'>
				<td width='30px'><?= ++$i ?></td>
				<td width='600px'>
                    <img src="<?= base_url()."public/images/products/".$listProduct[$id]['pro_images'] ?>" width="100"/>
                    <a href="<?= base_url().'default/home/detail/'.$id ?>">
                        <span><?= $listProduct[$id]['pro_name'] ?></span>
                    </a>                    
                </td>
				<td width='100px'>
                    <form action="cart/update" method="post">
                        <input type="text" name="quantity" value="<?= $pro['quantity'] ?>" size="2"/>
                        <input type="hidden" name="id" value="<?= $id ?>"/>
                        <input type="submit" name="btnok" value="Update"/>
                    </form>                    
                </td>
				<td width='100px'><?= $pro['price']." $" ?></td>
				<td colspan='2'>
                <a href="<?php echo base_url()."default/cart/delete/". $id ?>" 
                onclick='if(checkDelete() == false) return false' class='fa fa-trash-o' ></a>
                </td>
			</tr>
            <?php 
            endforeach; 
            endif; ?>
		</table>
		<div id='cart-price'>
			<span>Total price: <?php echo $cost." $";?></span>
		</div>
		
		<div id='check-clear'>
			<form action="" method='POST'>
				<input type='submit' value='Check out' name='checkout'/>&nbsp;
				<input type='submit' value='Clear cart' name='clear' onclick='if(checkDelete() == false) return false'/>
			</form>
		</div>
	</div>
</div>