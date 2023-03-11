<?php

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
$result = false;

$result = $product->update_password();

if ($result) {
    $requestResponse->result = 1;
    $requestResponse->message = "password updated.";
} else {
    $requestResponse->result = 0;
    $requestResponse->message = "password failed to update.";
}

echo json_encode($requestResponse);

exit;

?>

