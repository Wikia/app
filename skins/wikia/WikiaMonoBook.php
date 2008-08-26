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

class WikiaSkinMonoBook extends SkinTemplate {

	var $ads;

	function initPage(&$out) {
		global $wgOut, $wgHooks, $wgShowAds, $wgUseAdServer, $wgRequest;

		parent::initPage( $out );

		$diff = $wgRequest->getVal('diff');

		if($wgShowAds == false || $wgUseAdServer == false || isset($diff)) {
			$this->ads = false;
		}

		$wgHooks['SkinTemplateOutputPageBeforeExec'][] = array(&$this, 'addWikiaVars');
		$wgHooks['SkinTemplateSetupPageCss'][] = array(&$this, 'addWikiaCss');
	}

	function addWikiaVars(&$obj, &$tpl) {
		global $wgKennisnet;

		$isKennisnet = isset($wgKennisnet) && ($wgKennisnet == true);

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
    			'<!-- ADSERVER top right --><div id="column-google-topright">'.AdServer::getInstance()->getAd('tr').'</div>'."\n".
			'<!-- ADSERVER right     --><div id="column-google-right">'.AdServer::getInstance()->getAd('r').'</div>'."\n".
			'<!-- ADSERVER botright  --><div id="column-google-botright">'.AdServer::getInstance()->getAd('br').'</div>'."\n</div>\n"
			);

