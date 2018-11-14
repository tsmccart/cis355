<?php
session_start();
        if(!isset($_SESSION["username"])) {
            header("Location: login.php?upload01=Please log in to upload an image!");
        }
// see HTML form (upload03.html) for overview of this program

// include code for database access
require __DIR__ . "/database.php";

// set PHP variables from data in HTML form 
$fileDescription = $_POST['Description']; 
$fileName       = $_FILES['Filename']['name'];
$tempFileName   = $_FILES['Filename']['tmp_name'];
$fileSize       = $_FILES['Filename']['size'];
$fileType       = $_FILES['Filename']['type'];
$fileDescription= $_POST['Description'];

// abort if no filename
if (!$fileName) {
   die("No filename.");
}

// abort if file is not an image
// never assume the upload succeeded
if ($_FILES['Filename']['error'] !== UPLOAD_ERR_OK) {
   die("Upload failed with error code " . $_FILES['file']['error']);
}
$info = getimagesize($_FILES['Filename']['tmp_name']);
if ($info === FALSE) {
   die("Error Unable to determine <i>image</i> type of uploaded file");
}
if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) 
        && ($info[2] !== IMAGETYPE_PNG)) {
   die("Not a gif/jpeg/png");
}

// abort if file is too big
if($fileSize > 2000000) { echo "Error: file exceeds 2MB."; exit(); }

// fix slashes in $fileType variable, if necessary
$fileType=(get_magic_quotes_gpc()==0 ?
$_FILES['Filename']['type'] : 
stripslashes ($_FILES['Filename']));

// put the content of the file into a variable, $content
$fp      = fopen($tempFileName, 'r');
$content = fread($fp, filesize($tempFileName));
$content = addslashes($content);
fclose($fp);

// no longer needed - feature removed from php
// http://php.net/manual/en/function.get-magic-quotes-gpc.php
// restore slashes in $fileType variable, if necessary
if(!get_magic_quotes_gpc()) { $fileName = addslashes($fileName); }

// connect to database
$pdo = Database::connect();
$username = $_SESSION['username'];
// insert file info and content into table
$sql = "UPDATE customers SET filename = '$fileName', filetype = '$fileType', "
        . "filesize = '$fileSize', description = '$fileDescription', content = "
        . "'$content' WHERE email = '$username'";
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$q = $pdo->prepare($sql);
$q->execute(array());

// list all uploads in database 
// ORDER BY BINARY filename ASC (sorts case-sensitive, like Linux)
echo '<br><br>All files in database...<br><br>';
$sql = 'SELECT * FROM customers ' 
    . 'ORDER BY BINARY filename ASC;';

foreach ($pdo->query($sql) as $row) {
    $id = $row['id'];
    $sql = "SELECT * FROM customers where email = $username"; 
    echo $row['id'] . ' - ' . $row['filename'] . ' - ' . $row['description'] . '<br>'
        . '<img width=100 src="data:image/jpeg;base64,'
        . base64_encode( $row['content'] ).'"/>'
        . '<br><br>';
}
echo '<br><br>';

// disconnect
Database::disconnect(); 