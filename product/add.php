<?php

include "./Product.php";

$product = new Product();
echo json_encode($product->insertData());

?>