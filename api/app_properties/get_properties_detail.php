<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/api/database.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/api/app_properties/_property.php';

function getPropertyDetail($id)
{
    // instantiate database and product object
    $database = new Database();
    $db = $database->getConnection();

    // initialize object
    $product = new app_property($db);
    $product->id = $id;
    
    // query products
    $stmt = $product->find_details();
    $productResult = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $data = array(
        "property" => $productResult
    );

    return $data;

}
