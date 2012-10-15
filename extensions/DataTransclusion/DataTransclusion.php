<?php
/**
 * DataTransclusion extension - shows recent changes on a wiki page.
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler for Wikimedia Deutschland
 * @copyright © 2010 Wikimedia Deutschland (Author: Daniel Kinzler)
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'DataTransclusion',
	'author' => 'Daniel Kinzler for Wikimedia Deutschland',
	'url' => 'http://mediawiki.org/wiki/Extension:DataTransclusion',
	'descriptionmsg' => 'datatransclusion-desc',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['DataTransclusion'] = $dir . 'DataTransclusion.i18n.php';
$wgExtensionMessagesFiles['DataTransclusionMagic'] = $dir . 'DataTransclusion.i18n.magic.php';

$wgAutoloadClasses['DataTransclusionRenderer'] = $dir . 'DataTransclusionRenderer.php';
$wgAutoloadClasses['DataTransclusionHandler'] = $dir . 'DataTransclusionHandler.php';
$wgAutoloadClasses['ValueNormalizers'] = $dir . 'ValueNormalizers.php';
$wgAutoloadClasses['RecordTransformer'] = $dir . 'RecordTransformer.php';
$wgAutoloadClasses['FlattenRecord'] = $dir . 'FlattenRecord.php';
$wgAutoloadClasses['XPathFlattenRecord'] = $dir . 'XPathFlattenRecord.php';
$wgAutoloadClasses['OpenLibraryRecordTransformer'] = $dir . 'OpenLibraryRecordTransformer.php';
$wgAutoloadClasses['MAB2RecordTransformer'] = $dir . 'MAB2RecordTransformer.php';
$wgAutoloadClasses['DataTransclusionSource'] = $dir . 'DataTransclusionSource.php';
$wgAutoloadClasses['CachingDataTransclusionSource'] = $dir . 'DataTransclusionSource.php';
$wgAutoloadClasses['FakeDataTransclusionSource'] = $dir . 'DataTransclusionSource.php';
$wgAutoloadClasses['DBDataTransclusionSource'] = $dir . 'DBDataTransclusionSource.php';
$wgAutoloadClasses['WebDataTransclusionSource'] = $dir . 'WebDataTransclusionSource.php';
$wgAutoloadClasses['OpenLibrarySource'] = $dir . 'OpenLibrarySource.php';

$wgHooks['ParserFirstCallInit'][] = 'efDataTransclusionSetHooks';

// TODO: Special Page for displaying all configured data sources

$wgDataTransclusionSources = array();

function efDataTransclusionSetHooks( $parser ) {
	$parser->setHook( 'record' , 'DataTransclusionHandler::handleRecordTag' );
	$parser->setFunctionHook( 'record' , 'DataTransclusionHandler::handleRecordFunction' );
	return true;
}