			$tpl->set('ads_bottomjs', '<!-- adserver on, injecting bottom JS -->'."\n".
				str_replace('<script>', '<script type="text/javascript">', AdServer::getInstance()->getAd('js_bot1')).
				str_replace('<script>', '<script type="text/javascript">', AdServer::getInstance()->getAd('js_bot2')).
				str_replace('<script>', '<script type="text/javascript">', AdServer::getInstance()->getAd('js_bot3'))
			);
		}

		global $wgStyleVersion, $wgStylePath;

		$tpl->set('wikia_headscripts', "\n\n\t\t".'<!-- Wikia -->'."\n\t\t".
			GetReferences('monobook_js').
			"\n\t\t".
			"<!-- YUI CSS -->\n\t\t".
			'<link rel="stylesheet" type="text/css" href="'.$wgStylePath.'/common/yui_2.5.2/container/assets/container.css?'.$wgStyleVersion.'"/>'.
			'<link rel="stylesheet" type="text/css" href="'.$wgStylePath.'/common/yui_2.5.2/logger/assets/logger.css?'.$wgStyleVersion.'"/>'.
			'<link rel="stylesheet" type="text/css" href="'.$wgStylePath.'/common/yui_2.5.2/tabview/assets/tabview.css?'.$wgStyleVersion.'"/>'.
			"\n\t\t".'<!-- /Wikia -->'."\n\n");

		global $wgCurse, $wgStylePath, $wgOut, $wgHooks;
		if(!empty($wgCurse) && $wgCurse == true) {
		$tpl->set('cursed', true);
		$tpl->set('cursed_path', 'http://www.curse.com/js/wikia');	// serve JS from curse.com
		//$this->set('cursed_path', $wgCurseExternal ? 'http://www.curse.com/js/wikia' : $wgStylePath.'/monobook/curse'); // serve JS from wikia.com

		$wgOut->addScript('<!-- curse --><script type="text/javascript" src="'.$tpl->textret('cursed_path').'/head.js"></script><!-- /curse -->'."\n");

		$tpl->set('curse_header', '<!-- curse header --><script type="text/javascript" src="'.$tpl->textret('cursed_path').'/header.js"></script><!-- /curse header -->');
		$tpl->set('curse_footer', '<!-- curse footer --><script type="text/javascript" src="'.$tpl->textret('cursed_path').'/footer.js"></script><!-- /curse footer -->');

		} else {
		    $tpl->set('cursed', false);
		}

		// ABC.com cobranding
		global $wgPartnerWikiData;
		if( isset($wgPartnerWikiData['project']) &&  $wgPartnerWikiData['project'] == 'ABC' ) {
			$tpl->set( 'abc_css', '<link rel="stylesheet" type="text/css" href="'.$wgStylePath.'/monobook/abc/main.css"/>' );
			$tpl->set( 'abc_header', '<iframe width="100%" height="172" src="http://abc.go.com/static/gnav/header_fall2007_external.html?url=/primetime/lost/wiki"></iframe><div id="wikia-content"><div>' );
			$tpl->set( 'abc_footer', '</div><iframe width="100%" height="97" src="http://abc.go.com/static/gnav/footer_fall2007_external.html"></iframe>' );
		}

		// wikia toolbox
		$tpl->set('wikia_toolbox', !$isKennisnet ? $this->buildWikiaToolbox() : '');

		// setup footer links
		$tpl->set('copyright',  '');
		$tpl->set('privacy',    '');

		if(!$isKennisnet)
		{
		    $tpl->set('about',      '<a href="http://www.wikia.com/wiki/About_Wikia" title="About Wikia">About Wikia</a>');
		    $tpl->set('disclaimer', '<a href="http://www.wikia.com/wiki/Terms_of_use" title="Terms of use">Terms of use</a>');
		    $tpl->set('advertise',  '<a href="http://www.federatedmedia.net/authors/wikia" title="advertise on wikia">Advertise</a>');
		    $tpl->set('hosting',    '<i>Wikia</i>&reg; is a registered service mark of Wikia, Inc. All rights reserved.');

		    $tpl->set('credits',    ' ');
		}
		else
		{
		    $tpl->set('about',      '');
		    $tpl->set('disclaimer', '');
		    $tpl->set('advertise',  '');
		    $tpl->set('hosting',    '');
		    $tpl->set('diggs',      '');
		    $tpl->set('delicious',  '');
		}

		return true; // hooks must return true
	}

	function addWikiaCss(&$out)
	{
	    global $wgStylePath, $wgStyleVersion;

	    $out = '@import "'.$wgStylePath.'/wikia/css/Monobook.css?'.$wgStyleVersion.'";' . $out;

	    //print_r($out);

	    return true; // hooks must return true
	}

	function buildWikiaToolbox()
	{
	    wfProfileIn(__METHOD__);

	    global $wgKennisnet, $wgOut;

	    $wikicitiesNavUrls = $this->buildWikicitiesNavUrls();

	    $toolbox = '';

	    if (empty($wgKennisnet))
	    {
    		$toolbox = "\n\t".'<div class="portlet" id="p-wikicities-nav">'."\n\t\t".'<h5>'.wfMsg('wikicities-nav').'</h5>'."\n\t\t".'<div class="pBody">';

		if (count($wikicitiesNavUrls))
		{
		    $toolbox .= "\n\t\t\t<ul>";

		    foreach($wikicitiesNavUrls as $navlink)
		    {
                	$toolbox .= "\n\t\t\t\t".'<li id="'.htmlspecialchars($navlink['id']).'"><a href="'.htmlspecialchars($navlink['href']).'">'.htmlspecialchars($navlink['text']).'</a></li>';
		    }

		    $toolbox .= "\n\t\t\t</ul>\n\n\t\t\t<hr />";

		}

    		$toolbox .= "\n\n\t\t\t<ul>".
	            "\n\t\t\t\t".'<li><a href="http://www.wikia.com/wiki/Wikia_news_box">Wikia messages:</a><br />'.self::getWikiaMessages().'</li>'.
		    "\n\t\t\t</ul>\n\t\t</div>\n\t</div>\n";
	    }

	    //print_pre(htmlspecialchars($toolbox));

	    wfProfileOut(__METHOD__);

	    return $toolbox;

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
	function bottomScripts()
	{
	    global $wgServer, $wgDBserver;

	    $bottomScriptText = "\n\t".'<!-- WikiaBottomScripts  -->'."\n";
        wfRunHooks( 'SkinAfterBottomScripts', array( $this, &$bottomScriptText ) );
	    $bottomScriptText .= "\n\n\t".'<!-- /WikiaBottomScripts  -->'."\n\n" . '<!-- DB: '.$wgDBserver.' -->'."\n\n";

        return $bottomScriptText;
	}
} // end of class
?>
