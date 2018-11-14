<?php
session_start();
        if(!isset($_SESSION["username"])) {
            header("Location: login.php?upload01=Please log in to upload an image!");
}

require __DIR__ . "/database.php";

$username = $_SESSION['username'];
echo '<br><br>Uploaded Pictures (sql): <br><br>';
$sql = 'SELECT * FROM customers ' 
    . 'ORDER BY BINARY filename ASC';

$pdo = Database::connect();

foreach ($pdo->query($sql) as $row) {
    $id = $row['id'];
    $sql = "SELECT * FROM customers where email = $username"; 
    echo $row['id'] . ' - ' . $row['filename'] . ' - ' . $row['description'] . '<br>'
        . '<img width=100 src="data:image/jpeg;base64,'
        . base64_encode( $row['content'] ).'"/>'
        . '<br><br>';
}
Database::disconnect();