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
if (isset($_SESSION['login_admin'])) {
    $product->id = $_SESSION['login_admin']['id'];
}
else {
    $product->id = $_SESSION['login_agent']['id'];
}
$requestResponse = new RequestResponse();
$result = false;

$result = $product->change_password();

if ($result) {
    $requestResponse->result = $result->rowCount();
    $requestResponse->message = "password updated.";
} else {
    $requestResponse->result = 0;
    $requestResponse->message = "password failed to update.";
}

echo json_encode($requestResponse);

exit;
