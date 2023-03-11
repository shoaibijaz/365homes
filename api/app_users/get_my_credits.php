<?php

session_start();

include_once '../database.php';
include_once '_user.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_user($db);

$data = $_POST;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

$product->id = $_SESSION['login_agent']['id'];

$count = $product->get_credits();

echo($count);

?>

