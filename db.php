<?php

$server = "localhost";
$username = "root";
$password = "";
$db = "test";

try {
    $conn = new PDO("mysql:host=$server;dbname=$db",$username,$password);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Can't connect to database: ".$e->getMessage();
}



?>
