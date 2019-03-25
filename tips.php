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
  $sql = "SELECT * FROM tips";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc())
  {
    $output.= "<tr style='cursor:pointer' onclick='javascript:location.href=\"tipsdetail.php?sno=".$row['sno']."\"'><td>" . $row['sno'] . "</td><td>" . $row['date'] . "</td><td>". $row['title']."</td></tr>";
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

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            color: white;
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
    <a href="menu.php"><img src="/images/back.png" class="col s3" style="width:60px; padding-top:13px"></a>
    <h4 class="col s9" style="margin-top: 15px; line-height:2rem; font-size:2rem"><b>Daily Tips</b></h4>
    </div>
  </div>

  <div class="table" style="height:83vh;">
    <div class="chatbox" style="height:78vh; padding:20px" id="chatboxd">
      <table style="border-collapse: collapse;" id="parent" border="1" class="highlight">
				<tr>
					<th>SI/No</th>
					<th>DATE</th>
					<th>TITLE</th>
				</tr>
        <?php echo $output; ?>
      </table>
    </div>
  </div>
  <div class="footer blue lighten-5">
      <?php echo $doctonly; ?>
  </div>

  <div id="modal1" class="modal">
    <form class="col s12" method="POST" action="tipspost.php">
      <div class="modal-content">
        <h4 class="blue-text">Today's Tips</h4>
        <div class="row">
            <div class="input-field col s6">
                <div class="black-text">TITLE</div><textarea placeholder="Enter the title.." id="textarea0" name="title" class="materialize-textarea"></textarea>
            </div>
            <div class="input-field col s12">
                <textarea id="textarea1" name="tips" class="materialize-textarea"></textarea>
                <label for="textarea1">Enter your tips here..</label>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="waves-effect waves-light btn" style="background-color:#42a5f5;" type="reset" name="Reset">Reset</button>
        <button class="waves-effect waves-light btn" style="background-color:#42a5f5;" type="submit" name="submit">Post</button>
      </div>
    </form>
  </div>
  <?php include_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
</body>

</html>
