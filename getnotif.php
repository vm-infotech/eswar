<?php
session_start();
error_reporting(0);
define('myprivateaccess', TRUE);
include_once($_SERVER['DOCUMENT_ROOT']."/conn.php");

if(isset($_GET['uto']))
{
  $userid = $_GET['uto'];
  if($userid!=0)
  {
    $sqlnot = "SELECT * FROM notification WHERE uto='$userid' AND seen=0 ORDER BY datetime LIMIT 1";
    $resultnot = $conn->query($sqlnot);
    if ($resultnot->num_rows == 1)
    {
      while($rownot = $resultnot->fetch_assoc())
    	{
        $notifid=$rownot['id'];
        $notifmsg=$rownot['notif'];
        echo $notifmsg;
        $sqlnotupdate="UPDATE notification SET seen=1 WHERE id='$notifid'";
        $conn->query($sqlnotupdate);
        if($rownot['redalert']==1)
        {
          echo "HJredXalrt";
        }
      }
    }
  }
}
?>
