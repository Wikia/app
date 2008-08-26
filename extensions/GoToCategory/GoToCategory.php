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
	'name'           => 'GoToCategory',
	'version'        => '1.0',
	'author'         => 'Tim Laqua',
	'description'    => "Checks search terms against the Category: namespace for Go 'jump to page' functionality",
	'descriptionmsg' => 'gotocategory-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:GoToCategory',
);

$wgExtensionFunctions[] = 'efGoToCategory_Setup';

function efGoToCategory_Setup() {
	global $wgHooks;
	$wgHooks['SpecialSearchNogomatch'][] = 'efGoToCategory_SpecialSearchNogomatch';
	return true;
}

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
