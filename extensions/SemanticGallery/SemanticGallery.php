<?php

if ( !defined('MEDIAWIKI') )
	die(1);

$wgExtensionFunctions[] = 'semanticGallery_Setup';

function semanticGallery_Setup()
{
	global $wgExtensionCredits, $wgAutoloadClasses;

	// credits
	$wgExtensionCredits['parserhook'][] = array(
		'path'            => __FILE__,
		'name'            => 'Semantic Gallery',
		'version'         => '0.3.1',
		'author'          => array( 'Rowan Rodrik van der Molen' ),
		'url'             => 'https://www.mediawiki.org/wiki/Extension:Semantic_Gallery',
		'descriptionmsg'  => 'semanticgallery-desc',
	);

	$wgAutoloadClasses['SemanticGallery_ResultPrinter'] = dirname(__FILE__).'/SG_ResultPrinter.php';

	// global variable introduced in SMW 1.2.2
	global $smwgResultFormats;
	if (isset($smwgResultFormats))
		$smwgResultFormats['gallery'] = 'SemanticGallery_ResultPrinter';
	else
		SMWQueryProcessor::$formats['gallery'] = 'SemanticGallery_ResultPrinter';
}
