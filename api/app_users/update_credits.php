<?php

session_start();

include_once '../post_header.php';
include_once '_user.php';
include_once '../app_user_credits_logs/_credit_log.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_user($db);
$creditLog = new app_user_credit_log($db);

$data = $_POST;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

$creditLog->user_id = $product->id;
$creditLog->credits = $product->credits;
$creditLog->last_credits = $_POST['last_credits'];

if (isset($_SESSION['login_admin'])) {
    $creditLog->created_by = $_SESSION['login_admin']['id'];
}
else {
    $creditLog->created_by = $_SESSION['login_agent']['id'];
}

$requestResponse = new RequestResponse();
$result = false;

$result = $product->update_credits();

if ($result) {

    $creditLog->add_new();

    $requestResponse->result = 1;
    $requestResponse->message = "credits updated.";
} else {
    $requestResponse->result = 0;
    $requestResponse->message = "credits failed to update.";
}

echo json_encode($requestResponse);

exit;

?>

