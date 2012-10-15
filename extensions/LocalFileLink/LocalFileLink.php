<?php
# localFileLink MediaWiki Extention
# Created by  Doru Moisa, Optaros Inc.
#

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'LocalFileLink',
	'author' => 'Moisa Doru (tmoisa@optaros.com), Optaros Inc.',
	'description' => 'Allows the usage of local file links with FCKEditor',
);

function lflAddLocalFileLinks( &$out ) {

	$search  = '/\[(file\:\/{2,5}[a-zA-Z]{0,1}[\:]{0,1}\S*)\s*([^\]]*)\]/';
	$replace = '<a href="$1" class="link-ftp">$2</a>';

	$out->mBodytext = preg_replace( $search, $replace, $out->mBodytext );

	return true;
} 

function lflAjaxAddLocalFileLinks( &$parser, &$text ) {

	$search  = '/\[(file\:\/{2,5}[a-zA-Z]{0,1}[\:]{0,1}\S*)\s*([^\]]*)\]/';
	$replace = '<a href="$1" class="link-ftp">$2</a>';

	$text = preg_replace($search, $replace, $text);

	return true;
}

if ( isset($_REQUEST['rs']) ) {
	$wgHooks['ParserBeforeTidy'][] = 'lflAjaxAddLocalFileLinks';
}
else {
	$wgHooks['BeforePageDisplay'][] = 'lflAddLocalFileLinks';
}
