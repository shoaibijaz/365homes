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

$count = $product->email_count();

$requestResponse->result = 0;

if($count > 0) {
   
    $result = $product->forgot_password();

    if ($result && $result->rowCount() > 0) {
        $requestResponse->result = 1;
        $requestResponse->message = "A password reset message was sent to your email address. Please click the link to reset the password.";
    } else {
        $requestResponse->message = "We are not able complete your request. Please try again. Thanks";
    }
}
else{

    $requestResponse->message = "Please enter valid email address.";
}

echo json_encode($requestResponse);

exit;

?>

