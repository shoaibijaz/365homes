<?php

session_start();

include_once '../post_header.php';
include_once '_image.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_property_image($db);

$data = $_POST;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

$requestResponse = new RequestResponse();
$requestResponse->result = 0;

$result = $product->add_new();

if ($result)
    $requestResponse->result = $db->lastInsertId();

// create the product
if ($result) {
    $requestResponse->message = "created.";
} else {
    $requestResponse->result = 0;
    $requestResponse->message = "failed to create.";
}

echo json_encode($requestResponse);
exit;
