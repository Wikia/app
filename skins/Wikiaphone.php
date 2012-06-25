<?php
/**
 * Mobile Skin for webkit mobile
 *
 * @author Hyun Lim
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

require_once( dirname(__FILE__) . '/MonoBook.php' );

global $wgHooks, $wgEnableArticleCommentsExt, $wgEnableFacebookConnectExt,
	$wgEnableFacebookConnectPushing, $wgEnableMWSuggest, $wgAjaxWatch;

$wgEnableArticleCommentsExt = false;
$wgEnableFacebookConnectExt = false;
$wgEnableFacebookConnectPushing = false;
$wgEnableMWSuggest = false;
$wgAjaxWatch = false;

$wgHooks['MakeGlobalVariablesScript'][] = 'SkinWikiaphone::onMakeGlobalVariablesScript';
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'SkinWikiaphone::onSkinTemplateOutputPageBeforeExec';
$wgHooks['SkinGetHeadScripts'][] = 'SkinWikiaphone::onSkinGetHeadScripts';

/**
 * @todo document
 * @ingroup Skins
 */
class SkinWikiaphone extends WikiaSkin {
	function __construct() {
		parent::__construct( 'MonoBookTemplate', 'wikiaphone', ''/* this makes Common.css and WikiaPhone.css get added to the page */ );

		//non-strict checks of css/js/scss assets/packages
		$this->strictAssetUrlCheck = false;

		$this->mRenderColumnOne = false;
		$this->useHeadElement = true;
	}

	function initPage( OutputPage $out ) {
		global $wgHooks, $wgUseSiteCss;

		SkinTemplate::initPage( $out );

		$out->addMeta("viewport", "width=320");
	}

	public static function onSkinTemplateOutputPageBeforeExec( &$obj, &$tpl ){
		$tpl->set('skipColumnOne', true);
		$tpl->set('skipFooter', true);
		return true;
	}

	function setupSkinUserCss( OutputPage $out ){
		$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( "/skins/wikiaphone/skin.scss") );
	}
	
	public function onSkinGetHeadScripts(&$scripts) {
		global $wgJsMimeType, $wgEnableAbTesting;
		
		$packages = array( 'wikiaphone_js' );

		//make abtesting code load before all the others
		if ( !empty( $wgEnableAbTesting ) ) {
			array_unshift( $packages, 'abtesting' );
		}

		foreach ( AssetsManager::getInstance()->getGroupCommonURL( $packages ) as $src ) {
			$scripts .= "\n<script type=\"$wgJsMimeType\" src=\"{$src}\"></script>";
		}
		
		return true;
	}

	function printTopHtml() {
		global $wgRequest, $wgBlankImgUrl, $wgSitename, $wgBlankImgUrl;
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();
		$this->wordmarkText = $settings["wordmark-text"];

		$this->mainPageURL = Title::newMainPage()->getLocalURL();

		echo AdEngine::getInstance()->getAd('MOBILE_TOP_LEADERBOARD');
?>
<div class="mobile-header">
<img src="<?= $wgBlankImgUrl ?>">
<form action="index.php?title=Special:Search" method="get">
<input type="text" name="search" placeholder="<?= wfMsg('Tooltip-search', $wgSitename) ?>" accesskey="f" size="13">
<input id="mobile-search-btn" type="image" src="<?= $wgBlankImgUrl ?>">
</form>
<?= Wikia::specialPageLink('Random', 'oasis-button-random-page', array('accesskey' => 'x', 'class' => 'wikia-button secondary', 'data-id' => 'randompage'), 'blank.gif', null, 'sprite random') ?>
</div>
<h1 class="mobile-wikiname">
<a href="<?= $this->mainPageURL ?>">
<?= $this->wordmarkText ?>
</a>
</h1>
<?php
	}

	public static function onMakeGlobalVariablesScript( $vars ) {
		global $wgContLang, $wgDevelEnvironment;
		
		$vars['DevelEnvironment'] = $wgDevelEnvironment;
		$vars['CategoryNamespaceMessage'] = $wgContLang->getNsText(NS_CATEGORY);
		$vars['SpecialNamespaceMessage'] = $wgContLang->getNsText(NS_SPECIAL);
		
		return true;
	}
	
	protected function afterContentHook () {
		global $wgCityId, $wgRightsUrl;
		
		$data = '';
		
		$data .= '<div id="mw-data-after-content"><div id="fullsite"><a href="#" class="fullsite" rel="nofollow">'.wfMsg('mobile-full-site').'</a> | '.$this->getCopyright().'</div>';
		
		$data .= '<script>var MobileSkinData = {showtext: "'.wfMsg("mobile-show").'", hidetext:"'.wfMsg("mobile-hide").'"};</script>';
		
		// Comscore
		$data .= AnalyticsEngine::track('Comscore', AnalyticsEngine::EVENT_PAGEVIEW);
		
		// Quantcast
		$data .= AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW, array(), array('extraLabels'=>array('mobilebrowser')));
		
		// load Google Analytics code
		$data .= AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW);
		
		// onewiki GA
		$data .= AnalyticsEngine::track('GA_Urchin', 'onewiki', array($wgCityId));
		
		return $data;
	}
	
	/**
	* empty stub for compatibility with MonoBook.php wikiaBox()
	*/
	function wikiaBox() {
		return;
	}
}
