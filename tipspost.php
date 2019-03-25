<?php
session_start();
$servername = "148.72.232.28";
$username="DAGXhAV6lvX2l";
$password="}6oINv-lNVjrq]RvX+zGy@z~";
$dbname="jkkn";
$error="";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(isset($_POST['submit']))
{
  if(!empty($_POST['tips']) && !empty($_POST['title']))
  {
  	$date = date("Y-m-d");
  	$title= $_POST['title'];
  	$tips = $_POST['tips'];
    $sql="INSERT INTO tips (date,title,tips) VALUES ('$date','$title','$tips')";
  	$result = $conn->query($sql);
  }
  header("Location: tips.php");
  exit;
} else
{
      echo "Something when wrong please contact your admin";
}
$conn->close();
?>
