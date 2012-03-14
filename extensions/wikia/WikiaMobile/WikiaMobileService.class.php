<?php
/**
 * WikiaMobile skin entry point
 *
 * @author Jakub Olek <jakubolek(at)wikia-inc.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileService extends WikiaService {
	const CACHE_MANIFEST_PATH = 'wikia.php?controller=WikiaMobileAppCacheController&method=serveManifest&format=html';
	const JS_PACKAGE_NAME_HEAD = 'wikiamobile_js_head';
	const JS_PACKAGE_NAME_BODY = 'wikiamobile_js_body';
	const SCSS_PACKAGE_NAME = 'extensions/wikia/WikiaMobile/css/WikiaMobile.scss';

	static private $initialized = false;

	private $templateObject;
	
	//TODO: remove whe multi-skin resource loading fixed
	private $scripts;
	private $styles;

	function init(){
		if ( !self::$initialized ) {
			F::setInstance( __CLASS__, $this );
			self::$initialized = true;
			$this->wf->LoadExtensionMessages( 'WikiaMobile' );
			F::build('JSMessages')->enqueuePackage('WkMbl', JSMessages::INLINE);

			//TODO: remove when multi-skin resource loading fixed
			$this->scripts = array();
			$this->styles = array();
		}
	}

	/**
	 * @brief Sets the template object for internal use
	 *
	 * @requestParam QuickTeamplate $templateObject
	 */
	public function setTemplateObject(){
		$this->templateObject = $this->getVal( 'templateObject') ;
	}

	//TODO: remove when multi-skin resource loading fixed
	public function addAsset(){
		$js = $this->request->getVal( 'js' );
		$css = $this->request->getVal( 'css' );
		$scss = $this->request->getVal( 'scss' );
		$pkg = $this->request->getVal( 'package' );

		if ( !empty( $pkg ) ) {
			$assetsManager = F::build( 'AssetsManager', array(), 'getInstance' );
			$type = $this->app->getAssetsConfig()->getGroupType( $pkg );
			$sources = array();

			switch ( $type ) {
				case AssetsManager::TYPE_JS:
					$this->scripts += $assetsManager->getGroupCommonURL( $pkg );
					break;

				case AssetsManager::TYPE_CSS:
					$this->styles += $assetsManager->getGroupCommonURL( $pkg );
					break;

				case AssetsManager::TYPE_SCSS:
					$this->styles += $assetsManager->getSassCommonURL( $pkg );
					break;
			}
		}

		if ( !empty( $js ) ) {
			$this->scripts[] = $assetsManager->getOneCommonURL( $js );
		}

		if ( !empty( $css ) ) {
			$this->styles[$assetsManager->getOneCommonURL( $css )] =  array();
		}

		if ( !empty( $scss ) ) {
			$this->styles[$assetsManager->getSassCommonURL( $scss )] = array();
		}
	}

	public function index() {
		$jsHeadPackageName = self::JS_PACKAGE_NAME_HEAD;
		$jsBodyPackageName = self::JS_PACKAGE_NAME_BODY;
		$scssPackageName = self::SCSS_PACKAGE_NAME;
		$bottomscripts = '';
		$jsBodyFiles = '';
		$jsHeadFiles = '';
		$cssFiles = '';
		$tmpOut = new OutputPage();

		$tmpOut->styles = array() + $this->wg->Out->styles;

		foreach( $tmpOut->styles as $style => $options ) {
			if ( isset( $options['media'] ) || strstr( $style, 'shared' ) || strstr( $style, 'index' ) ) {
				unset( $tmpOut->styles[$style] );
			}
		}

		//TODO: remove when multi-skin resource loading fixed
		$tmpOut->styles += $this->styles;

		//let extensions change the asset packages (e.g. ArticleComments,
		//this is done to cut down the number or requests
		//until AssetsManager won't support arbitrary file group requests)
		$this->app->runHook(
			'WikiaMobileAssetsPackages',
			array(
				&$jsHeadPackageName,
				&$jsBodyPackageName,
				&$scssPackageName
			)
		);

		//Bottom Scripts
		$this->wf->RunHooks( 'SkinAfterBottomScripts', array ( $this->wg->User->getSkin(), &$bottomscripts ) );

		//force skin main CSS file to be the first so it will be always overridden by other files
		$cssFiles .= "<link rel=\"stylesheet\" href=\"" . AssetsManager::getInstance()->getSassCommonURL( $scssPackageName ) . "\"/>";
		$cssFiles .= $tmpOut->buildCssLinks();

		//core JS in the head section
		$srcs = AssetsManager::getInstance()->getGroupCommonURL( $jsHeadPackageName );

		//TODO: add scripts from $wgOut as needed
		foreach ( $srcs as $src ) {
			$jsHeadFiles .= "<script type=\"{$this->wg->JsMimeType}\" src=\"$src\"></script>\n";
		}

		//additional JS at the bottom of the body section
		$srcs = array_merge( AssetsManager::getInstance()->getGroupCommonURL( $jsBodyPackageName ), $this->scripts );

		//TODO: add scripts from $wgOut as needed
		foreach ( $srcs as $src ) {
			$jsBodyFiles .= "<script type=\"{$this->wg->JsMimeType}\" src=\"$src\"></script>\n";
		}

		//AppCache will be disabled for the first several releases
		//$this->appCacheManifestPath = ( $this->wg->DevelEnvironment && !$this->wg->Request->getBool( 'appcache' ) ) ? null : self::CACHE_MANIFEST_PATH . "&{$this->wg->StyleVersion}";
		$this->mimeType = $this->templateObject->data['mimetype'];
		$this->charSet = $this->templateObject->data['charset'];
		$this->showAllowRobotsMetaTag = !$this->wg->DevelEnvironment;
		$this->globalVariablesScript = Skin::makeGlobalVariablesScript( $this->templateObject->data['skinname'] );
		$this->pageTitle = $this->wg->Out->getHTMLTitle();
		$this->cssLinks = $cssFiles;
		$this->headLinks = $this->wg->Out->getHeadLinks();
		$this->jsHeadFiles = $jsHeadFiles;
		$this->languageCode = $this->templateObject->data['lang'];
		$this->languageDirection = $this->templateObject->data['dir'];
		$this->wikiaNavigation = $this->sendRequest( 'WikiaMobileNavigationService', 'index' )->toString();
		$this->advert = $this->sendRequest( 'WikiaMobileAdService', 'index' )->toString();
		$this->pageContent = $this->sendRequest( 'WikiaMobileBodyService', 'index', array(
			'bodyText' => $this->templateObject->data['bodytext'],
			'categoryLinks' => $this->templateObject->data['catlinks']
		) )->toString();
		$this->wikiaFooter = $this->sendRequest( 'WikiaMobileFooterService', 'index', array(
			'copyrightLink' => $this->templateObject->data['copyright']
		))->toString();
		$this->jsBodyFiles = $jsBodyFiles;
		$this->bottomscripts = $bottomscripts;

		//tracking
		$this->quantcastTracking = AnalyticsEngine::track(
			'QuantServe',
			AnalyticsEngine::EVENT_PAGEVIEW,
			array(),
			array( 'extraLabels'=> array( 'mobilebrowser' ) )
		);
		$this->comscoreTracking = AnalyticsEngine::track('Comscore', AnalyticsEngine::EVENT_PAGEVIEW);
		$this->gaTracking = AnalyticsEngine::track( 'GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW );
		$this->gaOneWikiTracking = AnalyticsEngine::track( 'GA_Urchin', 'onewiki', array( $this->wg->CityId ) );
	}
}