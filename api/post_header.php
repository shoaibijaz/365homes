<?php
// required headers
header("Access-Control-Allow-Origin: *");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    
    $requestResponse->result = 0;
    $requestResponse->message = "Method is not post.";

    echo json_encode($requestResponse);

    exit;
}

include_once 'database.php';
include_once 'response.php';
?>