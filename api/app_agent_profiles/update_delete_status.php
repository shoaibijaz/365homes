<?php

include_once '../post_header.php';
include_once '_agent_profile.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_agent_profile($db);

$data = $_POST;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

$requestResponse = new RequestResponse();
$result = false;

$result = $product->update_delete_status();

if ($result) {
    $requestResponse->result = 1;
    $requestResponse->message = "deleted.";
} else {
    $requestResponse->result = 0;
    $requestResponse->message = "failed to delete.";
}

echo json_encode($requestResponse);

exit;

?>

