<?php

session_start();

include_once '../database.php';
include_once '_analytics.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_property_analytics($db);

$data = $_GET;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

$user_id = null;

if(isset($_SESSION['login_agent'])) {
    $user_id = $_SESSION['login_agent']['id'];
}

// query products
$stmt = $product->filter($user_id);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$json=json_encode($results);

echo $json;

?>

