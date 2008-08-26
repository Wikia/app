<?php
$wgAjaxExportList [] = 'wfGetFlickrPhotos';
function wfGetFlickrPhotos($page,$search){ 
	global $wgIFI_FlickrAPIKey, $IP;
	
	require_once("$IP/extensions/wikia/FlickrImport/FlickrImportClass.php");
	require_once("$IP/extensions/wikia/FlickrImport/phpFlickr-2.1.0/phpFlickr.php");
	require_once("$IP/extensions/wikia/FlickrImport/FlickrImport.i18n.php" );
	# Add messages
	global $wgMessageCache, $wgFlickrImportMessages;
	foreach( $wgFlickrImportMessages as $key => $value ) {
		$wgMessageCache->addMessages( $wgFlickrImportMessages[$key], $key );
	}
	
	$search = urldecode($search);
	$f = new FlickrImport($wgIFI_FlickrAPIKey); 
	$output = $f->getPhotos( $page,$search );
	
	return $output;
}

$wgAjaxExportList [] = 'wfImageExists';
function wfImageExists( $page_name ){ 	
	//load mediawiki objects to check if article exists
	$image_title = Image::newFromName( ( $page_name ) );
	if( $image_title->exists() ){ 
		return "Page exists";
	} else {
		return "OK";
	}
}
?>