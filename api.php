<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
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
        $stmt = $conn->prepare("INSERT INTO products (name, brand, price, stock, description, image_url) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param(
            "ssdiss",
            $input['name'],
            $input['brand'],
            $input['price'],
            $input['stock'],
            $input['description'],
            $input['image_url']
        );

        if ($stmt->execute()) {
            echo json_encode(["message" => "Product created", "id" => $conn->insert_id]);
        } else {
            echo json_encode(["error" => $stmt->error]);
        }
        break;

    case 'PUT':
        $id = intval($_GET['id']);
        $stmt = $conn->prepare("UPDATE products SET name=?, brand=?, price=?, stock=?, description=?, image_url=? WHERE id=?");
        $stmt->bind_param(
            "ssdissi",
            $input['name'],
            $input['brand'],
            $input['price'],
            $input['stock'],
            $input['description'],
            $input['image_url'],
            $id
        );

        if ($stmt->execute()) {
            echo json_encode(["message" => "Product updated"]);
        } else {
            echo json_encode(["error" => $stmt->error]);
        }
        break;

    case 'DELETE':
        $id = intval($_GET['id']);
        $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Product deleted"]);
        } else {
            echo json_encode(["error" => $stmt->error]);
        }
        break;

    default:
        echo json_encode(["error" => "Method not supported"]);
        break;
}

$conn->close();
