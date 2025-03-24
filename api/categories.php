<?php
require_once "database.php";

$database = new Database();
$conn = $database->connect();

$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET") {
    if (isset($_GET["id"])) {
        $stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$_GET["id"]]);
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC) ?: ["message" => "category_id Not Found"]);
    } else {
        $stmt = $conn->query("SELECT * FROM categories");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
} elseif ($method == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data["category"])) {
        echo json_encode(["message" => "Missing Required Parameters"]);
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO categories (category) VALUES (?)");
    $stmt->execute([$data["category"]]);
    echo json_encode(["id" => $conn->lastInsertId(), "category" => $data["category"]]);
}
?>
