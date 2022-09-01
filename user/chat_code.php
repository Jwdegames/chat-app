<?php
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
            //Store all data in an array to send to js
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
            //Store all data in an array to send to js
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
            $query = "INSERT INTO globalchat(userid,username,msg,sent) VALUES($id,'$username','$message', CURRENT_TIMESTAMP())";
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
                    $query = "INSERT INTO privatechat(userid,username,recipid,recipient,msg,sent) VALUES($id,'$username',$recid,'$pmuser','$message', CURRENT_TIMESTAMP())";
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
?>