<?php
require 'PHPMailerAutoload.php';
require 'credential.php';
include_once('class-phpass.php'); 
session_start();

$conn = new mysqli('localhost','root','','test');

if($_REQUEST["type"]=="sendmail")
{   
    $mailid = $_REQUEST["emailid"];
    if(checkUserExists())
    {
      if(resetMailThresholdReached($mailid)==false)
      sendMail($mailid);
      else
      {
      echo json_encode(array("status"=>400,"message"=>"Maxmium reset requests reached <br><br>please try again Tomorrow."));
      exit();
      }
    }
    else
    {
      echo json_encode(array("status"=>400,"message"=>"Mailid doesnt exist in our records"));
      exit();
    }
}
else if($_REQUEST["type"]=="sessioncode")
{
  if(isset($_SESSION["secretcode"]))
  {
    if($_SESSION["secretcode"]==$_REQUEST["secretcode"])
      echo json_encode(array("status"=>200));
  }
  else 
    echo json_encode(array("status"=>400));
}
else if($_REQUEST["type"]=="updatepass")
{
    updatePass();
}

function getUserName()
{
    global $conn;
    $useremail=$_REQUEST["emailid"];
    $strSql = "SELECT username FROM secureusers WHERE emailid = '$useremail'";

    $result = $conn->query($strSql);
    
    if($result->num_rows==1)
    {
        $row = $result->fetch_assoc();
        return array("username"=>$row["username"]);
    }
    else
        {
            echo json_encode(array("status"=>400,"message"=>"Server Error,Please try again later"));
            exit();
        }
}


function resetMailThresholdReached($recipientmailid)
{
  global $conn;
  $strSql = "SELECT * FROM resetcounter WHERE emailid = '$recipientmailid'";
  $result = $conn->query($strSql);
  $currdate = date('Y/m/d');
  if($result->num_rows==0)
  {
    $strSql = "insert into resetcounter(emailid,counter,resetmaildate) values('$recipientmailid',1,'$currdate')";
    $result = $conn->query($strSql);
    if($conn->affected_rows==0)
    {
    echo json_encode(array("status"=>400));
    exit();
    }
    return false;
  }
  else
  {
    $row = $result->fetch_assoc();
    $counter = $row["counter"];
    $mailsentdate= $row["resetmaildate"];
    $currdate=date("Y/m/d");
    if($counter<3 && $mailsentdate==$currdate)
    {
      $strSql = "update resetcounter set counter = (counter+1) where emailid='$recipientmailid'";
      $result = $conn->query($strSql);
      if($conn->affected_rows==0)
      {
      echo json_encode(array("status"=>400));
      exit();
      }
      return false;  
    }
    else if($counter==3 && $mailsentdate==$currdate)
      return true;
    else if($counter==3 && $mailsentdate!=$currdate)  
    {
      $strSql = "update resetcounter set counter = 1 where emailid='$recipientmailid'";
      $result = $conn->query($strSql);
      if($conn->affected_rows==0)
      {
      echo json_encode(array("status"=>400));
      exit();
      }
      return false;  
    }
  }
  
}
function checkUserExists()
{
    global $conn;
    $useremail=$_REQUEST["emailid"];
    $strSql = "SELECT * FROM secureusers WHERE emailid = '$useremail'";
    $result = $conn->query($strSql);
    $row = $result->fetch_assoc();
    if($result->num_rows>0)
        return true;
    else
         return false;  
}
function getSecretCode()
{   
    return rand(1000,9999);
}
function getEncryptedPassword()
{   
        $plain_password=$_REQUEST["passone"];
        $wp_hasher = new PasswordHash(8, TRUE);
        $password_hashed = $wp_hasher->HashPassword($plain_password);
        return $password_hashed;
}
function updatePass()
{
    global $conn;
    $useremail=$_SESSION["emailid"];
    $encpass = getEncryptedPassword();
    $strSql = "UPDATE secureusers set pass='$encpass' where emailid='$useremail'";   
    $result = $conn->query($strSql);
    if($conn->affected_rows>0)
    {
        session_destroy();
        echo json_encode(array("status"=>200));
        exit();
    }
    else
    {
        session_destroy();
        echo json_encode(array("status"=>400));
        exit();
    }
}
function sendMail($recipientmailid)
{
    $code = getSecretCode();
    global $result;
    $snippet = "";
    $mail = new PHPMailer;
    // $mail->SMTPDebug = 4;                              // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.hostinger.com';                   // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = EMAIL;                              // SMTP username
    $mail->Password = PASS;                               // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
    $mail->setFrom(EMAIL, 'Password Recovery');                // from mail id 
    $mail->addAddress($recipientmailid);            // to mail id 
    $mail->addReplyTo(EMAIL);
    // print_r($_FILES['file']); exit;
    // for ($i=0; $i < count($_FILES['file']['tmp_name']) ; $i++) { 
    //   $mail->addAttachment($_FILES['file']['tmp_name'][$i], $_FILES['file']['name'][$i]);    // Optional name
    // }
    $mail->isHTML(true); 
    $userdetails = getUserName();
    $username = $userdetails["username"];
    $mail->Subject = "Password Reset Mail Mail";
    $mail->Body    = "Hi $username, your secret code is <b>$code</b>";
    $mail->AltBody = "Confirmed Mail";
    if(!$mail->send()) {
      session_destroy();
        $result["status"] = 500;
        // $result["message"] = "Error Sending Mail, Please try again later". $mail->ErrorInfo;
        $result["message"] = "Error Sending Mail, Please try again later";
        echo json_encode($result);
        exit();
    } 
    else {
      $_SESSION["emailid"]=$recipientmailid;
      $_SESSION["secretcode"]=$code;
      $result["status"] = 200;  
      $result["message"] = 'Message has been sent';
      echo json_encode($result);
      exit();                   
    }
}

?>