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
	$wgEnableFacebookConnectPushing, $wgEnableMWSuggest, $wgAjaxWatch, $wgUseSiteJs;

$wgEnableArticleCommentsExt = false;
$wgEnableFacebookConnectExt = false;
$wgEnableFacebookConnectPushing = false;
$wgEnableMWSuggest = false;
$wgAjaxWatch = false;
$wgUseSiteJs = false;
$wgUseSiteCss = false;

$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'SkinWikiaApp::onSkinTemplateOutputPageBeforeExec';
$wgHooks['SkinGetHeadScripts'][] = 'SkinWikiaApp::onSkinGetHeadScripts';

/**
 * @todo document
 * @ingroup Skins
 */
class SkinWikiaApp extends WikiaSkin {
	const COOKIE_NAME = 'mobileapp';
	const COOKIE_DURATION = 86400;/*24h*/
	
	function __construct() {
		parent::__construct( 'MonoBookTemplate', 'wikiaapp');

		//non-strict checks of css/js/scss assets/packages
		$this->strictAssetUrlCheck = false;

		$this->mRenderColumnOne = false;
		$this->useHeadElement = true;
	}
	
	function initPage( OutputPage $out ) {
		global $wgRequest, $wgCookiePrefix;

		$out->prependHTML(
			'<a style="width:100%;" href="https://play.google.com/store/apps/details?id=com.wikia.app.GameGuides&amp;referrer=utm_source%3Dwikia%26utm_medium%3Dwikiaapp"><img style="width:100%;height:auto;" src="/extensions/wikia/GameGuides/images/GG_MobileAd_320x50.jpg"></a><br>
			<a href="?useskin=wikiamobile">This skin is being deprecated please use WikiaMobile</a>'
		);

		//We want to log any usage of this skin
		//This WILL be removed after about 2 weeks
		Wikia::log('SkinWikiaApp', 'visit', '', true);

		//this will force the skin after the first visit, only for selected mobile platforms
		if( empty( $_COOKIE[ $wgCookiePrefix . self::COOKIE_NAME ] ) ) {	
			$mobServ = MobileService::getInstance();
			
			if ( $mobServ->isMobile() ) {
				$wgRequest->response()->setcookie( self::COOKIE_NAME, 1, time() + self::COOKIE_DURATION );
			}
		}

		SkinTemplate::initPage( $out );

		$out->addMeta("viewport", "width=320");
	}
	
	public static function onSkinTemplateOutputPageBeforeExec( &$obj, &$tpl ){
		$tpl->set('skipColumnOne', true);
		$tpl->set('skipFooter', true);
		return true;
	}
	
	function setupSkinUserCss( OutputPage $out ){
		foreach ( AssetsManager::getInstance()->getGroupCommonURL( 'wikiaapp_css' ) as $src ) {
			$out->addStyle( $src );
		}
	}
	
	public function onSkinGetHeadScripts(&$scripts) {
		global $wgJsMimeType;
		
		//$scripts = '';
		
		foreach ( AssetsManager::getInstance()->getGroupCommonURL( 'wikiaapp_js' ) as $src ) {
			$scripts .= "\n<script type=\"$wgJsMimeType\" src=\"{$src}\"></script>";
		}
		
		return true;
	}

	function printTopHtml() {}
	
	protected function afterContentHook () {
		global $wgCityId, $wgRightsUrl;
		
		$data = '';
	
		// Comscore
		$data .= AnalyticsEngine::track('Comscore', AnalyticsEngine::EVENT_PAGEVIEW);
		
		// Quantcast
		$data .= AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW, array(), array('extraLabels'=>array('mobileapp')));
		
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