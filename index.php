<?php 
    include "../../res/head.php";  
?>

<!-- Navigation Bar -->
<?php
	include $backup . 'res/nav.php';
?>

<!--Set Active Page to 'active' in navbar (imported from nav.php)-->
	<script type="text/javascript">
	document.getElementById('nav-bar-home').setAttribute('class', 'active nav-item');
	</script>

	<div id = "content-background">
		<div id = "content">
			<h2><u><b>Proof of Concept Chat App</b></u></h2>

			<p>
				This program demonstrates the core features of a chat app. Users can login and send either global or private messages.
				There are also administrators that can change user's names, passwords, and even ban users if they behave rudely or inappropriately.
			</p>

			<p>
				To try out the app, click the login button in the top right. You can either sign up and make an account, or use the administrator account 'Tr1n3ty' with password 'Th!rdsT1m3Th3Ch4rm!'. 
			</p>
		</div>
	</div>
</body>
</html>
