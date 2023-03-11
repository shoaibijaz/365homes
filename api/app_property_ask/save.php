<?php

session_start();

include_once '../post_header.php';
include_once '_ask.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_property_ask($db);

$data = $_POST;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

$requestResponse = new RequestResponse();
$requestResponse->result = 0;

$result = $product->add_new();

if ($result) {
    $requestResponse->result = $db->lastInsertId();
    $product->id = $requestResponse->result;
}

if (isset($_POST['address']) && isset($_POST['agent_email'])) {

    $emails = explode(",", $_POST['agent_email']);

    foreach ($emails as $value) {
        $mailResult = $product->send_mail($_POST['address'], $value);

        $requestResponse->sub_message .= $mailResult . ",";
        
    }
}

// create the product
if ($result) {
    $requestResponse->message = "created.";
} else {
    $requestResponse->result = 0;
    $requestResponse->message = "failed to create.";
}

echo json_encode($requestResponse);
exit;
