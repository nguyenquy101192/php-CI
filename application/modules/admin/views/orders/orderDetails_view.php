<script>
    function check_pay(){
        press = confirm("Do you want to payment ?");
        return press;
    }
</script>
<div>
<?php
    if(isset($userInfo)){
        if($userInfo[0]['order_status'] == 0){
            echo "
                <form method='POST' action=''>
                    <input type='submit' name='pay' value='Pay' onclick='if(check_pay()==false) return false'/>
                </form>
                ";
        }
    }
?>
<fieldset id="customer-info">
    <legend>Customer infomation</legend>
    <table border='0'>
        <?php
            if(isset($userInfo)){
                foreach($userInfo as $key=>$value){
                    echo "<tr>";
                        echo "<th><b>Customer Name</b></th>";
                        echo "<td>" . $value['order_name'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<th><b>Email</b></th>";
                        echo "<td>" . $value['order_email'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<th><b>Address</b></th>";
                        echo "<td>" . $value['order_address'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<th><b>Phone</b></th>";
                        echo "<td>" . $value['order_phone'] . "</td>";
                    echo "</tr>";
                }
            }
            else
                echo "<span class='fa fa-warning'></span>&nbsp;No data";
        ?>
    </table>
</fieldset>

<fieldset id="order-details">
    <legend>Order details</legend>
    <table border='1'>
        <?php
            echo "<tr class='title-table'>";
                echo "<td>No</td>";
                echo "<td>Product</td>";
                echo "<td>Quantity</td>";
                echo "<td>Price</td>";
                echo "<td>Total rows</td>";
            echo "</tr>";
            
            if(isset($orderDetails)){
                $total_price = 0;
                $stt = 1;
                foreach($orderDetails as $key_de=>$value_de){
                    echo "<tr>";
                        echo "<td>" . $stt . "</td>";
                        echo "<td>" . $value_de['pro_name'] . "</td>";
                        echo "<td>" . $value_de['orderDetail_quantity'] . "</td>";
                        echo "<td style='color: #ff3333;'>" . number_format($value_de['orderDetail_price'], "0", "", ".") . "&nbsp;<span class='fa fa-dollar'></span></td>";
                        echo "<td style='color: #ff3333;'>" . number_format($value_de['orderDetail_quantity']*$value_de['orderDetail_price'], "0", "", ".") . "&nbsp;<span class='fa fa-dollar'></span></td>";
                    echo "</tr>";
                    $total_price += $value_de['orderDetail_price']*$value_de['orderDetail_quantity'];
                    $stt++;
                }
            }
            else
                echo "<span class='fa fa-warning'></span>&nbsp;No data";
        ?>
    </table>
</fieldset>
</div>
<div style="clear: both;">
    <fieldset id="customer-info">
        <legend>Order Totals</legend>
        <table border='0'>
            <?php
            echo "
            <tr>
                <th>Subtotal</th>
                <td style='color: #ff3333;'>" . number_format($total_price, "0", "", ".") . "&nbsp;<span class='fa fa-dollar'></span></td>
            </tr>
            
            <tr>
                <th>Shipping & Handling</th>
                <td style='color: #ff3333;'>75&nbsp;<span class='fa fa-dollar'></span></td>
            </tr>
            
            <tr>
                <th>Grand Total</th>
                <td style='color: #ff3333;'>" . number_format($total_price+75, "0", "", ".") . "&nbsp;<span class='fa fa-dollar'></span></td>
            </tr>
            
            <tr>
                <th>Total Paid</th>
                <td style='color: #ff3333;'>0&nbsp;<span class='fa fa-dollar'></span></td>
            </tr>
            
            <tr>
                <th>Total Refunded</th>
                <td style='color: #ff3333;'>0&nbsp;<span class='fa fa-dollar'></span></td>
            </tr>
            
            <tr>
                <th>Total Due</th>
                <td style='color: #ff3333;'>" . number_format($total_price+75, "0", "", ".") . "&nbsp;<span class='fa fa-dollar'></span></td>
            </tr>";
            ?>
        </table>
    </fieldset>
</div>