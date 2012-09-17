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

	function initPage(&$out) {
		global $wgHooks, $wgShowAds, $wgUseAdServer, $wgRequest, $wgOut;

		parent::initPage( $out );

		$diff = $wgRequest->getVal('diff');

		if($wgShowAds == false || $wgUseAdServer == false || isset($diff)) {
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
		$tpl->set('copyright',  '');
		$tpl->set('privacy',    '<a href="http://www.wikia.com/wiki/Wikia:Privacy_Policy" title="Privacy Policy">Privacy</a> <span style="color: red">(Updated)</span>');

		$tpl->set('about',      '<a href="http://www.wikia.com/wiki/Wikia:About" title="About Wikia">About Wikia</a>');
		$tpl->set('disclaimer', '<a href="http://www.wikia.com/wiki/Wikia:Terms_of_use" title="Terms of use">Terms of use</a> <span style="color: red">(Updated)</span>');
		$tpl->set('advertise',  '<a href="http://www.wikia.com/wiki/Wikia:Advertising_on_Wikia" title="advertise on Wikia">Advertise</a>'); # rt33045
		$tpl->set('hosting',    '<i>Wikia</i>&reg; is a registered service mark of Wikia, Inc. All rights reserved.');
		$tpl->set('credits',    ' ');

		# rt33045
		$tpl->set('contact',    '<a href="'. $wgUser->getSkin()->makeUrl('Special:Contact') . '" title="Contact Wikia">Contact Wikia</a>');

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
		global $wgEnableAbTesting, $wgResourceBasePath;
		$scripts .= "\n<!--[if lt IE 8]><script src=\"". $wgResourceBasePath ."/resources/wikia/libraries/json2/json2.js\"></script><![endif]-->";
		$scripts .= "\n<!--[if lt IE 9]><script src=\"". $wgResourceBasePath ."/resources/wikia/libraries/html5/html5.min.js\"></script><![endif]-->";

		$packages = array( 'monobook_js' );

		if ( !empty( $wgEnableAbTesting ) ) {
			$pkg = F::build('AbTesting')->getJsPackage();

			if(!empty($pkg)){
				//make abtesting code load before all the others
				array_unshift( $packages, $pkg  );
			}
		}

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
		AdEngine::getInstance()->setLoadType('inline');

		// BugId:26735 We want spotlights regardless of whether ads have been enabled.
		$adsColumn = '<div id="column-google" class="noprint">'."\n".
			AdEngine::getInstance()->getSetupHtml() .
			'<div id="wikia_header" style="display:none"></div>'; // Hack because ads have code that referenc    es this. Awful.

		if($this->ads === false) {
			// FIXME: not used anymore?
			$tpl->set('ads_top', '');
			$tpl->set('ads_topleft', '');
			$tpl->set('ads_topright', '');
			$tpl->set('ads_bot','');

			$adsColumn .= '<!-- not USING ad server! -->'."\n".'</div>'."\n</div>\n";
		} else {
			// FIXME: not used anymore?
			$tpl->set('ads_top', AdServer::getInstance()->getAd('t'));
			$tpl->set('ads_topleft', AdServer::getInstance()->getAd('tl'));
			$tpl->set('ads_topright', AdServer::getInstance()->getAd('tr'));
			$tpl->set('ads_bot', AdServer::getInstance()->getAd('b'));

			$adsColumn .= '<!-- USING ad server! -->'."\n".
				'<div id="column-google-right">'.AdEngine::getInstance()->getAd('RIGHT_SKYSCRAPER_1').'</div></div>'."\n";
		}

		// BugId:26735 We want spotlights regardless of whether ads have been enabled.
		$adsColumn .= '<table id="spotlight_container"><tr>' .
			'<td><div>'.AdEngine::getInstance()->getPlaceHolderIframe('SPOTLIGHT_FOOTER_1').'</div></td>' .
			'<td><div>'.AdEngine::getInstance()->getPlaceHolderIframe('SPOTLIGHT_FOOTER_2').'</div></td>' .
			'<td><div>'.AdEngine::getInstance()->getPlaceHolderIframe('SPOTLIGHT_FOOTER_3').'</div></td>'.
			"</tr></table>\n".
			AdEngine::getInstance()->getDelayedIframeLoadingCode();

		// add ads column after content
		$tpl->set('ads-column', $adsColumn);
	}

	/**
	 * Return tracking code
	 */
	private function getAnalyticsCode() {
		global $wgCityId;

		return AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW) .
			AnalyticsEngine::track('GA_Urchin', 'hub', AdEngine::getCachedCategory()) .
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

		$html = <<<HTML
	<div class="portlet" id="p-wikicities-nav">
		<h5>$toolboxTitle</h5>
		<div class="pBody">$toolbox
			<ul>
				<li><a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog">Wikia messages:</a><br />$wikiaMessages</li>
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
			$ret = wfMsgExt( 'shared-News_box', array('parseinline', 'content') );
			if( $cacheWikiaMessages ) {
				$wgMemc->set( $memcKey, $ret, 60*60 );
			}
		}
		wfProfileOut( __METHOD__ );
		return $ret;
	}

	protected function buildWikicitiesNavUrls () {
		global $wgWikicitiesNavLinks, $wgMemc;
		wfProfileIn( __METHOD__ );

		$result = $wgMemc->get( wfMemcKey( 'wikiaNavUrls' ) );
		if ( empty ( $result ) ) {
			$result = array();
			if(isset($wgWikicitiesNavLinks) && is_array($wgWikicitiesNavLinks)) {
				foreach ( $wgWikicitiesNavLinks as $link ) {
					$text = wfMsg( $link['text'] );
					wfProfileIn( __METHOD__.'::'.$link['text'] );
					if ($text != '-') {
						$dest = wfMsgForContent( $link['href'] );
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
			$wgMemc->set( wfMemcKey( 'wikiaNavUrls' ), $result, 60*60 );
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

abstract class WikiaMonoBookTemplate extends WikiaBaseTemplate{
	public function set( $name, $value ) {
		if ( $name == 'headelement' ) {
			$this->wf->profileIn( __METHOD__ );

			//filter out assets specifically registered for other skins
			$skin = $this->wg->user->getSkin();
			$styleTags = $skin->getStyles();
			$scriptTags = $skin->getScripts();
			$out = $this->wg->out;
			$allowedScripts = '';
			$allowedStyles = '';
			$allowedHeadItems = $skin->getHeadItems();

			foreach ( $styleTags as $s ) {
				$allowedStyles .= "{$s['tag']}\n";
			}

			foreach ( $scriptTags as $s ) {
				$allowedScripts .= "{$s['tag']}\n";
			}

			//headitems need to be replaced BEFORE csslinks and scripts as it might be a subset of those!!!
			$value = str_replace( array( $out->getHeadItems(), $out->buildCssLinks(), $out->getScriptsOnly()  ), array( $allowedHeadItems, $allowedStyles, $allowedScripts ), $value );

			$this->wf->profileOut( __METHOD__ );
		}

		parent::set( $name, $value );
	}
}
