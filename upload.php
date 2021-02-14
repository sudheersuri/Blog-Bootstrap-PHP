<?php
$ext="";
$file="";
$conn=new mysqli("localhost","root","","test");
if(isset($_REQUEST["submit"]))
{
    
    $file = $_FILES["myfile"];
    checkFileExtension();
    checkFileSize();
    uplodFileToDestination();
}
function checkFileExtension()
{
    global $ext;
    $filename=$_FILES["myfile"]["name"];
    $tmparray = explode(".",$filename);
    $ext = strtolower(end($tmparray));
    $extarray=["jpg","jpeg","png"];
    if(!in_array($ext,$extarray))
    {
        echo "Invalid file size given";
        exit();
    }
}
function checkFileSize()
{
   $onemb=1000000;
   if($_FILES["myfile"]["size"]>($onemb))
   {
       echo $_FILES["myfile"]["size"];
        echo "file too large";
        exit();
   }
}
function uplodFileToDestination()
{
    global $file,$ext;
    $newname = uniqid('',true).".".$ext;
    $filepath = $_FILES["myfile"]["tmp_name"];
    $destination="uploads/".$newname;
    move_uploaded_file($filepath,$destination);
    insertInTable($destination);
    exit();
}
function insertInTable($location)
{
    global $conn;
    $date = date("Y/m/d");
    $title = $_REQUEST["title"];
    $sdesc = $_REQUEST["sdesc"];
    $fdesc = $_REQUEST["fdesc"];
    $category = $_REQUEST["category"];
    $query = "insert into blogs(title,sdesc,fdesc,imglocation,category,dateadded) values('$title','$sdesc','$fdesc','$location','$category','$date')"; 
    $result = $conn->query($query);
    if($conn->affected_rows==1)
        header("Location: index.html");
    else
        echo $conn->error;
}
?>