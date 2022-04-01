<?php
ini_set('display_errors', 1);
//putenv('GDFONTPATH=' . realpath('.'));
// If image was uploaded without any errors, Proceed to watermarking
// print_r($_FILES);
// if($_FILES && $_FILES['image_file']['error'] === 0){

//     $file = $_FILES['image_file'];
//     $type = substr($_FILES['image_file']['type'], 0,5);
//     $file_size = number_format($_FILES['image_file']['size'] / 1024,2);

//     if($type == 'image' && $file_size < 2048){
//         $to_image = imagecreatefromstring(file_get_contents('images/watermark-image.png'));
//         $stamp = imagecreatefrompng('images/watermark.png');
//         $spacing = 15;
//         $spacing_double = $spacing  * 2;

//         list($width,$height) = getimagesize($file['tmp_name']);
//         list($stamp_width,$stamp_height) = getimagesize('images/watermark.png');
//         // echo $stamp_width.'-';
//         // echo $stamp_height;exit;
//         switch($_POST['position']){
//             // Repeat watermark over whole image
//             case "repeat_all":
//                 // calculate how many rows & columns watermark will repeat
//                 $rows = floor($height / ($stamp_height + $spacing_double));
//                 $cols = floor($width / ($stamp_width + $spacing_double));

//                 // Initial offset (point to start) of watermark
//                 $offsetX = ($width - ($cols * ($stamp_width + $spacing_double))) / 2 + $spacing;
//                 $offsetY = ($height - ($rows * ($stamp_height + $spacing_double))) / 2 + $spacing;

//                 // Loop through all rows & columns and place watermark
//                 for($rc = 0 ; $rc < $rows ; $rc++){
//                    for($cc = 0; $cc < $cols; $cc++){
//                         imagecopy($to_image, $stamp, $cc * ($stamp_width + $spacing_double) + $offsetX, $rc * ($stamp_height + $spacing_double) + $offsetY, 0, 0, $stamp_width, $stamp_height);
//                     }
//                 }
//                 break;
//             // Place watermark to top left of uploaded image
//             case "top_left":
//                 $offsetX = $spacing;
//                 $offsetY = $spacing;
//                 imagecopy($to_image, $stamp, $offsetX, $offsetY, 0, 0, $stamp_width, $stamp_height);
//                 break;

//             // Place watermark to top right of uploaded image
//             case "top_right":
//                 $offsetX = $width - ($stamp_width + $spacing);
//                 $offsetY = $spacing;
//                 imagecopy($to_image, $stamp, $offsetX, $offsetY, 0, 0, $stamp_width, $stamp_height);
//                 break;

//             // Place watermark to bottom left of uploaded image
//             case "bottom_left":
//                 $offsetX = $spacing;
//                 $offsetY = $height - ($stamp_height + $spacing);
//                 imagecopy($to_image, $stamp, $offsetX, $offsetY, 0, 0, $stamp_width, $stamp_height);
//                 break;

//             // Place watermark to bottom right of uploaded image
//             case "bottom_right":
//                 $offsetX = $width - ($stamp_width + $spacing);
//                 $offsetY = $height - ($stamp_height + $spacing);
//                 imagecopy($to_image, $stamp, $offsetX, $offsetY, 0, 0, $stamp_width, $stamp_height);
//                 break;

//             // Place watermark to center of uploaded image, Also the default case
//             case "center":
//             default:
//                 $offsetX = ($width  - ($stamp_width + $spacing)) / 2;
//                 $offsetY = ($height - ($stamp_height + $spacing)) / 2;
//                 imagecopy($to_image, $stamp, $offsetX, $offsetY, 0, 0, $stamp_width, $stamp_height);
//                 break;
//         }
//         // Save image after adding watermark
//         imagepng($to_image, 'images/watermark-image.png', 9);
//     }
// }
//header("Location: watermark-index.php");


$file = 'images/watermark-image.jpg';
$fontfile = 'font/chinese.msyh.ttf';
$sourceimage = imagecreatefromstring(file_get_contents($file));
$textcolor = imagecolorallocatealpha($sourceimage, 0, 0, 0, 100);
$imageParams = getimagesize($file);
// echo "<pre>";
// print_r($imageParams);exit;
$width = $imageParams['0'];
$height = $imageParams['1'];

//Cover the screen
//$water_w The width of the text watermark
$water_w = 100;
//$water_h height of text watermark
$water_h = 100;
//$angle Watermark text tilt angle
$angle = -45;
//$font_size Watermark text size
$font_size = 18;
//$water_text watermark text
$water_text = 'Preferred Mall';

for ($x = 10; $x < $width; $x) {
    for ($y = 20; $y < $height; $y) {
        imagettftext($sourceimage, $font_size, $angle, $x, $y, $textcolor, $fontfile, $water_text);
        $y += $water_h;
    }
    $x += $water_w;
}

// imagettftext($sourceimage, 50, 0, $width/80, $height/2, $textcolor, $fontfile,'Optimal Mall');
imagejpeg($sourceimage,$file);
imagedestroy($sourceimage);

?>