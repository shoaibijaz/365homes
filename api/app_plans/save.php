<?php

include_once '../post_header.php';
include_once '_plan.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_plan($db);

$data = $_POST;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

$requestResponse = new RequestResponse();
$requestResponse->result = 0;

if($product->id >0) {
    $result = $product->update();
}
else{
    $result = $product->add_new();
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
