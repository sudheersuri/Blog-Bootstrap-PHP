<?php
date_default_timezone_set('UTC');
include_once('class-phpass.php'); 
include '../../db.php'; 


$userexist = checkUserExists();

if($userexist==false)
{
    registerUser();
}


decryptAndValidatePassword();

function checkUserExists()
{
    global $conn;
    $useremail=$_REQUEST["emailid"];
    $strSql = "SELECT * FROM secureusers WHERE emailid = '$useremail'";
    $result = $conn->query($strSql);
    $row = $result->fetch_assoc();
    if($result->num_rows>0)
    {
        echo json_encode(array("status"=>400,"message"=>"User already exists in our records"));
        exit();
    }
    else
         return false;  
}

function registerUser()
{
    global $conn;
    $username = $_REQUEST["username"];
    $emailid = $_REQUEST["emailid"];
    $encpass = getEncryptedPassword();
    $currdate = date('Y/m/d');
    $strSql = "insert into secureusers(username,emailid,pass,joineddate) values('$username','$emailid','$encpass','$currdate')";
    $result = $conn->query($strSql);
    if($conn->affected_rows>0)
    {
      
        echo json_encode(array("status"=>200));
        exit();
    }
    else
    {
        echo json_encode(array("status"=>500,"message"=>"server error"));
        exit();
    }
}
function getEncryptedPassword()
{   
        $plain_password=$_REQUEST["pass"];
        $wp_hasher = new PasswordHash(8, TRUE);
        $password_hashed = $wp_hasher->HashPassword($plain_password);
        return $password_hashed;
}
?>