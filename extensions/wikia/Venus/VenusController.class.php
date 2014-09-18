<?php

class VenusController extends WikiaController {
	private static $bodyParametersArray = [];
	private static $skinAssetGroups = [];

	private $assetsManager;
	private $skinTemplateObj;
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
		$this->bottomScriptLinks = $skinVars['bottomscripts'];
		$this->pageCss = $this->getPageCss();


		// initialize variables
		$this->comScore = null;
		$this->quantServe = null;

		//TODO clean up wg variables inclusion in views (CON-1533)
		global $wgOut;
		$this->topScripts = $wgOut->topScripts;
	}

	public function index() {
		global $wgUser, $wgTitle;

		$this->title = $wgTitle->getText();
		$this->contents = $this->skinTemplateObj->data['bodytext'];

		$this->isUserLoggedIn = $wgUser->isLoggedIn();

		$this->setBodyModules();

		$this->setBodyClasses();
		$this->setHeadItems();
		$this->setAssets();

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	private function setBodyModules() {
		$this->globalNavigation = $this->getGlobalNavigation();
		$this->notifications = $this->getNotifications();
		$this->topAds = $this->getTopAds();
		$this->localNavigation = $this->getLocalNavigation();
		$this->globalFooter = $this->getGlobalFooter();
		$this->corporateFooter = $this->getCorporateFootet();
	}


	private function setBodyClasses() {
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

		foreach ( $this->assetsManager->getURL( $cssGroups ) as $s ) {
			if ( $this->assetsManager->checkAssetUrlForSkin( $s, $this->skin ) ) {
				$cssLinks .= "<link rel=stylesheet href='{$s}'/>";
			}
		}

		if ( is_array( $styles ) ) {
			foreach ( $styles as $s ) {
				$cssLinks .= $s['tag'];
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

		//global variables from ResourceLoaderStartUpModule
		$res = new ResourceVariablesGetter();
		$vars = WikiaSkin::makeInlineVariablesScript($res->get());

		// set variables
		$this->cssLinks = $cssLinks;
		$this->jsBodyFiles =  $jsBodyFiles;
		$this->jsHeadScripts = $this->skinTemplateObj->data['headscripts'] . $jsHeadFiles;
	}

	public function getGlobalNavigation() {
		return $this->app->renderView('GlobalNavigation', 'index');
	}

	private function getNotifications() {
		//return $this->app->renderView('Notifications', 'Confirmation');
	}

	private function getLocalNavigation() {
		return $this->app->renderView( 'LocalNavigation', 'Index' );
	}

	private function getTopAds() {
		//return $this->app->renderView('Ad', 'Top');
	}

	private function getGlobalFooter() {
		return $this->app->renderView('GlobalFooter', 'index');
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
}
