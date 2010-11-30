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

global $wgHooks;
$wgHooks['MakeGlobalVariablesScript'][] = 'SkinWikiaphoneOld::onMakeGlobalVariablesScript';

/**
 * @todo document
 * @ingroup Skins
 */
class SkinWikiaphoneOld extends SkinTemplate {
	function initPage( OutputPage $out ) {
		SkinTemplate::initPage( $out );
		$this->skinname  = 'wikiaphoneold';
		$this->stylename = 'wikiaphoneold';
		$this->template  = 'MonoBookTemplate';
	}

	function setupSkinUserCss( OutputPage $out ){
		global $wgRequest;
		parent::setupSkinUserCss( $out );
		
		// Append to the default screen common & print styles...
		$out->addMeta("viewport", "width=device-width");
		$out->addStyle( 'wikiaphoneold/main.css', 'screen,handheld' );
		// Nick wonders why we have IE 5 style sheets for a mobile skin?
		// Hyun wonders the same thing as Nick
		$out->addStyle( 'wikiaphoneold/IE50Fixes.css', 'screen,handheld', 'lt IE 5.5000' );
		$out->addStyle( 'wikiaphoneold/IE55Fixes.css', 'screen,handheld', 'IE 5.5000' );
		$out->addStyle( 'wikiaphoneold/IE60Fixes.css', 'screen,handheld', 'IE 6' );
		$analitycsProvider = new AnalyticsProviderGA_Urchin();
		$out->addScript( $analitycsProvider->getSetupHtml() );
		$out->addScript(AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW));
		$out->addScript(AnalyticsEngine::track('GA_Urchin', 'hub', AdEngine::getCachedCategory()));
		global $wgCityId;
		$out->addScript(AnalyticsEngine::track('GA_Urchin', 'onewiki', array($wgCityId)));
		$out->addScript(AnalyticsEngine::track('GA_Urchin', 'pagetime', array('lean_monaco')));
		$out->addScriptFile( '../wikiaphoneold/main.js' );
	}

	function printTopHtml() {
		global $wgRequest, $wgBlankImgUrl, $wgSitename;
		echo AdEngine::getInstance()->getAd('MOBILE_TOP_LEADERBOARD');
	}
	
	public static function onMakeGlobalVariablesScript( $vars ) {
		global $wgContLang;
		
		$vars['CategoryNamespaceMessage'] = $wgContLang->getNsText(NS_CATEGORY);
		$vars['SpecialNamespaceMessage'] = $wgContLang->getNsText(NS_SPECIAL);
		
		return true;
	}

}