<?php

/**
 * SlimboxThumbs extension /REWRITTEN/
 * Originally http://www.mediawiki.org/wiki/Extension:SlimboxThumbs
 * Now it does the same, but the code is totally different
 * Required MediaWiki: 1.13+
 *
 * This extension includes a copy of Slimbox.
 * It has one small modification: caption is animated together
 * with image container, instead of original annoying consequential animation.
 * You can however get your own copy of Slimbox and use it by replacing the
 * included one, or pointing to it with $slimboxThumbsFilesDir
 * http://www.digitalia.be/software/slimbox2
 *
 * @license GNU GPL 3.0 or later: http://www.gnu.org/licenses/gpl.html
 * CC-BY-SA should not be used for software as it's incompatible with GPL, and MW is GPL.
 *
 * @file SlimboxThumbs.php
 *
 * @author Vitaliy Filippov <vitalif@mail.ru>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

define( 'SlimboxThumbs_VERSION', '2011-12-30' );

// Register the extension credits.
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'SlimboxThumbs',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SlimboxThumbs',
	'author' => array(
		'[http://yourcmc.ru/wiki/User:VitaliyFilippov Vitaliy Filippov], ' .
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw].'
	),
	'descriptionmsg' => 'slimboxthumbs-desc',
	'version' => SlimboxThumbs_VERSION
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['SlimboxThumbs'] = $dir . 'SlimboxThumbs.i18n.php';

// Include the settings file.
require_once 'SlimboxThumbs_Settings.php';

if ( $slimboxThumbsFilesDir ) {
	$wgHooks['BeforePageDisplay'][] = 'efSBTAddScripts';
	$wgHooks['ImageBeforeProduceHTML'][] = 'efSBTImageHTML';
	$wgHooks['ParserAfterTidy'][] = 'efSBTAfterTidy';
}

// Remembers the image dimensions to tell it to JS
function efSBTImageHTML( $skin, $title, $file, $frameParams, &$handlerParams, $time, $res ) {
	global $slimboxImages;
	$slimboxImages[ $file->getName() ] = array( $file->getWidth(), $file->getHeight() );
	return true;
}

// Saves remembered image dimensions to parser output
function efSBTAfterTidy( $parser, &$text, $clearState ) {
	global $slimboxImages;
	if ( !empty( $slimboxImages ) ) {
		$ws = array();
		foreach( $slimboxImages as $n => $w ) {
			$ws[] = '"'.addslashes( $n ).'":['.$w[0].','.$w[1].']';
		}
		$ws = 'var slimboxSizes = {'.implode( ',', $ws ).'}';
		$parser->mOutput->addHeadItem( '<script language="JavaScript">'.$ws.'</script>', 'slimboxSizes' );
	}
	return true;
}

// Adds javascript files and stylesheets.
function efSBTAddScripts( $out ) {
	global $wgVersion, $wgExtensionAssetsPath, $wgUploadPath;
	$eDir = $wgExtensionAssetsPath . '/SlimboxThumbs/slimbox';

	if ( substr( $wgVersion, 0, -2 ) < 1.16 ) {
		$j = '$';
		$out->addScript( '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>' . "\n" );
	} else {
		$j = '$j';
		$out->includeJQuery();
	}

	$out->addScript( '<script type="text/javascript" src="' . $eDir . '/js/slimbox2.js"></script>' . "\n" );
	$out->addExtensionStyle( $eDir . '/css/slimbox2.css', 'screen' );
	$out->addScript( '<script type="text/javascript" src="' . $eDir . '/slimboxthumbs.js"></script>' . "\n" );
	$out->addInlineScript( "$(function() {".
		"makeSlimboxThumbs( $j, \"".addslashes( $wgUploadPath ).
		"\", \"".addslashes( $wgServer.$wgScriptPath )."\" ); } );" );

	return true;
}
