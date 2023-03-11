<?php

include_once '../database.php';
include_once '_plan.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_plan($db);

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

