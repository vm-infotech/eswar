<?php if(!defined('myprivateaccess')){die("<head><meta name='robots' content='noindex, nofollow'></head><body>Direct access not permitted</body>");} ?>
<div id="modalnotif" class="modal">
    <div class="modal-content">
      <h5 class="center purple-text text-darken-2">Important Message</h5>
			<p id="impnotif"></p>
    </div>
    <div class="modal-footer">
			<a href="" onclick="sound.stop();" class="modal-close waves-effect waves-green btn-flat">Close</a>
      <a href="<?php
        if($id==1)
      	{
      		if(!isset($_GET['chatuser']))
      		{
      			echo "chatlist.php";
      			exit;
      		} else
      		{
      			$chatuser = $_GET['chatuser'];
            echo "/chat.php?chatuser=".$chatuser;
      		}
      	} else
        {
          echo "/chat.php";
        }
        ?>" class="waves-effect waves-green btn-flat">Open</a>
    </div>
  </div>
<script src="/js/materialize.js"></script>
<script src="/howler.js"></script>
<script>
    var sound = new Howl({
      src: ['ringtone.ogg', 'ringtone.mp3', 'ringtone.wav'],
			loop: true,
    });
</script>
<script>
	M.AutoInit();
</script>
<script>
<?php
if($_SERVER['PHP_SELF']!="/chat.php")
{
  echo "var mynotif = setInterval(checknotif, 1000);";
}
?>
	function checknotif()
	{
		var xmlnotif = new XMLHttpRequest();
		xmlnotif.onreadystatechange = function()
		{
			if (this.readyState == 4 && this.status == 200)
			{
				msgres=this.responseText;
				if (msgres.indexOf("HJredXalrt") !=-1)
				{
					msgres = msgres.replace("HJredXalrt", "");
				  redalert(msgres);
				}
				if(msgres.length!=0)
				{
					 M.toast({html: msgres})
				}
			}
		};
		xmlnotif.open("GET", "getnotif.php?uto="+<?php echo $sesid; ?>, true);
		xmlnotif.send();
	}
</script>
<script>
function redalert(msg)
{
	elem=document.getElementById("modalnotif");
	var instance = M.Modal.getInstance(elem);
	instance.open();
	document.getElementById("impnotif").innerHTML=msg;
	sound.play();
}
</script>
