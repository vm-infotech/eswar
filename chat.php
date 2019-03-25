<?php
session_start();
error_reporting(0);
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
		if(!isset($_GET['chatuser']))
		{
			header("Location: chatlist.php?emergency=".$emergency);
			exit;
		} else
		{
			$chatuser = $_GET['chatuser'];
			$sr=1;
		}
	}else
	{
		$chatuser = $id;
		$sr=0;
	}
}

$output="";
$sql = "SELECT * FROM chat WHERE userid='$chatuser' AND seen=1 ORDER BY id ASC";
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
		if($row['sr']==1)
		{
			if($id!=1)
			{
				$output.="<tr style='border:none'><td class='left grey lighten-4' style='margin:5px; max-width:300px;padding:10px; border-radius:10px;'>".$rowmsg."</td></tr>";
			} else
			{
				$output.="<tr style='border:none'><td class='right grey lighten-2' style='margin:5px; max-width:300px;padding:10px; border-radius:10px;'>".$rowmsg."</td></tr>";
			}
		} else
		{
			if($id!=1)
			{
				$output.="<tr style='border:none'><td class='right grey lighten-2' style='margin:5px; max-width:300px;padding:10px; border-radius:10px;'>".$rowmsg."</td></tr>";
			} else
			{
				$output.="<tr style='border:none'><td class='left grey lighten-4' style='margin:5px; max-width:300px;padding:10px; border-radius:10px;'>".$rowmsg."</td></tr>";
			}
		}
	}
}
if (isset($_FILES['file']))
{
	$z_target_dir = "files/";
	$z_fileName = $_FILES["file"]["name"];
	$z_fileTmpLoc = $_FILES["file"]["tmp_name"];
	$z_fileType = $_FILES["file"]["type"];
	$z_fileSize = $_FILES["file"]["size"];
	$z_fileErrorMsg = $_FILES["file"]["error"];
	$z_lastelemarray = explode(".", $z_fileName);
	$z_fileExt = end($z_lastelemarray);
	$z_fileconvname = "sharedfile-".uniqid().mt_rand();
	$z_fileconvpath = $z_target_dir.$z_fileconvname.".".$z_fileExt;
	if (file_exists($z_fileTmpLoc))
	{
		if ($z_fileErrorMsg == 1)
		{
			echo "<script>alert('File not supported or large size. Please try again later');</script>";
		} else
		{
			if (move_uploaded_file($z_fileTmpLoc, $z_fileconvpath))
			{
				$sql = "INSERT INTO chat (msg, userid, sr, file) VALUES ('$z_fileconvpath', $chatuser, $sr, 1)";
				if ($conn->query($sql) === TRUE)
				{
					$output.="<tr style='border:none'><td class='right grey lighten-2' style='margin:5px; max-width:300px;padding:10px; border-radius:10px;'><a href='".$z_fileconvpath."' target='blank'>".$z_fileconvpath."</a></td></tr>";
				}
			}
		}
	}
}
if($id==1)
{
	$sqlnotif="UPDATE notification SET seen=1 WHERE uto=".$id." AND ufrom=1";
} else
{
	$sqlnotif="UPDATE notification SET seen=1 WHERE uto=1 AND ufrom=".$chatuser;
}
$conn->query($sqlnotif);
?>

<!DOCTYPE html>
<html>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
  <style>
	.table{

		background:url(/images/chat.jpg) no-repeat;
		background-size: 100% 85%;
		background-position:center;
		background-attachment:cover;
	}
	.chatbox{
		overflow:auto;
	}
	.footer
	{
	   position: fixed;
	   left: 0;
	   bottom: 0;
	   width: 100%;
	   color: white;
	   height:50px;
	}
	.first{width:10%;margin-left:10px;margin-top:15px;}
	.second{width:75%;}
	.third{width:10%;}
	.first,.second,.third{
		display:block;
		float:left;
		padding:2px;
	}
	input[type="text"]{
		color:blue;
		background-color:blue;
	}
</style>

<body style="overflow:hidden">
	<div class="blue" style=" height: 80px;">
		<div class="row">
		<a href="menu.php"><img src="/images/back.png" class="col s3" style="width:60px; padding-top:13px"></a>
		<h4 class="col s9" style="margin-top: 15px; line-height:2rem; font-size:2rem"><b> Talk <?php if($id==1){ echo "Patient"; }else {echo "Pharmacist"; } ?></b></h4>
		</div>
	</div>
	<div class="table" style="height:83vh;">
		<div class="chatbox" style="height:78vh; padding:20px" id="chatboxd">
			<table style="border-collapse: collapse;" id="parent">
				<?php echo $output; ?>
			</table>
		</div>
	</div>
	<div class="footer blue lighten-5">
		<form id="fileform" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post" enctype="multipart/form-data">
			<div class="first black-text file-field input-field"><div class="material-icons">attach_file
			<input type="file" name="file" onchange="submitform();"></div><div class="file-path-wrapper" type="text"></div></div>
		</form>
			<div class="second"><input type="text" name="msg" placeholder="enter text...." id="msg"></div>
			<div class="third"><button class="col btn-flat waves-effect waves-light black-text blue lighten-5" id="submtbtn" style="height:50px;" onclick="ajaxfunc();"><i class="material-icons">send</i></div>
	</div>
	<input type="hidden" id="emergency" value=<?php echo $emergency; ?>>
  <?php include_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
	<script>
	gotolast();
	function gotolast()
	{
		var objDiv = document.getElementById("chatboxd");
	objDiv.scrollTop = objDiv.scrollHeight;
	}
	var mycheck = setInterval(checknewmsg, 1000);
	function checknewmsg()
	{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function()
		{
			if (this.readyState == 4 && this.status == 200)
			{
				msgres=this.responseText;
				if(msgres.length!=0)
				{
					var table = document.getElementById('parent');
					table.innerHTML+=msgres;
					gotolast();
				}
			}
		};
		xmlhttp.open("GET", "getmsg.php?sr="+<?php echo $sr; ?>+"&userid="+<?php echo $chatuser; ?>, true);
		xmlhttp.send();
	}
	</script>
	<script>
	function ajaxfunc()
	{
		var msg = document.getElementById("msg").value;
		emergency = document.getElementById("emergency").value;
		document.getElementById("emergency").value=0;
		if (msg.length != 0)
		{
			var msg = encodeURIComponent(msg);
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function()
			{
				if (this.readyState == 4 && this.status == 200)
				{
					msgres=this.responseText;
					var table = document.getElementById('parent');
						var tr = document.createElement('tr');
						var td = document.createElement('td');
						var text = document.createTextNode(msgres);

						tr.appendChild(td);
						table.appendChild(tr);
						tr.style.border="none";
						tr.innerHTML=msgres;
						document.getElementById("msg").value="";
						gotolast();
				}
			};
			xmlhttp.open("GET", "submitmsg.php?sr="+<?php echo $sr; ?>+"&userid="+<?php echo $chatuser; ?>+"&msg=" + msg + "&emergency=" + emergency, true);
			xmlhttp.send();
		}
	}
	</script>
	<script>
	addEventListener('keypress', function (e) {
    var key = e.which || e.keyCode;
    if (key === 13) {
			ajaxfunc();
    }
});
	</script>
	<script>
		function submitform()
		{
			form=document.getElementById('fileform');
			form.method="POST";
			form.action="<?php echo $_SERVER["REQUEST_URI"];?>";
			form.enctype="multipart/form-data";
			form.submit();
		}
	</script>
</body>
</html>
