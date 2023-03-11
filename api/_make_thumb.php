<?php

function makeThumbnails($updir, $img)
{
    $thumbnail_width = 400;
    $thumbnail_height = 239;
    $thumb_beforeword = "thumb";
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

    $dest_x= 0;
    $dest_y =0;
    
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
        $trans_layer_overlay = imagecolorallocatealpha($new_image, 220, 220, 220, 127);
        imagefill($new_image, 0, 0, $trans_layer_overlay);
        
        imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
        $imgt($new_image, "$updir" . "$thumb_beforeword" . "$img");

        return "$updir" . "$thumb_beforeword" . "$img";
    }
}

makeThumbnails('../users_gallery_files/', '0e5215b3da1c59619f574feac68ce559.jpg', '');

?>