<?php
/**
 * WikiaMobile skin entry point
 *
 * @author Jakub Olek <jakubolek(at)wikia-inc.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileService extends WikiaService {
	//AppCache will be disabled for the first several releases
	//const CACHE_MANIFEST_PATH = 'wikia.php?controller=WikiaMobileAppCacheController&method=serveManifest&format=html';
	const LYRICSWIKI_ID = 43339;

	static protected $initialized = false;

	//holds an instance to WikiaMobileTemplate
	protected $templateObject;

	function __construct(){
		if ( !self::$initialized ) {
			//singleton
			F::setInstance( __CLASS__, $this );
			self::$initialized = true;
		}
	}

	function init(){
		$this->wf->LoadExtensionMessages( 'WikiaMobile' );
		F::build('JSMessages')->enqueuePackage('WkMbl', JSMessages::INLINE);
	}

	/**
	 * @brief Sets the template object (WikiaMobileTemplate)
	 *
	 * @requestParam WikiaQuickTemplate $templateObject
	 */
	public function setTemplateObject( WikiaMobileTemplate $template ){
		$this->templateObject = $template;
	}

	/**
	 * @brief Gets the template object (WikiaMobileTemplate)
	 *
	 * @return WikiaQuickTeamplate the Template instance
	 */
	public function getTemplateObject(){
		return $this->templateObject;
	}

	public function index() {
		$skin = $this->wg->user->getSkin();
		$jsBodyPackages = array( 'wikiamobile_js_body' );
		$scssPackages = array( 'wikiamobile_scss' );
		$bottomscripts = '';
		$jsBodyFiles = '';
		$jsHeadFiles = '';
		$cssLinks = '';
		$styles = $skin->getStyles();
		$scripts = $skin->getScripts();
		$assetsManager = F::build( 'AssetsManager', array(), 'getInstance' );
		

		//let extensions manipulate the asset packages (e.g. ArticleComments,
		//this is done to cut down the number or requests)
		$this->app->runHook(
				'WikiaMobileAssetsPackages',
				array(
						//no access to js packages in the head, those can slow down the page sensibly, sorry ;)
						&$jsBodyPackages,
						&$scssPackages
				)
		);

		//force main SCSS as first to make overriding it possible
		foreach ( $assetsManager->getURL( $scssPackages ) as $s ) {
			//packages/assets are enqueued via an hook, let's make sure we should actually let them through
			if ( $assetsManager->checkAssetUrlForSkin( $s, $skin->getSkinName(), $skin->isStrict() ) ) {
				//W3C standard says type attribute and quotes (for single non-URI values) not needed, let's save on output size
				$cssLinks .= "<link rel=stylesheet href=\"" . $s . "\"/>";
			}
		}

		foreach ( $styles as $s ) {
			//safe URL's as getStyles performs all the required checks
			//W3C standard says type attribute and quotes (for single non-URI values) not needed, let's save on output size
			$cssLinks .= "<link rel=stylesheet href=\"{$s['url']}\"/>";//this is a strict skin, getStyles returns only elements with a set URL
		}

		//core JS in the head section, definitely safe
		$srcs = $assetsManager->getURL( 'wikiamobile_js_head' );

		foreach ( $srcs as $src ) {
			//HTML5 standard, no type attribute required == smaller output
			$jsHeadFiles .= "<script src=\"{$src}\"></script>";
		}

		foreach ( $assetsManager->getURL( $jsBodyPackages ) as $s ) {
			//packages/assets are enqueued via an hook, let's make sure we should actually let them through
			if ( $assetsManager->checkAssetUrlForSkin( $s, $skin->getSkinName(), $skin->isStrict() ) ) {
				//HTML5 standard, no type attribute required == smaller output
				$jsBodyFiles .= "<script src=\"{$s}\"></script>";
			}
		}

		foreach ( $scripts as $s ) {
			//safe URL's as getScripts performs all the required checks
			//HTML5 standard, no type attribute required == smaller output
			$jsBodyFiles .= "<script src=\"{$s['url']}\"></script>";
		}

		//Bottom Scripts
		$this->wf->RunHooks( 'SkinAfterBottomScripts', array ( $this->wg->User->getSkin(), &$bottomscripts ) );
		$matches = array();

		//find the src if set
		preg_match_all( '/<script[^>]+src=["\'\s]?([^"\'>\s]+)["\'\s]?[^>]*>/im', $bottomscripts, $matches );
		
		if ( !empty( $matches[1] ) ) {
			foreach ( $matches[1] as $s ) {
				//packages/assets are enqueued via an hook, let's make sure we should actually let them through
				if ( $assetsManager->checkAssetUrlForSkin( $s, $skin->getSkinName(), $skin->isStrict() ) ) {
					//HTML5 standard, no type attribute required == smaller output
					$jsBodyFiles .= "<script src=\"{$s}\"></script>";
				}
			}
		}

		//AppCache will be disabled for the first several releases
		//$this->appCacheManifestPath = ( $this->wg->DevelEnvironment && !$this->wg->Request->getBool( 'appcache' ) ) ? null : self::CACHE_MANIFEST_PATH . "&{$this->wg->StyleVersion}";
		$this->mimeType = $this->templateObject->get( 'mimetype' );
		$this->charSet = $this->templateObject->get( 'charset' );
		$this->showAllowRobotsMetaTag = !$this->wg->DevelEnvironment;
		$this->globalVariablesScript = Skin::makeGlobalVariablesScript( $this->templateObject->get( 'skinname' ) );
		$this->bodyClasses = array( 'wkMobile', $this->templateObject->get( 'pageclass' ) );
		$this->pageTitle = $this->wg->Out->getHTMLTitle();
		$this->cssLinks = $cssLinks;
		$this->headLinks = $this->wg->Out->getHeadLinks();
		$this->jsHeadFiles = $jsHeadFiles;
		$this->languageCode = $this->templateObject->get( 'lang' );
		$this->languageDirection = $this->templateObject->get( 'dir' );
		$this->wikiaNavigation = $this->app->renderView( 'WikiaMobileNavigationService', 'index' );
		$this->advert = $this->app->renderView( 'WikiaMobileAdService', 'index' );
		$this->pageContent = $this->app->renderView( 'WikiaMobileBodyService', 'index', array(
			'bodyText' => $this->templateObject->get( 'bodytext' ),
			'categoryLinks' => $this->templateObject->get( 'catlinks')
		) );
		$this->wikiaFooter = $this->app->renderView( 'WikiaMobileFooterService', 'index', array(
			'copyrightLink' => $this->templateObject->get( 'copyright' )
		) );
		$this->jsBodyFiles = $jsBodyFiles;
		$this->bottomscripts = $bottomscripts;

		//tracking
		$isEditing = in_array( $this->wg->request->getVal( 'action' ), array( 'edit', 'submit' ) );

		$this->quantcastTracking = ( !$isEditing ) ?
			AnalyticsEngine::track(
					'QuantServe',
					AnalyticsEngine::EVENT_PAGEVIEW,
					array(),
					array( 'extraLabels'=> array( 'mobilebrowser' ) )
			) :
			'';
		$this->comscoreTracking = ( !$isEditing ) ? AnalyticsEngine::track( 'Comscore', AnalyticsEngine::EVENT_PAGEVIEW ) : '';
		$this->gaOneWikiTracking = AnalyticsEngine::track( 'GA_Urchin', 'onewiki', array( $this->wg->cityId ) );
		$this->gaTracking = AnalyticsEngine::track( 'GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW );

		//Stats for Gracenote reporting
		if ( $this->wg->cityId == self::LYRICSWIKI_ID ){
			$this->gaTracking .= AnalyticsEngine::track('GA_Urchin', 'lyrics');
		}
	}
}