<?php
//VSUM - CODE - BLOCK
require('vsum-class.php');   
if(isset($_POST['do']))
{
    if($_POST['do']== 'unregister')
    {         
        //NOTE: Be sure password has been checked before form sending... 
        $user = new vsumClass($_POST['username'],$_POST['password1'],$_POST['password2']);
        $user->vUserLogin();
        $status = $user->vGetUserStatus();
        switch($status)
        {
            case vUserStatus::stValidUser: 
                $user->vLogOut(); 
                $r = $user->vUserDelete(); //Already registered???
                $user->vGoLoginPage($r); //Go to login page if register is done...
                $user = 0;
                break;
            case vUserStatus::stUnknownUser:
            case vUserStatus::stWrongCredentials:
            case vUserStatus::stValidationPending:
            default:                                     
                     $user->vGoLoginPage($r); //Go to login page if register is done...
                                                 
        }
    }
}
//VSUM - CODE - BLOCK - END
?>
<!DOCTYPE html>
<head>
<title>VSUM - Demo - Un-Register</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="css/global.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" /> 
</head>
<body>
<div id="wrapper">
  <div id="logo"> <a href="#"><img src="img/logo.png" alt="" /></a> </div>
  <!--
  <div id="nav">
    <ul>
      <li><a href="page1.php">Page 1</a></li>
      <li>/</li>
      <li><a href="page2.php">Page 2</a></li>
      <li>/</li>
      <li><a href="page3.php">Page 3</a></li>
      <li>/</li>
      <li><a href="page4.php">Page 4</a></li>
    </ul>
  </div>
  -->
  <div id="main" style="background: yellow;">    
    <div class="left">
      <h3>Un-registration form demo</h3>
      <p>Here you can <b>un-register</b> to this demo page.<br/>	
	  </p>
	  <!-- VSUM CODE BLOCK -->
      <form action="unregister.php" enctype="application/x-www-form-urlencoded" method="post">
	  <fieldset>
      <label for="username">Email:</label>
      <input name="username" size="25" type="text" class="field"/>
      <label for="password1">Password:</label>
      <input name="password1" size="25" type="password"class="field"/>
      <label for="password2">Re-type Password:</label>
      <input name="password2" size="25" type="password" class="field"/>
      <input name="submit" type="submit" value="Un-Register" class="button"/>                                    
	  </fieldset>
      <input name="do" size="25" type="hidden" value="unregister"/>
      </form>   
	  <!-- VSUM CODE BLOCK END -->
    </div>    
	<div  class="right">
    <h1><b>VSUM - Vejam Simple User Management</b>, is an Open Source user management Framework written in php, developed as part of <a href="http://www.vejam.info/"> VEJAM Project </a> by Oscar Sanz.<br/><br/>
	VSUM has been designed to be <b>easy and simple</b> to use, configure and adapt to 'any' web.
	<br/><br/>	
	<br/><br/>
	You can get full source under MIT license at <a href="https://code.google.com/p/vsum/"> code.google.com/vsum </a>
	</h1>
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
