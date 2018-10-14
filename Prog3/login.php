<?php
session_start();
require __DIR__ . "/database.php";

//check for errorMessage and logout, then initialize them
if(isset($_GET['errorMessage']))
    $errorMessage = $_GET['errorMessage'];
else
    $errorMessage = '';
if(isset($_GET['logout']))
    $logout = $_GET['logout'];
else
    $logout = '';
    
       
        
if($_POST) {
    $success = false;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = MD5($password); 
    //echo $username . ' ' . $password; exit();
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM customers WHERE email = '$username' AND password_hash = '$password' LIMIT 1";
    $q = $pdo->prepare($sql);
    $q->execute(array());
    $data = $q->fetch(PDO::FETCH_ASSOC);
    //print_r ($data); exit();
    if($data) {
        $_SESSION["username"] = $username;
        header("Location: customer.php" ); //?id=$username
    }
        
    else {
        header("Location: login.php?errorMessage=Invalid Username or Password");
    }
}
?>
<h1>Log in</h1>
<form class="form-horizontal" action="login.php" method="post">
    
    <input name="username" type="text" placeholder="me@email.com" required>
    <input name="password" type="password" required>
    <button type="submit" class="btn btn-success">Sign In</button>
    <a class='btn btn-success' href='customer.php?fun=5'>Join</a>
    <a href='logout.php' >Log Out</a>
    <p style='color: red;'><?php echo $errorMessage ?></p>
    <p style='color: green;'><?php echo $logout ?></p>
</form>