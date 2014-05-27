<?php

class OasisController extends WikiaController {

	private static $extraBodyClasses = [];
	private static $bodyParametersArray = [];
	private static $skinAssetGroups = [];

	/* @var AssetsManager */
	private $assetsManager;

	/**
	 * Add extra CSS classes to <body> tag
	 * @author: Inez Korczyński
	 */
	public static function addBodyClass($className) {

		if(!in_array($className,self::$extraBodyClasses)) {
			self::$extraBodyClasses[] = $className;
			return true;
		}
		return false;
	}

	public function init() {
		wfProfileIn(__METHOD__);
		$skinVars = $this->app->getSkinTemplateObj()->data;

		$this->assetsManager = AssetsManager::getInstance();
		$this->pageTitle = $skinVars['pagetitle'];
		$this->displayTitle = $skinVars['displaytitle'];
		$this->mimeType = $skinVars['mimetype'];
		$this->charset = $skinVars['charset'];
		$this->dir = $skinVars['dir'];
		$this->lang = $skinVars['lang'];
		$this->pageClass = $skinVars['pageclass'];
		$this->pageCss = $skinVars['pagecss'];
		$this->skinNameClass = $skinVars['skinnameclass'];
		$this->bottomScripts = $skinVars['bottomscripts'];
		// initialize variables
		$this->comScore = null;
		$this->quantServe = null;
		$this->amazonDirectTargetedBuy = null;
		$this->dynamicYield = null;
		$this->ivw2 = null;

		wfProfileOut(__METHOD__);
	}

	/**
	 * Add global JS variables
	 *
	 * @param array $vars global variables list
	 * @return boolean return true
	 */
	public static function onMakeGlobalVariablesScript(Array &$vars) {
		$vars['wgOasisResponsive'] = BodyController::isResponsiveLayoutEnabled();
		$vars['verticalName'] = HubService::getCurrentWikiaVerticalName();
		return true;
	}

	/*
	 * TODO remove after Global Header ABtesting
	 */
	public static function onWikiaSkinTopScripts( &$vars, &$scripts, $skin ) {
		$app = F::app();
		if ( $app->checkSkin( ['oasis'], $skin ) ) {
			$globalSearch = GlobalTitle::newFromText(
				'Search',
				NS_SPECIAL,
				WikiService::WIKIAGLOBAL_CITY_ID
			)->getFullURL();

			$vars['wgGlobalSearchUrl'] = $globalSearch;
		}

		return true;
	}
	/*
	 *  END TODO
	 */

