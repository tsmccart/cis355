<?php
require __DIR__ . "/database.php";
if(isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];
    
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM customers WHERE email = '$email' AND confirm_code = '$token' AND confirm = 0";
    $q = $pdo->prepare($sql);
    $q->execute(array());
    $data = $q->fetch(PDO::FETCH_ASSOC);
    
    if($data) {
        $sql = "UPDATE customers SET confirm = 1 WHERE email = '$email' AND confirm_code = '$token'";
        $q = $pdo->prepare($sql);
        $q->execute(array());
        header('Location: login.php?confirmSuccess=Your email address has been confirmed and you may log in!');
    }
    else {
        header('Location: login.php?confirmError=Incorrect confirmation address!');
    }
}
else {
    header('Location: login.php?confirmError=Incorrect confirmation address!');
}
    ?>

