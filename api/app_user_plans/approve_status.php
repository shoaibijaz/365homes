<?php

include_once '../post_header.php';
include_once '_user_plan.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_user_plan($db);

$data = $_POST;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

$requestResponse = new RequestResponse();
$requestResponse->result = 0;

$result = false;

$product->status_id = 2;

if($product->id >0) {
    $result = $product->update_status();
}

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
