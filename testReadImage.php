<?php
/*! \brief Read image from hd (output folder)
 *
 *   in this moment this page is used to get an image from the HD.
 *   maybe an alternative solution can be a simple symbolic link
 *   is this script a definitive solution? it depends, before we must see the evolution of
 *   gAn
 */



header('Content-Type: image/gif');

$imageName = $_GET["image"];

//echo "path: " . "opt/lampp/htdocs/Tesi/gAn/gAn-updated/output/".$imageName;

readfile("/opt/lampp/htdocs/Tesi/gAn/gAn-updated/output/".$imageName);

?>
