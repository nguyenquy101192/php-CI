<script>
    function checkDelete() {
        press = confirm("Bạn có chắc chắn xóa?")
        if(press == true)
            return true;
        else return false;
    }
    var base_url = "http://localhost/FR06/Mock/";
    $(document).ready(function(){
    	$('#per_page_users').change(function(){
    		var per_page = this.value;
            $.ajax({
    	        url: base_url + "admin/config/config_users",
    	        type: "POST",
    	        data: {'per_page': per_page},
    	        success: function(data){
        	        $(".table-center").html(data);
    	        },
    	        error: function(data){
    	        	console.log(data);
    	        }
    	    });
        });
    });
</script>

<?php 
	$next_order = ($order == 'ASC') ? 'DESC' : 'ASC';
	$current_url = base_url() . 'admin/users/index/';
	if($this->session->userdata("config_users")){
		$select_value = $this->session->userdata("config_users");
	}
	else
		$select_value = 5;
?>
<div class="info-button">
    <div class="count-record">
        Per page: <span>
	        		  	<select name='per_page' id='per_page_users' class="config-per-page">
	        		  		<option value='2' <?php if($select_value==2) echo "selected";?>>2</option>
	        		  		<option value='3' <?php if($select_value==3) echo "selected";?>>3</option>
	        		  		<option value='5' <?php if($select_value==5) echo "selected";?>>5</option>
	        		  		<option value='7' <?php if($select_value==7) echo "selected";?>>7</option>
	        		  		<option value='10' <?php if($select_value==10) echo "selected";?>>10</option>
	        		  	</select>
        		  </span>
        Total records: <?php
                            if(isset($total)){
                                echo "<b>" . $total . "</b>";
                            }
                        ?>	
    </div>
    
    <div class="button">
        <a href="<?php echo base_url();?>admin/users/insert"><button class="insert fa fa-plus">&nbsp;Add user</button></a>
    </div>
</div>

<div class="table-center">
<table class="result-table" border='1'>
    <tr class="title-table">
        <td>No</td>
        <td>Username&nbsp;<a href="<?php echo $current_url . $page_number . '/user_name/' . $next_order; ?>" class="fa fa-sort"></a></td>
        <td>Email&nbsp;<a href="<?php echo $current_url . $page_number . '/user_email/' . $next_order; ?>" class="fa fa-sort"></a></td>
        <td>Address&nbsp;<a href="<?php echo $current_url . $page_number . '/user_address/' . $next_order; ?>" class="fa fa-sort"></a></td>
        <td>Phone</td>
        <td>Gender&nbsp;<a href="<?php echo $current_url . $page_number . '/user_gender/' . $next_order; ?>" class="fa fa-sort"></a></td>
        <td>Level&nbsp;<a href="<?php echo $current_url . $page_number . '/user_level/' . $next_order; ?>" class="fa fa-sort"></a></td>
        <td colspan="2">Action</td>
    </tr>
    
    <?php
        if(isset($listUser)){
            foreach($listUser as $key=>$value) {
                echo "<tr>";
                    echo "<td class='align'>" . $stt . "</td>";
                    echo "<td>" . $value['user_name'] . "</td>";
                    echo "<td>" . $value['user_email'] . "</td>";
                    echo "<td>" . $value['user_address'] . "</td>";
                    echo "<td>" . $value['user_phone'] . "</td>";
                    echo "<td>";
                        if($value['user_gender'] == 1)
                            echo "Male";
                        else echo "Female";
                    echo "</td>";
                    echo "<td>";
                        if($value['user_level'] == 1)
                            echo "Admin";
                        else echo "Member";
                    echo "</td>";
                    echo "<td class='align'><a href='".base_url("admin/users/update")."/".$value['user_id']."' class='fa fa-pencil'></a></td>";
                    echo "<td class='align'><a href='". base_url()."admin/users/delete/". $value['user_id'] ."' onclick='if(checkDelete() == false) return false' class='fa fa-trash-o' ></a></td>";
                echo "</tr>";
                $stt++;
            }
        }
        else if(!isset($listUser) || $listUser == null){
            echo "<tr>";
                echo "<td colspan='9' class='align'>No data..!</td>";
            echo "</tr>";
        }
    ?>
</table>
<div class="pagination">
    <?php
        if(isset($pages)){
            echo $pages;
        }
    ?>
</div>
</div>