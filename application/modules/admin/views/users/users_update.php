<?php if (isset($user) && $user != false): ?>
    <form action="" method="post" id="insert">

        <label>Username</label>
        <input type="text" name="name" value="<?= $user['user_name'] ?>"/>
        <span class="error"><?php echo form_error("name") ?></span>
        <br/>

        <label>Password</label>
        <input type="password" name="pass" value="<?= $user['user_password'] ?>"/>
        <span class="error"><?php echo form_error("pass") ?></span>
        <br/>

        <label>Email</label>
        <input type="text" name="email" value="<?= $user['user_email'] ?>"/>
        <span class="error"><?php echo form_error("email") ?></span>
        <br/>

        <label>Address</label>
        <input type="text" name="address" value="<?= $user['user_address'] ?>"/>
        <span class="error"><?php echo form_error("address") ?></span>
        <br/>

        <label>Phone</label>
        <input type="text" name="phone" value="<?= $user['user_phone'] ?>"/>
        <span class="error"><?php echo form_error("phone") ?></span>
        <br/>

        <label>Gender</label>
        <select name="gender">
            <option <?php if ($user['user_gender'] == 1) echo "selected" ?> value="1">Nam</option>
            <option <?php if ($user['user_gender'] == 2) echo "selected" ?> value="2">Nu</option>
        </select>
        <br/>

        <label>Level</label>
        <select name="level">
            <option <?php if ($user['user_level'] == 1) echo "selected" ?> value="1">Admin</option>
            <option <?php if ($user['user_level'] == 2) echo "selected" ?> value="2">Member</option>
        </select>
        <br/>

        <input type="submit" name="ok" value="Update"/>&nbsp;<input type="submit" name="cancel" value="Cancel"/>
    </form>
<?php
else: echo "Id khong ton tai";
endif;
?>