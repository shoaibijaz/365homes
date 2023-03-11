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

$result = $product->reset_token_password();

if ($result && $result->rowCount() > 0) {
    $requestResponse->result = 1;
    $requestResponse->message = "Your password has been changed successfully.";
} else {
    $requestResponse->result = 0;
    $requestResponse->message = "We are not able to reset your password.";
}

echo json_encode($requestResponse);

exit;

?>

