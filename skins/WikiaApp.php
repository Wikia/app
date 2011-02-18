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

global $wgHooks, $wgEnableArticleCommentsExt, $wgEnableFacebookConnectExt,
	$wgEnableFacebookConnectPushing, $wgEnableMWSuggest, $wgAjaxWatch;

$wgEnableArticleCommentsExt = false;
$wgEnableFacebookConnectExt = false;
$wgEnableFacebookConnectPushing = false;
$wgEnableMWSuggest = false;
$wgAjaxWatch = false;

//$wgHooks['MakeGlobalVariablesScript'][] = 'SkinWikiaApp::onMakeGlobalVariablesScript';
//$wgHooks['SkinAfterContent'][] = 'SkinWikiaApp::onSkinAfterContent';
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'SkinWikiaApp::onSkinTemplateOutputPageBeforeExec';

/**
 * @todo document
 * @ingroup Skins
 */
class SkinWikiaApp extends SkinTemplate {
	const COOKIE_NAME = 'mobileapp';
	const COOKIE_DURATION = 86400;/*24h*/
	
	function __construct() {
		parent::__construct();
		$this->mRenderColumnOne = false;
		$this->useHeadElement = true;
	}
	
	function initPage( OutputPage $out ) {
		global $wgHooks, $wgUseSiteCss, $wgRequest, $wgCookiePrefix;
		
		//this will force the skin after the first visit, only for selected mobile platforms
		if( empty( $_COOKIE[ $wgCookiePrefix . self::COOKIE_NAME ] ) ) {	
			$mobServ = MobileService::getInstance();
		
			//iPad should be served the default skin, not the mobile one
			if ( $mobServ->isMobile() && !$mobServ->isIPad() ) {
				$wgRequest->response()->setcookie( self::COOKIE_NAME, 1, time() + self::COOKIE_DURATION );
			}
		}
		
		SkinTemplate::initPage( $out );
		$this->skinname  = 'wikiaapp';
		$this->stylename = 'wikiaapp';
		$this->themename = 'wikiaapp';
		$this->template  = 'MonoBookTemplate';
		$wgUseSiteCss = false;
	}
	
	public static function onSkinTemplateOutputPageBeforeExec( &$obj, &$tpl ){
		$tpl->set('skipColumnOne', true);
		$tpl->set('skipFooter', true);
		return true;
	}
	
	function setupSkinUserCss( OutputPage $out ){
		global $wgRequest;
		$out->addMeta("viewport", "width=320");
		
		//StaticChute minification breaks Zepto, cannot use a package
		$out->addScriptFile( '../common/zepto/zepto-0.4.min.js' );
		$out->addScriptFile( '../wikiaapp/main.min.js' );
		
		$staticChute = new StaticChute( 'css' );
		$staticChute->useLocalChuteUrl();
		$out->addHTML( $staticChute->getChuteHtmlForPackage( 'wikiaapp_css' ) );
	}

	function printTopHtml() {}
	
	public static function onMakeGlobalVariablesScript( $vars ) {
		global $wgContLang;
		
		$vars['CategoryNamespaceMessage'] = $wgContLang->getNsText(NS_CATEGORY);
		$vars['SpecialNamespaceMessage'] = $wgContLang->getNsText(NS_SPECIAL);
		
		return true;
	}
	
	protected function afterContentHook () {
		global $wgCityId, $wgRightsUrl;
		
		$data = '';
		
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