<?php

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
$result = false;

$result = $product->update_sort_order($data['id']);

if ($result) {
    $requestResponse->result = 1;
    $requestResponse->message = "sorted.";
} else {
    $requestResponse->result = 0;
    $requestResponse->message = "failed to sorted.";
}

echo json_encode($requestResponse);

exit;
