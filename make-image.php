<?
/**
 * This will return a php generated image
 * Necessary query string parameters include:
 * $file - which is the identifier of the jpeg
 * $type - which is the folder for the image i.e. artists, genres, or paintings
 * Optional query string parameters include:
 * $width - if nothing is provided, will default to original size
 * $size - can either be full or square, if nothing is provided it will automatically default to square as per Randy's spec.
 */
    $pic = $_GET['file'];
    $source = $_GET['type'];

    if(isset($_GET['width'])) {
        $width = $_GET['width'];
    }

    if(isset($_GET['size'])) {
        $size =$_GET['size'];
    } else {
        $size = "square";
    }
    $imgSource = "randy/images/$source/$size/$pic.jpg";

    header('Content-Type: image/jpeg');

    $img = imagecreatefromjpeg($imgSource);

    if ($width) {
        if ($size == "square") {
            $newImg = imagescale($img, $width, $width);
        } else {
            $newImg = imagescale($img, $width, -1);
        }
    } else {
        $newImg = $img;
    }

    imagejpeg($newImg);

