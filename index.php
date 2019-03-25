<?php
session_start();
define('myprivateaccess', TRUE);
include_once($_SERVER['DOCUMENT_ROOT']."/conn.php");
$error="";
if(isset($_SESSION['id']))
{
	header("Location: menu.php");
	exit;
}
if(isset($_POST['submit']))
{
	$uname = $_POST['uname'];
	$pswd = $_POST['pswd'];
	$sql = "SELECT * FROM register WHERE BINARY uname='$uname' AND BINARY pswd='$pswd'";
	$result = $conn->query($sql);

	if ($result->num_rows == 1)
	{
		while($row = $result->fetch_assoc())
		{
			$_SESSION['id'] = $row['id'];
			header("Location: menu.php");
			die();
		}
	}
else
	{
		$error= "<br><p class='grey-text text-lighten-4 center'>User name or pass is incorrect";
	}
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
<style>
 .main-container  , .image
{
	background-image: url('/images/bluebg.jpg');
	background-repeat: no-repeat;
	background-size: cover;
	background-position: :center;
	background-attachment:fixed;
}
  .uname-pass
{
	background-color: rgba(900,900,900,0.1);
	padding-top: 5%;
	margin-top: 1cm;
	height: 60%;
}
</style>
<body class="row image">
    <div class="main-container"><br><br>
        <!--    logo    -->
        <div class="logo container center">
            <img src="/images/main-logo.png">
        </div>
        <!--    user name and password    -->
        <div class="row uname-pass col s10 m8 l4 push-s1 push-l4 push-m2" style="padding-top:-20px;">
            <form action="" method="POST" class="col s12"><br>
                <div class="input-field">
                    <i class="material-icons prefix">person</i>
                    <input id="username" type="text" name="uname" class="validate" autocomplete="new-username">
                    <label for="username" class="black-text">Username</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">vpn_key</i>
                    <input id="password" type="password" name="pswd" class="validate" autocomplete="new-password">
                    <label for="password" class="black-text">Password</label>
                </div>
                <div class="input-field center" >
                    <button class="btn-large waves-effect waves-light black-text N/A transparent" type="submit" name="submit"><i class="material-icons right">keyboard_arrow_right</i>
                        Login</button>
                </div>
                <div class="input-field center">
				 <a class="btn-large waves-effect waves-light black-text N/A transparent" href="signup.php"><i class="material-icons right">keyboard_arrow_right</i>Sign Up</a>
				</div>
				<div><?php echo $error; ?></div>
            </form>
        </div>
    </div>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
</body>
</html>
