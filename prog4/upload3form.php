<?php
session_start();
        if(!isset($_SESSION["username"])) {
            header("Location: login.php");
        }
            ?>
<!DOCTYPE html>
<!--            ****************************************
File:           upload03.html
Description:    Uploads image file as BLOB in MySQL table. 
                See also: upload03.php.
SQL table name: upload03: 
                id (int), filename (varchar), filetype (varchar), 
                filesize (int), filecontents (blob), description (varchar)
Source:         Code modified from:
                http://codereview.stackexchange.com/questions/27796/php-upload-to-database
                **************************************** -->
<html>
    
    <head>
        <title>Upload03</title>
        <meta charset="UTF-8">
        <meta name="viewport" 
              content="width=device-width, initial-scale=1.0">
    </head>
    
    <body>
        
        <h1>(3) Upload an image file, and store as BLOB</h1>
        <p>This form will insert an image file (png/jpg/gif) 
            as a binary large object (BLOB), 
            as long as the file is smaller than 2MB. 
            Filename, file contents, and other file information
            will be stored in the MySQL table, upload03.
        </p>
        <form method="post" action="upload03.php" 
              onsubmit="return Validate(this);"
              enctype="multipart/form-data">
            <p>File</p>
            <input type="file" required
                name="Filename"> 
            <p>Description</p>
            <textarea rows="10" cols="35" 
                name="Description"></textarea>
            <br/>
            <input TYPE="submit" name="upload" value="Submit"/>
        </form>
        
        <script>
            var _validFileExtensions = [".jpg", ".jpeg", ".gif", ".png"];    
            function Validate(oForm) {
                var arrInputs = oForm.getElementsByTagName("input");
                for (var i = 0; i < arrInputs.length; i++) {
                    var oInput = arrInputs[i];
                    if (oInput.type == "file") {
                        var sFileName = oInput.value;
                        if (sFileName.length > 0) {
                            var blnValid = false;
                            for (var j = 0; j < _validFileExtensions.length; j++) {
                                var sCurExtension = _validFileExtensions[j];
                                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                                    blnValid = true;
                                    break;
                                }
                            }

                            if (!blnValid) {
                                alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                                return false;
                            }
                        }
                    }
                }

                return true;
            }
        </script>
        
    </body>
    
</html>
