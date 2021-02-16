<?php
session_start();
include '../../db.php'; 

$userdetails = getUserDetails();

$username = $userdetails["username"]; 
$encpass = $userdetails["encpass"];

decryptAndValidatePassword();

function getUserDetails()
{
    global $conn;
    $useremail=$_REQUEST["emailid"];
    
    $strSql = "SELECT username,pass FROM secureusers WHERE emailid = '$useremail'";

    $result = $conn->query($strSql);
    
    if($result->num_rows==1)
    {
        $row = $result->fetch_assoc();
        return array("username"=>$row["username"],"encpass"=>$row["pass"]);
    }
    else
        {
            echo json_encode(array("status"=>400,"message"=>"Mail id doesnt exist in our records"));
            exit();
        }
}


function decryptAndValidatePassword()
{
        global $username,$encpass;
        $password=$_REQUEST["pass"];
    
        include_once('class-phpass.php'); 
        $wp_hasher = new PasswordHash(8, TRUE);
        $password_hashed = $encpass;
        $plain_password = $password;
    
        if($wp_hasher->CheckPassword($plain_password, $password_hashed)) {
            $_SESSION["emailid"]=$_REQUEST["emailid"];
            $_SESSION["username"]=$username;
            echo json_encode(array("status"=>200));
            exit();
        }
        else {
            echo json_encode(array("status"=>401,"message"=>"Invalid Credentials"));
            exit();
        }
    
}
?>