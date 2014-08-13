<?php if(file_exists('vsum-page.php')){include('vsum-page.php');}else{echo "File ERROR!"; exit(0);} ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>VSUM - Demo</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="css/global.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
</head>
<body>
<div id="wrapper">
  <div id="logo"> <a href="#"><img src="img/logo.png" alt="" /></a> </div>
  <div id="nav">
    <ul>
      <li><a href="page1.php">Page 1</a></li>
      <li>/</li>
      <li><a href="page2.php">Page 2</a></li>
      <li>/</li>
      <li><a href="page3.php"><b>Page 3</b></a></li>
      <li>/</li>
      <li><a href="page4.php">Page 4</a></li>
	  <li>/</li>
      <li><a href="vsum-logout.php">LOGOUT</a></li>	 	
      <li>/</li>
      <li><a href="unregister.php">UN-REGISTER</a></li>	             
    </ul>
  </div>
  <div id="main">    
    <div class="left">
	<br/><br/><br/><br/>
	<h1>Now you are logged on Page 3</h1>
    </div>    
	<div  class="right">
  </div>
</div>
<div id="footer">
  <ul>
    <li>&copy;2014 VSUM demo page based on </li>    
    <li>'Studio980' CSS Template designed by <a href="http://www.skyrocketlabs.com/">Skyrocket Labs</a></li>
  </ul>
</div>
</body>
</html>
