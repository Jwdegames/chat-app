

<div class="row position-fixed" id="login-form" style="display:none;">
	<aside class="col-sm-4">
	
<div class="card" id="login-card" style="width:300px;">
<button type="submit" id = "login-exit" class="btn btn-primary btn-block"> X  </button>
<article class="card-body" >
<input type="submit" id = "register-send" class="float-right btn btn-outline-primary" value="Sign up">
<h4 class="card-title mb-4 mt-1" style = "left:100px;">Sign in</h4>
	 <form  onsubmit="return false" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
    	<label>Your username</label>
        <input name="username" class="form-control" id="user-box" placeholder="Username" type="text" value="">
        <div class="invalid-feedback" id = "invalid-user" style="display:none">Invalid Username!</div>
        <div class="invalid-feedback" id = "empty-user" style="display:none">Username must not be empty!</div>
        <div class="invalid-feedback" id = "invalid-user-chars" style="display:none">Username must not contain ', ", /, or \!</div>
        <div class="invalid-feedback" id = "user-taken" style="display:none">Username is already in use!</div>

    </div>
    
     <!-- form-group// -->
    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
    	<!-- <a class="float-right" href="#">Forgot?</a> -->
    	<label>Your password</label>
        <input class="form-control" id="pass-box" placeholder="******" type="password">
        <div class="invalid-feedback" id = "invalid-pass" style="display:none">Invalid Password!</div>
    </div>
    
     <!-- form-group// --> 
    <div class="form-group"> 
    <div class="checkbox">
      <!-- <label> <input type="checkbox"> Save password </label>-->
    </div> <!-- checkbox .// -->
    </div> <!-- form-group// -->  
    <div class="form-group ">
        <input type="submit" class="btn btn-primary btn-block" id="login-send" value="Login">
    </div> <!-- form-group// -->                                                           
</form>
</article>
</div>
</aside>
</div>

