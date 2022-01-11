<?php

include '../db.php';


$name = $_POST['name'];
$unit = $_POST['unit'];
$price = $_POST['price'];
$date = $_POST['date'];
$available = $_POST['available'];
$image = $_POST['image'];

$sql = "INSERT INTO product ('name', 'unit', price, 'date', 'available', 'image') VALUES ('$name', '$unit', '$price', '$date', '$available', '$image')";

if(mysqli_query($connection, $sql){
    echo "Sucess"
})
else{
    echo "Error"
}

mysqli_close($connection)

?>