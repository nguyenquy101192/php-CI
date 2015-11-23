<script>
    function check_delete(id) {
        press = confirm("Do you want to delete?");
        if (press == true) document.getElementById('del_form' + id).submit();
        else return false;
    }
</script>
<div class="button">
    <a href="<?php echo base_url(); ?>admin/categories/insert">
        <button class="insert fa fa-plus">&nbsp;Add category</button>
    </a>
    <a href="<?php echo base_url(); ?>admin/categories/move">
        <button class="insert">Move</button>
    </a>
</div>
<div class="table-center">
    <table border='1' class="result-table">
        <tr class="title-table">
            <td>STT</td>
            <td>Category name</td>
            <td colspan="2">Action</td>
        </tr>

        <?php
        $stt = 1;
        foreach ($listCate as $key => $value) {
            $margin = "";
            echo "<tr>";
            echo "<td class='align' style='width:50px;'>" . $stt . "</td>";
            echo "<td>";
            for ($i = 1; $i <= $value['level']; $i++) {
                $margin .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            }
            echo $margin . "<span class='fa fa-caret-right'></span>&nbsp;" . $value['cate_name'];
            echo "</td>";
            //" . base_url() . "admin/categories/update/" . $value['cate_id'] . "
            echo "<td class='align' style='width:80px;'><a href='' class='fa fa-pencil'></a></td>";
            echo "<td class='align' style='width:80px;'>
                    <form id='del_form" . $value['cate_id'] . "' action='categories/delete' method='post'>
                    <a href='javascript:{}' 
                    onclick='if(check_delete(" . $value['cate_id'] . ")==false) return false;' class='fa fa-trash-o'></a>
                    <input type='hidden' name='id' value='" . $value['cate_id'] . "'/>
                    <input type='checkbox' name='delmode' value='deleteAllSub'/>Sub
                    </form>
                    </td>";
            echo "</tr>";
            $stt++;
        }
        ?>
    </table>
</div>