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

global $wgHooks, $wgEnableArticleCommentsExt;

$wgEnableArticleCommentsExt = false;
$wgEnableFacebookConnectExt = false;
$wgEnableFacebookConnectPushing = false;

$wgHooks['MakeGlobalVariablesScript'][] = 'SkinMobile::onMakeGlobalVariablesScript';
$wgHooks['SkinAfterContent'][] = 'SkinMobile::onSkinAfterContent';
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'SkinMobile::onSkinTemplateOutputPageBeforeExec';

/**
 * @todo document
 * @ingroup Skins
 */
class SkinMobile extends SkinTemplate {
	function __construct() {
		parent::__construct();
		$this->mRenderColumnOne = false;
	}
	
	function initPage( OutputPage $out ) {
		global $wgHooks;
		SkinTemplate::initPage( $out );
		$this->skinname  = 'mobile';
		$this->stylename = 'mobile';
		$this->template  = 'MonoBookTemplate';
	}
	
	public static function onSkinAfterContent( &$data ) {
		$data = null;
		return true;
	}
	
	public static function onSkinTemplateOutputPageBeforeExec( &$obj, &$tpl ){
		$tpl->set('skipColumnOne', true);
		$tpl->set('skipFooter', true);
		return true;
	}
	
	function setupSkinUserCss( OutputPage $out ){
		global $wgRequest;
		parent::setupSkinUserCss( $out );
		$out->addMeta("viewport", "width=320");
		$out->addStyle( 'mobile/main.css', 'screen,handheld' );
		$out->addStyle( 'mobile/skin.css', 'screen,handheld' );
		//$out->addScriptFile( '../common/zepto/zepto-0.1.1.js' );
		//$out->addScriptFile( '../mobile/main.js' );
		$out->addScriptFile( '../common/jquery/jquery-1.4.4.min.js' );
		$out->addScriptFile( '../wikiaphone/iOS.js' );
	}

	function printTopHtml() {
		global $wgRequest, $wgBlankImgUrl, $wgSitename, $wgBlankImgUrl;
		echo AdEngine::getInstance()->getAd('MOBILE_TOP_LEADERBOARD');

		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();
		$this->wordmarkText = $settings["wordmark-text"];
		
		$this->mainPageURL = Title::newMainPage()->getLocalURL();
		
		echo AdEngine::getInstance()->getAd('MOBILE_TOP_LEADERBOARD');
?>
			<div class="iOS-header">
				<img src="<?= $wgBlankImgUrl ?>">
				<form action="index.php?title=Special:Search" method="get">
					<input type="text" name="search" placeholder="<?= wfMsg('Tooltip-search', $wgSitename) ?>" accesskey="f" size="13">
					<input type="image" src="<?= $wgBlankImgUrl ?>">
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