<?php
session_start();

include_once '../database.php';
include_once '_ask.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_property_ask($db);

$data = $_GET;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

$ownerId = null;

if(isset($_SESSION['login_agent'])) {
    $ownerId= $_SESSION['login_agent']['id'];
}

// query products
$stmt = $product->get_messages($ownerId);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$json=json_encode($results);

echo $json;

?>

