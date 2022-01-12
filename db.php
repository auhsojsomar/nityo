<?php

$server = "localhost";
$username = "root";
$password = "";
$db = "test";

try {
    $pdo = new PDO("mysql:host=$server;dbname=$db",$username,$password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Can't connect to database: ".$e->getMessage();
}



?>
