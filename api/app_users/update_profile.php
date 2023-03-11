<?php

session_start();

include_once '../post_header.php';
include_once '_user.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_user($db);

$data = $_POST;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

$requestResponse = new RequestResponse();
$requestResponse->result = 0;

$result = $product->update_profile();

// create the product
if ($result) {
    $requestResponse->result = $product->id;
    $requestResponse->message = "created.";
} else {
    $requestResponse->result = 0;
    $requestResponse->message = "failed to create.";
}

echo json_encode($requestResponse);
exit;
