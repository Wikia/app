<?php
/**
 * SkeleSkin
 *
 * @author Jakub Olek, Federico Lucignano
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

$app = F::app();
$dir = dirname( __FILE__ );


$wgExtensionFunctions[] = 'wfSkeleSkinSetup';


// TODO: why do we have this code here? It should be placed in ThemeDesigner
function SkeleSkin_UploadVerification($destName, $tempPath, &$error) {
	$destName = strtolower($destName);
	if($destName == 'wiki-wordmark.png' || $destName == 'wiki-background') {
		// BugId:983
		$error = wfMsg('themedesigner-manual-upload-error');
		return false;
	}
	return true;
}

/**
 * info
 */
$app->wg->append(
	'wgExtensionCredits',
	array(
		"name" => "SkeleSkin",
		"description" => "Skin for smartphones",
		"author" => array(
			'Federico "Lox" Lucignano <federico(at)wikia-inc.com>',
			'Jakub Olek <bukaj.kelo(at)gmail.com>'
		)
	),
	'other'
);

/**
 * classes
 */

/**
 * services
 */

/**
 * controllers
 */

/**
 * special pages
 */


/**
 * message files
 */
$app->wg->set( 'wgExtensionMessagesFiles', "{$dir}/SkeleSkin.i18n.php", 'SkeleSkin' );

/**
 * hooks
 */

/*
 * settings
 */
