<?php

class OasisModule extends Module {

	private static $extraBodyClasses = array();

	/**
	 * Add extra CSS classes to <body> tag
	 * @author: Inez Korczyński
	 */
	public static function addBodyClass($className) {
		self::$extraBodyClasses[] = $className;
	}

	// remove default meta tags added by core mediawiki so they don't show up twice
	// we will add them back in again when we regenerate headlinks
	private function clearDefaultMeta(&$tags) {
		foreach($tags as $i => $tag) {
			if (in_array($tag[0], array('generator', 'robots', 'keywords'))) {
				unset($tags[$i]);
			}
		}
	}

	// template vars
	var $bodyClasses;
	var $csslinks;
	var $headlinks;
	var $headscripts;
	var $body;
	var $globalVariablesScript;
	var $analytics;
	var $printableCss;
	var $jsAtBottom;

	// skin/template vars
	var $pagetitle;
	var $displaytitle;
	var $mimetype;
	var $charset;
	var $body_ondblclick;
	var $dir;
	var $lang;
	var $pageclass;
	var $skinnameclass;
	var $bottomscripts;

	public function executeIndex() {
		global $wgOut, $wgUser, $wgTitle, $wgRequest;

		$this->body = wfRenderModule('Body');

		// generate list of CSS classes for <body> tag
		$this->bodyClasses = array('mediawiki', $this->dir, $this->pageclass);
		$this->bodyClasses = array_merge($this->bodyClasses, self::$extraBodyClasses);
		$this->bodyClasses[] = $this->skinnameclass;

		if(Wikia::isMainPage()) {
			$this->bodyClasses[] = 'mainpage';
		}

		// add skin theme name
		$skin = $wgUser->getSkin();
		if($skin->themename != '') {
			$this->bodyClasses[] = "oasis-{$skin->themename}";
		}

		// add site JS
		// copied from Skin::getHeadScripts
		global $wgUseSiteJs, $wgJsMimeType;
		if (!empty($wgUseSiteJs)) {
			$jsCache = $wgUser->isLoggedIn() ? '&smaxage=0' : '';
			$wgOut->addScript("<script type=\"$wgJsMimeType\" src=\"".
					htmlspecialchars(Skin::makeUrl('-',
							"action=raw$jsCache&gen=js&useskin=" .
							urlencode( $skin->getSkinName() ) ) ) .
					"\"><!-- site js --></script>");
		}

		// We re-process the wgOut scripts and links here so modules can add to the arrays inside their execute method
		$this->headscripts = $wgOut->getScript();
		$this->csslinks = $wgOut->buildCssLinks();
		$this->clearDefaultMeta($wgOut->mMetatags);
		$this->headlinks = $wgOut->getHeadLinks();

		$this->pagetitle = htmlspecialchars( $this->pagetitle );
		$this->displaytitle = htmlspecialchars( $this->displaytitle );
		$this->mimetype = htmlspecialchars( $this->mimetype );
		$this->charset = htmlspecialchars( $this->charset );

		$this->globalVariablesScript = Skin::makeGlobalVariablesScript(Module::getSkinTemplateObj()->data);

		// printable CSS (to be added at the bottom of the page)
		$this->printableCss = Xml::element('link', array(
			'href' => wfGetSassUrl('skins/oasis/css/print.scss'),
			'media' => $wgOut->transformCssMedia('print'),
			'rel' => 'stylesheet',
			'type' => 'text/css',
		));

		// load Google Analytics code
		$this->analytics = AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW);

		// track page load time
		$this->analytics .= AnalyticsEngine::track('GA_Urchin', 'pagetime', array('oasis'));

		// decide where JS should be placed (only add JS at the top for special and edit pages)
		if ($wgTitle->getNamespace() == NS_SPECIAL || BodyModule::isEditPage()) {
			$this->jsAtBottom = false;
		}
		else {
			$this->jsAtBottom = true;
		}

