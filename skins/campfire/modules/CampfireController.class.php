<?php

class CampfireController extends WikiaController {

	private static $extraBodyClasses = array();

	private $printStyles;

	/**
	 * Add extra CSS classes to <body> tag
	 * @author: Inez Korczyński
	 */
	public static function addBodyClass($className) {
		self::$extraBodyClasses[] = $className;
	}

	public function init() {
		$skinVars = $this->app->getSkinTemplateObj()->data;
		$this->pagetitle = $skinVars['pagetitle'];
		$this->displaytitle = $skinVars['displaytitle'];
		$this->mimetype = $skinVars['mimetype'];
		$this->charset = $skinVars['charset'];
		$this->body_ondblclick = $skinVars['body_ondblclick'];
		$this->dir = $skinVars['dir'];
		$this->lang = $skinVars['lang'];
		$this->pageclass = $skinVars['pageclass'];
		$this->pagecss = $skinVars['pagecss'];
		$this->skinnameclass = $skinVars['skinnameclass'];
		$this->bottomscripts = $skinVars['bottomscripts'];
		// initialize variables
		$this->comScore = null;
		$this->quantServe = null;
	}

	public function executeIndex($params) {
		global $wgOut, $wgUser, $wgTitle, $wgRequest, $wgCityId, $wgAllInOne, $wgContLang, $wgJsMimeType;

		$allInOne = $wgAllInOne;

		// macbre: let extensions modify content of the page (e.g. EditPageLayout)
		$this->body = !empty($params['body']) ? $params['body'] : F::app()->renderView('CampfireBody', 'Index');

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

		$this->setupJavaScript();

		$this->printStyles = array();

		// render CSS <link> tags

		$this->headlinks = $wgOut->getHeadLinks();

		$this->pagetitle = htmlspecialchars( $this->pagetitle );
		$this->displaytitle =  htmlspecialchars( $this->displaytitle );
		$this->mimetype = htmlspecialchars( $this->mimetype );
		$this->charset = htmlspecialchars( $this->charset );

		$this->globalVariablesScript = Skin::makeGlobalVariablesScript($this->app->getSkinTemplateObj()->data);

		// printable CSS (to be added at the bottom of the page)
		// If this is an anon article view, use the combined version of the print files.
		if($allInOne){
			// Create the combined URL.
			global $parserMemc, $wgStyleVersion;
			$cb = $parserMemc->get(wfMemcKey('wgMWrevId'));

			global $wgDevelEnvironment;
			if(empty($wgDevelEnvironment)){
				$prefix = "__wikia_combined/";
			} else {
				global $wgWikiaCombinedPrefix;
				$prefix = $wgWikiaCombinedPrefix;
			}

			// no print styles
			$this->printStyles = array();
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

		// track browser height
		$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'browser-height');

		// record which varnish this page was served by
		$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'varnish-stat');

		$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'noads');

		$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'abtest');

		// Add important Gracenote analytics for reporting needed for licensing on LyricWiki.
		if (43339 == $wgCityId){
			$this->googleAnalytics .= AnalyticsEngine::track('GA_Urchin', 'lyrics');
		}

		// macbre: RT #25697 - hide Comscore & QuantServe tags on edit pages

		if(!in_array($wgRequest->getVal('action'), array('edit', 'submit'))) {
			$this->comScore = AnalyticsEngine::track('Comscore', AnalyticsEngine::EVENT_PAGEVIEW);
			$this->quantServe = AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW);
		}

		$this->mainsassfile = 'skins/campfire/css/campfire.scss';

	} // end executeIndex()

	private function renderPrintCSS() { return ''; }

	private function setupJavaScript() {
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

	// TODO: implement as a separate module?
	private function loadJs() {
		global $wgTitle, $wgOut, $wgJsMimeType, $wgUser;
		wfProfileIn(__METHOD__);

		// decide where JS should be placed (only add JS at the top for special and edit pages)
		if ($wgTitle->getNamespace() == NS_SPECIAL || BodyController::isEditPage()) {
			$this->jsAtBottom = false;
		}
		else {
			$this->jsAtBottom = true;
		}

		//store AssetsManager output and reset jsFiles
		$jsAssets = $this->jsFiles;
		$this->jsFiles = '';

		// load WikiaScriptLoader
		$this->wikiaScriptLoader = '';
		$wslFiles = AssetsManager::getInstance()->getGroupCommonURL( 'wsl' );

		foreach($wslFiles as $wslFile) {
			$this->wikiaScriptLoader .= "<script type=\"$wgJsMimeType\" src=\"$wslFile\"></script>";
		}

		// get JS files from <script> tags returned by AssetsManager
		// TODO: get AssetsManager package (and other JS files to be loaded) here
		preg_match_all("/src=\"([^\"]+)/", $jsAssets, $matches, PREG_SET_ORDER);

		foreach($matches as $scriptSrc) {
			$jsReferences[] = str_replace('&amp;', '&', $scriptSrc[1]);;
		}

		// move JS files added to OutputPage to list of files to be loaded using WSL
		$scripts = $wgUser->getSkin()->getScripts();

		foreach ( $scripts as $s ) {
			//add inline scripts to jsFiles and move non-inline to WSL queue
			if ( !empty( $s['url'] ) ) {
				$jsReferences[] = $s['url'];
			} else {
				$this->jsFiles .= $s['tag'];
			}
		}

		// add user JS (if User:XXX/wikia.js page exists)
		// copied from Skin::getHeadScripts
		if($wgUser->isLoggedIn()){
			wfProfileIn(__METHOD__ . '::checkForEmptyUserJS');

			$userJS = $wgUser->getUserPage()->getPrefixedText() . '/wikia.js';
			$userJStitle = Title::newFromText( $userJS );

			if ( $userJStitle->exists() ) {
				global $wgSquidMaxage;

				$siteargs = array(
						'action' => 'raw',
						'maxage' => $wgSquidMaxage,
				);

				$userJS = Skin::makeUrl( $userJS, wfArrayToCGI( $siteargs ) );
				$jsReferences[] = Skin::makeUrl( $userJS, wfArrayToCGI( $siteargs ) );;
			}

			wfProfileOut(__METHOD__ . '::checkForEmptyUserJS');
		}

		// generate code to load JS files
		$jsReferences = json_encode($jsReferences);
		$jsLoader = "<script type=\"text/javascript\">/*<![CDATA[*/ (function(){ wsl.loadScript({$jsReferences}); })(); /*]]>*/</script>";

		// use loader script instead of separate JS files
		$this->jsFiles = $jsLoader . $this->jsFiles;

		wfProfileOut(__METHOD__);
	}

}