	/**
	 * Business-logic for determining if the javascript should be at the bottom of the page (it usually should be
	 * at the bottom for performance reasons, but there are some exceptions for engineering reasons).
	 *
	 * TODO: make sure JavaScripts can be always loaded on bottom
	 *
	 * Note: NS_FILE pages need JS at top because AnyClips relies on jQuery.
	 */
	public static function JsAtBottom(){
		global $wgTitle;

		// decide where JS should be placed (only add JS at the top for non-search Special and edit pages)
		if (WikiaPageType::isSearch() || WikiaPageType::isForum()) {
			// Remove this whole condition when AdDriver2.js is fully implemented and deployed

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
		global $wgOut, $wgUser, $wgTitle, $wgRequest, $wgCityId, $wgEnableAdminDashboardExt, $wgAllInOne, $wgOasisThemeSettings;

		wfProfileIn(__METHOD__);

		//Add Smart banner for My Wikia App
		//See: https://wikia-inc.atlassian.net/browse/MOB-167
		$wgOut->addHeadItem('My Wikia Smart Banner', '<meta name="apple-itunes-app" content="app-id=623705389">');

		/* set the grid if passed in, otherwise, respect the default */
		$grid = $wgRequest->getVal('wikiagrid', '');

		if ( '1' === $grid ) {
			$this->wg->OasisGrid = true;
		} else if ( '0' === $grid ) {
			$this->wg->OasisGrid = false;
		}
		/* end grid or full width */

		$jsPackages = array();
		$scssPackages = array();
		$this->app->runHook(
			'WikiaAssetsPackages',
			array(
				&$wgOut,
				&$jsPackages,
				&$scssPackages
			)
		);

		$this->isUserLoggedIn = $wgUser->isLoggedIn();

		// TODO: move to CreateNewWiki extension - this code should use a hook
		$wikiWelcome = $wgRequest->getVal('wiki-welcome');

		if(!empty($wikiWelcome)) {
			$wgOut->addStyle( $this->assetsManager->getSassCommonURL( 'extensions/wikia/CreateNewWiki/css/WikiWelcome.scss' ) );
			$wgOut->addScript( '<script src="' . $this->wg->ExtensionsPath . '/wikia/CreateNewWiki/js/WikiWelcome.js"></script>' );
		}

		if( RenderContentOnlyHelper::isRenderContentOnlyEnabled() ) {
			$this->body = F::app()->renderView('BodyContentOnly', 'Index');
		} else {
			// macbre: let extensions modify content of the page (e.g. EditPageLayout)
			wfProfileIn(__METHOD__ . ' - renderBody');
			$this->body = !empty($params['body']) ? $params['body'] : F::app()->renderView('Body', 'Index');
			wfProfileOut(__METHOD__ . ' - renderBody');
		}

		// get microdata for body tag
		$this->itemType = self::getItemType();

		$skin = RequestContext::getMain()->getSkin(); /* @var $skin WikiaSkin */
		// this is bad but some extensions could have added some scripts to bottom queue
		// todo: make it not run twice during each request
		$this->bottomScripts = $skin->bottomScripts();

		// generate list of CSS classes for <body> tag
		$bodyClasses = array('mediawiki', $this->dir, $this->pageClass);
		$bodyClasses = array_merge($bodyClasses, self::$extraBodyClasses);
		$bodyClasses[] = $this->skinNameClass;

		if(Wikia::isMainPage()) {
			$bodyClasses[] = 'mainpage';
		}

		wfProfileIn(__METHOD__ . ' - skin Operations');
		// add skin theme name
		if(!empty($skin->themename)) {
			$bodyClasses[] = "oasis-{$skin->themename}";
		}

		// mark dark themes
		if (SassUtil::isThemeDark()) {
			$bodyClasses[] = 'oasis-dark-theme';
		}

		// sets background settings by adding classes to <body>
		$bodyClasses = array_merge($bodyClasses, $this->getOasisBackgroundClasses($wgOasisThemeSettings));

		$this->bodyClasses = $bodyClasses;

		if (is_array($scssPackages)) {
			foreach ($scssPackages as $package) {
				$wgOut->addStyle($this->assetsManager->getSassCommonURL('extensions/'.$package));
			}
		}

    	// Reset (this ensures no duplication in CSS links)
		$this->cssLinks = '';
		$this->cssPrintLinks = '';

		$sassFiles = [];
		foreach ( $skin->getStyles() as $s ) {
			if ( !empty($s['url']) ) {
				$tag = $s['tag'];
				if ( !empty( $wgAllInOne ) ) {
					$url = $this->minifySingleAsset($s['url']);
					if ($url !== $s['url']) {
						$tag = str_replace($s['url'],$url,$tag);
					}
				}

				// Print styles will be loaded separately at the bottom of the page
				if ( stripos($tag, 'media="print"') !== false ) {
					$this->cssPrintLinks .= $tag;
				} elseif ($wgAllInOne && $this->assetsManager->isSassUrl($s['url'])) {
					$sassFiles[] = $s['url'];
				} else {
					$this->cssLinks .= $tag;
				}
			} else {
				$this->cssLinks .= $s['tag'];
			}
		}

		$mainSassFile = 'skins/oasis/css/oasis.scss';
		if (!empty($sassFiles)) {
			array_unshift($sassFiles, $mainSassFile);
			$sassFiles = $this->assetsManager->getSassFilePath($sassFiles);
			$sassFilesUrl = $this->assetsManager->getSassesUrl($sassFiles);

			$this->cssLinks = Html::linkedStyle($sassFilesUrl) . $this->cssLinks;
			$this->bottomScripts .= Html::inlineScript("var wgSassLoadedScss = ".json_encode($sassFiles).";");
		} else {
			$this->cssLinks = Html::linkedStyle($this->assetsManager->getSassCommonURL($mainSassFile)) . $this->cssLinks;
		}

		$this->headLinks = $wgOut->getHeadLinks();
		$this->headItems = $skin->getHeadItems();

		$this->pageTitle = htmlspecialchars( $this->pageTitle );
		$this->displayTitle = htmlspecialchars( $this->displayTitle );
		$this->mimeType = htmlspecialchars( $this->mimeType );
		$this->charset = htmlspecialchars( $this->charset );

		wfProfileOut(__METHOD__ . ' - skin Operations');

		$this->topScripts = $wgOut->topScripts;

		if (is_array($jsPackages)) {
			foreach ($jsPackages as $package) {
				$wgOut->addScriptFile($this->wg->ExtensionsPath . '/' . $package);
			}
		}

		// setup loading of JS/CSS
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
			$this->amazonDirectTargetedBuy = AnalyticsEngine::track('AmazonDirectTargetedBuy', AnalyticsEngine::EVENT_PAGEVIEW);
			$this->dynamicYield = AnalyticsEngine::track('DynamicYield', AnalyticsEngine::EVENT_PAGEVIEW);
			$this->ivw2 = AnalyticsEngine::track('IVW2', AnalyticsEngine::EVENT_PAGEVIEW);
		}

		if (!empty($wgEnableAdminDashboardExt) && AdminDashboardLogic::displayAdminDashboard($this->app, $wgTitle)) {
			$this->displayAdminDashboard = true;
		} else {
			$this->displayAdminDashboard = false;
		}

		wfProfileOut(__METHOD__);
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

	/**
	 * Gets the URL and converts it to minified one if it points to single static file (JS or CSS)
	 * If it's not recognized as static asset the original URL is returned
	 *
	 * @param $url string URL to be inspected
	 * @return string
	 */
	private function minifySingleAsset( $url ) {
		global $wgAllInOne;
		if ( !empty( $wgAllInOne ) ) {
			static $map;
			if (empty($map)) {
				$map = array(
					array( $this->app->wg->ExtensionsPath, 'extensions/' ),
					array( $this->app->wg->StylePath, 'skins/' ),
					// $wgResourceBasePath = $wgCdnStylePath (there's no /resources in it)
					array( $this->app->wg->ResourceBasePath . '/resources', 'resources/' ),
				);
			}

			// BugId:38195 - don't minify already minified assets
			if (strpos($url, '/__am/') !== false) {
				return $url;
			}

			// don't minify already minified JS files
			if (strpos($url, '.min.js') !== false) {
				return $url;
			}

			foreach ($map as $item) {
				list( $prefix, $replacement ) = $item;

				// BugId: 38195 - wgExtensionPath / stylePath / ResourceBasePath do not end with a slash
				// add one to remove double slashes in resulting URL
				$prefix .= '/';

				if (startsWith($url, $prefix)) {
					$nurl = substr($url,strlen($prefix));
					$matches = array();
					if (preg_match("/^([^?]+)/",$nurl,$matches)) {
						if (preg_match("/\\.(css|js)\$/i",$matches[1])) {
							return $this->assetsManager->getOneCommonURL($replacement . $matches[1],true);
						}
					}
				}
			}
		}
		return $url;
	}

	// TODO: implement as a separate module?
	private function loadJs() {
		global $wgJsMimeType, $wgUser, $wgSpeedBox, $wgDevelEnvironment, $wgEnableAdEngineExt, $wgEnableAbTesting, $wgAllInOne, $wgEnableRHonDesktop;
		wfProfileIn(__METHOD__);

		$this->jsAtBottom = self::JsAtBottom();

		// load AbTesting files, anything that's so mandatory that we're willing to make a blocking request to load it.
		$this->globalBlockingScripts = '';
		$jsReferences = array();

		$jsAssetGroups = array( 'oasis_blocking' );
		wfRunHooks('OasisSkinAssetGroupsBlocking', array(&$jsAssetGroups));
		$blockingScripts = $this->assetsManager->getURL($jsAssetGroups);

		foreach($blockingScripts as $blockingFile) {
			if( $wgSpeedBox && $wgDevelEnvironment ) {
				$blockingFile = $this->rewriteJSlinks( $blockingFile );
			}

			$this->globalBlockingScripts .= "<script type=\"$wgJsMimeType\" src=\"$blockingFile\"></script>";
		}

		// move JS files added to OutputPage to list of files to be loaded
		$scripts = RequestContext::getMain()->getSkin()->getScripts();

		foreach ( $scripts as $s ) {
			//add inline scripts to jsFiles and move non-inline to the queue
			if ( !empty( $s['url'] ) ) {
				// FIXME: quick hack to load MW core JavaScript at the top of the page - really, please fix me!
				// @author macbre
				if (strpos($s['url'], 'load.php') !== false) {
					$this->globalVariablesScript = $s['tag'] . $this->globalVariablesScript;
				}
				else {
					$url = $s['url'];
					if ( $wgAllInOne ) {
						$url = $this->minifySingleAsset( $url );
					}
					if ( !empty( $wgSpeedBox ) && !empty( $wgDevelEnvironment ) ) {
						$url = $this->rewriteJSlinks( $url );
					}
					$jsReferences[] = $url;
				}
			} else {
				$this->jsFiles .= $s['tag'];
			}
		}
		$isLoggedIn = $wgUser->isLoggedIn();

		$assetGroups = ['oasis_shared_core_js', 'oasis_shared_js'];
		$assetGroups[] = $isLoggedIn ? 'oasis_user_js' : 'oasis_anon_js';

		$jsLoader = '';

		wfRunHooks('OasisSkinAssetGroups', array(&$assetGroups));

		// add groups queued via OasisController::addSkinAssetGroup
		$assetGroups = array_merge($assetGroups, self::$skinAssetGroups);

		$assets = $this->assetsManager->getURL( $assetGroups ) ;

		// jQueryless version - appears only to be used by the ad-experiment at the moment.
		// disabled - not needed atm (and skipped in wsl-version anyway)
		// $assets[] = $this->assetsManager->getURL( $isLoggedIn ? 'oasis_nojquery_shared_js_user' : 'oasis_nojquery_shared_js_anon' );

		// get urls
		if (!empty($wgSpeedBox) && !empty($wgDevelEnvironment)) {
			foreach ($assets as $index => $url) {
				$assets[$index] = $this->rewriteJSlinks( $url );
			}
		}

		// as $jsReferences
		$assets = array_merge($assets, $jsReferences);

		// generate direct script tags
		foreach ($assets as $url) {
			$url = htmlspecialchars( $url );
			$jsLoader .= "<script src=\"{$url}\"></script>\n";
		}

		$tpl = $this->app->getSkinTemplateObj();

		// $tpl->set( 'headscripts', $out->getHeadScripts() . $out->getHeadItems() );
		// FIXME: we need to remove head items - i.e. <meta> tags
		$remove = $this->wg->out->getHeadItemsArray();
		$remove[ ] = $this->topScripts;
		array_walk( $remove, 'trim' );
		$headScripts = str_replace( $remove, '', $tpl->data[ 'headscripts' ] );

		$this->jsFiles = $headScripts . $jsLoader . $this->jsFiles;

		// experiment: squeeze calls to mw.loader.load() to make fewer HTTP requests
		if ($this->jsAtBottom) {
			$jsFiles = $this->jsFiles;
			$bottomScripts = $this->bottomScripts;
			$this->squeezeMediawikiLoad($jsFiles,$bottomScripts);
			$this->bottomScripts = $bottomScripts;
			$this->jsFiles = $jsFiles;
		}

		if ($wgEnableAdEngineExt &&  !$wgEnableRHonDesktop) {
			$this->jsFiles = AdEngine2Controller::getLiftiumOptionsScript() . $this->jsFiles;
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

	/**
	 *	Logic for microdata to be added to body tag.
	 */
	protected function getItemType() {
		$type = '';
		if($this->wg->Title->isSpecial('Videos')) {
			$type = "VideoGallery";
		}
		// TODO: Add ImageGallery for photos page
		if(!empty($type)) {
			return ' itemscope itemtype="http://schema.org/'.$type.'"';

		}

		if (isset(static::$bodyParametersArray) && count(static::$bodyParametersArray) > 0 ) {
			return implode(" ", static::$bodyParametersArray);
		}

		return '';
	}

	/**
	 * Takes $themeSettings ( in $wgOasisThemeSettings format )
	 * and produces array of strings representing classes
	 * that should be applied to body element
	 *
	 * @param $themeSettings array
	 * @return array
	 */
	protected function getOasisBackgroundClasses($themeSettings) {
		$bodyClasses = [];

		if ( isset($themeSettings['background-fixed'])
			&& filter_var($themeSettings['background-fixed'], FILTER_VALIDATE_BOOLEAN) )
		{
			$bodyClasses[] = 'background-fixed';
		}

		if ( isset($themeSettings['background-tiled'])
			&& !filter_var($themeSettings['background-tiled'], FILTER_VALIDATE_BOOLEAN) )
		{
			$bodyClasses[] = 'background-not-tiled';

			if ( (isset($themeSettings['background-dynamic'])
					&& filter_var($themeSettings['background-dynamic'], FILTER_VALIDATE_BOOLEAN))
				// old wikis may not have 'background-dynamic' set
				|| (!isset($themeSettings['background-dynamic'])
					&& isset($themeSettings['background-image-width'])
					&& (int)$themeSettings['background-image-width'] >= ThemeSettings::MIN_WIDTH_FOR_SPLIT))
			{

				$bodyClasses[] = 'background-dynamic';
			}
		}

		return $bodyClasses;
	}

	public static function addBodyParameter($parameter) {
		static::$bodyParametersArray[] = $parameter;
	}

	/**
	 * Adds given AssetsManager group to Oasis main non-blocking JS request
	 *
	 * @param string $group group name
	 */
	public static function addSkinAssetGroup($group) {
		self::$skinAssetGroups[] = $group;
	}
}
