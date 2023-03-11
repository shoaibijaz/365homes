<?php

include_once '../database.php';
include_once '_user.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_user($db);

$data = $_GET;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

// query products
$stmt = $product->find();

$results = $stmt->fetch(PDO::FETCH_ASSOC);

$json=json_encode($results);

echo $json;

?>

