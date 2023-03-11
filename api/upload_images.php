<?php

session_start();

if(!isset($_SESSION['login_agent']) && !isset($_SESSION['login_admin'])) {
    die();
}

include_once 'post_header.php';

$database = new Database();
$db = $database->getConnection();

$path = '../users_uploaded_files/';

$requestResponse = new RequestResponse();

$requestResponse->result = 0;

if (isset($_FILES['file'])) {

    $originalName = $_FILES['file']['name'];
    $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
    $generatedName = md5($_FILES['file']['tmp_name']).$ext;
    $filePath = $path.$generatedName;

    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    if (!is_writable($path)) {
       $requestResponse->message = 'Destination directory not writable.';
    }
    else if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        $requestResponse->result = 1;
        $requestResponse->message = str_replace('../','/',$filePath);
    }
}

echo json_encode($requestResponse);

exit;

?>