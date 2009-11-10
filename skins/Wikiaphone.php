<?php
/**
 * See docs/skin.txt
 *
 * @todo document
 * @file
 * @ingroup Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/** */
require_once( dirname(__FILE__) . '/MonoBook.php' );

/**
 * @todo document
 * @ingroup Skins
 */
class SkinWikiaphone extends SkinTemplate {
	function initPage( OutputPage $out ) {
		SkinTemplate::initPage( $out );
		$this->skinname  = 'wikiaphone';
		$this->stylename = 'wikiaphone';
		$this->template  = 'MonoBookTemplate';
	}

	function setupSkinUserCss( OutputPage $out ){
		parent::setupSkinUserCss( $out );
		// Append to the default screen common & print styles...
		$out->addStyle( 'wikiaphone/main.css', 'screen,handheld' );
		$out->addStyle( 'wikiaphone/IE50Fixes.css', 'screen,handheld', 'lt IE 5.5000' );
		$out->addStyle( 'wikiaphone/IE55Fixes.css', 'screen,handheld', 'IE 5.5000' );
		$out->addStyle( 'wikiaphone/IE60Fixes.css', 'screen,handheld', 'IE 6' );
		$out->addScript( '<script type="text/javascript" src="http://www.google-analytics.com/urchin.js"></script>' );
		$out->addScriptFile( '../wikiaphone/main.js' );
	}
}


