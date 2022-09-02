<?php
include "../../res/head.php";
?>

<!-- Navigation Bar -->
<?php
include $backup . 'res/nav.php';
?>

	<!--Set Active Page to 'active' in navbar (imported from nav.php)-->
	  <script type="text/javascript">
		document.getElementById('nav-login-user').setAttribute('class', 'active nav-item');
	 </script>

<div id = "content-background">
	<div id="content">
	<h1 style = "text-align:center;">Profile Page</h1>
	<h2><u><b>Welcome <?php echo $_COOKIE['username']?>!</b></u></h2>
	<div style ="width: 75%; display:table;">
		<div style ="display: table-row;">
			<div id = "history-table" style="display:table-cell;"></div>
		
			<div id = "admin-user-table" style ="display:table-cell;"></div>
			
			<div id = "admin-user-tools" style ="display:table-cell;"></div>
		</div>
	</div>
</div>

	<script type="text/javascript">

	var histories;
	var users;
	var adata;
	
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

	function displayAdminData(username,password) {
		var ajaxurl = "<?php echo $backup . 'chat-simulator/chat-app/user/admin_code.php'?>";
		data =  {get_admin_data: "get_admin_data",
                username:username,
                password:password};
		$.ajax({type:'post',url:ajaxurl, data, success:function (response) {
			if (response.substring(0,9) == "Success: ") {
					response = response.substring(9,response.length);
					console.log(response);
					users = JSON.parse(response);
					console.log(users);
					var userTable = "<p style = 'margin-left:200px; margin-top:0px'><u><b>Admin User Data</b></u></p><table class = 'table table-hover table-light mx-md-1'><tr><td>id</td>";
					userTable += "<td>Username</td>";
					userTable += "<td>Password</td>";
					userTable += "<td>Admin</td>";
					userTable += "<td>Banned</td></tr>";
		            //Make the history table
		            for (let [key,value] of Object.entries(users)) {
		    			userTable += "<tr><td>"+value["id"]+"</td>";
		    			userTable += "<td>"+value["username"]+"</td>";
		    			userTable += "<td>"+value["pass"]+"</td>";
						userTable += "<td>"+value["isAdmin"]+"</td>";
		    			userTable += "<td>"+value["banned"]+"</td></tr>";
		            }

		          //Display history table
		            $("#admin-user-table").html(userTable);
				}
			else {
				console.log("Failed to get admin data. Error Details: \n"+response);
				}
			}
		});
	}

	function displayAdminTools(username,password) {
		var toolsForm = "<p style = 'margin-left:50px; margin-top:0px'><u><b>Admin User Tools</b></u></p><form style= 'margin-left: 50px' onsubmit='return false'>";
		toolsForm += "<br>Select Username: <input type='text' class='form-control' placeholder = 'Username' id = 'select-box'>";
		toolsForm += "<br><div class ='form-group'><input type='submit' class='btn btn-primary btn-block' id='select-send' value='Select'></div>";
		toolsForm += "<br><div class ='form-group' id = 'selected-user' style='text-align:center;font-weight:bold;text-decoration:underline'>No Selected User</div>";

		toolsForm += "</form>";
		$("#admin-user-tools").html(toolsForm);

		var dToolsForm = toolsForm;
		var addOns = "";

		var selectedUser;
		
		$("#select-send").click(function(){
			console.log("Searching for user!");
			var searchname = $("#select-box").val();
			var ajaxurl = "<?php echo $backup . 'chat-simulator/chat-app/user/admin_code.php'?>";
			var userPrint = "";
			data =  {get_auser_data: "get_auser_data",
	                username:username,
	                password:password,
	                searchname:searchname};
			$.ajax({type:'post',url:ajaxurl, data, success:function(response) {
				if (response.substring(0,9) == "Success: ") {
					response = response.substring(9,response.length);
						console.log(response);
						adata = JSON.parse(response);
						console.log(adata);
						userPrint = "";
						for (let [key,value] of Object.entries(adata)) {
							userPrint = "<p id = 'disp-user'>Selected User: "+value["username"]+"</p>"
							userPrint += "<p id = 'disp-pass'>Password: "+value["pass"]+"</p>"
							userPrint += "<p = 'disp-banned'>User Banned: "+((value["banned"]==1)?"True":"False")+"</p>";
							userPrint += "<p>User is admin: "+((value["isAdmin"]==1)?"True":"False")+"</p>";
							userPrint += "<br>New Username: <input type='text' class='form-control' placeholder = 'Username' value = '"+value["username"]+"' id = 'rename-user-box'>";
							userPrint += "<br>New Password: <input type='password' class='form-control' placeholder = 'Password' value = '"+value["pass"]+"' id = 'rename-pass-box'>";
							userPrint += "<br>Banned: <input type='checkbox' class='form-control' id = 'banned-box'"+((value["banned"]==1)?"checked":"")+">";
							userPrint += "<br><div class ='form-group'><input type='submit' class='btn btn-primary btn-block' id='change-user-send' value='Change user data'></div>";
							console.log(userPrint);
			    			$("#selected-user").html(userPrint);

			    			//Handles changing user data
			    			$("#change-user-send").click(function() {
			    				console.log("Updating user data!");
			    				var newname = $("#rename-user-box").val();
			    				var newpass = $("#rename-pass-box").val();
			    				var banned = $("#banned-box").prop("checked");
			    				console.log(banned);
			    				ajaxurl = "<?php echo $backup . 'chat-simulator/chat-app/user/admin_code.php'?>";
			    				userPrint = "";
			    				data =  {auser_update: "auser_update",
			    		                username:username,
			    		                password:password,
			    		                searchname:searchname,
			    		                newname:newname,
			    		                newpass:newpass,
			    		                banned:banned};
			    				$.ajax({type:'post',url:ajaxurl, data, success:function(response) {
			    					if (response == "Success!") {
				    						
			    							displayAdminData(username,password);
			    							$("#disp-user").text("Selected User: "+newname);
			    							$("#disp-passr").text("Password: "+newpass);
			    							$("#disp-banned").text("User Banned: "+banned);
			    						}
			    					else {
			    						console.log("Failed to update user data. Error Details: \n"+response);
			    							
			    							}
			    					}
			    				});
			    			});
			            }
					}
				else {
					console.log("Failed to get admin user data. Error Details: \n"+response);
						
						}
					}
				});
			});
		}
	
	
	$(document).ready(function(){
		// Kick us out if we are not logged in
		if (getCookie("loggedin") != "true") {
			var path = window.location.pathname;
			var page = path.split("/").pop();
			var origpath = path.substring(0,path.length-page.length);
			window.location.href = origpath + "index.php";
		}
		
		var ajaxurl = "<?php echo $backup . 'chat-simulator/chat-app/user/history_code.php'?>";
        var username = getCookie("username");
        var password = getCookie("password");
        console.log("Gathering User Data");
        data =  {get_histories: "get_histories",
                username:username,
                password:password};
        //Request Histories from server
        histories = [];
        $.ajax({type:'post',url:ajaxurl, data, success:function (response) {
            console.log(response);
            histories = JSON.parse(response);
            console.log(histories);
        	//console.log(histories); 
    		var histTable = "<p style = 'margin-left:50px;'><u><b>Login Histories</b></u></p><table class = 'table table-hover table-light table-bordered mx-md-n1'><tr><td>Login Date/Time</td><td>Logout Date/Time</td></tr>";
			
            //Make the history table
            for (let [key,value] of Object.entries(histories)) {
    			histTable += "<tr><td style = 'width = 300px;'>"+value["login_time"]+"</td><td>" + value["logout_time"] + "</td></tr>";
            }

            //Display history table
            $("#history-table").html(histTable);
       	}

		

	});

      //Get admin tools and data if we are an admin user
		if (getCookie("admin") == "true") {
			displayAdminData(username,password);
			displayAdminTools(username,password);
		}
		else {
			console.log("Not an admin! "+getCookie("admin"));
		}
	});
	</script>

</html>
