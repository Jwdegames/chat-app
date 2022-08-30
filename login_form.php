

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

<script>

	//Handle UI
	var exitLoginBtn = document.getElementById("login-exit");
	exitLoginBtn.addEventListener("click", function(){
	loginForm.style.display = "none";
	//Reveal all elements
	document.body.childNodes.forEach(function(element) {
		if (element.id == "pg-content") {
			element.style.display = "";
			}
		});
	});

	//Handle Login and Registration
	$(document).ready(function(){
		// Handle Login Button
        $('#login-send').click(function(){
            //var clickBtnValue = $(this).val();
            var ajaxurl = 'res/login_code.php';
            var username = $("#user-box").val();
            var password = $("#pass-box").val();
            console.log("Gathering Login Data");
            data =  {do_login: "do_login",
                    username:username,
                    password:password};
            console.log(data);
            // Perform Login to Server
            $.ajax({type:'post',url:ajaxurl, data, success:function (response) {
                console.log("Login Response: "+response);
                switch (response) {
                case "Invalid Username!":
                    console.log("Alert: Invalid Username!");
                    $("#invalid-user").css("display","");
                    $("#invalid-user").text("Invalid Username!");
                    if (!$("#user-box").hasClass("is-invalid")) {
						$("#user-box").addClass("is-invalid");
                    }
                    $("#user-taken").css("display","none");
                    $("#invalid-pass").css("display","none");
                    if ($("#pass-box").hasClass("is-invalid")) {
						$("#pass-box").removeClass("is-invalid");
                    }
                    break;
                case "Invalid Password!":
                    console.log("Alert: Invalid Password!");
                    $("#invalid-pass").css("display","");
                    if (!$("#pass-box").hasClass("is-invalid")) {
						$("#pass-box").addClass("is-invalid");
                    }
                    $("#invalid-user").css("display","none");
                    if ($("#user-box").hasClass("is-invalid")) {
						$("#user-box").removeClass("is-invalid");
                    }
                    break;
                case "User is banned!":
                	$("#invalid-user").css("display","");
                	$("#invalid-user").text("User is banned!");
                    if (!$("#user-box").hasClass("is-invalid")) {
						$("#user-box").addClass("is-invalid");
                    }
                    $("#user-taken").css("display","none");
                    $("#invalid-pass").css("display","none");
                    if ($("#pass-box").hasClass("is-invalid")) {
						$("#pass-box").removeClass("is-invalid");
                    }
                    break;
                case "Success (Regular)!":
					console.log("Alert: Regular Login Successful!");
					// Remove invalid markers
					$("#invalid-pass").css("display","none");
                    if ($("#pass-box").hasClass("is-invalid")) {
						$("#pass-box").removeClass("is-invalid");
                    }
                    $("#invalid-user").css("display","none");
                    if ($("#user-box").hasClass("is-invalid")) {
						$("#user-box").removeClass("is-invalid");
                    }
                    
                    // Prevent Login because we are already logged in
                    $("#pg-content").css("display","");
                    $("#login-form").css("display","none");
                    $("#chat-link").css("display","");
                    $("#login-link").text("Logout");
                    $("#user-link").text(username);
				
                    document.cookie = "username = "+username;
                    document.cookie = "password ="+password;
                    document.cookie = "loggedin ="+true;
                    document.cookie = "admin ="+false;
                    <?php $_SESSION['loggedin']= $_COOKIE['loggedin'] ?? '';
                    $_SESSION['password']=$_COOKIE['password'] ?? '';
                    $_SESSION['username']=$_COOKIE['username'] ?? '';
                    $_SESSION['admin']=$_COOKIE['admin'] ?? '';?>
                    break;
                case "Success (Admin)!":
                	console.log("Alert: Admin Login Successful!");
					// Remove invalid markers
					$("#invalid-pass").css("display","none");
                    if ($("#pass-box").hasClass("is-invalid")) {
						$("#pass-box").removeClass("is-invalid");
                    }
                    $("#invalid-user").css("display","none");
                    if ($("#user-box").hasClass("is-invalid")) {
						$("#user-box").removeClass("is-invalid");
                    }
                    
                    // Prevent Login because we are already logged in
                    $("#pg-content").css("display","");
                    $("#login-form").css("display","none");
                    $("#chat-link").css("display","");
                    $("#login-link").text("Logout");
                    $("#user-link").text(username);
				
                    document.cookie = "username = "+username;
                    document.cookie = "password ="+password;
                    document.cookie = "loggedin ="+true;
                    document.cookie = "admin ="+true;
                    <?php $_SESSION['loggedin']= $_COOKIE['loggedin'] ?? '';
                    $_SESSION['password']=$_COOKIE['password'] ?? '';
                    $_SESSION['username']=$_COOKIE['username'] ?? '';
                    $_SESSION['admin']=$_COOKIE['admin'] ?? '';?>
                    break;
                default:
					console.log("Unusual Response: "+response);
                    break;
                }
                
            }});
        });

        //Handle Registration
        $("#register-send").click(function(){
        	var ajaxurl = 'res/register_code.php';
            var username = $("#user-box").val();
            var password = $("#pass-box").val();
            console.log("Gathering Registration Data");
            data =  {do_register: "do_register",
                    username:username,
                    password:password};
            // Perform Login to Server
            $.ajax({type:'post',url:ajaxurl, data, success:function (response) {
                console.log("Registration Response: "+response);
                switch (response) {
                case "User Already Exists!":
                    console.log("Alert: Invalid Username!");
                    //$("#invalid-user").css("display","");
                    if (!$("#user-box").hasClass("is-invalid")) {
						$("#user-box").addClass("is-invalid");
                    }
                    $("#user-taken").css("display","");
                    $("#invalid-pass").css("display","none");
                    if ($("#pass-box").hasClass("is-invalid")) {
						$("#pass-box").removeClass("is-invalid");
                    }
                    break;
                case "Success!":
					console.log("Alert: Registration Successful!");
					// Remove invalid markers
					$("#invalid-pass").css("display","none");
                    if ($("#pass-box").hasClass("is-invalid")) {
						$("#pass-box").removeClass("is-invalid");
                    }
                    $("#invalid-user").css("display","none");
                    if ($("#user-box").hasClass("is-invalid")) {
						$("#user-box").removeClass("is-invalid");
                    }
                    $("#user-taken").css("display","");
                    // Prevent Login because we are already logged in
                    $("#pg-content").css("display","");
                    $("#login-form").css("display","none");
                    $("#chat-link").css("display","");
                    $("#login-link").text("Logout");
                    $("#user-link").text(username);
				
                    document.cookie = "username ="+username;
                    document.cookie = "password ="+password;
                    document.cookie = "loggedin ="+true;
                    document.cookie = "admin ="+false;
                    <?php $_SESSION['loggedin']= $_COOKIE['loggedin'] ?? '';
                    $_SESSION['password']=$_COOKIE['password'] ?? '';
                    $_SESSION['username']=$_COOKIE['username'] ?? '';
                    $_SESSION['admin']=$_COOKIE['admin'] ?? '';?>
                    break;
                }
                
            }});
        });
	});
</script>