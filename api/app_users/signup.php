<?php

include_once '../post_header.php';
include_once '../mailer.php';
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

$product->is_super=0;
$product->status='pending';
$product->user_type=1;
$product->login_name=$product->email;
$product->credits=1;

$requestResponse = new RequestResponse();

$count = $product->email_count();

$result = false;

if ($count <= 0) {
    $result = $product->add_new();
    $product->send_verification_email($db->lastInsertId());

    //$body = 'New user has been registered on 247virtualtours.com <br />'. $product->email;
    //sendmail('photography@mib360.com;emma.d@mib360.com', $body, $body, 'Alert! New user has been registered');

} else {
    $requestResponse->result = 0;
    $requestResponse->message = "Email already exist";
    echo json_encode($requestResponse);
    exit;
}

// create the product
if ($result) {
    $requestResponse->result = 1;
    $requestResponse->message = "User created.";
} else {
    $requestResponse->result = 0;
    $requestResponse->message = "User failed to create.";
}

echo json_encode($requestResponse);
exit;
