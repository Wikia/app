<?php
require 'StaticChute.php';

$StaticChute = new StaticChute($_GET['type']);
// Temporary hack for transition
$_GET['packages'] = preg_replace('/awesome/', 'monaco', @$_GET['packages']);
$files = $StaticChute->getFileList($_GET);
if (empty($files)){
	header('HTTP/1.0 400 Bad Request');
	echo $StaticChute->comment("Invalid 'packages' or 'files'");
	exit;
}

echo $StaticChute->process($files);
