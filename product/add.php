<?php

include "../db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $output = array("msgType" => "error", "message" => "");
    
    $name = $_POST["name"];
    $unit = $_POST["unit"];
    $price = $_POST["price"];
    $date = $_POST["date"];
    $available = $_POST["available"];
    $fileName = $_FILES["image"]["name"];
    
    if(empty($name) || !preg_match('/^\pL+$/u', $name)){
        if(empty($name)){
            $output = array("msgType" => "error", "message" => "Product Name is required");
        }
        else{
            $output = array("msgType" => "error", "message" => "Product Name should contain letters only");
            
        }
    }
    else if(empty($unit) || !preg_match('/^\pL+$/u', $unit)){
        if(empty($unit)){
            $output = array("msgType" => "error", "message" => "Unit is required");
        }
        else{
            $output = array("msgType" => "error", "message" => "Unit should contain letters only");
        }
    }else if(empty($price) || (float) $price < 1){
        $output = array("msgType" => "error", "message" => "Price must be greater than 1");
    }else if(empty($date)){
        $output = array("msgType" => "error", "message" => "Expiration date is required");
    }else if(empty($available) || (int) $available < 1){
        $output = array("msgType" => "error", "message" => "Value must be greater than 1");
    }else if(!empty($fileName)){
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $validExtension = array('jpg','jpeg','png','gif');

        if(in_array(strtolower($extension), $validExtension)){
            $newName = md5(rand()) . "." . $extension;
            $path = "../images/". $newName;

            if(move_uploaded_file($_FILES["image"]["tmp_name"], $path)){
                $newPrice = number_format((float) $price, 2, '.', '');
                $sql = "INSERT INTO products (name, unit, price, date, available, image) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$name, $unit, $newPrice, $date, $available, $newName]);

                $output = array("msgType" => "success", "message" => "Product Added");
            }
        }else{
            $output = array("msgType" => "error", "message" => "Invalid image extension");
        }
    }
    else{
        $output = array("msgType" => "error", "message" => "Picture is required");
    }
    
    echo json_encode($output);
}

?>