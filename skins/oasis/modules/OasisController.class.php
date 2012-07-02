<?php

class OasisController extends WikiaController {

	private static $extraBodyClasses = array();

	private $printStyles;
	private $assetsManager;

	/**
	 * Add extra CSS classes to <body> tag
	 * @author: Inez Korczyński
	 */
	public static function addBodyClass($className) {
		self::$extraBodyClasses[] = $className;
	}

	public function init() {
		wfProfileIn(__METHOD__);
		$skinVars = $this->app->getSkinTemplateObj()->data;
		$this->assetsManager = F::build( 'AssetsManager', array(), 'getInstance' );
		$this->pagetitle = $skinVars['pagetitle'];
		$this->displaytitle = $skinVars['displaytitle'];
		$this->mimetype = $skinVars['mimetype'];
		$this->charset = $skinVars['charset'];
		$this->dir = $skinVars['dir'];
		$this->lang = $skinVars['lang'];
		$this->pageclass = $skinVars['pageclass'];
		$this->pagecss = $skinVars['pagecss'];
		$this->skinnameclass = $skinVars['skinnameclass'];
		$this->bottomscripts = $skinVars['bottomscripts'];
		// initialize variables
		$this->comScore = null;
		$this->quantServe = null;

		$this->app->registerHook('MakeGlobalVariablesScript', 'OasisController', 'onMakeGlobalVariablesScript');
		wfProfileOut(__METHOD__);
	}

	/**
	 * Add global JS variables with wgJsAtBottom
	 *
	 * @param array $vars global variables list
	 * @return boolean return true
	 */
	public function onMakeGlobalVariablesScript($vars) {
		$vars['wgJsAtBottom'] = self::JsAtBottom();
		return true;
	}

	/**
	 * Business-logic for determining if the javascript should be at the bottom of the page (it usually should be
	 * at the bottom for performance reasons, but there are some exceptions for engineering reasons).
	 */
	public static function JsAtBottom(){
		global $wgTitle;

		// decide where JS should be placed (only add JS at the top for non-search Special and edit pages)
		if (ArticleAdLogic::isSearch()) {
			$jsAtBottom = true;	// Liftium.js (part of AssetsManager) must be loaded after LiftiumOptions variable is set in page source
		}
		elseif ($wgTitle->getNamespace() == NS_SPECIAL || BodyController::isEditPage()) {
			$jsAtBottom = false;
		}
		else {
			$jsAtBottom = true;
		}
		return $jsAtBottom;
	}

	public function executeIndex($params) {
		global $wgOut, $wgUser, $wgTitle, $wgRequest, $wgCityId, $wgEnableAdminDashboardExt, $wgEnableWikiaHubsExt;

		wfProfileIn(__METHOD__);
		// TODO: move to WikiaHubs extension - this code should use a hook
		if(!empty($wgEnableWikiaHubsExt)) {
			$wgOut->addStyle( $this->assetsManager->getSassCommonURL( 'extensions/wikia/WikiaHubs/css/WikiaHubs.scss' ) );
			$wgOut->addScriptFile($this->wg->ExtensionsPath . '/wikia/WikiaHubs/js/WikiaHubs.js');
		}

		$this->showAllowRobotsMetaTag = !$this->wg->DevelEnvironment;

		$this->isUserLoggedIn = $wgUser->isLoggedIn();

		// TODO: move to CreateNewWiki extension - this code should use a hook
		$wikiWelcome = $wgRequest->getVal('wiki-welcome');
		if(!empty($wikiWelcome)) {
			$wgOut->addStyle( $this->assetsManager->getSassCommonURL( 'extensions/wikia/CreateNewWiki/css/WikiWelcome.scss' ) );
			$wgOut->addScript( '<script src="' . $this->wg->ExtensionsPath . '/wikia/CreateNewWiki/js/WikiWelcome.js"></script>' );
		}

		$renderContentOnly = false;
		if (!empty($this->wg->EnableRenderContentOnlyExt)) {
			if(renderContentOnly::isRenderContentOnlyEnabled()) {
				$renderContentOnly = true;
			}
		}

		if($renderContentOnly) {
			$this->body = wfRenderModule('BodyContentOnly');
		} else {
			// macbre: let extensions modify content of the page (e.g. EditPageLayout)
			wfProfileIn(__METHOD__ . ' - renderBody');
			$this->body = !empty($params['body']) ? $params['body'] : wfRenderModule('Body');
			wfProfileOut(__METHOD__ . ' - renderBody');
		}

		// generate list of CSS classes for <body> tag
		$bodyClasses = array('mediawiki', $this->dir, $this->pageclass);
		$bodyClasses = array_merge($bodyClasses, self::$extraBodyClasses);
		$bodyClasses[] = $this->skinnameclass;

		if(Wikia::isMainPage()) {
			$bodyClasses[] = 'mainpage';
		}

		wfProfileIn(__METHOD__ . ' - skin Operations');
		// add skin theme name
		$skin = $wgUser->getSkin();
		if(!empty($skin->themename)) {
			$bodyClasses[] = "oasis-{$skin->themename}";
		}

		// mark dark themes
		if (SassUtil::isThemeDark()) {
			$bodyClasses[] = 'oasis-dark-theme';
		}
		$this->bodyClasses = $bodyClasses;

    	//reset, this ensures no duplication in CSS links
		$this->printStyles = array();
		$this->csslinks = '';

		foreach ( $skin->getStyles() as $s ) {
			// Remove the non-inlined media="print" CSS from the normal array and add it to another so that it can be loaded asynchronously at the bottom of the page.
			if ( !empty( $s['url'] ) && stripos($s['tag'], 'media="print"')!== false) {
				$this->printStyles[] = $s['url'];
			} else {
				$this->csslinks .= $s['tag'];
			}
		}

		$this->headlinks = $wgOut->getHeadLinks();
		$this->headitems = $skin->getHeadItems();

		$this->pagetitle = htmlspecialchars( $this->pagetitle );
		$this->displaytitle = htmlspecialchars( $this->displaytitle );
		$this->mimetype = htmlspecialchars( $this->mimetype );
		$this->charset = htmlspecialchars( $this->charset );

		wfProfileOut(__METHOD__ . ' - skin Operations');

		$this->topScripts = $this->wg->user->getSkin()->getTopScripts();

		// printable CSS (to be added at the bottom of the page)
		// FIXME: move to renderPrintCSS() method
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
		wfProfileOut(__METHOD__);
	} // end executeIndex()

