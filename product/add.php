<?php

include "../db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $output = "";
    
    $name = $_POST["name"];
    $unit = $_POST["unit"];
    $price = $_POST["price"];
    $date = $_POST["date"];
    $available = $_POST["available"];
    $fileName = $_FILES["image"]["name"];
    
    $newFileName = "";
    $newPrice = "";

    if(empty($name) || !preg_match('/^\pL+$/u', $name)){
        if(empty($name)){
            $output = "Product Name is required";
        }
        else{
            $output = "Product Name should contain letters only";
        }
    }
    else if(empty($unit) || !preg_match('/^\pL+$/u', $unit)){
        if(empty($unit)){
            $output = "Unit is required";
        }
        else{
            $output = "Unit should contain letters only";
        }
    }else if(empty($price) || (float) $price < 1){
        $output = "Price must be greater than 1";
        $newNumber = number_format((float) $price, 2, '.', '');
        $newPrice = $newNumber;
    }else if(empty($date)){
        $output = "Expiration date is required";
    }else if(empty($available) || (int) $available < 1){
        $output = "Value must be greater than 1";
    }
    else if(!empty($fileName)){
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $validExtension = array('jpg','jpeg','png','gif');

        if(in_array(strtolower($extension), $validExtension)){
            $newName = md5(rand()) . "." . $extension;
            $path = "../images/". $newName;

            if(move_uploaded_file($_FILES["image"]["tmp_name"], $path)){
                $newFileName = $newName;
            }
        }else{
            $output = "Invalid image extension";
        }
    }
    else{
        $output = "Picture is required";
    }

    
    
    
    echo json_encode(array("msgType" => "error", "message" => $output));
    

    // $sql = "INSERT INTO products (name, unit, price, date, available, image) VALUES (?, ?, ?, ?, ?, ?)";
    // $stmt = $conn->prepare($sql);
    // $stmt->execute([$name, $unit, $price, $date, $available, $fileName]);

}

?>