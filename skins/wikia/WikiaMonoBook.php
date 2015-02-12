<?php
/**
 * MonoBook nouveau with Wikia modifications
 *
 * Translated from gwicke's previous TAL template version to remove
 * dependency on PHPTAL.
 *
 * @author Maciej Brencz <macbre@wikia.com>
 * @addtogroup Skins
 */

if(!defined('MEDIAWIKI')) {
	die(-1);
}

abstract class WikiaSkinMonoBook extends WikiaSkin {

	protected $ads;

	function __construct(){
		//required to let Common.css and MonoBook.css be output
		//@see Skin::setupUserCss
		$this->themename = '';

		parent::__construct();

		//allow non-strick asset check agains skin, @see WikiaSkin::getScripts and WikiaSkin::getStyles
		$this->strictAssetUrlCheck = false;
	}

	function initPage( OutputPage $out) {
		global $wgHooks, $wgShowAds, $wgRequest;

		parent::initPage( $out );

		$diff = $wgRequest->getVal('diff');

		if($wgShowAds == false || isset($diff)) {
			$this->ads = false;
		}

		$wgHooks['SkinTemplateOutputPageBeforeExec'][] = array($this, 'addWikiaVars');
		$wgHooks['SkinTemplateSetupPageCss'][] = array($this, 'addWikiaCss');
		$wgHooks['SkinGetPageClasses'][] = array($this, 'addBodyClasses');
		$wgHooks['SkinGetHeadScripts'][] = array($this, 'onSkinGetHeadScripts');
	}

	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );

		$out->addModuleStyles('wikia.monobook');

		// add file with fixes for IE8
		$out->addStyle('wikia/css/IE80Fixes.css', 'screen', 'IE 8');
	}

	public function addWikiaVars(&$obj, BaseTemplate &$tpl) {
		global $wgUser;
		wfProfileIn(__METHOD__);

		// ads
		$this->setupAds($tpl);

		// setup footer links
        $tpl->set('footerlinks',  wfMsgExt( 'Shared-Monobook-footer-wikia-links', 'parse' ) );

		# rt33045
		$tpl->set('contact',    '<a href="'. $wgUser->getSkin()->makeUrl('Special:Contact') . '" title="Contact Wikia">Contact Wikia</a>');

		# BAC-1036, CE-278
		/* Replace Wikia logo path
		   This functionality is for finding proper path of Wiki.png instead of const one from wgLogo
		   wikia logo should be stored under File:Wiki.png on current wikia. If wfFindFile doesn't find it
		   on current wikia it tires to fallback to starter.wikia.com where the default one is stored
		*/
		$logoPage = Title::newFromText( 'Wiki.png', NS_FILE );
		$logoFile = wfFindFile( $logoPage );
		if( $logoFile ) {
			$tpl->set( 'logopath', $logoFile->getUrl() );
		} else {
			$tpl->set('logopath', wfReplaceImageServer( $tpl->data['logopath'] ));
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	public function addWikiaCss(&$out) {
		global $wgStylePath, $wgStyleVersion;
		$out = '@import "'.$wgStylePath.'/wikia/css/Monobook.css?'.$wgStyleVersion.'";' . $out;
		return true;
	}

	public function addBodyClasses(&$classes) {
		$classes .= ($this->ads ? ' with-adsense' : ' without-adsense');
		return true;
	}

	// load skin-specific JS files from MW (wikibits, user and site JS) - BugId:960
	public function onSkinGetHeadScripts(&$scripts) {
		global $wgResourceBasePath;
		$scripts .= "\n<!--[if lt IE 8]><script src=\"". $wgResourceBasePath ."/resources/wikia/libraries/json2/json2.js\"></script><![endif]-->";
		$scripts .= "\n<!--[if lt IE 9]><script src=\"". $wgResourceBasePath ."/resources/wikia/libraries/html5/html5.min.js\"></script><![endif]-->";

		$packages = array( 'monobook_js' );

		wfRunHooks('MonobookSkinAssetGroups', array(&$packages));

		$srcs = AssetsManager::getInstance()->getURL( $packages );

		foreach($srcs as $src) {
			$scripts .= "\n<script src=\"$src\"></script>";
		}

		return true;
	}

	/**
	 * Setup ads handling
	 */
	protected function setupAds(BaseTemplate &$tpl) {
		$tpl->set('ads-column', '');
		$tpl->set('ads_top', '');
		$tpl->set('ads_topleft', '');
		$tpl->set('ads_topright', '');
		$tpl->set('ads_bot','');
	}

	/**
	 * Return tracking code
	 */
	private function getAnalyticsCode() {
		global $wgCityId;

		return AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW) .
			AnalyticsEngine::track('GA_Urchin', 'hub', AdEngine2Service::getCachedCategory()) .
			AnalyticsEngine::track('GA_Urchin', 'onewiki', array($wgCityId)) .
			AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW);
	}

	/**
	 * Return Wikia specific toolbox
	 */
	function wikiaBox() {
		global $wgOut;
		wfProfileIn(__METHOD__);

		$wikicitiesNavUrls = $this->buildWikicitiesNavUrls();
		$toolboxTitle = htmlspecialchars(wfMsg('wikicities-nav'));
		$wikiaMessages = self::getWikiaMessages();

		if (!empty($wikicitiesNavUrls)) {
			foreach($wikicitiesNavUrls as $navlink) {
				$items[] = '<li id="'.htmlspecialchars($navlink['id']).'"><a href="'.htmlspecialchars($navlink['href']).'">'.htmlspecialchars($navlink['text']).'</a></li>';
			}

			$toolbox = "
			<ul>
				" . implode("\n\t\t\t\t", $items) . "
			</ul>
			<hr />";
		}
		else {
			$toolbox = '';
		}
		$staffBlogLinkText = wfMessage( 'wikia_messages' )->escaped();
		$html = <<<HTML
	<div class="portlet" id="p-wikicities-nav">
		<h5>$toolboxTitle</h5>
		<div class="pBody">$toolbox
			<ul>
				<li><a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog">$staffBlogLinkText:</a><br />$wikiaMessages</li>
			</ul>
		</div>
	</div>
HTML;

		echo $html;

		wfProfileOut(__METHOD__);
	}

	protected function getWikiaMessages() {
		global $wgMemc, $wgOut, $wgLang, $wgContLang;
		wfProfileIn( __METHOD__ );

		$cacheWikiaMessages = $wgLang->getCode() == $wgContLang->getCode();
		if( $cacheWikiaMessages ) {
			$memcKey = wfMemcKey( 'WikiaMessages', $wgLang->getCode() );
			$ret = $wgMemc->get( $memcKey );
		}

		if( empty( $ret ) ) {
			$ret = wfMessage( 'shared-News_box' )->parse();
			if( $cacheWikiaMessages ) {
				$wgMemc->set( $memcKey, $ret, 60*60 );
			}
		}
		wfProfileOut( __METHOD__ );
		return $ret;
	}

	protected function buildWikicitiesNavUrls () {
		global $wgWikicitiesNavLinks, $wgMemc, $wgLang, $wgContLang;
		wfProfileIn( __METHOD__ );
		$cacheWikicitiesNavUrls = $wgLang->getCode() == $wgContLang->getCode();
		if( $cacheWikicitiesNavUrls ) {
			$memcKey = wfMemcKey( 'wikiaNavUrls', $wgLang->getCode() );
			$result = $wgMemc->get( $memcKey );
		}

		if( empty( $result ) ) {
			$result = array();
			if(isset($wgWikicitiesNavLinks) && is_array($wgWikicitiesNavLinks)) {
				foreach ( $wgWikicitiesNavLinks as $link ) {
					$text = wfMessage( $link['text'] )->text();
					wfProfileIn( __METHOD__.'::'.$link['text'] );
					if ($text != '-') {
						$dest = wfMessage( $link['href'] )->text();
						wfProfileIn( __METHOD__.'::'.$link['text'].'::2' );
						$result[] = array(
						'text' => $text,
						'href' => $this->makeInternalOrExternalUrl( $dest ),
						'id' => 'n-'.$link['text']
						);
						wfProfileOut( __METHOD__.'::'.$link['text'].'::2' );
					}
					wfProfileOut( __METHOD__.'::'.$link['text'] );
				}
			}
			if( $cacheWikicitiesNavUrls ) {
				$wgMemc->set( $memcKey, $result, 60*60 );
			}
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	// HTML to be added between footer and end of page
	public function bottomScripts() {
		$analytics = $this->getAnalyticsCode();
		$bottomScriptText = parent::bottomScripts();

		$html =  <<<HTML
<!-- WikiaBottomScripts -->
$bottomScriptText
<!-- /WikiaBottomScripts -->
$analytics
<div id="positioned_elements"></div>
HTML;

		return $html;
	}

	function wideSkyscraper() {
		global $wgDBname;
		$wideSkyscraperWikis = array('yugioh', 'transformers', 'swg', 'paragon');
		if (in_array($wgDBname, $wideSkyscraperWikis)) {
			echo ' style="margin-right: 165px;"';
		}
	}

	function isSkyscraper() {
		global $wgDBname, $wgEnableAdsInContent;
		$noSkyscraperWikis = array('espokemon');
		if (in_array($wgDBname, $noSkyscraperWikis) && $wgEnableAdsInContent) {
			return true;
		}
		else {
			return false;
		}
	}

	function noSkyscraper() {
		if ( $this->isSkyscraper() ) {
			echo ' style="margin-right: 0px;"';
		}
	}

} // end of class
