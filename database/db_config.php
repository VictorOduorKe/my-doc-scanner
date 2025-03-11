<?php

$host="localhost"; // Host name
$_username="root"; // Mysql username
$_database_name="all_users_db"; // Database name
$_password=""; // Mysql password    

// Connect to server and select databse.
$pdo=new PDO("mysql:host=$host;dbname=$_database_name", $_username, $_password);

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: ".$e->getMessage();
   
}