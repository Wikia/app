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
		// initialize variables
		$this->comScore = null;
		$this->quantServe = null;
		$this->amazonMatch = null;
		$this->nielsen = null;
		$this->openXBidder = null;
		$this->prebid = null;
		$this->rubiconFastlane = null;
		$this->dynamicYield = null;
		$this->ivw2 = null;
		$this->ivw3 = null;
		$this->krux = null;

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
		$vars['wgOasisBreakpoints'] = BodyController::isOasisBreakpoints();
		$vars['verticalName'] = HubService::getCurrentWikiaVerticalName();
		return true;
	}

	public function executeIndex($params) {
		global $wgOut, $wgUser, $wgTitle, $wgRequest, $wgEnableAdminDashboardExt, $wgOasisThemeSettings,
		$wgWikiaMobileSmartBannerConfig;

		wfProfileIn(__METHOD__);

		//Add Smart banner for Wikia dedicated App
		//Or fallback to My Wikia App
		if (
			!empty( $wgWikiaMobileSmartBannerConfig ) &&
			is_array( $wgWikiaMobileSmartBannerConfig['meta'] ) &&
			!empty( $wgWikiaMobileSmartBannerConfig['meta']['apple-itunes-app'] )
		) {
			$appId= $wgWikiaMobileSmartBannerConfig['meta']['apple-itunes-app'];
			$wgOut->addHeadItem(
				'Wikia App Smart Banner',
				sprintf('<meta name="apple-itunes-app" content="%s, app-arguments=%s">', $appId, $wgRequest->getFullRequestURL())
			);
		} else {
			$wgOut->addHeadItem('My Wikia Smart Banner', '<meta name="apple-itunes-app" content="app-id=623705389">');
		}

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
			$bodyClasses[] = Sanitizer::escapeClass( "oasis-{$skin->themename}" );
		}

		// mark dark themes
		if (SassUtil::isThemeDark()) {
			$bodyClasses[] = 'oasis-dark-theme';
		}

		/**
		 * Login status based CSS class
		 */
		$bodyClasses[] = $skin->getUserLoginStatusClass();

		// sets background settings by adding classes to <body>
		$bodyClasses = array_merge($bodyClasses, $this->getOasisBackgroundClasses($wgOasisThemeSettings));

		// VOLDEV-168: Add a community-specific class to the body tag
		$bodyClasses[] = $skin->getBodyClassForCommunity();

		$this->bodyClasses = $bodyClasses;

		if (is_array($scssPackages)) {
			foreach ($scssPackages as $package) {
				$wgOut->addStyle($this->assetsManager->getSassCommonURL('extensions/'.$package));
			}
		}

    	// Reset (this ensures no duplication in CSS links)
		$sassFiles = ['skins/oasis/css/oasis.scss'];

		$this->cssLinks = $skin->getStylesWithCombinedSASS($sassFiles);

		// $sassFiles will be updated by getStylesWithCombinedSASS method will all extracted and concatenated SASS files
		$this->bottomScripts .= Html::inlineScript("var wgSassLoadedScss = ".json_encode($sassFiles).";");

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

		// macbre: RT #25697 - hide Comscore & QuantServe tags on edit pages
		if(!in_array($wgRequest->getVal('action'), array('edit', 'submit'))) {
			$this->comScore = AnalyticsEngine::track('Comscore', AnalyticsEngine::EVENT_PAGEVIEW);
			$this->quantServe = AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW);
			$this->amazonMatch = AnalyticsEngine::track('AmazonMatch', AnalyticsEngine::EVENT_PAGEVIEW);
			$this->nielsen = AnalyticsEngine::track('Nielsen', AnalyticsEngine::EVENT_PAGEVIEW);
			$this->openXBidder = AnalyticsEngine::track('OpenXBidder', AnalyticsEngine::EVENT_PAGEVIEW);
			$this->prebid = AnalyticsEngine::track('Prebid', AnalyticsEngine::EVENT_PAGEVIEW);
			$this->rubiconFastlane = AnalyticsEngine::track('RubiconFastlane', AnalyticsEngine::EVENT_PAGEVIEW);
			$this->dynamicYield = AnalyticsEngine::track('DynamicYield', AnalyticsEngine::EVENT_PAGEVIEW);
			$this->ivw2 = AnalyticsEngine::track('IVW2', AnalyticsEngine::EVENT_PAGEVIEW);
			$this->ivw3 = AnalyticsEngine::track('IVW3', AnalyticsEngine::EVENT_PAGEVIEW);
			$this->krux = AnalyticsEngine::track('Krux', AnalyticsEngine::EVENT_PAGEVIEW);
		}

		wfProfileOut(__METHOD__);
	}

	// TODO: implement as a separate module?
	private function loadJs() {
		wfProfileIn(__METHOD__);

		// load AbTesting files, anything that's so mandatory that we're willing to make a blocking request to load it.
		$this->globalBlockingScripts = '';
		$jsReferences = array();

		$jsAssetGroups = array( 'oasis_blocking' );
		wfRunHooks('OasisSkinAssetGroupsBlocking', array(&$jsAssetGroups));
		$blockingScripts = $this->assetsManager->getURL($jsAssetGroups);

		foreach($blockingScripts as $blockingFile) {
			$this->globalBlockingScripts .= "<script src=\"$blockingFile\"></script>";
		}

		$assetGroups = ['oasis_shared_core_js', 'oasis_shared_js'];

		if ( $this->wg->User->isLoggedIn() ) {
			$assetGroups[] = 'oasis_user_js';
		} else {
			$assetGroups[] = 'oasis_anon_js';
		}

		wfRunHooks('OasisSkinAssetGroups', array(&$assetGroups));

		// add groups queued via OasisController::addSkinAssetGroup
		$assetGroups = array_merge($assetGroups, self::$skinAssetGroups);

		// SUS-WTF: Load all AM JS groups in a single HTTP request
		/** @var SkinOasis $skin */
		$skin = $this->getContext()->getSkin();
		$jsLoader = $skin->getScriptsWithCombinedGroups( $assetGroups );

		$tpl = $this->app->getSkinTemplateObj();

		// $tpl->set( 'headscripts', $out->getHeadScripts() . $out->getHeadItems() );
		// FIXME: we need to remove head items - i.e. <meta> tags
		$remove = $this->wg->out->getHeadItemsArray();
		$remove[ ] = $this->topScripts;
		array_walk( $remove, 'trim' );
		$headScripts = str_replace( $remove, '', $tpl->data[ 'headscripts' ] );

		$this->jsFiles = $headScripts . $jsLoader . $this->jsFiles;

		// experiment: squeeze calls to mw.loader.load() to make fewer HTTP requests
		$jsFiles = $this->jsFiles;
		$bottomScripts = $this->bottomScripts;
		$this->squeezeMediawikiLoad( $jsFiles, $bottomScripts );
		$this->bottomScripts = $bottomScripts;
		$this->jsFiles = $jsFiles;

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
