<?php

session_start();

if(!$_SESSION['login_admin']) {
    die();
}

include_once '../database.php';
include_once '_user_plan.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_user_plan($db);

$data = $_GET;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

$stmt = $product->filter();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$json=json_encode($results);

echo $json;

?>

