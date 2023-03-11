<?php

header("Access-Control-Allow-Origin: *");

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

if(isset($_GET['id'])) {
    $product->id = $_GET['id'];
}

$count = $product->email_count();

if( $count> 0 ){
    echo 'false';
} else {
    echo 'true';
}

?>

