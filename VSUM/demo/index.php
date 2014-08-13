<!DOCTYPE html>
<head>
<title>VSUM - Demo</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="css/global.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- VSUM CODE BLOCK -->
	<script>
        <?php
            if(isset($_GET['loginError']))
            {
                echo "var vsumError = ".$_GET['loginError'].";";
            }
            if(isset($_GET['user']))
            {
                echo "var vsumUser = '".$_GET['user']."';";
            }            
        ?>
        function vSetFormError(setReset)
        {
           //VSUM-TODO: Add form highlight control if need...
        }
        
	    $( document ).ready(function() 
        {     
            if(vsumUser) $("#username").val(vsumUser);
            if(vsumError)
            {
                switch(vsumError)
                {
                    case 1: alert("ERROR: This account has not been activated yet. Please check your email account for registration message.");
                            break;
                    case 2: //VSUM-Everything allrigth!
                            break;                                                    
                    case 200:
                        alert("ERROR: While sending activation email!");
                        vSetFormError(true);
                        break;  
						
                    case 201:
                        alert("ERROR: Registration password mismatch!");                        
						vSetFormError(true);
                        break;  						

					case 103: 	
						alert("WARING: Session expired!");                        
						vSetFormError(true);
						break;

					case 104: 	
						alert("WARING: User logged out!");                        
						vSetFormError(true);
						break;

					case 105: 	
						alert("ERROR: Session error!");       
						vSetFormError(true);
						break;						

					case 106: 	
						alert("INFO: User deleted!");       
						vSetFormError(true);
						break;						
						
                    case 100:                    
                    case 101:                        
					case 102:
                    default: 
                        alert("ERROR: Wrong username or password?");
                        vSetFormError(true);
                        break;                        
                }
            }
	});       
	</script>	
    <!-- VSUM CODE BLOCK END -->
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
      <li><a href="page3.php">Page 3</a></li>
      <li>/</li>
      <li><a href="page4.php">Page 4</a></li>
    </ul>
  </div>
  <div id="main">    
    <div class="left">
      <h3>Login form demo</h3>
      <p>Here you can use<br/>'<b>myname@it.is</b>' as Email,<br/>and '<b>mypass</b>' as Password below or...<br/>
	  Create a <a href="/vsum/demo/register.php">new account</a> for this demo...
	  </p>
	  <!-- VSUM CODE BLOCK -->
      <form action="page1.php" enctype="application/x-www-form-urlencoded" method="post">
        <fieldset>
          <label for="name">Email</label>
          <input type="text" name="username" id="username" size="35" class="field" />
          <label for="email">Password</label>
          <input type="password" name="password" id="password" size="35" class="field" />
          <input type="submit" value="Login" class="button" />
        </fieldset>
      </form>
	  <!-- VSUM CODE BLOCK END -->
    </div>    
	<div  class="right">
    <h1><b>VSUM - Vejam Simple User Management</b>, is an Open Source user management Framework written in php, developed as part of <a href="http://www.vejam.info/"> VEJAM Project </a> by Oscar Sanz.<br/><br/>
	VSUM has been designed to be <b>easy and simple</b> to use, configure and adapt to 'any' web. This page is to demonstrate the VSUM functionality.
	<br/><br/>On the left there is a form to log in to vsum'ed pages. Successful login will take you to 'Page 1' of this demo.
	<br/><br/>Once logged you can navigate between Page 1 to Page 4 without need to authenticate again, using the top links.
	<br/><br/><br/>You can get full source under MIT license at <a href="https://code.google.com/p/vsum/"> code.google.com/vsum </a>
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
