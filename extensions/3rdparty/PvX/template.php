<?php
# gcardinal, www.pvxbuilds.com
$name = $_GET["name"];
$build = $_GET["build"];
//Begin writing headers
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header('Content-Type: text/force-download');
//Sending tha shit...
header('Content-Disposition: attachment; filename="' . $name . '.txt"');
if (strlen($build) < 100) echo $_GET["build"];
?>