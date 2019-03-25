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
if(isset($_POST['uname']))
{
	if(!empty($_POST['name']) && !empty($_POST['uname']) && !empty($_POST['gender']) && !empty($_POST['dob']) && !empty($_POST['age']) && !empty($_POST['email']) && !empty($_POST['phone']))
	{
		$uname = $_POST['uname'];
		$name = $_POST['name'];
		if(isset($_POST['gender'])) {$gender = $_POST['gender'];} else {$gender="Male";}
		$dob = $_POST['dob'];
		$temp=date_create($dob);
		$dob=date_format($temp,"Y-m-d");
		$age = $_POST['age'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$pswd = $_POST['pswd'];
		$rpswd = $_POST['rpswd'];
		if($pswd!=$rpswd)
		{
			$error="<p class='white-text center'>Passwords do not match</p><br>";
		}
		else
		{
			$sql="INSERT INTO register (uname,name,gender,dob,age,email,phone,pswd) VALUES ('$uname','$name','$gender','$dob','$age','$email','$phone','$pswd')";
			if ($conn->query($sql) === TRUE)
			{
				header("Location: index.php");
			}
			else
			{
				$temp=$conn->error;
				if (strpos($temp, 'Duplicate') !== false)
				{
					$error= "<p class='white-text center'>Username already exist</p><br>";
				} else
				{
					$error="<p class='white-text center'>".$temp."</p><br>";
				}
			}
		}
	} else
	{
		$error= "<p class='white-text center'>Please enter all the fields</p><br>";
	}
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
    <style>
    .image
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
        height: 78%;
    }
    </style>

<body class="row image">
	<div class="main-container" style="position:relative;">
		<a href="menu.php" style="margin:10px; float:left; position:fixed; top:0px; left:0px;"><img src="/images/back_white.png" style="width:30px; height:30px; margin:20px;"></a><br><br>
        <!--    logo    -->
        <div class="logo container center">
            <img src="/images/main-logo.png">
        </div>
		<form action="signup.php" method="POST">
        <!--    user name and password    -->
				<div class="row">
            <div class="uname-pass col s10 m8 l4 offset-s1 offset-l4 offset-m2" style="padding:20px">
					          <?php echo $error; ?>
                    <div class="input-field">
                        <i class="material-icons prefix">person</i>
                        <input id="username" type="text" name="uname" class="validate" required>
                        <label for="username" class="black-text">Username</label>
                    </div>
										<div class="input-field">
                        <i class="material-icons prefix">person</i>
                        <input id="name" type="text" name="name" class="validate" required>
                        <label for="name" class="black-text">Full Name</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">person_pin</i>
                        <select name="gender" required>
                            <option value="" disabled selected>Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Transgender">Transgender</option>
                        </select>
                        <!--<label>Gender</label>-->
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">date_range</i>
                        <input id="dob" type="date" name="dob" class="validate" required>
                        <label for="dob" class="black-text">DOB</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">face</i>
                        <input id="age" type="number" name="age" class="validate" required>
                        <label for="age" class="black-text">Age</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">mail_outline</i>
                        <input id="email" type="email" name="email" class="validate" required>
                        <label for="email" class="black-text">Email</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">phone_iphone</i>
                        <input id="phone" type="text" name="phone" maxlength=10 class="validate" required>
                        <label for="phone" class="black-text">Mobile No</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <input id="password" type="password" name="pswd" class="validate" required>
                        <label for="password" class="black-text">Password</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <input id="password2" type="text" name="rpswd" class="validate" oninput="checkpass();" required>
                        <label for="password2" class="black-text">Confirm Password</label>
												<p class="center red-text text-darken-2" id="showpasserr"></p>
                    </div>
                    <div class="input-field center">
                        <button class="btn waves-effect waves-light black-text N/A transparent" type="submit" name="submit"><i class="material-icons right">keyboard_arrow_right</i>
                            Create</button>
                    </div>
            </div>
        </div>
			</form>
        <!--    username and passwordd div ends here    -->
    </div>

<?php include_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
	<script>
	function checkpass()
	{
		var password=document.getElementById("password").value;
		var password2=document.getElementById("password2").value;
		if(password!=password2)
		{
			document.getElementById("showpasserr").innerHTML="Passwords do not match";
		} else
		{
			document.getElementById("showpasserr").innerHTML="";
		}
	}
	</script>
</body>
</html>
