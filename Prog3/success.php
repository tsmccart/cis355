<?php
session_start();
if(!isset($_SESSION["username"])) {
    header("Location: login.php");
}
?>
<h1>Success!</h1>
