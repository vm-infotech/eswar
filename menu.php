<?php
session_start();
define('myprivateaccess', TRUE);
include_once($_SERVER['DOCUMENT_ROOT']."/conn.php");
if(!isset($_SESSION['id']))
{
	header("Location: index.php");
	exit;
} else
{
$id=$_SESSION['id'];
if($id==1)
{
	$tempbut="Talk Patients";
} else
{
	$tempbut="Talk Pharmacist";
}
$sql = "SELECT * FROM register WHERE id='$id'";
$result = $conn->query($sql);

	if ($result->num_rows == 1)
	{
		while($row = $result->fetch_assoc())
		{
			$name = $row['name'];
		}
	}
}
?>

<!DOCTYPE html>
<html>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
<style>
body {
  margin: 0;
  padding: 0;
}

.img1 {
  background: url(/images/bluebg.jpg) no-repeat center;
  background-size: cover;
  height: 330px;
  position: relative;
}
.img2 {
  background: url(/images/tablet.jpg) no-repeat center;
  background-size: cover;
  height: 330px;
  position: relative;
}
.buttons{
	text-align:center;
	padding-top:50px;

}
input[type=submit] {
    padding:5px 15px;
    background:rgba(0,0,0,0.2);
	color:white;
    cursor:pointer;
	height:50px;
	width:40%;
    border-radius: 2px;
	font-size:15px;
}
input[type=submit]:hover {
    border:2px solid white;
	color:white;
	font-size:20px;
}
h2{color:white;}
.emergency:hover
{
	width:100px;
	height:100px;
 }
</style>
<body>
<div class="img1">
    <a class='dropdown-trigger' href='#' data-target='dropdown1' style="margin:10px; float:right"><img src="/images/settings_white.png" style="width:30px; height:30px; margin:20px;"></a><br>
    <ul id='dropdown1' class='dropdown-content'>
	    <li><a class="blue-text text-darken-2" href="edit-profile.php">Edit Profile</a></li>
	    <li><a class="blue-text text-darken-2" href="change-password.php">Change Password</a></li>
	    <li><a class="blue-text text-darken-2" href="logout.php">Logout</a></li>
  	</ul>
		<center style="padding:20px 100px;">
			<img src="/images/logo.png" style="width:150px; ">
		</center>
		<p class="white-text center" style="font-size:2rem; line-height:3rem;"><?php echo $name; ?></p>
</div>

<div class="img2">
  <div class="buttons">
  <a href="chat.php"><input type="submit" value="<?php echo $tempbut; ?>"></a><br><br>
	<a href="tips.php"><input type="submit" value="Daily Tips"></a><br><br>
	<a href="chat.php?emergency=1"><img src="/images/emergency.png" class="emergency" width="80" height="78" style="border-radius:50px;"></a>
  </div>
</div>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.dropdown-trigger');
    var instances = M.Dropdown.init(elems, {'coverTrigger':false});
  });
</script>
</body>
</html>
