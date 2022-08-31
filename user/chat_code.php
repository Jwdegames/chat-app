<?php
/*
 * Jacob's Test Website's History
 * Bootstrap v4.1
 */
// Initialize the session
//session_start();

include "../db_config.php";

// Attempt to connect to MySQL database
$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($connect === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_POST['get_global_chat']))
{
    $username=$_POST['username'];
    $password=$_POST['password'];
    $select_data=mysqli_query($connect,"select * from users where username='$username' and pass='$password'");
    $has_user = mysqli_query($connect,"select * from users where username='$username'");
    if ($row = mysqli_fetch_assoc($has_user)) {
        if($row = mysqli_fetch_assoc($select_data)) {
            
            $result = mysqli_query($connect,"SELECT * FROM globalchat");
            //$histories[] = array();
            //Store all histories in an array to send to js
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $data[] = $row;
            }
            echo json_encode($data);
            //echo "Success!";
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

if(isset($_POST['get_private_chat']))
{
    $username=$_POST['username'];
    $password=$_POST['password'];
    $pmuser=$_POST['pmuser'];
    $select_data=mysqli_query($connect,"select * from users where username='$username' and pass='$password'");
    $has_user = mysqli_query($connect,"select * from users where username='$username'");
    if ($row = mysqli_fetch_assoc($has_user)) {
        if($row = mysqli_fetch_assoc($select_data)) {
            
            $result = mysqli_query($connect,"SELECT * FROM privatechat where (username='$username' AND recipient='$pmuser') OR (recipient='$username' AND username='$pmuser')");
            //$histories[] = array();
            //Store all histories in an array to send to js
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $data[] = $row;
            }
            echo json_encode($data);
            //echo "Success!";
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

if(isset($_POST['get_user_data']))
{
    $username=$_POST['username'];
    $password=$_POST['password'];
    $select_data=mysqli_query($connect,"select * from users where username='$username' and pass='$password'");
    $has_user = mysqli_query($connect,"select * from users where username='$username'");
    if ($row = mysqli_fetch_assoc($has_user)) {
        if($row = mysqli_fetch_assoc($select_data)) {
           
            $result = mysqli_query($connect,"SELECT id,username FROM users where banned=false");
            //$histories[] = array();
            //Store all histories in an array to send to js
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $users[] = $row; 
            }
            echo json_encode($users);
            //echo "Success!";
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

if(isset($_POST['send_global_message']))
{
    $username=$_POST['username'];
    $password=$_POST['password'];
    $message=$_POST['message'];
    $select_data=mysqli_query($connect,"select * from users where username='$username' and pass='$password'");
    $has_user = mysqli_query($connect,"select * from users where username='$username'");
    if ($row = mysqli_fetch_assoc($has_user)) {
        if($row = mysqli_fetch_assoc($select_data)) {
            $result = mysqli_query($connect,"SELECT id FROM users WHERE username='$username'");
            if ($rowres = mysqli_fetch_assoc($result)) {
                $id =  $rowres['id'];
            $query = "INSERT INTO globalchat(userid,username,msg) VALUES($id,'$username','$message')";
            $result = mysqli_query($connect,$query);
            
            echo "Success!";
            }
            else {
                echo "Failed To Get User ID!";
            }
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

if(isset($_POST['send_private_message']))
{
    $username=$_POST['username'];
    $password=$_POST['password'];
    $pmuser=$_POST['pmuser'];
    $message=$_POST['message'];
    $select_data=mysqli_query($connect,"select * from users where username='$username' and pass='$password'");
    $has_user = mysqli_query($connect,"select * from users where username='$username'");
    if ($row = mysqli_fetch_assoc($has_user)) {
        if($row = mysqli_fetch_assoc($select_data)) {
            $result = mysqli_query($connect,"SELECT id FROM users WHERE username='$username'");
            if ($rowres = mysqli_fetch_assoc($result)) {
                $id =  $rowres['id'];
                $result = mysqli_query($connect,"SELECT id FROM users WHERE username='$pmuser'");
                if ($rowres = mysqli_fetch_assoc($result)) {
                    $recid =  $rowres['id'];
                    $query = "INSERT INTO privatechat(userid,username,recipid,recipient,msg) VALUES($id,'$username',$recid,'$pmuser','$message')";
                    $result = mysqli_query($connect,$query);
                    
                    echo "Success!";
                }
            }
            else {
                echo "Failed To Get User ID!";
            }
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

/*
if(isset($_POST['get_auser_data']))
{
    $username=$_POST['username'];
    $password=$_POST['password'];
    $searchname=$_POST['searchname'];
    $select_data=mysqli_query($connect,"select * from users where username='$username' and password='$password'");
    $has_user = mysqli_query($connect,"select * from users where username='$username'");
    if ($row = mysqli_fetch_assoc($has_user)) {
        if($row = mysqli_fetch_assoc($select_data)) {
            //Check to see if we are admin
            $result = mysqli_query($connect,"SELECT isAdmin FROM users WHERE username='$username'");
            if ($row = mysqli_fetch_assoc($result)) {
                $isAdmin = $row['isAdmin'];
                if ($isAdmin == false) {
                    echo $username . " is trying to access admin data!";
                    exit();
                }
                
            }
            $result = mysqli_query($connect,"SELECT * FROM users where username='$searchname'");
            if (mysqli_num_rows($result) == 0) {
                echo "No username found!";
                exit();
            }
            //$histories[] = array();
            //Store all histories in an array to send to js
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $users[] = $row;
            }
            echo "Success: " .json_encode($users);
            //echo "Success!";
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

if(isset($_POST['get_auser_data']))
{
    $username=$_POST['username'];
    $password=$_POST['password'];
    $searchname=$_POST['searchname'];
    $select_data=mysqli_query($connect,"select * from users where username='$username' and password='$password'");
    $has_user = mysqli_query($connect,"select * from users where username='$username'");
    if ($row = mysqli_fetch_assoc($has_user)) {
        if($row = mysqli_fetch_assoc($select_data)) {
            //Check to see if we are admin
            $result = mysqli_query($connect,"SELECT isAdmin FROM users WHERE username='$username'");
            if ($row = mysqli_fetch_assoc($result)) {
                $isAdmin = $row['isAdmin'];
                if ($isAdmin == false) {
                    echo $username . " is trying to access admin data!";
                    exit();
                }
                
            }
            $result = mysqli_query($connect,"SELECT * FROM users where username='$searchname'");
            if (mysqli_num_rows($result) == 0) {
                echo "No username found!";
                exit();
            }
            //$histories[] = array();
            //Store all histories in an array to send to js
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $users[] = $row;
            }
            echo "Success: " .json_encode($users);
            //echo "Success!";
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

if(isset($_POST['auser_update']))
{
    $username=$_POST['username'];
    $password=$_POST['password'];
    $searchname=$_POST['searchname'];
    $newname=$_POST['newname'];
    $newpass=$_POST['newpass'];
    $banned=$_POST['banned'];
    $select_data=mysqli_query($connect,"select * from users where username='$username' and password='$password'");
    $has_user = mysqli_query($connect,"select * from users where username='$username'");
    if ($row = mysqli_fetch_assoc($has_user)) {
        if($row = mysqli_fetch_assoc($select_data)) {
            //Check to see if we are admin
            $result = mysqli_query($connect,"SELECT isAdmin FROM users WHERE username='$username'");
            if ($row = mysqli_fetch_assoc($result)) {
                $isAdmin = $row['isAdmin'];
                if ($isAdmin == false) {
                    echo $username . " is trying to access admin data!";
                    exit();
                }
                
            }
            $result = mysqli_query($connect,"SELECT * FROM users where username='$searchname'");
            if (mysqli_num_rows($result) == 0) {
                echo "No username found!";
                exit();
            }
            else {
                if ($banned == "false") {
                    $banned = 0;
                }
                else {
                    $banned = 1;
                }
                $result = mysqli_query($connect, "UPDATE users SET username = '$newname' WHERE username = '$searchname'");
                $result = mysqli_query($connect, "UPDATE users SET password = '$newpass' WHERE username = '$newname'");
                $result = mysqli_query($connect, "UPDATE users SET banned = '$banned' WHERE username = '$newname'");
            }

            echo "Success!";
            //echo "Success!";
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
    
}*/

?>