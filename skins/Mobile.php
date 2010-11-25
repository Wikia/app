<?php
/**
 * Mobile Skin for webkit mobile
 *
 * @author Hyun Lim
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/** */
require_once( dirname(__FILE__) . '/MonoBook.php' );

global $wgHooks;
$wgHooks['MakeGlobalVariablesScript'][] = 'SkinMobile::onMakeGlobalVariablesScript';
$wgHooks['WikiaIOSInsertHeader'][] = 'SkinMobile::insertHeader';

/**
 * @todo document
 * @ingroup Skins
 */
class SkinMobile extends SkinTemplate {
	function initPage( OutputPage $out ) {
		SkinTemplate::initPage( $out );
		$this->skinname  = 'mobile';
		$this->stylename = 'mobile';
		$this->template  = 'MonoBookTemplate';
	}

	function setupSkinUserCss( OutputPage $out ){
		global $wgRequest;
		parent::setupSkinUserCss( $out );
		$out->addMeta("viewport", "width=320");
		$out->addStyle( 'wikiaphone/main.css', 'screen,handheld' );
		$out->addStyle( 'wikiaphone/iOS.css', 'screen,handheld');
		$out->addScriptFile( '../common/jquery/jquery-1.4.4.min.js' );
		$out->addScriptFile( '../wikiaphone/iOS.js' );
	}

	function printTopHtml() {
		global $wgRequest, $wgBlankImgUrl, $wgSitename;
		echo AdEngine::getInstance()->getAd('MOBILE_TOP_LEADERBOARD');

		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();
		$this->wordmarkText = $settings["wordmark-text"];
		
		$this->mainPageURL = Title::newMainPage()->getLocalURL();
		
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
				<a href="<?= $this->mainPageURL ?>">
				<?= $this->wordmarkText ?>
				</a>
			</h1>
<?php
		
	}
	
	public static function onMakeGlobalVariablesScript( $vars ) {
		global $wgContLang;
		
		$vars['CategoryNamespaceMessage'] = $wgContLang->getNsText(NS_CATEGORY);
		$vars['SpecialNamespaceMessage'] = $wgContLang->getNsText(NS_SPECIAL);
		
		return true;
	}

}