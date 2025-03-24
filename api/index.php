<?php 
include '../config.php';
header("Content-Type: application/json");

// Get the URI and sanitize it
$uri = explode("/", trim($_SERVER["REQUEST_URI"], "/"));
$endpoint = filter_var($uri[count($uri) - 1], FILTER_SANITIZE_STRING);

// Check the endpoint and include the corresponding file
switch (true) {
    case str_starts_with($endpoint, "authors"):
        require_once "authors.php";
        break;
    case str_starts_with($endpoint, "categories"):
        require_once "categories.php";
        break;
    case str_starts_with($endpoint, "quotes"):
        require_once "quotes.php";
        break;
    default:
        echo json_encode(["message" => "Invalid API endpoint"]);
}
?>
