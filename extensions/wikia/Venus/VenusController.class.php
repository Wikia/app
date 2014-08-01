<?php

class VenusController extends WikiaController {
	private static $bodyParametersArray = [];
	private static $skinAssetGroups = [];

	private $assetsManager;
	private $skinTemplateObj;
	private $service;
	private $skin;

	public function init() {
		$this->assetsManager = AssetsManager::getInstance();
		$this->skinTemplateObj = $this->app->getSkinTemplateObj();
		$this->service = new VenusService( $this->skinTemplateObj );
		$this->skin = RequestContext::getMain()->getSkin();

		$skinVars = $this->skinTemplateObj->data;

		// this should be re-viewed and removed if not nessesary
		$this->pageTitle = $skinVars['pagetitle'];
		$this->displayTitle = $skinVars['displaytitle'];
		$this->mimeType = $skinVars['mimetype'];
		$this->charset = $skinVars['charset'];
		$this->dir = $skinVars['dir'];
		$this->lang = $skinVars['lang'];
		$this->pageClass = $skinVars['pageclass'];
		$this->pageCss = $skinVars['pagecss'];
		$this->skinNameClass = $skinVars['skinnameclass'];
		$this->bottomScriptLinks = $skinVars['bottomscripts'];

		// initialize variables
		$this->comScore = null;
		$this->quantServe = null;

		//TODO clean up wg variables inclusion in views
		global $wgOut;
		$this->topScripts = $wgOut->topScripts;
	}

	public function executeIndex() {
		global $wgUser, $wgTitle;

		$this->title = $wgTitle->getText();
		$this->contents = $this->skinTemplateObj->data['bodytext'];

		$this->isUserLoggedIn = $wgUser->isLoggedIn();

		$this->setBodyModules();

		$this->setBodyClasses();
		$this->setHeadItems();
		$this->setAssets();
	}

	public function setBodyModules() {
		$this->globalHeader = $this->getGlobalHeader();
		$this->notifications = $this->getNotifications();
		$this->topAds = $this->getTopAds();
		$this->wikiHeader = $this->getWikiHeader();
		$this->globalFooter = $this->getGlobalFooter();
		$this->corporateFooter = $this->getCorporateFootet();
	}


	public function setBodyClasses() {
		// generate list of CSS classes for <body> tag
		$bodyClasses = [$this->skinNameClass, $this->dir, $this->pageClass];

		// add skin theme name
		if(!empty($this->skin->themename)) {
			$bodyClasses[] = 'venus-' . $this->skin->themename;
		}

		// mark dark themes
		if (SassUtil::isThemeDark()) {
			$bodyClasses[] = 'venus-dark-theme';
		}

		$this->bodyClasses = implode(' ', $bodyClasses);
	}

	public function setHeadItems() {
		global $wgOut;
		$this->headLinks = $wgOut->getHeadLinks();
		$this->headItems = $this->skin->getHeadItems();

		$this->pageTitle = htmlspecialchars( $this->pageTitle );
		$this->displayTitle = htmlspecialchars( $this->displayTitle );
		$this->mimeType = htmlspecialchars( $this->mimeType );
		$this->charset = htmlspecialchars( $this->charset );
	}

