<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

// เรียกไฟล์เชื่อมต่อฐานข้อมูล
require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $result = $conn->query("SELECT * FROM products WHERE id=$id");
            echo json_encode($result->fetch_assoc());
        } else {
            $result = $conn->query("SELECT * FROM products");
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            echo json_encode($products);
        }
        break;

    case 'POST':
        $name = $input['name'];
        $brand = $input['brand'];
        $price = $input['price'];
        $stock = $input['stock'];
        $description = $input['description'];
        $image_url = $input['image_url'];

        $sql = "INSERT INTO products (name, brand, price, stock, description, image_url) 
                VALUES ('$name','$brand',$price,$stock,'$description','$image_url')";
        echo $conn->query($sql) ? json_encode(["message" => "Product created"]) 
                                 : json_encode(["error" => $conn->error]);
        break;

    case 'PUT':
        $id = intval($_GET['id']);
        $name = $input['name'];
        $brand = $input['brand'];
        $price = $input['price'];
        $stock = $input['stock'];
        $description = $input['description'];
        $image_url = $input['image_url'];

        $sql = "UPDATE products SET name='$name', brand='$brand', price=$price, stock=$stock,
                description='$description', image_url='$image_url' WHERE id=$id";
        echo $conn->query($sql) ? json_encode(["message" => "Product updated"]) 
                                 : json_encode(["error" => $conn->error]);
        break;

    case 'DELETE':
        $id = intval($_GET['id']);
        $sql = "DELETE FROM products WHERE id=$id";
        echo $conn->query($sql) ? json_encode(["message" => "Product deleted"]) 
                                 : json_encode(["error" => $conn->error]);
        break;
}

// ปิดการเชื่อมต่อ
$conn->close();
