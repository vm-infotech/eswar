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
    $doctonly="<p class='center'><a class='waves-effect waves-light btn modal-trigger purple darken-2' href='#modal1'>Add New Tips</a></p>";
	} else
  {
    $doctonly="<p class='center purple-text text-darken-2'>Welcome to Pharma Tips</p>";
  }
  $output="";
  if(isset($_GET['sno']))
  {
    $sno=$_GET['sno'];
    $sql = "SELECT * FROM tips WHERE sno='$sno'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc())
    {
      $output.= "<div class='section' style='border:1px solid black;'><h5 class='center blue-text text-darken-4' style='font-size:1.4rem; font-weight:bold'>" . $row['title'] . "</h5><h6 style='text-align:right; margin-right:10px; font-size:0.8rem'>" . $row['date'] . "</h6></div><br><div>". $row['tips']."</div>";
    }
  } else
  {
    $output.="<p class='center'>The data does not exist. It may be deleted. Please contact administrator.</p>";
  }
  $conn->close();
}
?>
<!DOCTYPE html>
<html>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
    <style>
        .table {

            background: url(/images/bg.png) no-repeat;
            background-size: 100% 85%;
            background-position: center;
            background-attachment: contain;
        }

        .chatbox {
            overflow: auto;
        }

        .third {
            width: 10%;
            display: block;
            padding: 2px;
        }

        input[type="text"] {
            color: blue;
            background-color: blue;
        }
		.title:hover{
			background-color:teal;
			color:white;
			border:none;
		}
		.tips{
			background-color:gray;
			color:blue;
			padding:10px;
		}
		td:hover{
			background-color:teal;
			color:white;
		}
    </style>
<body style="overflow:hidden">
  <div class="blue" style=" height: 80px;">
    <div class="row">
    <a href="tips.php"><img src="/images/back.png" class="col s3" style="width:60px; padding-top:13px"></a>
    <h4 class="col s9" style="margin-top: 15px; line-height:2rem; font-size:2rem"><b>Daily Tips</b></h4>
    </div>
  </div>

  <div class="table" style="height:90vh;">
    <div class="chatbox" style="height:78vh; padding:20px" id="chatboxd">
      <?php echo $output; ?>
    </div>
  </div>
  <?php include_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
</body>
</html>
