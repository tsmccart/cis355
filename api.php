<?php 
/* ---------------------------------------------------------------------------
 * filename    : fr_api.php
 * author      : George Corser, gcorser@gmail.com
 * description : Returns JSON object of all the names in the fr_persons file, OR 
 *               (if id parameter is specified) only one person's name
 * ---------------------------------------------------------------------------
 */
	require __DIR__ . "/database.php";
	
$pdo = Database::connect();
$test = false;
if(isset($_GET['fun'])) {
    createUser();
}
else {
    if(isset($_GET['id']))  {
        //trim quote marks
        $id = trim($_GET['id'], "\"");
        //if id contains a wildcard character, change the sql statement to handle it.
        if(strpos($id, '*') == FALSE) {
    	    $sql = "SELECT * from customers WHERE id=" . $id; 
        }
        else {
            $id = str_replace("*","%", $id);
            $sql = "SELECT * from customers WHERE id LIKE '" . $id . "' ";
        }
        $arr = array();
        $ti = $pdo->query($sql);
            foreach ($pdo->query($sql) as $row) {
            	array_push($arr, $row['id']);
            	array_push($arr, $row['name']);
            	array_push($arr, $row['email']);
            	array_push($arr, $row['mobile']);
            	array_push($arr, $row['password_hash']);
            }
        Database::disconnect();
        
        echo '{"records by id":' . json_encode($arr) . '}';
    }
    else if(isset($_GET['name']))  {
        $name = trim($_GET['name'], "\"");
        if(strpos($name, '*') == FALSE) {
        	$sql = "SELECT * from customers WHERE name='" . $name . "'"; 
            $arr = array();
            foreach ($pdo->query($sql) as $row) {
            	array_push($arr, $row['id']);
            	array_push($arr, $row['name']);
            	array_push($arr, $row['email']);
            	array_push($arr, $row['mobile']);
            	array_push($arr, $row['password_hash']);
            }
        }
        else {
            $name = str_replace("*","%", $name);
            $sql = "SELECT * from customers WHERE name LIKE '" . $name . "' ";
            $arr = array();
            foreach ($pdo->query($sql) as $row) {
            	array_push($arr, $row['name']);
            }
        }
        
        Database::disconnect();
        echo '{"names":' . json_encode($arr) . '}';
    }
    else if(isset($_GET['email']))  {
        $email = trim($_GET['email'], "\"");
        if(strpos($email, '*') == FALSE) {
        	$sql = "SELECT * from customers WHERE email='" . $email . "'"; 
            $arr = array();
            foreach ($pdo->query($sql) as $row) {
            	array_push($arr, $row['id']);
            	array_push($arr, $row['name']);
            	array_push($arr, $row['email']);
            	array_push($arr, $row['mobile']);
            	array_push($arr, $row['password_hash']);;
            }
        }
        else {
            $email = str_replace("*","%", $email);
            $sql = "SELECT * from customers WHERE email LIKE '" . $email . "' ";
            $arr = array();
            foreach ($pdo->query($sql) as $row) {
            	array_push($arr, $row['name']);
        }

            }
        Database::disconnect();
        echo '{"names":' . json_encode($arr) . '}';
    }
    else {
        $sql = "SELECT * from customers"; 
            $arr = array();
            foreach ($pdo->query($sql) as $row) {
            	array_push($arr, $row['name']);
            }
        Database::disconnect();
        echo '{"names":' . json_encode($arr) . '}';
    }
    	
}



function createUser() {
    if (!empty($_GET['name'])) {
		// keep track validation errors
		$test = true;
		$nameError = null;
		$emailError = null;
		$mobileError = null;
		
		// keep track post values
		$name = $_GET['name'];
		$email = $_GET['email'];
		$mobile = $_GET['mobile'];
		
		if($name{0} == "\"") {
		    $name = trim($name, '\"');
		    $email = trim($email, '\"');
		    $mobile = trim($mobile, '\"');
		}
		    
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($email)) {
			$emailError = 'Please enter Email Address';
			$valid = false;
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}
		
		if (empty($mobile)) {
			$mobileError = 'Please enter Mobile Number';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO customers (name,email,mobile,password_hash) values(?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$email,$mobile, MD5("password")));
			Database::disconnect();
			header("Location: api.php?name=" . $name);
		}
		else {
		}
	}
}
?>