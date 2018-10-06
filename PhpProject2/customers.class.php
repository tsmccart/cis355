<?php

class Customers {
    
    public $id;
    
    public $name;
    public $email;
    public $mobile;
    
    private $nameError = null;
    private $emailError = null;
    private $mobileError = null;
    
    private $title = "Customer";
    
	//########################################################
	//Purpose: Displays a form to create a new entry.   
	//Preconditions: There must be a valid fun.
	//Postconditions: Makes a call to insert_record() if user clicks Create button.
	//Input: none
	//Output: none
	//Notes: None.
	//########################################################
    function create_record() { // display create form
        echo "
        <html>
            <head>
                <title>Create a $this->title</title>
                    ";
        echo "
                <meta charset='UTF-8'>
                <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
                <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
                    "; 
        echo "
            </head>

            <body>
                <div class='container'>

                    <div class='span10 offset1'>
                        <p class='row'>
                            <h3>Create a $this->title</h3>
                        </p>
                        <form class='form-horizontal' action='customer.php?fun=11' method='post'>                        
                    ";
        $this->control_group("name", $this->nameError, $this->name);
        $this->control_group("email", $this->emailError, $this->email);
        $this->control_group("mobile", $this->mobileError, $this->mobile);
        echo " 
                            <div class='form-actions'>
                                <button type='submit' class='btn btn-success'>Create</button>
                                <a class='btn' href='customer.php'>Back</a>
                            </div>
                        </form>
                    </div>

                </div> <!-- /container -->
            </body>
        </html>
                    ";
    }
    
	//########################################################
	//Purpose: Prints out the name, email and mobile fields for 
	//each record onto a page. Serves as website index. 
	//Preconditions: None 
	//Postconditions: All records are printed out. 
	//Input: none
	//Output: none
	//Notes: None.
	//########################################################
    function list_records() {
        echo "
		
        <html>
            <head>
                <title>$this->title" . "s" . "</title>
                    ";
        echo "
                <meta charset='UTF-8'>
                <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
                <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
                    ";  
        echo "
            </head>
            <body>
                <div class='container'>
                    <p class='row'>
                        <h3>$this->title" . "s" . "</h3>
                    </p>
                    <p>
                        <a href='customer.php?fun=1' class='btn btn-success'>Create</a>
                    </p>
                    <div class='row'>
                        <table class='table table-striped table-bordered'>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                    ";
        $pdo = Database::connect();
        $sql = "SELECT * FROM customers ORDER BY id DESC";
        foreach ($pdo->query($sql) as $row) {
            echo "<tr>";
            echo "<td>". $row["name"] . "</td>";
            echo "<td>". $row["email"] . "</td>";
            echo "<td>". $row["mobile"] . "</td>";
            echo "<td width=250>";
            echo "<a class='btn' href='customer.php?id=".$row["id"]."&&fun=2'>Read</a>";
            echo "&nbsp;";
            echo "<a class='btn btn-success' href='customer.php?id=".$row["id"]."&&fun=3'>Update</a>";
            echo "&nbsp;";
            echo "<a class='btn btn-danger' href='customer.php?id=".$row["id"]."&&fun=4'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        Database::disconnect();        
        echo "
                            </tbody>
                        </table>
                    </div>
                </div>

            </body>

        </html>
                    ";  
    } // end list_records()
    

	//########################################################
	//Purpose: Creates an input field for a selected variable.  
	//Preconditions: There must be a valid id and fun. 
	//Postconditions: An input field an associated variable is output.
	//Input: none
	//Output: none
	//Notes: None.
	//########################################################
    function control_group ($label, $labelError, $val) { 
        echo "<div class='control-group'";
        echo !empty($labelError) ? 'error' : '';
        echo "'>";
        echo "<label class='control-label'>$label</label>";
        echo "<div class='controls'>";
        echo "<input name='$label' type='text' placeholder='$label' value='";
        echo !empty($val) ? $val : '';
        echo "'>";
        if (!empty($labelError)) {
            echo "<span class='help-inline'>";
            echo $labelError;
            echo "</span>";
        }
        echo "</div>";
        echo "</div>";
    }
	
	//########################################################
	//Purpose: Produces a page to confirm the deleting of a record. 
	//Preconditions: There must be a valid id and fun. 
	//Postconditions: delete_record() is called if the user confirms the deletion. 
	//Input: none
	//Output: none
	//Notes: None.
	//########################################################
	function delete_page () { //page to confirm deletion
		echo 
		"<!DOCTYPE html>
		<html lang='en'>
		<head>
			<meta charset='utf-8'>
            <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
            <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
			<link   href='css/bootstrap.min.css' rel='stylesheet'>
			<script src='js/bootstrap.min.js'></script>
		</head>

		<body>
			<div class='container'>
			
						<div class='span10 offset1'>
							<div class='row'>
								<h3>Delete a Customer</h3>
							</div>
							<form class='form-horizontal' action='customer.php?id=".$_GET['id']."&&fun=44' method='post'>";
							  echo "<input type='hidden' name='id' value='<".$_GET['id'].">'/>
							  <p class='alert alert-error'>Are you sure to delete ?</p>
							  <div class='form-actions'>
								  <button type='submit' class='btn btn-danger'>Yes</button>
								  <a class='btn' href='customer.php'>No</a>
								</div>
							</form>
						</div>
						
			</div> <!-- /container -->
		  </body>
		</html>";
	} //end delete_page()
	
	//########################################################
	//Purpose: Deletes a record from the table. 
	//Preconditions: There must be a valid id and fun. 
	//Postconditions: The record is deleted and user is returned to list_records().
	//Input: none
	//Output: none
	//Notes: None.
	//########################################################
	function delete_record () { //deletes a record
		
		//deletes record
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM customers  WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($_GET['id']));
		Database::disconnect();
		header("Location: customer.php");
			
	}
	
