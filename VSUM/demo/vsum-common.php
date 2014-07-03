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

function vDataBaseConnect($engine,$host,$dbname,$user,$pass)
{
    $DBH = "";
try {      
    switch ($engine) 
    {
        case "mysql": 
        case "mssql":
        case "sybase":
            $DBH = new PDO($engine.":host=".$host.";dbname=".$dbname, $user, $pass);  
            break;
        
        case "sqlite":
            $DBH = new PDO("sqlite:".$dbname);  
            break;

        default:
            vDataBaseError("No avaliable driver for '".$engine."' database engine... ");
            return 0;
    }
}  
catch(PDOException $e)
{  
    vDataBaseError($e->getMessage());
}      
    return $DBH;
}

function vDataBaseQuerry($sqlString, $pdoObject)
{
try
{
    $STH = $pdoObject->prepare($sqlString);
    $STH->execute();   
}
catch(PDOException $e)
{  
    vDataBaseError($e->getMessage());
}    
  return $STH->fetchAll();
}

function vDataBaseGetError($pdoObject)
{
	return $pdoObject->errorInfo();
}

function vDataBaseClose($pdoObject)
{
    $pdoObject = null;
}

function vDataBaseError($errorString)
{
    echo "vsum Error: ".$errorString;
    die();
}
?>