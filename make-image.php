<?
/**
 * This will return a php generated image when you pass the file name/number, the file path, and the desired width in
 * the query string.
 */
    $pic = $_GET['file'];
    $source = $_GET['type'];
    $width = $_GET['width'];

    $imgSource = "randy/images/$source/$pic.jpg";

    header('Content-Type: image/jpeg');

    $img = imagecreatefromjpeg($imgSource);

    $newImg = imagescale($img, $width, $width);

    imagejpeg($newImg);

