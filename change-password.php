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
  if(isset($_POST['submit']))
  {
    if(!empty($_POST['pswd']) && !empty($_POST['newpswd']) && !empty($_POST['newpswd_2']))
    {
      $pswd = $_POST['pswd'];
      $newpswd = $_POST['newpswd'];
      $newpswd_2 = $_POST['newpswd_2'];
      if($newpswd==$newpswd_2)
      {
        $sql = "SELECT * FROM register WHERE id='$id' AND pswd='$pswd'";
        $result = $conn->query($sql);
       if ($result->num_rows == 1)
       {
         while($row = $result->fetch_assoc())
         {
         	 $sql="UPDATE register SET pswd='$newpswd' WHERE id='$id'";
         		if ($conn->query($sql) === TRUE)
         		{
         			$error="<p class='center white-text'>Password updated successfully</p><br>";
         		}
         		else
         		{
         			$error= "<p class='center white-text'>Something went wrong</p><br>";
         		}
          }
       	} else
        {
           $error="<p class='center white-text'>Please check the old password</p><br>";
        }
      } else
      {
        $error="<p class='center white-text'>New passwords do not match</p><br>";
      }
    } else
    {
      $error="<p class='center white-text'>Please enter all the fields</p><br>";
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
		<form action="change-password.php" method="POST">
        <!--    user name and password    -->
        <div class="row">
            <div class="uname-pass col s10 m8 l4 offset-s1 offset-l4 offset-m2" style="padding:20px">
					          <?php echo $error; ?>
                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <input id="pswd" type="password" name="pswd" class="validate" required>
                        <label for="pswd" class="black-text">Old Password</label>
                    </div>
					          <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <input id="newpswd" type="password" name="newpswd" class="validate" required>
                        <label for="newpswd" class="black-text">New Password</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <input id="newpswd_2" type="password" name="newpswd_2" class="validate" required>
                        <label for="newpswd_2" class="black-text">Re-enter New Password</label>
                    </div>
                    <div class="input-field center">
                        <button class="btn waves-effect waves-light black-text N/A transparent" type="submit" name="submit"><i class="material-icons right">keyboard_arrow_right</i>
                            Change Password</button>
                    </div>
            </div>
          </div>
      </form>
        <!--    username and passwordd div ends here    -->
    </div>

<?php include_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
</body>
</html>
