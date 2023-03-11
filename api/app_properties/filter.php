<?php

session_start();

include_once '../database.php';
include_once '_property.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_property($db);

$data = $_GET;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

if(isset($_SESSION['login_agent'])) {
    $product->owner_id = $_SESSION['login_agent']['id'];
}

// query products
$stmt = $product->filter();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$json=json_encode($results);

echo $json;

?>