	private function setAssets() {
		$jsHeadGroups = ['venus_head_js'];
		$jsHeadFiles = '';
		$jsBodyGroups = ['venus_body_js'];
		$jsBodyFiles = '';
		$cssGroups = ['venus_css'];
		$cssLinks = '';

		$styles = $this->skin->getStyles();
		$scripts = $this->skin->getScripts();

		//let extensions manipulate the asset packages (e.g. ArticleComments,
		//this is done to cut down the number or requests)
		$this->app->runHook(
			'VenusAssetsPackages',
			[
				&$jsHeadGroups,
				&$jsBodyGroups,
				&$cssGroups
			]
		);

		//
		foreach ( $this->assetsManager->getURL( $cssGroups ) as $s ) {
			if ( $this->assetsManager->checkAssetUrlForSkin( $s, $this->skin ) ) {
				$cssLinks .= "<link rel=stylesheet href='{$s}'/>";
			}
		}

		if ( is_array( $styles ) ) {
			foreach ( $styles as $s ) {
				$cssLinks .= "<link rel=stylesheet href='{$s['url']}'/>";
			}
		}

		foreach ( $this->assetsManager->getURL( $jsHeadGroups ) as $src ) {
			if ( $this->assetsManager->checkAssetUrlForSkin( $s, $this->skin ) ) {
				$jsHeadFiles .= "<script src='{$src}'></script>";
			}
		}

		foreach ( $this->assetsManager->getURL( $jsBodyGroups ) as $src ) {
			if ( $this->assetsManager->checkAssetUrlForSkin( $s, $this->skin ) ) {
				$jsBodyFiles .= "<script src='{$src}'></script>";
			}
		}

		if ( is_array( $scripts ) ) {
			foreach ( $scripts as $s ) {
				$jsBodyFiles .= "<script src='{$s['url']}'></script>";
			}
		}

		// set variables
		$this->cssLinks = $cssLinks;
		$this->jsHeadFiles = $jsHeadFiles;
		$this->jsBodyFiles = $jsBodyFiles;
	}
	/*

	private function setStyles() {
		global $wgAllInOne;

		$this->cssPrintLinks = '';

		foreach ( $this->getSkin()->getStyles() as $s ) {
			if ( !empty($s['url']) ) {
				$tag = $s['tag'];
				if ( !empty( $wgAllInOne ) ) {
					$url = $this->assetsManager->minifySingleAsset($s['url']);
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

		if (!empty($sassFiles)) {
			array_unshift($sassFiles, self::MAIN_SASS_FILE);
			$sassFiles = $this->assetsManager->getSassFilePath($sassFiles);
			$sassFilesUrl = $this->assetsManager->getSassesUrl($sassFiles);

			$this->cssLinks = Html::linkedStyle($sassFilesUrl) . $this->cssLinks;
			$this->bottomScripts .= Html::inlineScript("var wgSassLoadedScss = ".json_encode($sassFiles).";");
		} else {
			$this->cssLinks = Html::linkedStyle($this->assetsManager->getSassCommonURL(self::MAIN_SASS_FILE)) . $this->cssLinks;
		}
	}

	private function setScripts() {
		global $wgOut;

		$this->topScripts = $wgOut->topScripts;
		// this is bad but some extensions could have added some scripts to bottom queue
		// todo: make it not run twice during each request
		$this->bottomScripts = $this->getSkin()->bottomScripts();

		// setup loading of JS/CSS
		$this->loadJs();
	}

	// TODO: implement as a separate module?
	private function loadJs() {
		global $wgJsMimeType, $wgUser, $wgSpeedBox, $wgDevelEnvironment, $wgEnableAbTesting, $wgAllInOne, $wgEnableRHonDesktop;
		wfProfileIn(__METHOD__);

		$this->jsAtBottom = true;

		// load AbTesting files, anything that's so mandatory that we're willing to make a blocking request to load it.
		$this->globalBlockingScripts = '';
		$jsReferences = array();

		$jsAssetGroups = array( 'oasis_blocking', 'venus_head_js' );

		wfRunHooks('OasisSkinAssetGroupsBlocking', array(&$jsAssetGroups));
		$blockingScripts = $this->assetsManager->getURL($jsAssetGroups);

		foreach($blockingScripts as $blockingFile) {
			if( $wgSpeedBox && $wgDevelEnvironment ) {
				$blockingFile = $this->assetsManager->rewriteJSlinks( $blockingFile );
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
						$url = $this->assetsManager->minifySingleAsset( $url );
					}
					if ( !empty( $wgSpeedBox ) && !empty( $wgDevelEnvironment ) ) {
						$url = $this->assetsManager->rewriteJSlinks( $url );
					}
					$jsReferences[] = $url;
				}
			} else {
				$this->jsFiles .= $s['tag'];
			}
		}

		$isLoggedIn = $wgUser->isLoggedIn();

		$assetGroups = ['oasis_shared_core_js', 'oasis_shared_js', 'venus_body_js'];
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
				$assets[$index] = $this->assetsManager->rewriteJSlinks( $url );
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

		if (!$wgEnableRHonDesktop) {
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
		if (preg_match(self::MW_LOADER_LOAD_REGEX,$script,$matches)) {
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
	*/

	public function getGlobalHeader() {
		//return $this->app->renderView('GlobalNavigation', 'Index');
	}

	public function getNotifications() {
		//return $this->app->renderView('Notifications', 'Confirmation');
	}

	public function getWikiHeader() {
		//return $this->app->renderView( 'LocalHeader', 'Index' );
	}

	public function getTopAds() {
		return $this->app->renderView('Ad', 'Top');
	}

	public function getGlobalFooter() {
		//return $this->app->renderView('Footer', 'Index');
	}

	public function getCorporateFootet() {
		//return $this->app->renderView('CorporateFooter', 'Index');
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
