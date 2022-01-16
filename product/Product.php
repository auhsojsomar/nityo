<?php

class Product{

    // Product Data

    private $name;
    private $unit;
    private $newPrice;
    private $date;
    private $available;
    private $newFileName;
    
    public function validateData(){
        

        $output = array("msgType" => "", "message" => "");
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $this->name = $_POST["name"];
            $this->unit = $_POST["unit"];
            $price = $_POST["price"];
            $this->date = $_POST["date"];
            $this->available = $_POST["available"];
            $fileName = $_FILES["image"]["name"];
            $id = $_POST["id"];

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
            }
            else if(empty($price) || (float) $price < 1){
                $output = array("msgType" => "error", "message" => "Price must be greater than 1");
            }
            else if(empty($this->date)){
                $output = array("msgType" => "error", "message" => "Expiration date is required");
            }
            else if(empty($this->available) || (int) $this->available < 1){
                $output = array("msgType" => "error", "message" => "Available stock must be greater than 1");
            }
            else if(empty($id)){
                if(!empty($fileName)){
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    $validExtension = array("jpg","jpeg","png","gif");
    
                    if(in_array(strtolower($extension), $validExtension)){
    
                        $this->newFileName = md5(rand()) . "." . $extension;
                        $path = "../images/". $this->newFileName;
    
                        if(move_uploaded_file($_FILES["image"]["tmp_name"], $path)){
                            $this->newPrice = number_format((float) $price, 2, ".", "");
                            $output = array("msgType" => "success");
                        }
                    }
                    else{
                        $output = array("msgType" => "error", "message" => "Invalid image extension");
                    }
                }
                else{
                    $output = array("msgType" => "error", "message" => "Picture is required");
                }
            }
            else{
                $this->newPrice = number_format((float) $price, 2, ".", "");
                if(!empty($fileName)){
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    $validExtension = array("jpg","jpeg","png","gif");
    
                    if(in_array(strtolower($extension), $validExtension)){
    
                        $this->newFileName = md5(rand()) . "." . $extension;
                        $path = "../images/". $this->newFileName;
    
                        if(move_uploaded_file($_FILES["image"]["tmp_name"], $path)){
                            $output = array("msgType" => "success");
                        }
                    }
                    else{
                        $output = array("msgType" => "error", "message" => "Invalid image extension");
                    }
                }
                else{
                    $output = array("msgType" => "success");
                }
            }
            
        }

        return $output;
    }

    public function insertData(){

        require_once "../db.php";

        $validate = $this->validateData();

        if($validate["msgType"] == "success"){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $sql = "INSERT INTO products (name, unit, price, date, available, image) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$this->name, $this->unit, $this->newPrice, $this->date, $this->available, $this->newFileName]);
                return array("msgType" => $validate["msgType"], "message" => "Product Added");
            }
        }
        else{
            return $validate;
        }
    }

    public function fetchData(){

        require_once "../db.php";

        $result = array();

        $sql = "SELECT * FROM products";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll();

        foreach($products as $product){
            // DataTables sturcture

            // data:[
            //     {id: "1", name: "Test1"},
            //     {id: "2", name: "Test2"},
            // ]
            $result['data'][] = array(
                $product->name,
                $product->unit,
                $product->price,
                $product->date,
                $product->available,
                number_format($product->available * $product->price, 2), 
                '<img class="img-thumbnail" style="max-height: 100px;" src="./images/'.$product->image.'" alt="'.$product->image.' ">',
                '<button type="button" class="btn btn-warning btn-sm" name="update" id="'.$product->id.'">Update</button>
                <button type="button" class="btn btn-danger btn-sm" name="delete" id="'.$product->id.'">Delete</button>'
            );
        }

        if(empty($result)){
            return array("data" => "");
        }
        else{
            return $result;
        }
    }

    public function deleteData($id){

        require_once "../db.php";

        $sql = "SELECT image FROM products WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $product = $stmt->fetch();
        $path = "../images/$product->image";

        $sql2 = "DELETE FROM products WHERE id = ?";
        $stmt2 = $pdo->prepare($sql2);
        $result = $stmt2->execute([$id]);

        if($result){
            if(file_exists($path)){
                if(unlink($path)){
                    echo "success";
                }
            }
        }
        else{
            echo "error";
        }
    }

    public function fetchSingle($id){

        require_once "../db.php";

        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $product = $stmt->fetch();

        return $product;
    }

    public function updateData($id){

        require_once "../db.php";

        $validate = $this->validateData();

        if($validate["msgType"] == "success"){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $sql = "UPDATE products SET name = ?, unit = ?, price = ?, date = ?, available = ?, image = COALESCE(?, image) WHERE id = $id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$this->name, $this->unit, $this->newPrice, $this->date, $this->available, $this->newFileName]);
                return array("msgType" => $validate["msgType"], "message" => "Data Updated");
            }
        }
        else{
            return $validate;
        }
    }
}

?>