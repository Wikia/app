<?php
require_once 'StaticChute.php';

$StaticChute = new StaticChute('css');
foreach(array('monaco_css', 'monaco_css_print') as $package){
	$files = $StaticChute->getFileList(array('packages'=> $package));
	echo "checksum for $package is " . $StaticChute->getChecksum($files) . ", files are \n";
}
