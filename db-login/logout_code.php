<?php
// Initialize the session
//session_start();

include "../db_config.php";

// Attempt to connect to MySQL database 
$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($connect === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_POST['do_logout']))
{
    $username=$_POST['username'];
    $has_user = mysqli_query($connect,"select * from users where username='$username'");
    if ($row = mysqli_fetch_row($has_user)) {
        $result = mysqli_query($connect,"SELECT id AS 'id' FROM users");
        if ($rowres = mysqli_fetch_assoc($result)) {
            $userid = $rowres['id'];
            // Find the latest login entry from the user
            $result2 = mysqli_query($connect,"SELECT MAX(id) AS 'id' FROM histories WHERE userid = '$userid'");
            if ($rowres2 = mysqli_fetch_assoc($result2)) {
                $id = $rowres2['id'];
                echo "ID is " . $id . "\n";
                // Update the entry with logout
                $result3 = mysqli_query($connect, "UPDATE histories SET logout_time = CURRENT_TIMESTAMP() WHERE id = '$id'");
                // print_r($result3);
            } else {
                echo "Failed to get maximum history id";
            }
        } else {
            echo "Failed to get User ID";
        }
    } else {
        echo "User doesn't exist";
    }
    $_SESSION['loggedin']= false;
    echo "Complete";
    exit();
    
}
 /*
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    //header("location: welcome.php");
    //exit;
}*/
 
// Include config file
//require_once "res/config.php";
// Define variables and initialize with empty values
//$username = $password = "";
//$username_err = $password_err = "";
//echo "<script> console.log(\"Beginning Login\"); </script>";
// Processing form data when form is submitted
/*
if(){
    echo "<script> console.log(\"Checking Login Data\"); </script>";
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            //header("location: welcome.php");
                            echo "Login Successful!";
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        echo "<script> console.log(\"Finished Login Check\"); </script>";
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}*/
/*
*/
?>

?>