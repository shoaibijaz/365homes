<?php

include_once '../database.php';
include_once '_agent.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_property_agent($db);

$data = $_GET;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

// query products
$stmt = $product->filter();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$json=json_encode($results);

echo $json;

?>

