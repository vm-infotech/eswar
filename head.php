<?php if(!defined('myprivateaccess')){die("<head><meta name='robots' content='noindex, nofollow'></head><body>Direct access not permitted</body>");} ?>
<head>
<title>JKKN Pharma</title>
<meta name="description" content="Ask a Pharmacist | JKKN Pharma">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<link rel="manifest" href="/manifest.json">
<meta name="application-name" content="Ask a Pharmacist">
<meta name="apple-mobile-web-app-title" content="Ask a Pharmacist">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="theme-color" content="#214db8">
<meta name="robots" content="noindex, nofollow">
<meta name="google" content="notranslate">
<link href="/css/materialize.css" type="text/css" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<![endif]-->
</head>
<?php
if(isset($_SESSION['id'])) {$sesid = $_SESSION['id'];} else {$sesid=0;}
?>
