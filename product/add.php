<?php

include "./Product.php";

$product = new Product("Product Added");
echo json_encode($product->insertData());
// public function insertData(){
//     if($_SERVER["REQUEST_METHOD"] == "POST"){
//         if($output["msgType"] == "success"){
//             $sql = "INSERT INTO products (name, unit, price, date, available, image) VALUES (?, ?, ?, ?, ?, ?)";
//             $stmt = $conn->prepare($sql);
//             $stmt->execute([$name, $unit, $newPrice, $date, $available, $newName]);
//         }
//     }
// }

?>