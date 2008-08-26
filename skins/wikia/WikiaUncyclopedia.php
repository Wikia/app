<?php

/**
 * MonoBook nouveau with Wikia modifications for uncyclopedia
 *
 * Translated from gwicke's previous TAL template version to remove
 * dependency on PHPTAL.
 *
 * @author Maciej Brencz <macbre@wikia.com>
 : @todo add Wikia specific hooks and xHTML/JS/CSS
 * @addtogroup Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );


class WikiaSkinUncyclopedia extends SkinTemplate {

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

	function addWikiaVars(&$obj, &$tpl)
	{
	        if ( $this->ads === false ) {

		    $tpl->set('pageclass', $tpl->textret('pageclass').' without-adsense');

		    // set all adsense stuff to empty strings
		    $tpl->set('ads_top',       '');
		    $tpl->set('ads_topleft',   '');
        	    $tpl->set('ads_topright',  '');
		    $tpl->set('ads_bot',       '');

		    // #column-google content
		    $tpl->set('ads_columngoogle',  '<!-- not USING ad server! -->'."\n".'<div id="column-google"></div>'."\n</div>\n");

		    // bottom JS
		    $tpl->set('ads_bottomjs', '');

		    $this->ads['ads_bottomjs'] = '';
    		}
		else if ( is_array($this->ads) ) {
		    // we're showing ads -> add CSS class to body
		    $tpl->set('pageclass', $tpl->textret('pageclass').' with-adsense');

		    // fill adsense placeholders with ads
		    $tpl->set('ads_top', AdServer::getInstance()->getAd('t'));
		    $tpl->set('ads_topleft', AdServer::getInstance()->getAd('tl'));
		    $tpl->set('ads_topright', AdServer::getInstance()->getAd('tr'));
		    $tpl->set('ads_bot', AdServer::getInstance()->getAd('b'));

		    // #column-google content
		    $tpl->set('ads_columngoogle',  '<!-- USING ad server! -->'."\n".'<div id="column-google">'."\n".
    			'<!-- ADSERVER top right --><div id="column-google-topright">'.AdServer::getInstance()->getAd('tr').'</div>'."\n".
			'<!-- ADSERVER right     --><div id="column-google-right">'.AdServer::getInstance()->getAd('r').'</div>'."\n".
			'<!-- ADSERVER botright  --><div id="column-google-botright">'.AdServer::getInstance()->getAd('br').'</div>'."\n</div>\n"
		    );

		    // bottom JS
		    $tpl->set('ads_bottomjs', '<!-- adserver on, injecting bottom JS.. -->'."\n".
			str_replace('<script>', '<script type="text/javascript">', AdServer::getInstance()->getAd('js_bot1')).
    			str_replace('<script>', '<script type="text/javascript">', AdServer::getInstance()->getAd('js_bot2')).
    			str_replace('<script>', '<script type="text/javascript">', AdServer::getInstance()->getAd('js_bot3'))
		    );

		    $this->ads['ads_bottomjs'] = $tpl->textret('ads_bottomjs');

	        }

	        global $wgStyleVersion, $wgStylePath;

	        // Wikia head scripts
		$tpl->set('wikia_headscripts', "\n\n\t\t".'<!-- Wikia -->'."\n\t\t".
			GetReferences('monobook_js').
			"\n\t\t".
			"<!-- YUI CSS -->\n\t\t".
			'<link rel="stylesheet" type="text/css" href="'.$wgStylePath.'/common/yui/2.3.1/container/assets/container.css?'.$wgStyleVersion.'"/>'.
			'<link rel="stylesheet" type="text/css" href="'.$wgStylePath.'/common/yui/2.3.1/logger/assets/logger.css?'.$wgStyleVersion.'"/>'.
			'<link rel="stylesheet" type="text/css" href="'.$wgStylePath.'/common/yui/2.3.1/tabview/assets/tabview.css?'.$wgStyleVersion.'"/>'.
			"\n\t\t".'<!-- /Wikia -->'."\n\n");


		// wikia toolbox
		$tpl->set('uncyclo_projects', $this->buildUncycloProjects());

		// setup footer links
		$tpl->set('credits',    ' ');
		$tpl->set('privacy',    '');

		$tpl->set('about',      '<a href="http://www.uncyclopedia.org/wiki/About" title="Uncyclopedia:About">About Uncyclopedia</a>');
		$tpl->set('disclaimer', '<a href="http://www.uncyclopedia.org/wiki/General_disclaimer" title="Uncyclopedia:General disclaimer">Disclaimers</a>');

		$tpl->set('hosting',    '<i>Wikia</i>&reg; is a registered service mark of Wikia, Inc. All rights reserved.');

		return true; // hooks must return true
	}

	function addWikiaCss(&$out)
	{
	    global $wgStylePath, $wgStyleVersion;

	    $out = '@import "'.$wgStylePath.'/wikia/css/Uncyclopedia.css?'.$wgStyleVersion.'";' . $out;

	    //print_r($out);

	    return true; // hooks must return true
	}

	function buildUncycloProjects()
	{
	    wfProfileIn(__METHOD__);

	    global $wgStylePath;

	    $toolbox = '
	<div class="portlet" id="p-projects">
	    <h5>projects</h5>
	    <div class ="pBody">
		<a href ="http://stillwatersca.blogspot.com/"><img src="'.$wgStylePath.'/uncyclopedia/stillwaters-button.png" alt="Stillwaters" width="80" height="15" /></a>
		<a href="http://www.chronarion.org/"><img src="'.$wgStylePath.'/uncyclopedia/chronarionbutton.png" alt="chronarion.org" width="80" height="15" /></a>
	    </div>
	</div>';

	    wfProfileOut(__METHOD__);

	    return $toolbox;
	}

	// HTML to be added between footer and end of page
	function bottomScripts()
	{
	    global $wgServer, $wgDBserver;

	    $bottomScriptText = "";
        wfRunHooks( 'SkinAfterBottomScripts', array( $this, &$bottomScriptText ) );

	    return "\n\t".'<!-- WikiaBottomScripts  -->'."\n".

		    ( !empty($this->ads['ads_bottomjs']) ? $this->ads['ads_bottomjs'] :

    			// emil: display GoogleAnalytics for wikis that don't use adserver
			( strpos($wgServer, 'wikia.com') !== false ? "\n\t".'<script type="text/javascript">_udn="wikia.com";_uacct = "UA-288915-1";urchinTracker();</script>' : '')

		    ). $bottomScriptText . "\n\n\t".'<!-- /WikiaBottomScripts  -->'."\n\n". '<!-- DB: '.$wgDBserver.' -->'."\n\n";
	}

	// macbre: serve powered by MW logo from images.wikia.com/common
	function getPoweredBy() {

	    global $wgStylePath;

    	    return '<a href="http://www.wikia.com/"><img src="'.$wgStylePath.'/wikia/img/Hosted_by_wikicities.png" alt="Wikia" /></a>'.
		    '<a href="http://www.mediawiki.org/"><img alt="Powered by MediaWiki" src="'.$wgStylePath.'/common/images/poweredby_mediawiki_88x31.png"/></a>';
	}

} // end of class
?>
