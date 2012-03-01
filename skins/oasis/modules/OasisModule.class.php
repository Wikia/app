<?php

class OasisModule extends Module {

	private static $extraBodyClasses = array();

	private $printStyles;

	/**
	 * Add extra CSS classes to <body> tag
	 * @author: Inez Korczyński
	 */
	public static function addBodyClass($className) {
		self::$extraBodyClasses[] = $className;
	}

	// template vars
	var $body;
	var $bodyClasses;
	var $csslinks;
	var $globalVariablesScript;

	var $googleAnalytics;
	var $headlinks;
	var $jsAtBottom;
	var $pagecss;
	var $printableCss;
	var $comScore;
	var $quantServe;
	var $isUserLoggedIn;

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
	var $displayAdminDashboard;

	// global vars
	var $wgEnableOpenXSPC;
	var $wgEnableCorporatePageExt;
	var $wgStylePath;
	var $wgDevelEnvironment;
	var $wgOasisLastCssScripts;

	public function executeIndex($params) {
		global $wgOut, $wgUser, $wgTitle, $wgRequest, $wgCityId, $wgAllInOne, $wgContLang, $wgJsMimeType, $wgEnableAdminDashboardExt, $wgDevelEnvironment, $wgEnableWikiaHubsExt;
		
		if(!empty($wgEnableWikiaHubsExt)) {
			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/WikiaHubs/css/WikiaHubs.scss'));
			$wgOut->addScriptFile($this->wg->ExtensionsPath . '/wikia/WikiaHubs/js/WikiaHubs.js');
		}

		$this->showAllowRobotsMetaTag = !$this->wgDevelEnvironment;

		$this->isUserLoggedIn = $wgUser->isLoggedIn();

		// TODO: move to CreateNewWiki extension - this code should use a hook
		$wikiWelcome = $wgRequest->getVal('wiki-welcome');
		if(!empty($wikiWelcome)) {
			global $wgExtensionsPath;
			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/CreateNewWiki/css/WikiWelcome.scss'));
			$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/CreateNewWiki/js/WikiWelcome.js"></script>');
		}

		$allInOne = $wgRequest->getBool('allinone', $wgAllInOne);

		// macbre: let extensions modify content of the page (e.g. EditPageLayout)
		$this->body = !empty($params['body']) ? $params['body'] : wfRenderModule('Body');

		// generate list of CSS classes for <body> tag
		$this->bodyClasses = array('mediawiki', $this->dir, $this->pageclass);
		$this->bodyClasses = array_merge($this->bodyClasses, self::$extraBodyClasses);
		$this->bodyClasses[] = $this->skinnameclass;

		if(Wikia::isMainPage()) {
			$this->bodyClasses[] = 'mainpage';
		}

		// add skin theme name
		$skin = $wgUser->getSkin();
		if(!empty($skin->themename)) {
			$this->bodyClasses[] = "oasis-{$skin->themename}";
		}

		// mark dark themes
		if (SassUtil::isThemeDark()) {
			$this->bodyClasses[] = 'oasis-dark-theme';
		}

		$this->setupStaticChute();

		// Remove the media="print CSS from the normal array and add it to another so that it can be loaded asynchronously at the bottom of the page.
		$this->printStyles = array();
		$tmpOut = new OutputPage();
		$tmpOut->styles = $wgOut->styles;
		foreach($tmpOut->styles as $style => $options) {
			if (isset($options['media']) && $options['media'] == 'print') {
				unset($tmpOut->styles[$style]);
				$this->printStyles[$style] = $options;
			}
		}

		// render CSS <link> tags
		$this->csslinks = $tmpOut->buildCssLinks();

		$this->headlinks = $wgOut->getHeadLinks();

		$this->pagetitle = htmlspecialchars( $this->pagetitle );
		$this->displaytitle = htmlspecialchars( $this->displaytitle );
		$this->mimetype = htmlspecialchars( $this->mimetype );
		$this->charset = htmlspecialchars( $this->charset );

		$this->globalVariablesScript = Skin::makeGlobalVariablesScript(Module::getSkinTemplateObj()->data);

		/* allow extensions to inject JS just after global JS variables - copied here from OutputPage.php */
		wfRunHooks('SkinGetHeadScripts', array(&$this->globalVariablesScript));

		// printable CSS (to be added at the bottom of the page)
		// FIXME: move to renderPrintCSS() method
		$StaticChute = new StaticChute('css');
		$StaticChute->useLocalChuteUrl();
		$oasisPrintStyles = $StaticChute->config['oasis_css_print'];
		foreach($oasisPrintStyles as $cssUrl){
			$this->printStyles[$cssUrl] = array("media" => "print");
		}

		// If this is an anon article view, use the combined version of the print files.
		if($allInOne){
			// Create the combined URL.
			global $parserMemc, $wgStyleVersion;
			$cb = $parserMemc->get(wfMemcKey('wgMWrevId'));

			if( empty($this->wgDevelEnvironment) ) {
				$prefix = "__wikia_combined/";
			} else {
				global $wgWikiaCombinedPrefix;
				$prefix = $wgWikiaCombinedPrefix;
			}

			// Completely replace the print styles with the combined version.
			$this->printStyles = array(
				"/{$prefix}cb={$cb}{$wgStyleVersion}&type=PrintCSS&isOasis=true" => array("media" => "print")
			);
		}

		$this->printableCss = $this->renderPrintCSS(); // The HTML for the CSS links (whether async or not).

		// setup loading of JS/CSS using WSL (WikiaScriptLoader)
		$this->loadJs();

		// FIXME: create separate module for stats stuff?
		// load Google Analytics code
		$this->googleAnalytics = AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW);