	/**
	 * @author Sean Colombo. Macbre
	 */
	private function renderPrintCSS() {
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		// add SASS for printable version of Oasis
		$this->printStyles[] = $this->assetsManager->getSassCommonURL( 'skins/oasis/css/print.scss' );

		// render the output
		$ret = '';

		if ($wgRequest->getVal('printable')) {
			// render <link> tags for print preview
			foreach ( $this->printStyles as $url ) {
				$ret .= "<link rel=\"stylesheet\" href=\"{$url}\" />\n";
			}
		} else {
			// async download
			$cssReferences = json_encode( $this->printStyles );
			$ret = Html::inlineScript("setTimeout(function(){wsl.loadCSS({$cssReferences}, 'print')}, 100)");
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	private function rewriteJSlinks( $link ) {
		global $IP;
		wfProfileIn( __METHOD__ );

		$parts = explode( "?cb=", $link ); // look for http://*/filename.js?cb=XXX

		if ( count( $parts ) == 2 ) {
			//$hash = md5(file_get_contents($IP . '/' . $parts[0]));
			$fileName = $parts[0];
			$fileName = preg_replace("#^(https?:)?//[^/]+#","",$fileName);
			$hash = filemtime( $IP . '/' . $fileName);
			$link = $parts[0].'?cb='.$hash;
		} else {
			$ret = preg_replace_callback(
				'#(/__cb)([0-9]+)/([^ ]*)#', // look for http://*/__cbXXXXX/* type of URLs
				function ( $matches ) {
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

		wfProfileOut( __METHOD__ );
		return $link;
	}

	// TODO: implement as a separate module?
	private function loadJs() {
		global $wgTitle, $wgOut, $wgJsMimeType, $wgUser, $wgSpeedBox, $wgDevelEnvironment, $wgEnableAbTesting;
		wfProfileIn(__METHOD__);

		$assetsManager = F::build( 'AssetsManager', array(), 'getInstance' );

		$this->jsAtBottom = self::JsAtBottom();

		// load WikiaScriptLoader, AbTesting files, anything that's so mandatory that we're willing to make a blocking request to load it.
		$this->wikiaScriptLoader = '';

		$packages = array( 'oasis_blocking' );

		if ( !empty( $wgEnableAbTesting ) ) {
			$pkg = F::build('AbTesting')->getJsPackage();

			if(!empty($pkg)){
				$packages[] = $pkg;
			}
		}

		$blockingScripts = $this->assetsManager->getURL( $packages );

		foreach($blockingScripts as $blockingFile) {
			if( $wgSpeedBox && $wgDevelEnvironment ) {
				$blockingFile = $this->rewriteJSlinks( $blockingFile );
			}

			$this->wikiaScriptLoader .= "<script type=\"$wgJsMimeType\" src=\"$blockingFile\"></script>";
		}

		/*
		// gen=js is no longer used in 1.19 - @author: wladek
		// TODO: remove after confirmation

		// BugId:20929 - tell (or trick) varnish to store the latest revisions of Wikia.js and Common.js.
		$oTitleWikiaJs	= Title::newFromText( 'Wikia.js',  NS_MEDIAWIKI );
		$oTitleCommonJs	= Title::newFromText( 'Common.js', NS_MEDIAWIKI );
		$iMaxRev = max( (int) $oTitleWikiaJs->getLatestRevID(), (int) $oTitleCommonJs->getLatestRevID() );
		unset( $oTitleWikiaJs, $oTitleCommonJs );

		// Load SiteJS / common.js separately, after all other js files (moved here from oasis_shared_js)
		$siteJS = Title::newFromText('-')->getFullURL('action=raw&smaxage=86400&maxrev=' . $iMaxRev . '&gen=js&useskin=oasis');
		$jsReferences[] = ( !empty( $wgSpeedBox ) && !empty( $wgDevelEnvironment ) ) ? $this->rewriteJSlinks( $siteJS ) : $siteJS;
		*/

		// move JS files added to OutputPage to list of files to be loaded using WSL
		$scripts = $wgUser->getSkin()->getScripts();

		foreach ( $scripts as $s ) {
			//add inline scripts to jsFiles and move non-inline to WSL queue
			if ( !empty( $s['url'] ) ) {
				// FIXME: quick hack to load MW core JavaScript at the top of the page - really, please fix me!
				// @author macbre
				if (strpos($s['url'], 'load.php') !== false) {
					$this->globalVariablesScript = $s['tag'] . $this->globalVariablesScript;
				}
				else {
					$jsReferences[] = ( !empty( $wgSpeedBox ) && !empty( $wgDevelEnvironment ) ) ? $this->rewriteJSlinks( $s['url'] ) : $s['url'];
				}
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
				$jsReferences[] = ( !empty( $wgSpeedBox ) && !empty( $wgDevelEnvironment ) ) ? $this->rewriteJSlinks( $userJS ) : $userJS;
			}

			wfProfileOut(__METHOD__ . '::checkForEmptyUserJS');
		}

		$assets = array();
		$assets['oasis_shared_js'] = $this->assetsManager->getURL( 'oasis_shared_js' );
		$assets['oasis_nojquery_shared_js'] = $this->assetsManager->getURL( 'oasis_nojquery_shared_js' );
		$assets['oasis_noads_extensions_js'] = $this->assetsManager->getURL( 'oasis_noads_extensions_js' );
		$assets['oasis_extensions_js']= $this->assetsManager->getURL( 'oasis_extensions_js' );
		$assets['oasis_user_anon'] = $this->assetsManager->getURL( ( $wgUser->isLoggedIn() ) ? 'oasis_user_js' : 'oasis_anon_js');

		if ( !empty( $wgSpeedBox ) && !empty( $wgDevelEnvironment ) ) {
			foreach ( $assets as $group => $urls ) {
				foreach ( $urls as $index => $u ) {
					$assets[$group][$index] = $this->rewriteJSlinks( $assets[$group][$index] );
				}
			}
		}

		$assets['references'] = $jsReferences;

		// generate code to load JS files
		$assets = json_encode($assets);
		$jsLoader = <<<EOT
<script type="text/javascript">
	var wsl_assets = {$assets};
EOT;
		if ($this->jsAtBottom) {
			$jsLoader .= <<<EOT
				if ( typeof window.EXP_AD_LOAD_TIMING != 'undefined' && (window.wgLoadAdDriverOnLiftiumInit || (window.getTreatmentGroup && (getTreatmentGroup(EXP_AD_LOAD_TIMING) == TG_AS_WRAPPERS_ARE_RENDERED)))) { 
					toload = wsl_assets.oasis_nojquery_shared_js.concat(wsl_assets.oasis_noads_extensions_js, wsl_assets.oasis_user_anon, wsl_assets.references); 
				} else { 
					toload = wsl_assets.oasis_shared_js.concat(wsl_assets.oasis_extensions_js, wsl_assets.oasis_user_anon, wsl_assets.references); 
				}
EOT;
		}
		else {
			$jsLoader .= <<<EOT
				var toload = wsl_assets.oasis_shared_js.concat(wsl_assets.oasis_extensions_js, wsl_assets.oasis_user_anon, wsl_assets.references);
EOT;
		}
		$jsLoader .= <<<EOT
			(function(){ wsl.loadScript(toload); })();
		</script>
EOT;

		$tpl = $this->app->getSkinTemplateObj();

		// $tpl->set( 'headscripts', $out->getHeadScripts() . $out->getHeadItems() );
		// FIXME: we need to remove head items - i.e. <meta> tags
		$headScripts = str_replace($this->wg->out->getHeadItems(), '', $tpl->data['headscripts']);
		// ...and top scripts too (BugId: 32747)
		$headScripts = str_replace($this->topScripts, '', $headScripts);

		$this->jsFiles = $headScripts . $jsLoader . $this->jsFiles;

		// experiment: squeeze calls to mw.loader.load() to make fewer HTTP requests
		if ($this->jsAtBottom) {
			$jsFiles = $this->jsFiles;
			$bottomScripts = $this->bottomscripts;
			$this->squeezeMediawikiLoad($jsFiles,$bottomScripts);
			$this->bottomscripts = $bottomScripts;
			$this->jsFiles = $jsFiles;
		}

		$this->adsABtesting = '';
		if ($this->jsAtBottom) {
			$jquery_ads = $this->assetsManager->getURL( 'oasis_jquery_ads_js' );
			if ( !empty( $wgSpeedBox ) && !empty( $wgDevelEnvironment ) ) {
				for( $j = 0; $j < count( $jquery_ads ); $j++ ) {
					$jquery_ads[$j] = $this->rewriteJSlinks( $jquery_ads[$j] );
				}
			}

			$jquery_ads = json_encode($jquery_ads);
			$this->adsABtesting = <<<EOT
				<script type="text/javascript">/*<![CDATA[*/ 
					(function(){ 
						if (typeof window.EXP_AD_LOAD_TIMING != 'undefined' && (window.wgLoadAdDriverOnLiftiumInit || window.getTreatmentGroup && (getTreatmentGroup(EXP_AD_LOAD_TIMING) == TG_AS_WRAPPERS_ARE_RENDERED))) { 
							wsl.loadScript({$jquery_ads}); 
						} 
					})(); 
				/*]]>*/</script>
EOT;
		}

		wfProfileOut(__METHOD__);
	}

	const MW_LOADER_LOAD_REGEX = "/if\\(window.mw\\){mw.loader.load\\((\\[[^]]+\\])([^)]*)?\\);\\}/";

	protected function getModuleListFromMediawikiLoad( $script ) {
		// remove start and end script tags
		$script = preg_replace("/^<script[^>]*>/","",$script);
		$script = preg_replace("/<\\/script[^>]*>\$/","",$script);
		// remove spaces - will be easier to preg_match
		$script = preg_replace("/\s+/","",$script);
		$matches = array();
//		var_dump($script);
		if (preg_match(self::MW_LOADER_LOAD_REGEX,$script,$matches)) {
//			var_dump($matches);
			$moduleNames = json_decode($matches[1]);
			return $moduleNames;
		}
		return false;
	}
	protected function squeezeMediawikiLoad( &$scripts, &$bottomScripts ) {
		// parse both script chunks
		$scriptMatches = array();
		if (preg_match_all(WikiaSkin::SCRIPT_REGEX,$scripts,$scriptMatches)) {
			$scriptMatches = reset($scriptMatches);
		}
		$bottomScriptMatches = array();
		if (preg_match_all(WikiaSkin::SCRIPT_REGEX,$bottomScripts,$bottomScriptMatches)) {
			$bottomScriptMatches = reset($bottomScriptMatches);
		}

		// find mw.loader.load()s
		$loadTags = array();
		$modules = array();
		foreach (array_merge($scriptMatches,$bottomScriptMatches) as $scriptTag) {
			$tagModules = $this->getModuleListFromMediawikiLoad($scriptTag);
			if ( $tagModules !== false ) {
				$loadTags[] = $scriptTag;
				$modules = array_merge( $modules, $tagModules );
			}
		}

		// we cannot optimize it
		if ( count($loadTags) <= 1 ) {
			return;
		}

		// build new modules list
		$modules = array_unique($modules);
//		sort($modules);

		// create conditional mw.loader.load() script
		$loadScript = Html::inlineScript(
			ResourceLoader::makeLoaderConditionalScript(
				Xml::encodeJsCall( 'mw.loader.load', array( $modules ) )
			)
		);

		// finally do the replacement
		$first = true;
		foreach ($loadTags as $loadTag) {
			$replacement = $first ? $loadScript : '';
			$scripts = str_replace($loadTag,$replacement,$scripts);
			$bottomScripts = str_replace($loadTag,$replacement,$bottomScripts);
			$first = false;
		}
	}

}
