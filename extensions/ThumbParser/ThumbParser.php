<?php
/**
* @addtogroup Extensions
*/
// Check environment
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
	die( -1 );
}

/* Configuration */

// Credits
$wgExtensionCredits['parserhook'][] = array (
	'path'=> __FILE__ ,
	'name'=>'ThumbParser',
	'url'=>'http://www.mediawiki.org/wiki/Extension:ThumbParser',
	'description'=>'Prints users Thumb size',
	'descriptionmsg' => 'thumbparser-desc',
	'author'=>'[http://www.dasch-tour.de DaSch]',
	'version'=>'0.2',
);
$dir = dirname( __FILE__ ) . '/';

// Internationalization
$wgExtensionMessagesFiles['ThumbParser'] = $dir . 'ThumbParser.i18n.php';
$wgExtensionMessagesFiles['ThumbParserMagic'] = $dir . 'ThumbParser.i18n.magic.php';

# Define a setup function
$wgHooks['ParserFirstCallInit'][] = 'efThumbParserFunction_Setup';

function efThumbParserFunction_Setup( $parser ) {
	# Set a function hook associating the "example" magic word with our function
	$parser->setFunctionHook( 'thumb', 'efThumbParserFunction_Render' );
	return true;
}

function efThumbParserFunction_Render( $parser, $param1 = '') {
	# The parser function itself
	# The input parameters are wikitext with templates expanded
	# The output should be wikitext too
	global $wgThumbLimits, $wgUser;
	$param1 = strtolower($param1);
	$parser->disableCache(); # Mark this content as uncacheable
	$wopt = $wgUser->getOption('thumbsize');
	switch ($param1) {
		case 'size':
			$output = $wgThumbLimits[$wopt];
			break;
		case 'px':
			$output = $wgThumbLimits[$wopt].'px';
			break;
		case 'width':
			$size = intval($wgThumbLimits[$wopt])+10;
			$strsize = strval($size);
			$output = $strsize."px";
			break;
		default:
			$output = $wgThumbLimits[$wopt];
	}
	return $output;
}
