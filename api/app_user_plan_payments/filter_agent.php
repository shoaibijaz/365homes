<?php

session_start();

include_once '../database.php';
include_once '_user_plan_payment.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_user_plan_payment($db);

$data = $_GET;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

$product->user_id = $_SESSION['login_agent']['id'];

// query products
$stmt = $product->filter_agent();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$json=json_encode($results);

echo $json;

?>

