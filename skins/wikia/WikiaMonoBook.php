<?php
/**
 * MonoBook nouveau with Wikia modifications
 *
 * Translated from gwicke's previous TAL template version to remove
 * dependency on PHPTAL.
 *
 * @author Maciej Brencz <macbre@wikia.com>
 * @todo add Wikia specific hooks and xHTML/JS/CSS
 * @addtogroup Skins
 */

if(!defined('MEDIAWIKI')) {
	die(-1);
}

require_once dirname(__FILE__) . "/../../extensions/wikia/AnalyticsEngine/AnalyticsEngine.php";

class WikiaSkinMonoBook extends SkinTemplate {

	protected $ads;

	function initPage(&$out) {
		global $wgHooks, $wgShowAds, $wgUseAdServer, $wgRequest;

		parent::initPage( $out );

		$diff = $wgRequest->getVal('diff');

		if($wgShowAds == false || $wgUseAdServer == false || isset($diff)) {
			$this->ads = false;
		}

		$wgHooks['SkinTemplateOutputPageBeforeExec'][] = array(&$this, 'addWikiaVars');
		$wgHooks['SkinTemplateSetupPageCss'][] = array(&$this, 'addWikiaCss');
	}

	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );

		// add YUI css
		$out->addStyle('common/yui_2.5.2/container/assets/container.css');
		$out->addStyle('common/yui_2.5.2/logger/assets/logger.css');
		$out->addStyle('common/yui_2.5.2/tabview/assets/tabview.css');
	}

	function addWikiaVars(&$obj, &$tpl) {
		global $wgCityId, $wgStyleVersion, $wgStylePath, $wgOut, $wgHooks;

		// setup ads
		AdEngine::getInstance()->setLoadType('inline');
		if($this->ads === false) {
			$tpl->set('pageclass', $tpl->textret('pageclass').' without-adsense');
			$tpl->set('ads_top', '');
			$tpl->set('ads_topleft', '');
			$tpl->set('ads_topright', '');
			$tpl->set('ads_bot','');
			$tpl->set('ads_columngoogle',  '<!-- not USING ad server! -->'."\n".'<div id="column-google"></div>'."\n</div>\n");
			$tpl->set('ads_bottomjs', '');
		} else {
			$tpl->set('pageclass', $tpl->textret('pageclass').' with-adsense');
			$tpl->set('ads_top', AdServer::getInstance()->getAd('t'));
			$tpl->set('ads_topleft', AdServer::getInstance()->getAd('tl'));
			$tpl->set('ads_topright', AdServer::getInstance()->getAd('tr'));
			$tpl->set('ads_bot', AdServer::getInstance()->getAd('b'));
			$tpl->set('ads_columngoogle',  '<!-- USING ad server! -->'."\n".'<div id="column-google" class="noprint">'."\n".
				AdEngine::getInstance()->getSetupHtml() .
				'<div id="wikia_header" style="display:none"></div>' . // Hack because ads have code that references this. Awful.
				'<div id="column-google-topright">'.AdEngine::getInstance()->getAd('RIGHT_SPOTLIGHT_1').'</div>'."\n".
				'<div id="column-google-right">'.AdEngine::getInstance()->getAd('RIGHT_SKYSCRAPER_1').'</div>'."\n".
				'<div id="column-google-botright">'.AdEngine::getInstance()->getAd('RIGHT_SPOTLIGHT_2').'</div>'."\n</div>\n"
			);
		}

		$tpl->set('ads_bottomjs',
			AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW) .
			AnalyticsEngine::track('GA_Urchin', 'hub', AdEngine::getCachedCategory()) .
			AnalyticsEngine::track('GA_Urchin', 'onewiki', array($wgCityId)) .
			AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW)
		);

		// load allinone / separate JS files
		$tpl->set('wikia_headscripts', GetReferences('monobook_js') . "<!-- wikia -->\n");

		// wikia toolbox
		$tpl->set('wikia_toolbox', $this->buildWikiaToolbox());

		// setup footer links
		$tpl->set('copyright',  '');
		$tpl->set('privacy',    '');

		$tpl->set('about',      '<a href="http://www.wikia.com/wiki/About_Wikia" title="About Wikia">About Wikia</a>');
		$tpl->set('disclaimer', '<a href="http://www.wikia.com/wiki/Terms_of_use" title="Terms of use">Terms of use</a>');
		$tpl->set('advertise',  '<a href="http://www.federatedmedia.net/authors/wikia" title="advertise on wikia">Advertise</a>');
		$tpl->set('hosting',    '<i>Wikia</i>&reg; is a registered service mark of Wikia, Inc. All rights reserved.');
		$tpl->set('credits',    ' ');

		return true; // hooks must return true
	}

	function addWikiaCss(&$out) {
		global $wgStylePath, $wgStyleVersion;
		$out = '@import "'.$wgStylePath.'/wikia/css/Monobook.css?'.$wgStyleVersion.'";' . $out;
		return true;
	}

	function buildWikiaToolbox() {
		wfProfileIn(__METHOD__);
		global $wgOut;

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

		$html = "	<div class=\"portlet\" id=\"p-wikicities-nav\">
		<h5>{$toolboxTitle}</h5>
		<div class=\"pBody\">{$toolbox}
			<ul>
				<li><a href=\"http://www.wikia.com/wiki/Wikia_news_box\">Wikia messages:</a><br />{$wikiaMessages}</li>
			</ul>
		</div>
	</div>";

		wfProfileOut(__METHOD__);
		return $html;
	}

	function getWikiaMessages() {
		global $wgMemc, $wgOut;
		global $wgLang, $wgContLang;
		wfProfileIn( __METHOD__ );

		$cacheWikiaMessages = $wgLang->getCode() == $wgContLang->getCode();
		if( $cacheWikiaMessages ) {
			$memcKey = wfMemcKey( 'WikiaMessages', $wgLang->getCode() );
			$ret = $wgMemc->get( $memcKey );
		}

		if( empty( $ret ) ) {
			$ret = $wgOut->parse( wfMsg( 'shared-News_box' ) );
			if( $cacheWikiaMessages ) {
				$wgMemc->set( $memcKey, $ret, 5*60 );
			}
		}
		wfProfileOut( __METHOD__ );
		return $ret;
	}

	function buildWikicitiesNavUrls () {

    	    wfProfileIn( __METHOD__ );

	    global $wgWikicitiesNavLinks, $wgMemc;

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
	function bottomScripts() {
		global $wgDBserver;
		$bottomScriptText = '';

		wfRunHooks( 'SkinAfterBottomScripts', array( $this, &$bottomScriptText ) );

		return "
		<!-- WikiaBottomScripts -->
		{$bottomScriptText}
		<!-- /WikiaBottomScripts -->
		<!-- DB: {$wgDBserver} -->";
	}
} // end of class
