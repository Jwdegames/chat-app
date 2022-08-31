<?php 
    include "../../res/head.php";  
?>

<?php include $backup . "chat-simulator/chat-app/db_config.php";?>
<?php
//Attempt to connect to MySQL database 
// $connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
// $dbs = mysqli_query($connect, "SHOW DATABASES");
// print_r($dbs);

// while( $row = $dbs->fetch_array() )
// {
//     print_r($row);
//     echo "<br />";
// }
// if ($connect === false){
// 	echo "Error!";
//     die("ERROR: Could not connect. " . mysqli_connect_error());
// }

// $username = "Tr1n3ty";
// $password = "Th!rdsT1m3Th3Ch4rm!";
// $select_data=mysqli_query($connect,"select * from users where username='$username' and pass='$password'");
//     $has_user = mysqli_query($connect,"select * from users where username='$username'");
//     if ($row = mysqli_fetch_row($has_user)) {
// 		print_r($row);
// 	}
// 	else {
// 		print_r("Error: Username");
// 	}
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
			<h2><u><b>About Me</b></u></h2>

			<p>
				Howdy! I'm a Computer Science and Statistics double major at Texas A&M and plan to graduate in 2024! I also have minors in Mathematics and Cybersecurity. 
				I'm intersted in the areas of Machine Learning, Data Science, Cybersecurity, and Human-Computer Interaction. 
			</p>

			<p>
				Right now, I'm an undergraduate researcher for the Sketch Recognition Lab (SRL) and a student web technician for the Texas A&M Health Science Center (TAMHSC). 
				For the	SRL, I'm currently helping out to implement a sketch recognition library that can be used for future projects. As part of the TAMHSC, I help to
				maintain over 40 different websites for TAMU schools, education centers, and health centers across Texas. 
			</p>
			
			<p>
				I love tutoring and helping others out. During the School Year, I do peer teaching and peer mentoring for the College of Engineering. Also, in high school, 
				I was part of the SciNow club for my high school, which taught elementary kids advanced science topics. Furthermore, I was also part of the 
				Youth Expanding Services (Y.E.S) program, where I volunteered for various organizations.
			</p>
		</div>
	</div>
</body>
</html>
