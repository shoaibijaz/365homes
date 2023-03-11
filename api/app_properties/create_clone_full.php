<?php

session_start();

include_once '../post_header.php';
include_once '_property.php';
include_once '../app_users/_user.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new app_property($db);

$data = $_POST;

foreach ($data as $key => $value) {
    if (property_exists($product, $key))
        $product->{$key} = $value;
}

$requestResponse = new RequestResponse();
$requestResponse->result = 0;

$result = false;

if ($product->id > 0) {
    $newID = copy_property($product, $db);
    copy_property_features($product, $db, $newID);
    copy_property_points($product, $db, $newID);
    copy_property_settings($product, $db, $newID);
    copy_property_agents($product, $db, $newID);
    copy_property_images($product, $db, $newID);
    copy_floor_pans($product, $db, $newID);
    copy_videos($product, $db, $newID);
    copy_tours($product, $db, $newID);
    $requestResponse->result = $newID;
}

echo json_encode($requestResponse);
exit;

function copy_property($product, $db)
{

    $sql = "INSERT INTO app_properties ( owner_id, title, address, map_location, price, property_type, details_short,
             details_long, sort_order, is_deleted, created_on, main_image, transaction_type, logo ) ";

    $sql = $sql . ' SELECT owner_id, ' . '"' . $product->title . '"' . ',' . '"' . $product->address . '"';
    $sql = $sql . ', map_location, price, property_type, details_short, details_long, ';
    $sql = $sql . '  sort_order, is_deleted, now(), main_image, transaction_type, logo';
    $sql = $sql . ' FROM app_properties where id = ' . $product->id;

    $db->prepare($sql)->execute();

    return $db->lastInsertId();
}

function copy_property_features($product, $db, $newID)
{
    $sql = "INSERT into app_properties_features (title, image, `value`, sort_order, is_deleted, created_on, property_id) ";
    $sql = $sql . " select title, image, `value`, sort_order, 0, now(), ".$newID." from app_properties_features ";
    $sql = $sql . " where property_id = ".$product->id." and is_deleted = 0";

    $db->prepare($sql)->execute();
}

function copy_property_points($product, $db, $newID)
{
    $sql = "INSERT into app_properties_key_points (property_id, key_point, sort_order, is_deleted, created_on) ";
    $sql = $sql . " select ".$newID.", key_point, sort_order, 0, now() from app_properties_key_points ";
    $sql = $sql . " where property_id = ".$product->id." and is_deleted = 0";

    $db->prepare($sql)->execute();
}

function copy_property_settings($product, $db, $newID)
{
    $sql = "INSERT into app_properties_settings (property_id, key_name, key_value, is_deleted, created_on)";
    $sql = $sql . " select ".$newID.", key_name, key_value, 0, now() from app_properties_settings ";
    $sql = $sql . " where property_id = ".$product->id." and is_deleted = 0";

    $db->prepare($sql)->execute();
}

function copy_property_agents($product, $db, $newID)
{
    $sql = "INSERT into app_property_agents (property_id, agent_id, is_deleted, sort_order, created_on)";
    $sql = $sql . " select ".$newID.", agent_id, 0, sort_order, now() from app_property_agents ";
    $sql = $sql . " where property_id = ".$product->id." and is_deleted = 0";

    $db->prepare($sql)->execute();
}

function copy_property_images($product, $db, $newID)
{
    $sql = "INSERT into app_property_images (property_id, image, image_thumb, sort_order, is_deleted, created_on)";
    $sql = $sql . " select ".$newID.", image, image_thumb, sort_order, 0, now() from app_property_images ";
    $sql = $sql . " where property_id = ".$product->id." and is_deleted = 0";

    $db->prepare($sql)->execute();
}

function copy_floor_pans($product, $db, $newID)
{
    $sql = "INSERT into app_property_floor_plans (property_id, image, image_thumb, sort_order, is_deleted, created_on)";
    $sql = $sql . " select ".$newID.", image, image_thumb, sort_order, 0, now() from app_property_floor_plans ";
    $sql = $sql . " where property_id = ".$product->id." and is_deleted = 0";

    $db->prepare($sql)->execute();
}

function copy_videos($product, $db, $newID)
{
    $sql = "INSERT into app_property_videos (property_id, video_link, sort_order, is_deleted, created_on)";
    $sql = $sql . " select ".$newID.", video_link, sort_order, 0, now() from app_property_videos ";
    $sql = $sql . " where property_id = ".$product->id." and is_deleted = 0";

    $db->prepare($sql)->execute();
}

function copy_tours($product, $db, $newID)
{
    $sql = "INSERT into app_property_tours (property_id, tour_link, sort_order, is_deleted, created_on)";
    $sql = $sql . " select ".$newID.", tour_link, sort_order, 0, now() from app_property_tours ";
    $sql = $sql . " where property_id = ".$product->id." and is_deleted = 0";

    $db->prepare($sql)->execute();
}