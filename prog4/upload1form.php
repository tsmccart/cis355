<?php
session_start();
        if(!isset($_SESSION["username"])) {
            header("Location: login.php?upload01=Please log in to upload an image!");
        }
        ?>
<!DOCTYPE html>
<!--            ****************************************
File:           upload01.html
Description:    Simple PHP file upload, without MySQL. 
                See also: upload01.php.
Source:         Code modified from: 
                http://www.lionblogger.com/how-to-upload-file-to-server-using-php-save-the-path-in-mysql/
                **************************************** 
-->
<html>
    
    <head>
        <title>Upload01</title>
        <meta charset='UTF-8'>
        <meta name='viewport' 
              content='width=device-width, initial-scale=1.0'>
    </head>
    
    <body>
        
        <h1>(1) Upload a file to a server subdirectory</h1>
        <p>This form will perform a simple upload of any file, 
            as long as the file is smaller than 2MB. </p>
        <form method='post' action='upload01.php' 
              enctype='multipart/form-data'>
            <p>File</p>
            <input type='file' 
                name='Filename'> 
            <p>Description</p>
            <textarea rows='10' cols='35' 
                name='Description' disabled></textarea>
            <br/>
            <input TYPE='submit' name='upload' value='Submit'/>
        </form>
        
    </body>
    
</html>


