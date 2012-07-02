<?php
if (!defined('MEDIAWIKI')) die();

/**
 * @file
 * @ingroup Extensions
 */

$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'Skin per page',
	'version'        => '1.0',
	'author'         => 'Tim Starling',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:SkinPerPage',
	'descriptionmsg' => 'skinperpage-desc',
);

$wgExtensionMessagesFiles['SkinPerPage'] = dirname( __FILE__ ) . "/SkinPerPage.i18n.php";

$wgHooks['ParserFirstCallInit'][] = 'SkinPerPage::setup';
$wgHooks['OutputPageParserOutput'][] = 'SkinPerPage::outputHook';

class SkinPerPage {
	static function setup( $parser ) {
		$parser->setHook( 'skin', array( __CLASS__, 'parserHook' ) );
		return true;
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
