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
$sql = "SELECT * FROM register WHERE id='$id'";
$result = $conn->query($sql);
 if ($result->num_rows == 1)
 {
   while($row = $result->fetch_assoc())
   {
     $name = $row['name'];
     $uname = $row['uname'];
     $gender = $row['gender'];
     $dob = $row['dob'];
     $age = $row['age'];
     $email = $row['email'];
     $phone = $row['phone'];

     if(isset($_POST['submit']))
     {
       if(!empty($_POST['name']) && !empty($_POST['uname']) && !empty($_POST['gender']) && !empty($_POST['dob']) && !empty($_POST['age']) && !empty($_POST['email']) && !empty($_POST['phone']))
       {
         $name = $_POST['name'];
         $uname = $_POST['uname'];
         if(isset($_POST['gender'])) {$gender = $_POST['gender'];}
         $dob = $_POST['dob'];
         $temp=date_create($dob);
         $dob=date_format($temp,"Y-m-d");
         $age = $_POST['age'];
         $email = $_POST['email'];
         $phone = $_POST['phone'];
       	 $sql="UPDATE register SET uname='$uname',name='$name',gender='$gender',dob='$dob',age='$age',email='$email',phone='$phone' WHERE id='$id'";
       		if ($conn->query($sql) === TRUE)
       		{
       			$error="<p class='center white-text'>Profile details updated successfully</p><br>";
       		}
       		else
       		{
       			$error= "<p class='center white-text'>Something went wrong</p><br>";
       		}
        }
     	}
   }
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
		<form action="edit-profile.php" method="POST">
        <!--    user name and password    -->
        <div class="row">
            <div class="uname-pass col s10 m8 l4 offset-s1 offset-l4 offset-m2" style="padding:20px">
					          <?php echo $error; ?>
                    <div class="input-field">
                        <i class="material-icons prefix">person</i>
                        <input id="username" type="text" name="uname" class="validate" value="<?php echo $uname; ?>" required>
                        <label for="username" class="black-text">Username</label>
                    </div>
					          <div class="input-field">
                        <i class="material-icons prefix">person</i>
                        <input id="name" type="text" name="name" class="validate" value="<?php echo $name; ?>" required>
                        <label for="name" class="black-text">Full Name</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">person_pin</i>
                        <select name="gender" required>
                            <option value="<?php echo $gender; ?>" selected><?php echo $gender; ?></option>
                            <option value="" disabled>Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Transgender">Transgender</option>
                        </select>
                        <!--<label>Gender</label>-->
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">date_range</i>
                        <input id="dob" type="date" name="dob" class="validate" value="<?php echo $dob; ?>" required>
                        <label for="dob" class="black-text">DOB</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">face</i>
                        <input id="age" type="number" name="age" class="validate" value="<?php echo $age; ?>" required>
                        <label for="age" class="black-text">Age</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">mail_outline</i>
                        <input id="email" type="email" name="email" class="validate" value="<?php echo $email; ?>" required>
                        <label for="email" class="black-text">Email</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">phone_iphone</i>
                        <input id="phone" type="text" name="phone" class="validate" value="<?php echo $phone; ?>" required>
                        <label for="phone" class="black-text">Mobile No</label>
                    </div>
                    <div class="input-field center">
                        <button class="btn waves-effect waves-light black-text N/A transparent" type="submit" name="submit"><i class="material-icons right">keyboard_arrow_right</i>
                            Change</button>
                    </div>
            </div>
          </div>
      </form>
        <!--    username and passwordd div ends here    -->
    </div>

<?php include_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
</body>
</html>
