<?php

session_start();

if(!isset($_SESSION['login_agent']) && !isset($_SESSION['login_admin'])) {
    die();
}

include_once 'post_header.php';

function makeThumbnails($updir, $img)
{
    $thumbnail_width = 400;
    $thumbnail_height = 239;
    
    $arr_image_details = getimagesize("$updir" . "$img"); // pass id to thumb name

    $original_width = $arr_image_details[0];
    $original_height = $arr_image_details[1];

    if ($original_width > $original_height) {
        $new_width = $thumbnail_width;
        $new_height = intval($original_height * $new_width / $original_width);
    } else {
        $new_height = $thumbnail_height;
        $new_width = intval($original_width * $new_height / $original_height);
    }

    $dest_x = intval(($thumbnail_width - $new_width) / 2);
    $dest_y = intval(($thumbnail_height - $new_height) / 2);

    $dest_x = 0;
    $dest_y = 0;

    if ($arr_image_details[2] == IMAGETYPE_GIF) {
        $imgt = "ImageGIF";
        $imgcreatefrom = "ImageCreateFromGIF";
    }
    if ($arr_image_details[2] == IMAGETYPE_JPEG) {
        $imgt = "ImageJPEG";
        $imgcreatefrom = "ImageCreateFromJPEG";
    }
    if ($arr_image_details[2] == IMAGETYPE_PNG) {
        $imgt = "ImagePNG";
        $imgcreatefrom = "ImageCreateFromPNG";
    }
    if ($imgt) {

        $image_path = "$updir" . "$img";
        $image_path = str_replace('-org', '-thumb', $image_path);

        $old_image = $imgcreatefrom("$updir" . "$img");
        $new_image = imagecreatetruecolor($new_width, $new_height);

        imagealphablending($new_image, false);
        imagesavealpha($new_image, true);
        $trans_layer_overlay = imagecolorallocatealpha($new_image, 220, 220, 220, 127);
        imagefill($new_image, 0, 0, $trans_layer_overlay);

        imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
        $imgt($new_image, $image_path);

        return $image_path;
    }
}

function resizeImage($updir, $img)
{
    $image_path = "$updir" . "$img";
    $image_path = str_replace('-org', '-res', $image_path);

    $max_width = 2500;
    $arr_image_details = getimagesize("$updir" . "$img"); // pass id to thumb name

    $original_width = $arr_image_details[0];
    $original_height = $arr_image_details[1];

    if ($original_width > $max_width) {
        $new_width = $max_width;
        $new_height = intval($original_height * $new_width / $original_width);
    } else {
        return "$updir" . "$img";;
    }

    $dest_x = 0;
    $dest_y = 0;

    if ($arr_image_details[2] == IMAGETYPE_GIF) {
        $imgt = "ImageGIF";
        $imgcreatefrom = "ImageCreateFromGIF";
    }
    if ($arr_image_details[2] == IMAGETYPE_JPEG) {
        $imgt = "ImageJPEG";
        $imgcreatefrom = "ImageCreateFromJPEG";
    }
    if ($arr_image_details[2] == IMAGETYPE_PNG) {
        $imgt = "ImagePNG";
        $imgcreatefrom = "ImageCreateFromPNG";
    }

    if ($imgt) {

        $old_image = $imgcreatefrom("$updir" . "$img");
        $new_image = imagecreatetruecolor($new_width, $new_height);

        imagealphablending($new_image, false);
        imagesavealpha($new_image, true);

        //$trans_layer_overlay = imagecolorallocatealpha($new_image, 220, 220, 220, 127);
        
        //imagefill($new_image, 0, 0, $trans_layer_overlay);

        imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
        $imgt($new_image, $image_path);

        return $image_path;
    }
}

$database = new Database();
$db = $database->getConnection();

$path = '../users_gallery_files/';

$requestResponse = new RequestResponse();
$requestResponse->result = 0;

$propertyId = $_POST['property'];

if (isset($_FILES['file'])) {

    $originalName = $_FILES['file']['name'];
    $ext = '.' . pathinfo($originalName, PATHINFO_EXTENSION);
    $generatedName = $propertyId . '-org-' . md5($_FILES['file']['tmp_name']) . $ext;
    $filePath = $path . $generatedName;

    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    if (!is_writable($path)) {
        $requestResponse->message = 'Destination directory not writable.';
    } else if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {

        $thumb_path = makeThumbnails($path, $generatedName);

        $resized_path = resizeImage($path, $generatedName);

        $requestResponse->result = 1;
        $requestResponse->message = str_replace('../', '/', $resized_path);
        $requestResponse->sub_message = str_replace('../', '/', $thumb_path);
    }
}

echo json_encode($requestResponse);

exit;
