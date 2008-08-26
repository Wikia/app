<?php
/*
 * Author: Inez Korczynski (inez@wikia.com)
 */
if(!defined('MEDIAWIKI')) {
	exit(1);
}

include_once(dirname(__FILE__).'/MergeFilesMinimal.php');

function GetReferences($groupName, $nowrap = false) {
	global $wgAllInOne, $wgRequest, $MF;
	if(empty($wgAllInOne)) {
		$wgAllInOne = false;
	}
	$allInOne = $wgRequest->getBool('allinone', $wgAllInOne);

	if(!empty($MF[$groupName])) {

		if(!$allInOne) {
			include_once(dirname(__FILE__) . "/MergeFilesAdditional.php");
			$files = $MF[$groupName]['source'];
		} else {
			$files = array($MF[$groupName]['target']);
		}

		if($nowrap) {
			return $files;
		}

		switch($MF[$groupName]['type']) {
			case "js":
				return GetReferencesJS($files);
				break;
			case "css":
				return GetReferencesCSS($files);
				break;
			default:
				return '';
				break;
		}
	}

	return '';
}

function GetReferencesJS($files) {
	global $wgMergeStyleVersionJS, $wgStylePath;

	$output = '';

	foreach($files as $file) {
		$output .= '<script type="text/javascript" src="' . $wgStylePath . '/' . $file . '?' . $wgMergeStyleVersionJS . '"></script>';

	}

	return $output;
}

function GetReferencesCSS($files) {
	global $wgMergeStyleVersionCSS, $wgStylePath;
	$output = '';
	foreach($files as $file) {
		$output .= '<link rel="stylesheet" type="text/css" href="' . $wgStylePath . '/' . $file . '?' . $wgMergeStyleVersionCSS . '" />';
	}
	return $output;
}
