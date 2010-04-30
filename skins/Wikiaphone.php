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
		$out->addMeta("viewport", "width=device-width");
		// Append to the default screen common & print styles...
		$out->addStyle( 'wikiaphone/main.css', 'screen,handheld' );
		// Nick wonders why we have IE 5 style sheets for a mobile skin?
		$out->addStyle( 'wikiaphone/IE50Fixes.css', 'screen,handheld', 'lt IE 5.5000' );
		$out->addStyle( 'wikiaphone/IE55Fixes.css', 'screen,handheld', 'IE 5.5000' );
		$out->addStyle( 'wikiaphone/IE60Fixes.css', 'screen,handheld', 'IE 6' );

		$out->addScript(AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW));
		$out->addScript(AnalyticsEngine::track('GA_Urchin', 'hub', AdEngine::getCachedCategory()));
		global $wgCityId;
		$out->addScript(AnalyticsEngine::track('GA_Urchin', 'onewiki', array($wgCityId)));
		$out->addScript(AnalyticsEngine::track('GA_Urchin', 'pagetime', array('lean_monaco')));
		$out->addScriptFile( '../wikiaphone/main.js' );
	}

	function printTopHtml() {
	        echo AdEngine::getInstance()->getAd('MOBILE_TOP_LEADERBOARD');
	}
}