	//########################################################
	//Purpose: Produces a page to enter and confirm an update to a record. 
	//Preconditions: There must be a valid id and fun. 
	//Postconditions: If the user selects yes, update_record() is called. 
	//Input: none
	//Output: none
	//Notes: None.
	//########################################################
	function update () {
 
		$pdo = Database::connect();
        $sql = "SELECT * FROM customers WHERE id=".$_GET['id'];
        foreach ($pdo->query($sql) as $row) {
			$nowName = $row["name"];
			$nowEmail = $row["email"];
			$nowCell = $row["mobile"];
		}
		
		echo "<!DOCTYPE html>
		<html lang='en'>
		<head>
			<meta charset='utf-8'>
			<link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
            <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
			<link   href='css/bootstrap.min.css' rel='stylesheet'>
			<script src='js/bootstrap.min.js'></script>
		</head>

		<body>
			<div class='container'>
			
						<div class='span10 offset1'>
							<div class='row'>
								<h3>Update a Customer</h3>
							</div>
							<form class='form-horizontal' action='customer.php?id=".$_GET['id']."&&fun=33' method='post'>";
							  
							$this->control_group("name", $this->nameError, $nowName);
							$this->control_group("email", $this->emailError, $nowEmail);
							$this->control_group("mobile", $this->mobileError, $nowCell);
							
							  echo "<div class='form-actions'>
								  <button type='submit' class='btn btn-success'>Update</button>
								  <a class='btn' href='customer.php'>Back</a>
								</div>
							</form>
						</div>
						
			</div> <!-- /container -->
		  </body>
		</html>"; 
	} // end update()
	
	//########################################################
	//Purpose: Updates a record.  
	//Preconditions: There must be a valid id and fun. There must be a valid
	//entry in the name, email and mobile input boxes. 
	//Postconditions: The record is updated. 
	//Input: none
	//Output: none
	//Notes: None.
	//########################################################
	function update_record () {
		
		// validate input
        $valid = true;
        if (empty($this->name)) {
            $this->nameError = 'Please enter Name';
            $valid = false;
        }

        if (empty($this->email)) {
            $this->emailError = 'Please enter Email Address';
            $valid = false;
        } 


        if (empty($this->mobile)) {
            $this->mobileError = 'Please enter Mobile Number';
            $valid = false;
        }

        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE customers SET name = ?, email = ?, mobile = ? WHERE id=".$_GET['id'];
            $q = $pdo->prepare($sql);
            $q->execute(array($this->name,$this->email,$this->mobile));
            Database::disconnect();
            header("Location: customer.php");
        }
        else {
            $this->update();
        }
	
	}
	
	//########################################################
	//Purpose: Prints out the information in a record onto a page
	//Preconditions: There must be a valid id and fun. 
	//Postconditions: The record is printed. 
	//Input: none
	//Output: $nowName, $nowEmail, $nowCell
	//Notes: None.
	//########################################################
	function read () { //print a record to a page
		
		//retrieve data from table
		$pdo = Database::connect();
        $sql = "SELECT * FROM customers WHERE id=".$_GET['id'];
        foreach ($pdo->query($sql) as $row) {
			$nowName = $row["name"];
			$nowEmail = $row["email"];
			$nowCell = $row["mobile"];
		}
		Database::disconnect();

		 echo "
        <html>
            <head>
                <title>$this->title" . "s" . "</title>
                    ";
        echo "
                <meta charset='UTF-8'>
				<link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
                <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
                <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
                <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
                    ";  
		echo "<body>
				<div class='container'>
			
						<div class='span10 offset1'>
							<div class='row'>
								<h3>Read a Customer</h3>
							</div>
							
							<form class='form-horizontal' action='customer.php?id=".$_GET['id']."&&fun=2' method='post'>
							  <div class='control-group'>
								<label class='control-label'>Name</label>
								<div class='controls'>
									<label class='checkbox'>";
									echo $nowName;
									echo 
									"</label>
								</div>
							  </div>
							  <div class='control-group'>
								<label class='control-label'>Email Address</label>
								<div class='controls'>
									<label class='checkbox'>
									";
									echo $nowEmail;
									
									echo "
									</label>
								</div>
							  </div>
							  <div class='control-group'>
								<label class='control-label'>Mobile Number</label>
								<div class='controls'>
									<label class='checkbox'>";
									
									echo $nowCell;
									echo "
									</label>
								</div>
							  </div>
								<div class='form-actions'>
								  <a class='btn' href='customer.php'>Back</a>
							   </div>
							
							 
							</div>
						</div>
						
			</div> <!-- /container -->
		  </body>
		</html>";
	}// end read()
	
	//########################################################
	//Purpose: Inserts a record into the database.  
	//Preconditions: There must be a valid id and fun.
	//Postconditions: The record is updated or the user is returned to
	//the create_record page if the data is invalid. 
	//Input: none
	//Output: none
	//Notes: None.
	//########################################################
    function insert_record () {
        // validate input
        $valid = true;
        if (empty($this->name)) {
            $this->nameError = 'Please enter Name';
            $valid = false;
        }

        if (empty($this->email)) {
            $this->emailError = 'Please enter Email Address';
            $valid = false;
        } 

        if (empty($this->mobile)) {
            $this->mobileError = 'Please enter Mobile Number';
            $valid = false;
        }

        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->name,$this->email,$this->mobile));
            Database::disconnect();
            header("Location: customer.php");
        }
        else {
            $this->create_record();
        }
    }
    
} // end class Customers