		// Merged JS files via StaticChute
		// get the right package from StaticChute
		$staticChute = new StaticChute('js');
		$staticChute->useLocalChuteUrl();

		$packagePrefix = "oasis_";
		if($wgUser->isLoggedIn()) {
			$package = $packagePrefix.'loggedin_js';
		} else {

			// list of namespaces and actions on which we should load package with YUI
			$ns = array(NS_SPECIAL);
			$actions = array('edit', 'preview', 'submit');

			// add blog namespaces
			global $wgEnableBlogArticles;
			if(!empty($wgEnableBlogArticles)) {
				$ns = array_merge($ns, array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK, NS_BLOG_LISTING, NS_BLOG_LISTING_TALK));
			}

			if(in_array($wgTitle->getNamespace(), $ns) || in_array($wgRequest->getVal('action', 'view'), $actions)) {
				// edit mode & special/blog pages (package with YUI)
				$package = $packagePrefix.'anon_everything_else_js';
			} else {
				// view mode (package without YUI)
				$package = $packagePrefix.'anon_article_js';
			}
		}
		// If we use StaticChute right on the page (rather than loaded asynchronously), we'll use this var.
		$this->staticChuteHtml = $staticChute->getChuteHtmlForPackage($package);

//		// load WikiaScriptLoader
//		// macbre: this is minified version of /skins/monaco/js/WikiaScriptLoader.js using Google Closure
//		$this->wikiaScriptLoader = "\t\t" . '<script type="text/javascript">/*<![CDATA[*/var WikiaScriptLoader=function(){var b=navigator.userAgent.toLowerCase();this.useDOMInjection=b.indexOf("opera")!=-1||b.indexOf("firefox")!=-1;this.isIE=b.indexOf("opera")==-1&&b.indexOf("msie")!=-1;this.headNode=document.getElementsByTagName("HEAD")[0]}; WikiaScriptLoader.prototype={loadScript:function(b,c){this.useDOMInjection?this.loadScriptDOMInjection(b,c):this.loadScriptDocumentWrite(b,c)},loadScriptDOMInjection:function(b,c){var a=document.createElement("script");a.type="text/javascript";a.src=b;var d=function(){a.onloadDone=true;typeof c=="function"&&c()};a.onloadDone=false;a.onload=d;a.onreadystatechange=function(){a.readyState=="loaded"&&!a.onloadDone&&d()};this.headNode.appendChild(a)},loadScriptDocumentWrite:function(b,c){document.write(\'<script src="\'+ b+\'" type="text/javascript"><\/script>\');b=function(){typeof c=="function"&&c()};typeof c=="function"&&this.addHandler(window,"load",b)},loadScriptAjax:function(b,c){var a=this,d=this.getXHRObject();d.onreadystatechange=function(){if(d.readyState==4){var e=d.responseText;if(a.isIE)eval(e);else{var f=document.createElement("script");f.type="text/javascript";f.text=e;a.headNode.appendChild(f)}typeof c=="function"&&c()}};d.open("GET",b,true);d.send("")},loadCSS:function(b,c){var a=document.createElement("link"); a.rel="stylesheet";a.type="text/css";a.media=c||"";a.href=b;this.headNode.appendChild(a)},addHandler:function(b,c,a){if(window.addEventListener)window.addEventListener(c,a,false);else window.attachEvent&&window.attachEvent("on"+c,a)},getXHRObject:function(){var b=false;try{b=new XMLHttpRequest}catch(c){for(var a=["Msxml2.XMLHTTP.6.0","Msxml2.XMLHTTP.3.0","Msxml2.XMLHTTP","Microsoft.XMLHTTP"],d=a.length,e=0;e<d;e++){try{b=new ActiveXObject(a[e])}catch(f){continue}break}}return b}};window.wsl=new WikiaScriptLoader;/*]]>*/</script>';
//
//		global $wgAllInOne, $wgRequest;
//		$allinone = $wgRequest->getBool('allinone', $wgAllInOne);
//
//		wfProfileIn(__METHOD__ . '::JSloader');
//		$jsReferences = array();
//		if($allinone && $package == $packagePrefix.'anon_article_js') {
//			global $parserMemc, $wgStyleVersion, $wgEnableViewYUI;
//			$cb = $parserMemc->get(wfMemcKey('wgMWrevId'));
//
//			$addParam = "";
//			// TODO: Do we still need this around in Oasis?
//			if (!empty($wgEnableViewYUI)) {
//				$addParam = "&yui=1";
//			}
//
//			global $wgDevelEnvironment;
//			if(empty($wgDevelEnvironment)){
//				$prefix = "__wikia_combined/";
//			} else {
//				global $wgWikiaCombinedPrefix;
//				$prefix = $wgWikiaCombinedPrefix;
//			}
//			$jsReferences[] = "/{$prefix}cb={$cb}{$wgStyleVersion}&type=CoreJS";
//		} else {
//			$jsHtml = $staticChute->getChuteHtmlForPackage($package);
//
//			if ($package == $packagePrefix."anon_article_js") {
//				$jsHtml .= $staticChute->getChuteHtmlForPackage("yui");
//			}
//
//			// get URL of StaticChute package (or a list of separated files) and use WSL to load it
//			preg_match_all("/src=\"([^\"]+)/", $jsHtml, $matches, PREG_SET_ORDER);
//
//			foreach($matches as $script) {
//				$jsReferences[] = str_replace('&amp;', '&', $script[1]);
//			}
//		}
//
//		/*
//		// THIS AND THE FUNCTION IT CALLS (would need to port from Monaco) WOULD LET USER-JS BE LOADED. THAT CURRENTLY DOES NOT BELONG HERE IN OASIS.
//		// scripts from getReferencesLinks() method
//		foreach($tpl->data['references']['js'] as $script) {
//			if (!empty($script['url'])) {
//				$url = $script['url'];
//				if($allinone && $package == $packagePrefix.'anon_article_js' && strpos($url, 'title=-') > 0) {
//					continue;
//				}
//				$jsReferences[] = $url;
//			}
//		}
//		*/
//
//		// scripts from $wgOut->mScripts
//		// <script type="text/javascript" src="URL"></script>
//		// load them using WSL and remove from $wgOut->mScripts
//		//
//		// macbre: Perform only for Monaco/Oasis skins! New Answers skin does not use WikiaScriptLoader
//// NOTE: This seems a bit buggy.  The page-weight drops when I enable it in Oasis.
//// TODO: Add  || Wikia::isOasis() to enable for Oasis.
//		if ((get_class($this) == 'SkinMonaco') || (get_class($this) == 'SkinAnswers')) {
//			global $wgJsMimeType;
//
//			preg_match_all("#<script type=\"{$wgJsMimeType}\" src=\"([^\"]+)\"></script>#", $this->headscripts, $matches, PREG_SET_ORDER);
//			foreach($matches as $script) {
//				$jsReferences[] = str_replace('&amp;', '&', $script[1]);
//				$this->headscripts = str_replace($script[0], '', $this->headscripts);
//			}
//
//			// generate code to load JS files
//			$jsReferences = Wikia::json_encode($jsReferences);
//			$jsLoader = <<<EOF
//
//		<script type="text/javascript">/*<![CDATA[*/
//			(function(){
//				var jsReferences = $jsReferences;
//				var len = jsReferences.length;
//				for(var i=0; i<len; i++)
//					wsl.loadScript(jsReferences[i]);
//			})();
//		/*]]>*/</script>
//EOF;
//
//			// Holds the code for asynchronously loading all of the files that we are willing to load async.
//			$this->jsLoader = $jsLoader;
//		}
//
//		wfProfileOut(__METHOD__ . '::JSloader');

	}
}
