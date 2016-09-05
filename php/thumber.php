<?php
#Appreciation goes to digifuzz (http://www.digifuzz.net) for help on this

$image_file = $_GET['img']; //takes in full path of image
$MAX_WIDTH = $_GET['mw'];
$MAX_HEIGHT = $_GET['mh'];
global $img;

//Check for image
if(!$image_file || $image_file == "") {
	die("NO FILE.");
}

//If no max width, set one
if(!$MAX_WIDTH || $MAX_WIDTH == "") {
	$MAX_WIDTH="100";
}

//if no max height, set one
if(!$MAX_HEIGHT || $MAX_HEIGHT == "") {
	$MAX_HEIGHT = "100";
}

$img = null;
//create image file from 'img' parameter string
$img = @imagecreatefromstring(file_get_contents($image_file));

//if image successfully loaded...
if($img) {
	//get image size and scale ratio
	$width = imagesx($img);
	$height = imagesy($img);

	//takes min value of these two
	$scale = min($MAX_WIDTH/$width, $MAX_HEIGHT/$height);

	//if desired new image size is less than original, output new image
	if($scale < 1) {
		$new_width = floor($scale * $width);

		$new_height = floor($scale * $height);


		$tmp_img = imagecreatetruecolor($new_width, $new_height);

		//copy and resize old image to new image
		imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		imagedestroy($img);

		//replace actual image with new image
		$img = $tmp_img;
	}
}
//set the content type header
header("Content-type: image/jpeg");

//imagejpeg outputs the image
imagejpeg($img);

imagedestroy($img);


function latestArtwork() {

}
?>
