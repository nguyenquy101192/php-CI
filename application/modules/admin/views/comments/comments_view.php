<script>
    function check_delete() {
        press = confirm("Do you want to delete ?");
        if (press == true)
            return true;
        else return false;
    }
</script>
<div class="info-button">
    <div class="count-record">
        Per page: <?php if (isset($per_page)) {
            echo "<b>" . $per_page . "</b>";
        } ?> |
        Total records: <?php
        if (isset($total)) {
            echo "<b>" . $total . "</b>";
        }
        ?>
    </div>
</div>
<div class="table-center">
    <table class="result-table" border='1'>
        <tr class="title-table">
            <td>No</td>
            <td>Name</td>
            <td>Title</td>
            <td width="30%">Content</td>
            <td>Rate</td>
            <td>Time</td>
            <td colspan="2">Action</td>
        </tr>

        <?php
        if (isset($listComment) && count($listComment) != 0) {
            foreach ($listComment as $key => $value) {
                echo "<tr>";
                echo "<td class='align'>" . $stt . "</td>";
                echo "<td>" . $value['feed_name'] . "</td>";
                echo "<td>" . $value['feed_title'] . "</td>";
                echo "<td>" . $value['feed_content'] . "</td>";
                echo "<td>" . $value['feed_rate'] . "</td>";
                echo "<td>" . $value['feed_time'] . "</td>";
                if ($value['status'] == 0) {
                    echo "<td class='align' style='width: 80px;'><a href='" . base_url() . "admin/comments/approve/" . $value['feed_id'] . "/" . $value['status'] . "' class='fa fa-minus-square' style='color: rgb(255,0,0)'></a></td>";
                } else {
                    echo "<td class='align' style='width: 80px;'><a href='" . base_url() . "admin/comments/approve/" . $value['feed_id'] . "/" . $value['status'] . "' class='fa fa-check-square' style='color: rgb(0,0,255)'></a></td>";
                }
                echo "<td class='align' style='width: 80px;'><a href='" . base_url() . "admin/comments/delete/" . $value['feed_id'] . "' onclick='if(check_delete() == false) return false' class='fa fa-trash-o'></a></td>";
                echo "</tr>";
                $stt++;
            }
        } else if (!isset($listBrand) || count($listBrand) == 0) {
            echo "<tr>";
            echo "<td colspan='4' class='align'>No data !</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
<div class="pagination">
    <?php
    if (isset($pages)) {
        echo $pages;
    }
    ?>
</div>