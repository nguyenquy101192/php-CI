<form action="" method="POST" id="insert">
    <label>Username</label>
    <input type="text" name="name" />
    <span class="error"><i><?php echo form_error("name"); ?></i></span>
    <br />
    
    <label>Password</label>
    <input type="text" name="password" />
    <span class="error"><i><?php echo form_error("password");?></i></span>
    <br />
    
    <label>Email</label>
    <input type="text" name="email" />
    <span class="error"><i><?php echo form_error("email");?></i></span>
    <br />
    
    <label>Address</label>
    <input type="text" name="address" />
    <span class="error"><i><?php echo form_error("address");?></i></span>
    <br />
    
    <label>Phone</label>
    <input type="text" name="phone" />
    <span class="error"><i><?php echo form_error("phone");?></i></span>
    <br />
    
    <label>Gender</label>
    Male&nbsp;<input type="radio" name="gender" value="1" />
    Female&nbsp;<input type="radio" name="gender" value="2" />
    <span class="error"><i><?php echo form_error("gender");?></i></span>
    <br />
    <br />
    
    <label>Level</label>
    Admin&nbsp;<input type="radio" name="level" value="1" />
    Normal user&nbsp;<input type="radio" name="level" value="2" />
    <span class="error"><i><?php echo form_error("level");?></i></span>
    <br />
    
    <input type="submit" name="insert" value="Insert" />&nbsp;<input type="submit" name="cancel" value="Cancel" />
</form>