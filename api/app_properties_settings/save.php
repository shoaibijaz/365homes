<?php

include_once '../post_header.php';
include_once '_setting.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_setting($db);

$data = $_POST;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

$requestResponse = new RequestResponse();
$requestResponse->result = 0;

$product->is_deleted = 1;

$product->update_delete_status_key();

$result = $product->add_new();

// create the product
if ($result) {
    $requestResponse->result = 1;
    $requestResponse->message = "created.";
} else {
    $requestResponse->result = 0;
    $requestResponse->message = "failed to create.";
}

echo json_encode($requestResponse);
exit;
