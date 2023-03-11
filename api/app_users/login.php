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

$stmt = $product->check_login();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

$requestResponse = new RequestResponse();

if($row!=false) {
   
    session_start();

    if($row['is_super'] == 1) {
        $_SESSION['login_admin']= $row; 
    }
    else if($row['user_type'] == 1) {
        $_SESSION['login_agent']= $row; 
    }

    $requestResponse->result = 1;
    $requestResponse->message = "User logged in.";
}
else{
    $requestResponse->result = 0;
    $requestResponse->message = "Invalid login details.";
}

echo json_encode($requestResponse);

exit;

?>;