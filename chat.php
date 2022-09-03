<?php
include "../../res/head.php";
?>
<!DOCTYPE html>
<html>


<head>
<title>Jacob's Test Website</title>

</head>

<!-- Navigation Bar -->
<?php
include $backup . 'res/nav.php';
?>

	<!--Set Active Page to 'active' in navbar (imported from nav.php)-->
	  <script type="text/javascript">
		document.getElementById('nav-chat').setAttribute('class', 'active nav-item');
	 </script>
<div id = "content-background">
	<div id = "content">
	<h1 style = "text-align:center;">Chat App</h1>
	<h2><u><b>Welcome <?php echo $_COOKIE['username']?>!</b></u></h2>
	<div style ="width: 75%; display:table;">
		<div style ="display: table-row;">
			<div id = "global-chat-table" style="display:table-cell;"></div>
		
			<div id = "user-table" style ="display:table-cell;"></div>
			
			<div id = "direct-message-table" style ="display:table-cell;"></div>
		</div>
	</div>
</div>

	<script type="text/javascript">

	var histories;
	var users;
	var adata;
	var dmuser;
	
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

	function updateUsers() {
		var ajaxurl = "<?php echo $backup . 'chat-simulator/chat-app/user/chat_code.php'?>";
        var username = getCookie("username");
        var password = getCookie("password");
        console.log("Gathering User Data");
        data =  {get_user_data: "get_user_data",
                username:username,
                password:password};
        //Request Histories from server
        histories = [];
        $.ajax({type:'post',url:ajaxurl, data, success:function (response) {
            console.log(response);
            histories = JSON.parse(response);
            console.log(histories);
        	//console.log(histories);
        	
    		var histTable = "<p style = 'margin-left:50px;'><u><b>Users</b></u></p><table class = 'table table-hover table-light auto'><tr><td>Username</td><td>ID</td><td>Private Message</tr>";
            //Make the history table
            for (let [key,value] of Object.entries(histories)) {
                console.log(JSON.stringify(value["username"]));
    			histTable += "<tr><td>"+value["username"]+"</td><td>"+value["id"]+"</td><td><div class ='form-group'><input type='submit' class='btn btn-primary btn-block' id='pm"+value["username"]+"' value='PM' onclick='dmuser="+JSON.stringify(value['username'])+";updatePrivateChat();'></div></td></tr>";
            }

            //Display history table
            $("#user-table").html(histTable);
       		}

		

		});
	}

	function updatePrivateChat() {
		var ajaxurl = "<?php echo $backup . 'chat-simulator/chat-app/user/chat_code.php'?>";
		var username = getCookie("username");
        var password = getCookie("password");
        pmuser = dmuser;
        console.log(pmuser);
		data = {get_private_chat: "get_private_chat",
				username: username,
				password: password,
				pmuser:pmuser};
		histories = [];
		console.log("Getting private chat info!");
		$.ajax({type:'post',url:ajaxurl, data, success:function (response) {
            console.log(response);
            
            histories = JSON.parse(response);
            console.log(histories);
        	var histTable = "<div class='form-group shadow-textarea' style='margin-left:50px'><label for='exampleFormControlTextarea6' style='text-decoration:underline; font-weight:bold;'>Private Chat With "+dmuser+"</label><div contenteditable='false' class='form-control z-depth-1' id='private-chat' style='width:568px; height:600px' readonly>"
            var globalIn = "";
    		//Make the global chat if we can put it in
            if (response != "null") {
                for (let [key,value] of Object.entries(histories)) {
        			globalIn += "<p style='text-decoration:bold;'><i><b>"+value["username"]+"</b> at "+value["sent"]+"</i></p><p style='margin-left:10px'>"+value["msg"]+"</p>";
                }
            }
			histTable += globalIn + "</textarea></div><br>";
			//Add the chat input area
            //<!--Textarea with icon prefix-->
            histTable +='<div class="md-form" style="margin-left:0px"><i class="fas fa-pencil-alt prefix"></i><label for="form10">Send a message:</label><textarea id="pmsg-send" class="md-textarea form-control" rows="3" cols="60" onkeypress="if(event.keyCode == 13) {sendPrivateMsg();}"></textarea></div></div>';

            //Display chat table
            $("#direct-message-table").html(histTable);
       		}

		

		});
	}

	function updateGlobalSend() {
		var ajaxurl ="<?php echo $backup . 'chat-simulator/chat-app/user/chat_code.php'?>";
		var username = getCookie("username");
        var password = getCookie("password");
		data = {get_global_chat: "get_global_chat",
				username: username,
				password: password};
		histories = [];

		$.ajax({type:'post',url:ajaxurl, data, success:function (response) {
            console.log("get_global_chat: " + response);
            
            histories = JSON.parse(response);
            console.log(histories);
        	var histTable = "<div class='form-group shadow-textarea' style='margin-right:50px'><label for='exampleFormControlTextarea6' style='text-decoration:underline; font-weight:bold;'>Global Chat</label><div contenteditable='false' class='form-control z-depth-1' id='global-chat' style='width:568px; height:600px' readonly>"
            var globalIn = "";
    		//Make the global chat if we can put it in
            if (response != "null") {
                for (let [key,value] of Object.entries(histories)) {
        			globalIn += "<p style='text-decoration:bold;'><i><b>"+value["username"]+"</b> at "+value["sent"]+"</i></p><p style='margin-left:10px'>"+value["msg"]+"</p>";
                }
            }
			histTable += globalIn + "</textarea></div><br>";
			//Add the chat input area
            //<!--Textarea with icon prefix-->
            histTable +='<div class="md-form" style="margin-left:0px"><i class="fas fa-pencil-alt prefix"></i><label for="form10">Send a message:</label><textarea id="gmsg-send" class="md-textarea form-control" rows="3" cols="75" onkeypress="if(event.keyCode == 13) {sendGlobalMsg();}"></textarea></div></div>';

            //Display chat table
            $("#global-chat-table").html(histTable);
       		}

		

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
		
		
		updateUsers();
		updateGlobalSend();
	});

	//Sends a global message
    function sendGlobalMsg() {
		console.log("Sending global message!");
		var ajaxurl = "<?php echo $backup . 'chat-simulator/chat-app/user/chat_code.php'?>";
        var username = getCookie("username");
        var password = getCookie("password");
        var message = $("#gmsg-send").val();
        console.log("Gathering User/Message Data");
        data =  {send_global_message: "send_global_message",
                username:username,
                password:password,
                message:message};
		console.log("Message data: " + data['message']);
        //Send the message
        $.ajax({type:'post',url:ajaxurl, data, success:function (response) {
            console.log(response);
            updateGlobalSend();
            updateUsers();
        }

		});
    }

  //Sends a private message
    function sendPrivateMsg() {
		console.log("Sending private message!");
		var ajaxurl = "<?php echo $backup . 'chat-simulator/chat-app/user/chat_code.php'?>";
        var username = getCookie("username");
        var password = getCookie("password");
        var message = $("#pmsg-send").val();
        console.log("Gathering User/Message Data");
        data =  {send_private_message: "send_private_message",
                username:username,
                password:password,
                pmuser:dmuser,
                message:message};
		console.log("send_private_message data: " + data);
        //Send the message
        $.ajax({type:'post',url:ajaxurl, data, success:function (response) {
            console.log("send_private_message: " + response);
            updatePrivateChat(dmuser);
            //updateUsers();
        }

		});
    }
	</script>

</html>