		// onewiki GA
		$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'onewiki', array($wgCityId));

		// track page load time
		$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'pagetime', array('oasis'));

		// track browser height TODO NEF no browser height tracking code anymore, remove
		//$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'browser-height');

		// record which varnish this page was served by
		$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'varnish-stat');

		// TODO NEF not used, remove
		//$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'noads');

		// TODO NEF we dont do AB this way anymore, remove
		//$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'abtest');

		// Add important Gracenote analytics for reporting needed for licensing on LyricWiki.
		if (43339 == $wgCityId){
			$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'lyrics');
		}

		// macbre: RT #25697 - hide Comscore & QuantServe tags on edit pages

		if(!in_array($wgRequest->getVal('action'), array('edit', 'submit'))) {
			$this->comScore = AnalyticsEngine::track('Comscore', AnalyticsEngine::EVENT_PAGEVIEW);
			$this->quantServe = AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW);
		}

		$this->mainsassfile = 'skins/oasis/css/oasis.scss';

		if (!empty($wgEnableAdminDashboardExt) && AdminDashboardLogic::displayAdminDashboard($this->app, $wgTitle)) {
			$this->displayAdminDashboard = true;
		} else {
			$this->displayAdminDashboard = false;
		}
	} // end executeIndex()

	/**
	 * @author Sean Colombo
	 */
	private function renderPrintCSS() {
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		if ($wgRequest->getVal('printable')) {
			// render <link> tags for print preview
			$tmpOut = new OutputPage();
			$tmpOut->styles = $this->printStyles;
			$ret = $tmpOut->buildCssLinks();
		} else {
			// async download
			$cssReferences = Wikia::json_encode(array_keys($this->printStyles));

			$ret = "<script type=\"text/javascript\">/*<![CDATA[*/ setTimeout(function(){wsl.loadCSS({$cssReferences}, 'print');}, 100); /*]]>*/</script>";
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	} // end delayedPrintCSSdownload()

	private function setupStaticChute() {
		global $wgJsMimeType, $wgUser;

		wfProfileIn(__METHOD__);

		$this->jsFiles =  '';

		$srcs = AssetsManager::getInstance()->getGroupCommonURL('oasis_shared_js');
		$srcs = array_merge($srcs, AssetsManager::getInstance()->getGroupCommonURL('oasis_extensions_js'));
		$srcs = array_merge($srcs, AssetsManager::getInstance()->getGroupLocalURL($wgUser->isLoggedIn() ? 'oasis_user_js' : 'oasis_anon_js'));

		foreach($srcs as $src) {
			$this->jsFiles .= "<script type=\"$wgJsMimeType\" src=\"$src\"></script>";
		}

		wfProfileOut(__METHOD__);
	}

	private function rewriteJSlinks( &$link ) {
		global $IP;
		$parts = explode( "?cb=", $link ); // look for http://*/filename.js?cb=XXX
		if( count($parts) == 2 ) {
			//$hash = md5(file_get_contents($IP . '/' . $parts[0]));
			$hash = filemtime( $IP . '/' . $parts[0]);
			$link = $parts[0].'?cb='.$hash;
		} else {
			$ret = preg_replace_callback(
				'#(/__cb)([0-9]+)/([^ ]*)#', // look for http://*/__cbXXXXX/* type of URLs
				function($matches) {
					global $IP, $wgStyleVersion;
					$filename = explode('?',$matches[3]); // some filenames may additionaly end with ?$wgStyleVersion
					//$hash = hexdec(substr(md5(file_get_contents( $IP . '/' . $filename[0])),0,6));
					$hash = filemtime( $IP . '/' . $filename[0] );
					return str_replace( $wgStyleVersion, $hash, $matches[0]);
				},
				$link
			);
			if ( $ret ) {
				$link = $ret;
			}
		}
		//error_log( $link );
	}

	// TODO: implement as a separate module?

	private function loadJs() {

		global $wgTitle, $wgOut, $wgJsMimeType, $wgUser, $wgSpeedBox, $wgDevelEnvironment;
		wfProfileIn(__METHOD__);

		// decide where JS should be placed (only add JS at the top for special and edit pages)
		if ($wgTitle->getNamespace() == NS_SPECIAL || BodyModule::isEditPage()) {
			$this->jsAtBottom = false;
		}
		else {
			$this->jsAtBottom = true;
		}

		// load WikiaScriptLoader
		$this->wikiaScriptLoader = '';
		$wslFiles = AssetsManager::getInstance()->getGroupCommonURL('wsl');
		foreach($wslFiles as $wslFile) {
			if( $wgSpeedBox && $wgDevelEnvironment ) {
				$this->rewriteJSlinks( $wslFile );
			}
			$this->wikiaScriptLoader .= "<script type=\"$wgJsMimeType\" src=\"$wslFile\"></script>";
		}

		wfProfileIn(__METHOD__ . '::regexp');

		// get JS files from <script> tags returned by StaticChute
		// TODO: get StaticChute package (and other JS files to be loaded) here
		$jsReferences = array();
		preg_match_all("/src=\"([^\"]+)/", $this->jsFiles, $matches, PREG_SET_ORDER);
		foreach($matches as $scriptSrc) {
			$jsReferences[] = str_replace('&amp;', '&', $scriptSrc[1]);
		}

		// move JS files added by extensions to list of files to be loaded using WSL
		$headscripts = $wgOut->getScript();

		// Load SiteJS / common.js separately, after all other js files (moved here from oasis_shared_js)
		$headscripts .= "<script type=\"$wgJsMimeType\" src=\"".Title::newFromText('-')->getFullURL('action=raw&smaxage=86400&gen=js&useskin=oasis')."\"></script>";

		// find <script> tags with src attribute
		preg_match_all("#<script[^>]+src=\"([^\"]+)\"></script>#", $headscripts, $matches, PREG_SET_ORDER);
		foreach($matches as $scriptSrc) {
			$jsReferences[] = str_replace('&amp;', '&', $scriptSrc[1]);
			$headscripts = str_replace($scriptSrc[0], '', $headscripts);
		}

		// move <link> tags from headscripts to csslinks (fix SMW issue)
		preg_match_all("#<link ([^>]+)>#", $headscripts, $matches, PREG_SET_ORDER);
		foreach($matches as $linkTag) {
			$this->csslinks .= "\n\t" . trim($linkTag[0]);
			$headscripts = str_replace($linkTag[0], '', $headscripts);
		}

		wfProfileOut(__METHOD__ . '::regexp');

		// add user JS (if User:XXX/wikia.js page exists)
		// copied from Skin::getHeadScripts
		if($wgUser->isLoggedIn()){
			wfProfileIn(__METHOD__ . '::checkForEmptyUserJS');

			$userJS = $wgUser->getUserPage()->getPrefixedText().'/wikia.js';
			$userJStitle = Title::newFromText($userJS);

			if ($userJStitle->exists()) {
				global $wgSquidMaxage;
				$siteargs = array(
					'action' => 'raw',
					'maxage' => $wgSquidMaxage,
				);

				$jsReferences[] = Skin::makeUrl($userJS, wfArrayToCGI($siteargs));
			}

			wfProfileOut(__METHOD__ . '::checkForEmptyUserJS');
		}

		if( $wgSpeedBox && $wgDevelEnvironment ) {
			foreach($jsReferences as &$ref) {
				$this->rewriteJSlinks( $ref );
			}
		}

		// generate code to load JS files
		$jsReferences = Wikia::json_encode($jsReferences);
		$jsLoader = "<script type=\"text/javascript\">/*<![CDATA[*/ (function(){ wsl.loadScript({$jsReferences}); })(); /*]]>*/</script>";

		// use loader script instead of separate JS files
		$this->jsFiles = $jsLoader;

		// add inline scripts
		$this->jsFiles .= trim($headscripts);

		wfProfileOut(__METHOD__);
	}

}
