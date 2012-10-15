<?php
/** \file
* \brief Contains code for the GoToCategory extension
*/

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "GoToCategory extension";
	exit(1);
}

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'GoToCategory',
	'version'        => '1.0',
	'author'         => 'Tim Laqua',
	'descriptionmsg' => 'gotocategory-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:GoToCategory',
);

$wgHooks['SpecialSearchNogomatch'][] = 'efGoToCategory_SpecialSearchNogomatch';

function efGoToCategory_SpecialSearchNogomatch($t) {
	global $wgOut, $wgRequest;

	$term = $wgRequest->getText('search');
	if( !empty( $term ) && strpos( 'category:', strtolower( $term ) ) !== 0 ) {
		$term = "Category:{$term}";
	}

	$title = SearchEngine::getNearMatch( $term );
	if( !is_null( $title ) ) {
		$wgOut->redirect( $title->getFullURL() );
	}
	return true;
}
