<?php

if ( !defined('MEDIAWIKI') )
	die(1);

$wgExtensionFunctions[] = 'semanticGallery_Setup';

function semanticGallery_Setup()
{
	global $wgExtensionCredits, $wgAutoloadClasses;

	// credits
	$wgExtensionCredits['parserhook'][] = array(
		'name'            => 'Semantic Gallery',
		'version'         => '0.3.1',
		'author'          => array( 'Rowan Rodrik van der Molen' ),
		'url'             => 'http://www.mediawiki.org/wiki/Extension:Semantic_Gallery',
		'description'     => 'Adds a gallery output format to SMW inline queries',
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
