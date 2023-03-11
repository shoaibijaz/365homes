<?php

include_once '../post_header.php';
include_once '_video.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_property_video($db);

$data = $_POST;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

$requestResponse = new RequestResponse();
$requestResponse->result = 0;

if($product->id> 0) {
    $result = $product->update();
}
else{
    $result = $product->add_new();
}

if ($result)
    $requestResponse->result = 1;

// create the product
if ($result) {
    $requestResponse->message = "created.";
} else {
    $requestResponse->result = 0;
    $requestResponse->message = "failed to create.";
}

echo json_encode($requestResponse);
exit;
