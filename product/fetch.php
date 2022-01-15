<?php

include_once "./Product.php";

$product = new Product();
echo json_encode($product->fetchData());

?>