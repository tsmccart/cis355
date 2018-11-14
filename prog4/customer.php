<?php

require __DIR__ . "/database.php";
require "customers.class.php";
$cust = new Customers();

if(isset($_POST["name"])) $cust->name = $_POST["name"];
if(isset($_POST["email"])) $cust->email = $_POST["email"];
if(isset($_POST["mobile"])) $cust->mobile = $_POST["mobile"];
if(isset($_POST["password_hash"])) $cust->password_hash = $_POST["password_hash"];

if(isset($_GET["fun"])) $fun = $_GET["fun"];
else $fun = 0;

switch ($fun) {
    case 1: // create
        $cust->create_record();
        break;
    case 2: // read
        $cust->read();
        break;
    case 3: // update
        $cust->update();
        break;
    case 4: // delete
        $cust->delete_page();
        break;
    case 5: // join
        $cust->join();
        break;
    case 6: // upload to server
        $cust->upload1();
        break;
    case 11: // insert database record from create_record()
        $cust->insert_record();
        break;
    case 33: // update database record from update_record()
        $cust->update_record();
        break;
    case 44: // delete database record from delete_record()
        $cust->delete_record();
        break;
    case 55: // Allow a new user to Join
        $cust->join_insert();
        break;
    case 66: // confirm upload to server
        $cust->upload1Confirm();
        break;
    case 0: // list
    default: // list
        $cust->list_records();
}