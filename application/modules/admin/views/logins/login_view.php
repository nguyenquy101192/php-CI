<html>
<title>Login page</title>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/login.css"/>
</head>
<body>
<div id="login_view">
    <div id="group3">
        <img src="<?php echo base_url(); ?>public/images/icon/logo-login.png"/>
    </div>
    <h1>Login to Admin</h1>
    <?php echo form_open('admin/login/verify'); ?>
    <div id="username">
        <label>Username</label>
        <br/>
        <input type="text" name="username" id="username-login"
               placeholder="<?php echo strip_tags(form_error('username')); ?>"
               value="<?php echo set_value('username'); ?>" size="30"/>
    </div>

    <div id="pass">
        <label>Password</label>
        <br/>
        <input type="password" name="password" id="password-login"
               placeholder="<?php echo strip_tags(form_error('password')); ?>"
               value="<?php echo set_value('password'); ?>" size="30"/>
        <br/>
    </div>

    <div id="lower">
        <label>&nbsp;</label>
        <input type="submit" name="submit" class="button" value="Login"/>
        <span class='error' id="login-error"><?php echo isset($login_failed) ? $login_failed : ""; ?></span>
    </div>
    </form>
</div>

</body>
</html>
	