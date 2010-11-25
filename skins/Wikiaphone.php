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
$wgHooks['MakeGlobalVariablesScript'][] = 'SkinWikiaphone::onMakeGlobalVariablesScript';
$wgHooks['WikiaIOSInsertHeader'][] = 'SkinWikiaphone::insertHeader';

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
		global $wgRequest;
		parent::setupSkinUserCss( $out );
		
		$iOS = $wgRequest->getVal('iOS', false);
		
		// Append to the default screen common & print styles...
		if(!empty($iOS)) {
			$out->addMeta("viewport", "width=320");
			$out->addStyle( 'wikiaphone/main.css', 'screen,handheld' );
			$out->addStyle( 'wikiaphone/iOS.css', 'screen,handheld');
			$out->addScriptFile( '../common/jquery/jquery-1.4.4.min.js' );
			$out->addScriptFile( '../wikiaphone/iOS.js' );
		} else {
			$out->addMeta("viewport", "width=device-width");
			$out->addStyle( 'wikiaphone/main.css', 'screen,handheld' );
			// Nick wonders why we have IE 5 style sheets for a mobile skin?
			// Hyun wonders the same thing as Nick
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
	}

	function printTopHtml() {
		global $wgRequest, $wgBlankImgUrl, $wgSitename;
		echo AdEngine::getInstance()->getAd('MOBILE_TOP_LEADERBOARD');
		$iOS = $wgRequest->getVal('iOS', false);
		if(!empty($iOS)) {
			$themeSettings = new ThemeSettings();
			$settings = $themeSettings->getSettings();
			$this->wordmarkText = $settings["wordmark-text"];
			
			echo AdEngine::getInstance()->getAd('MOBILE_TOP_LEADERBOARD');
?>
			<div class="iOS-header">
				<img src="/skins/oasis/images/wikia_logo.png">
				<form action="index.php?title=Special:Search" method="get">
					<input type="text" name="search" placeholder="<?= wfMsg('Tooltip-search', $wgSitename) ?>" accesskey="f" size="13">
					<input type="image" src="/skins/oasis/images/search_icon.png">
				</form>
				<?= View::specialPageLink('Random', 'oasis-button-random-page', array('accesskey' => 'x', 'class' => 'wikia-button secondary', 'data-id' => 'randompage'), 'blank.gif', null, 'sprite random') ?>
			</div>
			<h1 class="iOS-wikiname">
				<?= $this->wordmarkText ?>
			</h1>
<?php
		}
	}
	
	public static function onMakeGlobalVariablesScript( $vars ) {
		global $wgContLang;
		
		$vars['CategoryNamespaceMessage'] = $wgContLang->getNsText(NS_CATEGORY);
		$vars['SpecialNamespaceMessage'] = $wgContLang->getNsText(NS_SPECIAL);
		
		return true;
	}

}