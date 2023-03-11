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

$result = $product->verify_email();

// create the product
if ($result) {
    $requestResponse->result = 1;
    $requestResponse->message = "Thanks for verifying your email. Now you can login to website.";
} else {
    $requestResponse->result = 0;
    $requestResponse->message = "Sorry! We are not able to verify your account!!";
}

echo json_encode($requestResponse);
exit;

?>

