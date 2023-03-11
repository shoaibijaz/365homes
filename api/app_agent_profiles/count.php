<?php

session_start();

include_once '../database.php';
include_once '_agent_profile.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_agent_profile($db);

$data = $_GET;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

if(empty($product->owner_id) && isset($_SESSION['login_agent'])) {
    $product->owner_id = $_SESSION['login_agent']['id'];
}

// query products
$stmt = $product->count();

$results = $stmt->fetch(PDO::FETCH_ASSOC);

$json=json_encode($results);

echo $json;

?>

