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
	$emergency=0;
	if(isset($_GET['emergency']))
	{
		$emergency = $_GET['emergency'];
	}
  $id=$_SESSION['id'];
	if($id==1)
	{
    $output="";
    $id=$_SESSION['id'];
    $sql = "SELECT * FROM chat GROUP BY userid ORDER BY datetime ;";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc())
    {
      if($row['userid']!=1)
      {
        $tempid=$row['userid'];
        $sql1 = "SELECT * FROM register WHERE id='$tempid' ;";
        $result1 = $conn->query($sql1);
        if ($result1->num_rows == 1)
        {
          while($row1 = $result1->fetch_assoc())
          {
            $output .= "<tr class='tabrowd' onclick='javascript:location.href=\"chat.php?emergency=".$emergency."&chatuser=".$tempid."\"'><td style='text-align:center'>".$row1['id']."</td><td>".$row1['name']."</td></tr>";
          }
        }
      }
    }
  } else
  {
    die("You do not have permission to access this page");
  }
}

?>
<!DOCTYPE html>
<html>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
      <style>
        .tabrowd{
          cursor:pointer;
        }
      </style>

		<body>
      <div class="blue" style=" height: 80px;">
    		<div class="row">
    		<a href="menu.php"><img src="/images/back.png" class="col s3" style="width:1.5cm; height:1cm; margin-top: 20px"></a>
    		<h4 class="col s9" style="margin-top: 15px; line-height:2rem; font-size:2rem"><b> Talk pharmacist </b></h4>
    		</div>
    	</div>
      <table>
        <tr><th style="text-align:center">Id Number</th><th>Name</th></tr>
  			<?php echo $output;	?>
      </table>
		<?php include_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
	</body>
</html>
