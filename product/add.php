<?php

include "../db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $message = "";

    $name = $_POST["name"];
    $unit = $_POST["unit"];
    $price = $_POST["price"];
    $date = $_POST["date"];
    $available = $_POST["available"];

    $fileName = $_FILES["image"]["name"];
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    $validExtension = array('jpg','jpeg','png','gif');

    if(in_array(strtolower($extension), $valid_extension)){
        $newName = md5(rand()) . "." . $extension;
    }

    // if(empty($name) || !preg_match('/^\pL+$/u', $name)){
    //     if(empty($name)){
    //         $message = "Product Name is required";
    //     }
    //     else{
    //         $message = "Product Name should contain letters only";
    //     }
    // }
    // else if(empty($unit) || !preg_match('/^\pL+$/u', $unit)){
    //     if(empty($unit)){
    //         $message = "Unit is required";
    //     }
    //     else{
    //         $message = "Unit should contain letters only";
    //     }
    // }


    
    echo json_encode(array("msgType" => "error", "message" => $message));

    $sql = "INSERT INTO products (name, unit, price, date, available, image) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name, $unit, $price, $date, $available, $fileName]);

}

?>