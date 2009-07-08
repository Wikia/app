<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', true);
require 'StaticChute.php';

$StaticChute = new StaticChute($_GET['type']);
$files = $StaticChute->getFileList($_GET);
if (empty($files)){
	header('HTTP/1.0 400 Bad Request');
	echo $StaticChute->comment("Invalid 'packages' or 'files'");
	exit;
}

echo $StaticChute->process($files);
