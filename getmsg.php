<?php
session_start();
error_reporting(0);
define('myprivateaccess', TRUE);
include_once($_SERVER['DOCUMENT_ROOT']."/conn.php");

if(isset($_GET['userid']) && isset($_GET['sr']))
{
  $userid = $_GET['userid'];
	$sr = $_GET['sr'];
  if($sr==1)
  {
    $sr=0;
  } else
  {
    $sr=1;
  }
	$sql = "SELECT * FROM chat WHERE userid='$userid' AND sr='$sr' AND seen=0";
	$result = $conn->query($sql);
	if ($result->num_rows >= 1)
	{
		while($row = $result->fetch_assoc())
		{
      $rowmsg=$row['msg'];
  		if (strpos($rowmsg, 'files/sharedfile-') !== false)
  		{
  			$rowmsg="<a href='".$rowmsg."' target='blank'>".$rowmsg."</a>";
      }
			$output.="<tr style='border:none'><td class='left grey lighten-4' style='margin:5px; max-width:300px;padding:10px; border-radius:10px;'>".$rowmsg."</td></tr>";
			$sql2 = "UPDATE chat SET seen=1 WHERE id=".$row['id'];
			$result2 = $conn->query($sql2);
		}
	}
  if($sr==0)
  {
  	$sqlnotif="UPDATE notification SET seen=1 WHERE uto=1 AND ufrom=$userid";
  } else
  {
  	$sqlnotif="UPDATE notification SET seen=1 WHERE uto=$userid AND ufrom=1";
  }
  $conn->query($sqlnotif);
}

echo $output;
?>
