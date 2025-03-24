<?php
require_once "database.php";

$database = new Database();
$conn = $database->connect();

$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET") {
    $query = "SELECT quotes.id, quotes.quote, authors.author, categories.category 
              FROM quotes 
              JOIN authors ON quotes.author_id = authors.id 
              JOIN categories ON quotes.category_id = categories.id";
    $params = [];

    if (isset($_GET["id"])) {
        $query .= " WHERE quotes.id = ?";
        $params[] = $_GET["id"];
    }

    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} elseif ($method == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data["quote"], $data["author_id"], $data["category_id"])) {
        echo json_encode(["message" => "Missing Required Parameters"]);
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO quotes (quote, author_id, category_id) VALUES (?, ?, ?)");
    $stmt->execute([$data["quote"], $data["author_id"], $data["category_id"]]);
    echo json_encode(["id" => $conn->lastInsertId(), "quote" => $data["quote"], "author_id" => $data["author_id"], "category_id" => $data["category_id"]]);
}
?>
