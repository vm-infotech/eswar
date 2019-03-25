<?php
error_reporting(0);
define('myprivateaccess', TRUE);
include_once($_SERVER['DOCUMENT_ROOT']."/conn.php");
if ($conn->connect_error)
{
	echo $conn->connect_error;
	exit;
} else
{
	if(isset($_GET['msg']) && isset($_GET['userid']) && isset($_GET['sr']))
	{
		$msg = rawurldecode($_GET['msg']);
		$userid = $_GET['userid'];
		$sr = $_GET['sr'];
		$sql = "INSERT INTO chat (msg, userid, sr) VALUES ('$msg', $userid, $sr)";
		if ($conn->query($sql) === TRUE)
		{
			$output="<tr style='border:none'><td class='right grey lighten-2' style='margin:5px; max-width:300px;padding:10px; border-radius:10px;'>".$msg."</td></tr>";
			$redalert=0;
			if(isset($_GET['emergency'])){$redalert=$_GET['emergency'];}
			if($sr==1)
			{
				$ufrom=1;
				$uto=$userid;
			} else
			{
				$ufrom=$userid;
				$uto=1;
			}
			$sqlnot = "INSERT INTO notification (notif, ufrom, uto, seen, redalert) VALUES ('$msg', $ufrom, $uto, 0, $redalert)";
			if ($conn->query($sqlnot) === TRUE)
			{

			}
		}
	}
}
echo $output;
?>
