<?php
if (!defined('MEDIAWIKI')) die();

/**
 * @addtogroup Extensions
 */

$wgExtensionCredits['parserhook'][] = array(
	'name'           => 'Skin per page',
	'version'        => '1.0',
	'author'         => 'Tim Starling',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:SkinPerPage',
	'descriptionmsg' => 'skinperpage-desc',
);

$wgExtensionMessagesFiles['SkinPerPage'] = dirname( __FILE__ ) . "/SkinPerPage.i18n.php";

$wgExtensionFunctions[] = array( 'SkinPerPage', 'setup' );
$wgHooks['OutputPageParserOutput'][] = 'SkinPerPage::outputHook';

class SkinPerPage {
	static function setup() {
		global $wgParser;
		$wgParser->setHook( 'skin', array( __CLASS__, 'parserHook' ) );
	}

	static function parserHook( $text, $attribs, $parser ) {
		$parser->mOutput->spp_skin = trim( $text );
		return '';
	}

	static function outputHook( $out, $parserOutput ) {
		global $wgUser;
		if ( isset( $parserOutput->spp_skin ) ) {
			$wgUser->mSkin =& Skin::newFromKey( $parserOutput->spp_skin );
		}
		return true;
	}
}
