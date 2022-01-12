<?php

class Product{

    private $outputMessage;

    // Product Data

    private $name;
    private $unit;
    private $newPrice;
    private $date;
    private $available;
    private $newFileName;
    
    

    public function __construct($outputMessage){
        $this->outputMessage = $outputMessage;
    }

    public function validateData(){
        $output = array("msgType" => "", "message" => "");
    
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $this->name = $_POST["name"];
            $this->unit = $_POST["unit"];
            $price = $_POST["price"];
            $this->date = $_POST["date"];
            $this->available = $_POST["available"];
            $fileName = $_FILES["image"]["name"];

            if(empty($this->name) || !preg_match("/^\pL+$/u", $this->name)){
                if(empty($this->name)){
                    $output = array("msgType" => "error", "message" => "Product Name is required");
                }
                else{
                    $output = array("msgType" => "error", "message" => "Product Name should contain letters only");
                    
                }
            }
            else if(empty($this->unit) || !preg_match("/^\pL+$/u", $this->unit)){
                if(empty($this->unit)){
                    $output = array("msgType" => "error", "message" => "Unit is required");
                }
                else{
                    $output = array("msgType" => "error", "message" => "Unit should contain letters only");
                }
            }else if(empty($price) || (float) $price < 1){
                $output = array("msgType" => "error", "message" => "Price must be greater than 1");
            }else if(empty($this->date)){
                $output = array("msgType" => "error", "message" => "Expiration date is required");
            }else if(empty($this->available) || (int) $this->available < 1){
                $output = array("msgType" => "error", "message" => "Value must be greater than 1");
            }else if(!empty($fileName)){
                $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                $validExtension = array("jpg","jpeg","png","gif");

                if(in_array(strtolower($extension), $validExtension)){

                    $this->newFileName = md5(rand()) . "." . $extension;
                    $path = "../images/". $this->newFileName;

                    if(move_uploaded_file($_FILES["image"]["tmp_name"], $path)){
                        $this->newPrice = number_format((float) $price, 2, ".", "");
                        $output = array("msgType" => "success", "message" => $this->outputMessage);
                    }
                }else{
                    $output = array("msgType" => "error", "message" => "Invalid image extension");
                }
            }
            else{
                $output = array("msgType" => "error", "message" => "Picture is required");
            }
        }

        return $output;
    }

    public function insertData(){

        require_once('../db.php');
        
        $validate = $this->validateData();

        if($validate["msgType"] == "success"){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $sql = "INSERT INTO products (name, unit, price, date, available, image) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$this->name, $this->unit, $this->newPrice, $this->date, $this->available, $this->newFileName]);
                return array("msgType" => $validate["msgType"], "message" => $validate["message"]);
            }

        }else{
            return $validate;
        }
        
    }
}

?>