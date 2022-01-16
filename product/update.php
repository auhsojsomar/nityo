<?php

include_once "Product.php";

$id = $_POST["id"];

$product = new Product();
echo json_encode($product->updateData($id));

?>