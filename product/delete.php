<?php

include_once "Product.php";

$id = $_POST["id"];

$product = new Product();
$product->deleteData($id);

?>