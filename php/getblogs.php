<?php
$conn=new mysqli("localhost","root","","test");
$query = "select  * from blogs";
$result = $result->query($query);
$response = [];
while($row=$result->fetch_assoc())
{
$response[]=$row;
}
echo json_encode($response);
?>