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

    require('vsum-class.php');   
    if(isset($_POST['username']) && isset($_POST['password']))
    {
        $user = new vsumClass($_POST['username'],$_POST['password'],null);        
    }
	else if(isset($_GET['username']) && isset($_GET['password']))
    {
        $user = new vsumClass($_GET['username'],$_GET['password'],null);        
    }
    else
    {
       $user = new vsumClass(null,null,null); 
    }    
    
	$user->vUserLogin();
    $status = $user->vGetUserStatus();
    switch($status)
    {
        case vUserStatus::stValidUser: 
             break;
        default: $user->vGoLoginPage($status);                             
    }   
?>