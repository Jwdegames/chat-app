<?php
include "../db_config.php";

// Attempt to connect to MySQL database
$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($connect === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_POST['get_histories']))
{
    $username=$_POST['username'];
    $password=$_POST['password'];
    $select_data=mysqli_query($connect,"select * from users where username='$username' and pass='$password'");
    $has_user = mysqli_query($connect,"select * from users where username='$username'");
    if ($row = mysqli_fetch_assoc($has_user)) {
        if($row = mysqli_fetch_assoc($select_data)) {
            // $_SESSION['loggedin']= true;
            // $_SESSION['username']=$row['username'];
            //Get Our Histories!
            $result = mysqli_query($connect,"SELECT login_time, logout_time FROM histories WHERE userid=(SELECT id FROM users WHERE username='$username');");
            // $histories[] = array();
            //Store all histories in an array to send to js
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $histories[] = $row; 
            }
            echo json_encode($histories);
            // echo "Success!";
        }
    
        else {
            echo "Invalid Password!";
        }
    }
    else
    {
        echo "Invalid Username!";
    }
    
    exit();
    
}

?>

?>