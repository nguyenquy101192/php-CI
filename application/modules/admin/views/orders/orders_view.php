<script>
    function check_delete() {
        press = confirm("Do you want to delete ?");
        if (press == true)
            return true;
        else return false;
    }
</script>

<?php
$next_order = ($order == 'ASC') ? 'DESC' : 'ASC';
$current_url = base_url() . 'admin/orders/index/';
?>

<div class="info-button">
    <div class="count-record">
        Per page: <?php if (isset($listOrders)) {
            echo "<b>" . count($listOrders) . "</b>";
        } ?> |
        Total records: <?php
        if (isset($total)) {
            echo "<b>" . $total . "</b>";
        }
        ?>
    </div>
</div>
<div class="table-center">
    <table border='1' class="result-table">
        <tr class="title-table">
            <td>No</td>
            <td>Name&nbsp;<a href="<?php echo $current_url . $page_number . '/order_name/' . $next_order; ?>"
                             class="fa fa-sort"></a></td>
            <td>Date Buy</td>
            <td>Status&nbsp;<a href="<?php echo $current_url . $page_number . '/order_status/' . $next_order; ?>"
                               class="fa fa-sort"></a></td>
            <td colspan="2">Action</td>
        </tr>

        <?php
        if (isset($listOrders)) {
            $stt = 1;
            foreach ($listOrders as $key => $value) {
                echo "<tr>";
                echo "<td style='width: 50px;' class='align'>" . $stt . "</td>";
                echo "<td>" . $value['order_name'] . "</td>";
                echo "<td style='width: 180px;'>" . $value['order_time'] . "</td>";
                echo "<td style='width: 160px;'>";
                if ($value['order_status'] == 0)
                    echo "<span style='color:red;'>Pending...</span>";
                else
                    echo "Paid";
                echo "</td>";
                echo "<td class='align' style='width: 80px;'><a href='" . base_url() . "admin/orders/details/" . $value['order_id'] . "' class='fa fa-sign-in'>&nbsp;Detail</a></td>";
                echo "<td class='align' style='width: 80px;'>";
                if ($value['order_status'] == 0)
                    echo "<a href='" . base_url() . "admin/orders/delete/" . $value['order_id'] . "' class='fa fa-trash-o' onclick='if(check_delete() == false) return false;')'></a>";
                else echo "";
                echo "</td>";
                echo "</tr>";
                $stt++;
            }
        }
        ?>
    </table>
    <div class="pagination">
        <?php
        if (isset($pages)) {
            echo $pages;
        }
        ?>
    </div>
</div>