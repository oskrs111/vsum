<?php
/*******************************************************************************
Vejam-Simple-User-Management: 'vsum'
VERSION 1.0, February 2014
********************************************************************************
The MIT License (MIT)

Copyright (c) 2014 Oscar Sanz Llopis

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

require('config/vsum-config.php');
require('vsum-common.php');

interface vUserStatus
{    
    const stValidationPending = 1;  
    const stValidUser = 2;
    const stWrongCredentials = 100;
    const stUnknownUser = 101;   
    const stNullUser = 102;  
	const stSessionExpired = 103;  
    const stEmailSendError = 200;   
}

interface vUserGroup
{    
  const groupUser = "vsum-user";    
}

interface vUserRole
{    
    const roleNormalUser = 0;  
}


class vsumClass 
{    
    private $m_PDO;
    private $m_user;
    private $m_userName;
    private $m_userGroup;
    private $m_userRole;
    private $m_userPassWord;
    private $m_userStatus;
    private $m_vsumConfig;
    private $m_sqlString;
    
    function vsumClass($UserName,$PassWord) 
    {
       $this->m_userGroup = vUserGroup::groupUser;
       $this->m_userRole = vUserRole::roleNormalUser;
       $this->m_vsumConfig = new vsumConfig();
       $this->m_userStatus = vUserStatus::stUnknownUser;
       if(isset($UserName) && isset($PassWord))
       {           
            $this->m_userName = $UserName;
            $this->m_userPassWord = md5($PassWord); //Never use raw password!  
       }
       else if(isset($UserName))
       //This case is used on validation process, username is included on validation string.
       {           
            $this->m_userName = $UserName;
       }
       else
	   {
            //TODO: Add control to detect username / password mistake???
            $this->m_userStatus = vUserStatus::stUnknownUser;            
        }      
    }
      
    function vUserLogin()
    {
		session_start();
		
        $this->m_sqlString  = "SELECT * FROM ";
        $this->m_sqlString .= $this->m_vsumConfig->v_TableName;
        $this->m_sqlString .= " WHERE username='".$this->m_userName;
        $this->m_sqlString .= "' AND password='".$this->m_userPassWord."'";
        
        $this->m_PDO = vDataBaseConnect($this->m_vsumConfig->v_DataBaseEngine,
                                        $this->m_vsumConfig->v_HostName,
                                        $this->m_vsumConfig->v_BataBase,
                                        $this->m_vsumConfig->v_UserName,
                                        $this->m_vsumConfig->v_PassWord);
        
        $this->m_user = vDataBaseQuerry($this->m_sqlString, $this->m_PDO);
        if(sizeof($this->m_user) >= 1) 
        {
            //We just expect one result for this querry...
            $this->m_userStatus = $this->m_user[0]['userstatus'];
            $this->m_userGroup = $this->m_user[0]['usergroup'];
            $this->m_userRole = $this->m_user[0]['userrole'];
            
            if($this->m_userStatus == vUserStatus::stValidUser)
            //Start user session
            {
                
                $_SESSION['vejam'] = 1;
                if($this->m_vsumConfig->v_session_expiration > 0)
                {
                    $_SESSION['vejam-expires'] = time() + ($this->m_vsumConfig->v_session_expiration * 60);
                }
            }
        }
        else
		//Check session status
       {          
           if(isset($_SESSION['vejam']))
           {
                if(isset($_SESSION['vejam-expires']))
           {
               if(time() > $_SESSION['vejam-expires'])
               {
                    $this->m_userStatus = vUserStatus::stSessionExpired;
                    session_destroy();
               }
               else
               {
                   $this->m_userStatus = vUserStatus::stValidUser;
               }
           }
           }
       }      

	    $this->vWriteSqlLog();
		$this->vWriteClasslLog($this->m_user);
		$this->vWriteClasslLog($_SESSION);
		//$this->vWriteClasslLog($_SESSION['vejam']);
		//$this->vWriteClasslLog($_SESSION['vejam-expires']);
	   
       return $this->m_user;
    }
    
    function vUserRegister($sendEmailValidation)
    //$sendEmailValidation: 
    // true -> Validation email will be sent, so account will ned to activate..
    // false -> Do it without mail
    {
        $ret = 0;
        //Ok, here it's supposed we already know that current user does not
        //exists on database, just add it...
        ($sendEmailValidation == true) ? $us = vUserStatus::stValidationPending : $us = vUserStatus::stValidUser;
                               
        $this->m_sqlString  = "INSERT INTO ".$this->m_vsumConfig->v_TableName;
        $this->m_sqlString .= " (username, password, userstatus, validationtoken, usergroup, userrole, lastaccess)"; 
        $this->m_sqlString .= " VALUES ('".$this->m_userName."', ";
        $this->m_sqlString .= "'".$this->m_userPassWord."', ";
        $this->m_sqlString .= "'".$us."', ";
        $this->m_sqlString .= "'".$this->vGetUserToken()."', ";
        $this->m_sqlString .= "'".$this->vGetUserGroup()."', ";
        $this->m_sqlString .= $this->vGetUserRole().", ";
        $this->m_sqlString .= "'".date("d/m/Y-H:i:s")."')";
                        
        if($sendEmailValidation == true)
        {
            //echo "<p>".getcwd()."</p>";
            $path = $this->m_vsumConfig->v_ValidationEmailTemplate;
            $fh = fopen($path, 'r');
            $body = fread($fh, filesize($path));
            fclose($fh);
            
            $body = $this->vTokenReplace($body, "####USER-VALIDATION-NAME####", $this->m_userName);
                        
            $vurl = $this->m_vsumConfig->v_redirect_SiteRoot."/".$this->m_vsumConfig->v_redirect_ActivationPage;
            $vurl = $vurl."?user=".$this->m_userName."&token=".$this->vGetUserToken();
            $body = $this->vTokenReplace($body, "####USER-VALIDATION-URL####", $vurl);

            $headers = "From: ".$this->m_vsumConfig->v_ValidationEmailFrom."\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            
            if (mail($this->m_userName, 
                     $this->m_vsumConfig->v_ValidationEmailSubject,
                     $body,
                     $headers) == false) 
                {
                   return vUserStatus::stEmailSendError;
                }    
                
                $ret = vUserStatus::stValidationPending;
        }   
        
        $this->m_user = vDataBaseQuerry($this->m_sqlString, $this->m_PDO);
        $this->vWriteSqlLog();
        return $ret;
    }
    
    function vUserValidate($validationToken)
    {
        $this->m_sqlString = "UPDATE vejam_users SET userstatus = ".vUserStatus::stValidUser;
        $this->m_sqlString .= " WHERE username = '".$this->m_userName."'";
        $this->m_sqlString .= " AND validationtoken = '".$validationToken."';";
        vDataBaseQuerry($this->m_sqlString, $this->m_PDO);
        $this->m_userStatus = vUserStatus::stValidUser; //If something wrong has happened will see at login page...
        $this->vWriteSqlLog();   
    }
    
    function vUserDelete()
    {
        
    }
    
    function vGetUserStatus()
    //vGetUserStatus()-> Returns the actual state of looged user:
    //vUserStatus::stUnknownUser -> User has not found on database... registration need.
    //vUserStatus::stWrongCredentials -> Wrong credentials, type mistake? 
    //vUserStatus::stValidUser -> User has found on database, with good credentials.
    //vUserStatus::stValidationPending -> User has not validated the user account via email...
    {
        return $this->m_userStatus;
    }
    
    function vGetUserData()
    {
        return $this->m_user;
    }
    
    function vGoLoginPage($loginError)
    {
        $url = $this->m_vsumConfig->v_redirect_LoginPage;
        $url .= "?user=".$this->m_userName;
        if($loginError > 0)
        {
            $url .= '&loginError='.$loginError;
        }
        header('Location: '.$url);              
        die();
    }    
    
    function vGetUserToken()
    {
        return md5($this->m_userName.$this->m_userPassWord.date("d-m-Y-H-i-s"));
    }
    
    function vGetUserGroup()
    {
        return $this->m_userGroup;
    }
    
    function vSetUserGroup($userGroup)
    {
        $this->m_userGroup = $userGroup;
    }
    
    function vGetUserRole()
    {
        return $this->m_userRole;
    }
    
    function vSetUserRole($userRole)
    {
        $this->m_userRole = $userRole;
    }
    
    function vTokenReplace($mainString,$token,$replaceWith)
    {
        return str_replace($token,$replaceWith,$mainString);
    }
    
    function vWriteSqlLog()
    {
        if($this->m_vsumConfig->v_SqlLog == true)
        {
            $fh = "";
            $path = $this->m_vsumConfig->v_SqlLogFile;
            if(filesize($path) > 100000)
            {
                $fh = fopen($path, 'w');  
            }            
            else 
            {
                $fh = fopen($path, 'a');
            }
            
			fwrite($fh,"*********** ".basename($_SERVER['REQUEST_URI'])." - ");
			fwrite($fh, date("F j, Y, g:i:s:u a")); 
			fwrite($fh," ***********\r\n");
            fwrite($fh, $this->m_sqlString."\r\n\r\n");
            fclose($fh);
        }
    }
    
    function vWriteClasslLog($data)
    {
        if($this->m_vsumConfig->v_ClassLog == true)
        {
            $fh = "";
            $path = $this->m_vsumConfig->v_ClassLogFile;
            if(filesize($path) > 100000)
            {
                $fh = fopen($path, 'w');  
            }            
            else 
            {
                $fh = fopen($path, 'a');
            }
            
			ob_start();
			var_dump($data);
			$result = ob_get_clean();

			fwrite($fh,"*********** ".basename($_SERVER['REQUEST_URI'])." - ");
			fwrite($fh, date("F j, Y, g:i:s:u a")); 
			fwrite($fh," ***********\r\n");
            fwrite($fh,$result);
            fwrite($fh, "\r\n\r\n");
            fclose($fh);
        }
    }
}
?>