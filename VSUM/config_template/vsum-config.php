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

class vsumConfig
{
        public $v_HostName;
        public $v_BataBase;
        public $v_UserName;
        public $v_PassWord;
		public $v_WebmasterEmail;
		public $v_WebmasterEmailSubject;
		public $v_WebmasterNotify;
        public $v_TablePrefix;
        public $v_TableSufix;
        public $v_SqlLog;
        public $v_SqlLogFile;
        public $v_ClassLog;
        public $v_ClassLogFile;
        public $v_ValidationEmailSubject;
        public $v_ValidationEmailTemplate;
        public $v_ValidationEmailFrom;
        public $v_DataBaseEngine;
        public $v_session_expiration;
        public $v_redirect_SiteRoot;
        public $v_redirect_LoginPage;
        public $v_redirect_ActivationPage;
        
    function vsumConfig()
    {        
        $this->v_HostName = "www.hostname.com";
        $this->v_BataBase = "dbNmae";
        $this->v_UserName = "dbUserName";
        $this->v_PassWord = "password";
		$this->v_WebmasterEmail = "webmaster@web.com";		
		$this->v_WebmasterEmailSubject = "App Demo registration!"; 
		$this->v_WebmasterNotify = true;
        $this->v_TablePrefix = "prefix";
        $this->v_TableSufix = "sufix";    //So... table name will be 'prefix_sufix'...
        $this->v_SqlLog = true;  
        $this->v_SqlLogFile = "_________________app-sql.log";  
        $this->v_ClassLog = true;
        $this->v_ClassLogFile = "_________________app-class.log";  
        $this->v_ValidationEmailSubject = "App Demo activation"; 
        $this->v_ValidationEmailTemplate = "./email/template.html"; 
        $this->v_ValidationEmailFrom = "webmaster@web.com";
        $this->v_DataBaseEngine = "mysql"; //"mssql"; "sybase"; "sqlite";   
        $this->v_session_expiration = 5;   //In minutes; 0x00 for disable.
        $this->v_redirect_SiteRoot = "http://www.redirect.com/";
        $this->v_redirect_LoginPage = "index.php";
        $this->v_redirect_ActivationPage = "activate.php";
		//Do not edit below this line...
        $this->v_TableName = $this->v_TablePrefix.$this->v_TableSufix;
    }
}
?>
