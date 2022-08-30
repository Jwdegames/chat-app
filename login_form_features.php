<script>
// Gets a cookie from the browster
function getCookie(cname) {
	  var name = cname + "=";
	  var decodedCookie = decodeURIComponent(document.cookie);
	  var ca = decodedCookie.split(';');
	  for(var i = 0; i <ca.length; i++) {
	    var c = ca[i];
	    while (c.charAt(0) == ' ') {
	      c = c.substring(1);
	    }
	    if (c.indexOf(name) == 0) {
	      return c.substring(name.length, c.length);
	    }
	  }
	  return "";
	}
	
// Shake the login form if the user inputs the wrong password.
jQuery.fn.shakeLogin = function() {
	this.each(function(i) {
		let loginTop = (loginTop==undefined)?$(this).position().top:loginTop;
		let t = loginTop;
		//var t = 299.5;
		for (var x = 1; x <= 3; x++) {
			$(this).animate({
				top: t + 43
			}, 10).animate({
				top: t + 23
			}, 50).animate({
				top: t + 23
			}, 10).animate({
				top: t + 13
			}, 50).animate({
				top: t
			}, {duration: 50, done: function() {
					openLogin = true;
					//alert("animation done");
			}
			})
		};
	return this;
    })
}

// Prepare login 
var loginBtn = document.getElementById("nav-login-toggle");
var loginForm = document.getElementById("login-form");
var openLogin = true;

// Handle login process when login button is clicked
loginBtn.addEventListener("click", function(){
	if ($("#login-link").text() == "Logout") {
		// Logout if we are currently logged in.
		var ajaxurl = "<?php echo $backup . 'chat-simulator/chat-app/db-login/logout_code.php'?>";
		console.log("Logging Out");
		data =  {do_logout: "do_logout"};
		// Perform Login to Server
		$.ajax({type:'post',url:ajaxurl, data, success:function (response) {
		
			}
		});
		$("#login-link").text("Login");
		$("#user-link").text("");
		$("#chat-link").css("display","none");
		document.cookie = "loggedin = "+false;
		<?php $_SESSION['loggedin']= 0;?>

		//If we are in the profile page, send us to main page
		var path = window.location.pathname;
		var page = path.split("/").pop();
		var origpath = path.substring(0,path.length-page.length);
		
		console.log("Logging out on "+page);
		if (page == "profile.php" || page=="chat.php") {
			window.location.href = origpath + "index.php";
		}
		
		return;
	}
	if (loginForm.style.display == "none") {
		loginForm.style.display = "";
		//Hide all elements
		document.getElementById("content").style.display = 'none';
	}
	else {
		if (openLogin) {
			$("#login-form").shakeLogin();
			openLogin = false;
		}
		
	}
});


var exitLoginBtn = document.getElementById("login-exit");
exitLoginBtn.addEventListener("click", function(){
	loginForm.style.display = "none";
	//Reveal all elements
	document.getElementById("content").style.display = 'block';
	console.log("Exit: " + document.getElementById("content"));
});

//Handle Login and Registration
$(document).ready(function(){
	var loginstats = getCookie("loggedin");
	console.log(loginstats);
	if (loginstats == "true") {
		$("#user-link").text(getCookie("username"));
		$("#chat-link").css("display","");
		$("#login-link").text("Logout");
	}
	// Handle Login Button
	$('#login-send').click(function(){
		//var clickBtnValue = $(this).val();
		var ajaxurl = "<?php echo $backup . 'chat-simulator/chat-app/db-login/login_code.php'?>";
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
		var ajaxurl = "<?php echo $backup . 'chat-simulator/chat-app/db-login/register_code.php'?>";
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