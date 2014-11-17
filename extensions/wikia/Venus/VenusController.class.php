<?php

class VenusController extends WikiaController {
	private static $bodyParametersArray = [];
	private static $skinAssetGroups = [];

	/** @var AssetsManager $assetsManager */
	private $assetsManager;
	/** @var QuickTemplate $skinTemplateObj */
	private $skinTemplateObj;
	/** @var WikiaSkin $skin */
	private $skin;

	public function init() {
		$this->assetsManager = AssetsManager::getInstance();
		$this->skinTemplateObj = $this->app->getSkinTemplateObj();
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
		$this->skinNameClass = $skinVars['skinnameclass'];
		$this->pageCss = $this->getPageCss();


		// initialize variables
		$this->comScore = null;
		$this->quantServe = null;

		//TODO clean up wg variables inclusion in views (CON-1533)
		global $wgOut;
		$this->topScripts = $wgOut->topScripts;
	}

	public function index() {
		global $wgUser;

		$this->contents = $this->skinTemplateObj->data['bodytext'];

		$this->isUserLoggedIn = $wgUser->isLoggedIn();

		$this->setBodyModules();
		$this->setAds();

		$this->setBodyClasses();
		$this->setHeadItems();
		$this->setAssets();

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	private function setAds() {
		$this->adTopRightBoxad = $this->app->renderView('Ad', 'Index', ['slotName' => 'TOP_RIGHT_BOXAD']);
		$this->adTopLeaderboard = $this->app->renderView('Ad', 'Index', ['slotName' => 'TOP_LEADERBOARD']);
		$this->adInvisibleSkin = $this->app->renderView('Ad', 'Index', ['slotName' => 'INVISIBLE_SKIN']);
		$this->adsBottom = $this->app->renderView('Ad', 'Index', ['slotName' => 'GPT_FLUSH']);
		$this->adsBottom .= $this->app->renderView('Ad', 'Index', ['slotName' => 'SEVENONEMEDIA_FLUSH']);
	}

	private function setBodyModules() {
		$this->globalNavigation = $this->getGlobalNavigation();
		$this->localNavigation = $this->getLocalNavigation();
		$this->globalFooter = $this->getGlobalFooter();
		$this->corporateFooter = $this->getCorporateFooter();
		$this->launchRecommendationsModule();

		if ($this->isUserLoggedIn) {
			$this->recentWikiActivity = $this->getRecentWikiActivity();
		}

		if ( WikiaPageType::isArticlePage() ) {
			$this->leftArticleNav = $this->getLeftArticleNavigation();
			$this->setVal('header', $this->app->renderView('Venus', 'header'));
			Wikia::addAssetsToOutput( 'article_scss' );
		}
	}

	private function setBodyClasses() {
		// generate list of CSS classes for <body> tag
		$bodyClasses = [
			'mediawiki',
			$this->skinNameClass,
			$this->dir,
			$this->pageClass
		];

		// add skin theme name
		if(!empty($this->skin->themename)) {
			$bodyClasses[] = 'venus-' . $this->skin->themename;
		}

		// mark dark themes
		if (SassUtil::isThemeDark()) {
			$bodyClasses[] = 'venus-dark-theme';
		}

		$this->bodyClasses = implode(' ', array_merge($bodyClasses, self::getBackgroundClasses()));
	}

	private function setHeadItems() {
		global $wgOut;
		$this->headLinks = $wgOut->getHeadLinks();
		$this->headItems = $this->skin->getHeadItems();
	}

	private function getPageCss() {
		$skinVars = $this->skinTemplateObj->data;

		if ($pageCss = $skinVars['pagecss']) {
			return '<style type="text/css">' . $pageCss . '</style>';
		} else {
			return '';
		}
	}

	private function setAssets() {
		global $wgOut;

		$jsHeadGroups = ['venus_head_js'];
		$jsHeadFiles = '';
		$jsBodyGroups = ['venus_body_js'];
		$jsBodyFiles = '';
		$cssGroups = ['venus_css'];
		$cssLinks = '';

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

		// SASS files requested via VenusAssetsPackages hook
		$sassFiles = [];
		foreach ( $this->assetsManager->getURL( $cssGroups ) as $src ) {
			if ( $this->assetsManager->checkAssetUrlForSkin( $src, $this->skin ) ) {
				$sassFiles[] = $src;
			}
		}

		// try to fetch all SASS files using a single request (CON-1487)
		// "WikiaSkin::getStylesWithCombinedSASS: combined 9 SASS files"
		$cssLinks .= $this->skin->getStylesWithCombinedSASS($sassFiles);

		foreach ( $this->assetsManager->getURL( $jsHeadGroups ) as $src ) {
			if ( $this->assetsManager->checkAssetUrlForSkin( $src, $this->skin ) ) {
				$jsHeadFiles .= "<script src='{$src}'></script>";
			}
		}

		// try to fetch all AM groups in a single JS request (CON-1772)
		// "WikiaSkin::getScriptsWithCombinedGroups: combined 8 JS groups"
		$jsBodyFiles = $this->skin->getScriptsWithCombinedGroups($jsBodyGroups);

		//global variables from ResourceLoaderStartUpModule
		$res = new ResourceVariablesGetter();
		$vars = WikiaSkin::makeInlineVariablesScript($res->get()); // is it used anywhere?

		// set variables
		$this->cssLinks = $cssLinks;
		$this->jsBodyFiles =  $jsBodyFiles;
		$this->jsHeadScripts = $wgOut->getHeadScripts() . $jsHeadFiles;
	}

	public function getGlobalNavigation() {
		global $wgEnableGlobalNavExt;

		return !empty( $wgEnableGlobalNavExt ) ?
			$this->app->renderView('GlobalNavigation', 'index') :
			'';
	}

	private function getLocalNavigation() {
		global $wgEnableLocalNavExt;

		return !empty( $wgEnableLocalNavExt ) ?
			$this->app->renderView('LocalNavigation', 'Index') :
			'';
	}

	private function getGlobalFooter() {
		global $wgEnableGlobalFooterExt;

		return !empty( $wgEnableGlobalFooterExt ) ?
			$this->app->renderView('GlobalFooter', 'indexVenus') :
			'';
	}

	public function getCorporateFooter() {
		//return $this->app->renderView('CorporateFooter', 'Index');
		return '';
	}

	public function launchRecommendationsModule() {
		global $wgEnableRecommendationsExt, $wgOut;

		if ( !empty( $wgEnableRecommendationsExt ) ) {
			$wgOut->addModules( 'ext.wikia.venus.recommendations' );
		}
	}

	public function getRecentWikiActivity() {
		return $this->app->renderView('RecentWikiActivity', 'index');
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

	private static function getBackgroundClasses() {
		global $wgOasisThemeSettings;
		$themeSettings = $wgOasisThemeSettings; // OMG

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
		}

		return $bodyClasses;
	}

	private function getLeftArticleNavigation() {
		return $this->app->renderView('ArticleNavigation', 'index');
	}

	public function header() {
		global $wgOut, $wgArticle, $wgSupressPageTitle, $wgSupressPageSubtitle, $wgRequest;

		$title = $wgOut->getPageTitle();
		$redirect = null;

		$skin = RequestContext::getMain()->getSkin();

		// render subpage info like /ArticleOne/ArticleTwo
		$subtitle = $skin->subPageSubtitle();

		// render redirect info (redirected from)
		if ( !empty( $wgArticle->mRedirectedFrom ) ) {
			$redirect = trim( $wgOut->getSubtitle(), '()' );
		}

		if ( !empty( $wgSupressPageTitle ) ) {
			$title = null;
			$subtitle = null;
			$redirect = null;
		}

		if ( !empty(  $wgSupressPageSubtitle ) ) {
			$subtitle = null;
			$redirect = null;
		}

		//TODO should be removed when cover unit is going to be implemented
		$this->response->setVal('showCoverUnit', $wgRequest->getBool('coverunit', false));
		$this->response->setVal('title', $title);
		$this->response->setVal('subtitle', $subtitle);
		$this->response->setVal('redirect', $redirect);

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}
}
