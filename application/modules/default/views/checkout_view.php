<style>
    .check-out-content {
        background: none repeat scroll 0% 0% #FFF;
        padding: 1px;
        margin-bottom: 15px;
        width: 60%;
        margin-left: 50px;
    }

    .txtbox {
        width: 365px;
        height: 30px;
        margin-top: 10px;
        margin-bottom: 10px;
        margin-right: 20px;
    }

    label {
        color: #666;
        font-weight: bold;
    }

    li.fields {
        margin-top: 10px;
        display: block;
    }

    #method {
        display: none;
    }

    #payment {
        display: none;
    }

    .button {
        background: none repeat scroll 0% 0% #39C;
        display: inline-block;
        padding: 7px 15px;
        border: 0px none;
        color: #FFF;
        font-size: 13px;
        font-weight: normal;
        font-family: "Raleway", "Helvetica Neue", Verdana, Arial, sans-serif;
        line-height: 19px;
        text-align: center;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
    }

    #check-out {
        clear: both;
    }

    .error {
        color: red;
    }

    .success {
        text-align: center;
        font-size: 20px;
        line-height: 50px;
    }

    .success a {
        text-decoration: none;
        color: blue;
    }
</style>
<script>
    function open_method() {
        $("#method").show(1500);
        $("#info").hide(500);
        $("#payment").hide(500);
    }
    function open_info() {
        $("#method").hide(500);
        $("#info").show(1500);
        $("#payment").hide(500);
    }
    function open_payment() {
        $("#method").hide(500);
        $("#info").hide(500);
        $("#payment").show(1500);
    }
</script>
<div id='check-out'>
    <div class='contact-title'>CHECK OUT</div>
    <hr/>
    <?php if ($success): ?>
        <div class="success">
            Check out success! Thank you!<br/>
            <a href="<?= base_url() . "default/home" ?>"><i>Back to home</i></a>
        </div>
    <?php else: ?>
        <div id='check-out-table'>
            <table border='1' class='cart-table'>
                <tr class='title-table'>
                    <td width='50px'>No</td>
                    <td width='600px'>Product</td>
                    <td width='100px'>Quantity</td>
                    <td width='100px'>Price</td>
                    <td width='200px'>SubTotal</td>
                </tr>
                <?php
                $i = 0;
                //echo "<pre>"; print_r($listProduct); die();
                if ($listProduct == '') : ?>
                    <tr>
                        <td colspan='6' style='text-align: center;'>No item in cart</td>
                    </tr>
                <?php
                else:
                    foreach ($cart as $id => $pro): ?>
                        <tr style='text-align: center;'>
                            <td width='30px'><?= ++$i ?></td>
                            <td width='600px'>
                                <img
                                    src="<?= base_url() . "public/images/products/" . $listProduct[$id]['pro_images'] ?>"
                                    width="100"/>
                                <a href="<?= base_url() . 'default/home/detail/' . $id ?>">
                                    <span><?= $listProduct[$id]['pro_name'] ?></span>
                                </a>
                            </td>
                            <td width='100px'>
                                <?= $pro['quantity'] ?>
                            </td>
                            <td width='100px'><?= $pro['price'] . " $" ?></td>
                            <td width='200px'><?= $pro['quantity'] * $pro['price'] ?> $</td>
                        </tr>
                    <?php
                    endforeach;
                endif; ?>
            </table>
            <div id='cart-price'>
                <span>Total price: <?php echo $cost . " $"; ?></span>
            </div>
        </div>
        <div id="check-out">
            <form action="" method="post">
                <hr/>
                <div id='check-out-info'>
                    <div onclick="open_info()">
                        <span class='check-out-title'>Step 1. </span>INFORMATION
                    </div>
                    <div class='check-out-content' id="info">
                        <li class="fields"><label>Name</label></li>
                        <li class="fields">
                            <input type="text" name="name" id="left" class="txtbox"
                                   value="<?php echo set_value('name'); ?>">
                            <span class="error"><i><?php echo form_error("name"); ?></i></span>
                        </li>
                        <li class="fields"><label id="right">Email</label></li>
                        <li class="fields">
                            <input type="text" name="email" id="left" class="txtbox"
                                   value="<?php echo set_value('email'); ?>">
                            <span class="error"><i><?php echo form_error("email"); ?></i></span>
                        </li>
                        <li class="fields"><label>Address</label></li>
                        <li class="fields">
                            <input type="text" name="address" class="txtbox"
                                   value="<?php echo set_value('address'); ?>">
                            <span class="error"><i><?php echo form_error("address"); ?></i></span>
                        </li>
                        <li class="fields"><label>Phone</label></li>
                        <li class="fields">
                            <input type="text" name="phone" id="left" class="txtbox"
                                   value="<?php echo set_value('phone'); ?>">
                            <span class="error"><i><?php echo form_error("phone"); ?></i></span>
                        </li>
                        <li class="fields">
                            <input type="button" name="next"
                                   value="Continue" class="button" onclick="open_method()">
                        </li>
                    </div>
                </div>
                <hr/>
                <div id='check-out-method'>
                    <div onclick="open_method()">
                        <span class='check-out-title'>Step 2. </span>DELIVERY METHODS
                    </div>
                    <div class='check-out-content' id="method">
                        <li class="fields">
                            <input type="radio" name="shipping"><label>Standard(20$ - receive in 2 days)</label>
                        </li>
                        <li class="fields">
                            <input type="radio" name="shipping" checked="checked"><label>Fast(75$ - receive in 5
                                hours)</label>
                        </li>
                        <li class="fields">
                            <input type="button" name="next"
                                   value="Continue" class="button" onclick="open_payment()">
                        </li>
                    </div>
                </div>
                <hr/>
                <div id='check-out-payment' onclick="open_payment()">
                    <span class='check-out-title'>Step 3. </span>CHOOSE YOUR PAYMENT
                    METHODS
                    <div class='check-out-content' id="payment">
                        <li class="fields">
                            <input type="radio" name="payment" checked="checked" value="cash"><label>Cash</label>
                        </li>
                        <li class="fields">
                            <input type="radio" name="payment" value="credit_card"><label>Credit card</label>
                        </li>
                        <li class="fields">
                            <input type="submit" name="check_out" value="Finish" class="button">
                        </li>
                    </div>
                </div>
            </form>
            <span class="error"><i><?php if (isset($error)) echo $error; ?></i></span>
        </div>
    <?php endif; ?>
</div>