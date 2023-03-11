<?php

session_start();

include_once dirname(__DIR__) . '/mailer.php';

include_once '../post_header.php';
include_once '_property.php';
include_once '../app_users/_user.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_property($db);
$user_object = new app_user($db);

$data = $_POST;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

if (isset($_SESSION['login_admin']) && empty($product->owner_id)) {
    $product->owner_id = $_SESSION['login_admin']['id'];
}
else {
    $user_object->id = $_SESSION['login_agent']['id'];
    $product->owner_id = $_SESSION['login_agent']['id'];
}

$requestResponse = new RequestResponse();
$requestResponse->result = 0;

$result = false;

if ($product->id > 0) {

    $result = $product->update_address();

    if ($result) {
        $requestResponse->result = $product->id;
    }
} else {

    $product->title = $product->address;

    $result = $product->add_new();

    if ($result) {

        $requestResponse->result = $db->lastInsertId();

       // $mr = sendmail('shoaib.ijaz8@gmail.com', $product->address,  $product->address, 'New Property Created');

        $stmt = $user_object->find();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $user_object->credits = $row['credits'] - 1;
        $user_object->update_credits();

        $stmt = $user_object->find();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['login_agent'] = $row;
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
