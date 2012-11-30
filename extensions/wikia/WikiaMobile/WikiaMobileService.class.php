<?php
/**
 * WikiaMobile skin entry point
 *
 * @author Jakub Olek <jakubolek(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileService extends WikiaService {
	//AppCache will be disabled for the first several releases
	//const CACHE_MANIFEST_PATH = 'wikia.php?controller=WikiaMobileAppCache&method=serveManifest&format=html';
	const LYRICSWIKI_ID = 43339;

	static protected $initialized = false;
	/**
	* @var $skin WikiaSkin
	*/
	private $skin;

	/**
	 * @var $templateObject SkinTemplate
	 */
	private $templateObject;

	function __construct(){
		parent::__construct();

		if ( !self::$initialized ) {
			//singleton
			F::setInstance( __CLASS__, $this );
			self::$initialized = true;
		}
	}

	function init(){
		$this->wf->LoadExtensionMessages( 'WikiaMobile' );
		$this->skin = RequestContext::getMain()->getSkin();
		$this->templateObject = $this->app->getSkinTemplateObj();
	}

	public function index() {
		$this->wf->profileIn( __METHOD__ );

		$jsHeadPackages = array( 'wikiamobile_js_head' );
		$jsBodyPackages = array();
		$scssPackages = array();
		$cssLinks = '';
		$jsBodyFiles = '';
		$jsHeadFiles = '';
		$styles = null;
		$scripts = null;
		$assetsManager = F::build( 'AssetsManager', array(), 'getInstance' );
		$advert = '';

		F::build( 'JSMessages' )->enqueuePackage( 'WkMbl', JSMessages::INLINE );

		$jsBodyPackages[] = 'wikiamobile_js_body_full';
		$scssPackages[] = 'wikiamobile_scss';
		$styles = $this->skin->getStyles();
		$scripts = $this->skin->getScripts();

		//show ads only for anon users
		if ( $this->wg->user->isAnon() ) {
			$jsBodyPackages[] = 'wikiamobile_js_ads';
			$advert = $this->app->renderView( 'WikiaMobileAdService', 'index' );
		}

		$nav = $this->app->renderView( 'WikiaMobileNavigationService', 'index' );
		$pageContent = $this->app->renderView( 'WikiaMobileBodyService', 'index', array(
			'bodyText' => $this->templateObject->get( 'bodytext' ),
			'categoryLinks' => $this->templateObject->get( 'catlinks')
		) );
		$footer = $this->app->renderView( 'WikiaMobileFooterService', 'index' );

		//let extensions manipulate the asset packages (e.g. ArticleComments,
		//this is done to cut down the number or requests)
		$this->app->runHook(
			'WikiaMobileAssetsPackages',
			array(
				&$jsHeadPackages,
				&$jsBodyPackages,
				&$scssPackages
			)
		);

		if ( is_array( $scssPackages ) ) {
			//force main SCSS as first to make overriding it possible
			foreach ( $assetsManager->getURL( $scssPackages ) as $s ) {
				//packages/assets are enqueued via an hook, let's make sure we should actually let them through
				if ( $assetsManager->checkAssetUrlForSkin( $s, $this->skin ) ) {
					//W3C standard says type attribute and quotes (for single non-URI values) not needed, let's save on output size
					$cssLinks .= "<link rel=stylesheet href=\"" . $s . "\"/>";
				}
			}
		}

		if ( is_array( $styles ) ) {
			foreach ( $styles as $s ) {
				//safe URL's as getStyles performs all the required checks
				//W3C standard says type attribute and quotes (for single non-URI values) not needed, let's save on output size
				$cssLinks .= "<link rel=stylesheet href=\"{$s['url']}\"/>";//this is a strict skin, getStyles returns only elements with a set URL
			}
		}

		if ( is_array( $jsHeadPackages ) ) {
			//core JS in the head section, definitely safe
			foreach ( $assetsManager->getURL( $jsHeadPackages ) as $src ) {
				//HTML5 standard, no type attribute required == smaller output
				$jsHeadFiles .= "<script src=\"{$src}\"></script>";
			}
		}

		if ( is_array( $jsBodyPackages ) ) {
			foreach ( $assetsManager->getURL( $jsBodyPackages ) as $s ) {
				//packages/assets are enqueued via an hook, let's make sure we should actually let them through
				if ( $assetsManager->checkAssetUrlForSkin( $s, $this->skin ) ) {
					//HTML5 standard, no type attribute required == smaller output
					$jsBodyFiles .= "<script src=\"{$s}\"></script>";
				}
			}
		}

		if ( is_array( $scripts ) ) {
			foreach ( $scripts as $s ) {
				//safe URL's as getScripts performs all the required checks
				//HTML5 standard, no type attribute required == smaller output
				$jsBodyFiles .= "<script src=\"{$s['url']}\"></script>";
			}
		}

		//Bottom Scripts
		//do not run this hook, all the functionalities hooking in this don't take into account the pecularity of the mobile skin
		//$this->wf->RunHooks( 'SkinAfterBottomScripts', array ( $this->wg->User->getSkin(), &$bottomscripts ) );

		//AppCache will be disabled for the first several releases
		//$this->appCacheManifestPath = ( $this->wg->DevelEnvironment && !$this->wg->Request->getBool( 'appcache' ) ) ? null : self::CACHE_MANIFEST_PATH . "&{$this->wg->StyleVersion}";
		$this->response->setVal( 'jsHeadFiles', $jsHeadFiles );
		$this->response->setVal( 'topScripts', $this->skin->getTopScripts() );
		$this->response->setVal( 'allowRobots', ( !$this->wg->DevelEnvironment ) );
		$this->response->setVal( 'cssLinks', $cssLinks );
		$this->response->setVal( 'mimeType', $this->templateObject->get( 'mimetype' ) );
		$this->response->setVal( 'charSet', $this->templateObject->get( 'charset' ) );
		$this->response->setVal( 'headItems', $this->skin->getHeadItems() );
		$this->response->setVal( 'languageCode', $this->templateObject->get( 'lang' ) );
		$this->response->setVal( 'languageDirection', $this->templateObject->get( 'dir' ) );
		$this->response->setVal( 'headLinks', $this->wg->Out->getHeadLinks() );
		$this->response->setVal( 'pageTitle', $this->wg->Out->getHTMLTitle() );
		$this->response->setVal( 'bodyClasses', array( 'wkMobile', $this->templateObject->get( 'pageclass' ) ) );
		$this->response->setVal( 'jsBodyFiles', $jsBodyFiles );
		$this->response->setVal( 'advertisement', $advert );
		$this->response->setVal( 'wikiaNavigation', $nav );
		$this->response->setVal( 'pageContent', $pageContent );
		$this->response->setVal( 'wikiaFooter', $footer );

		//global variables
		//from Output class
		//and from ResourceLoaderStartUpModule
		$res = new ResourceVariablesGetter();
		$vars = array_diff_key(
			//I found that this array merge is the fastest
			$this->wg->Out->getJSVars() + $res->get(),
			array_flip( $this->wg->WikiaMobileExcludeJSGlobals )
		);

		$this->response->setVal( 'globalVariablesScript', WikiaSkin::makeInlineVariablesScript( $vars ) );

		//tracking
		$trackingCode = '';

		if(!in_array( $this->wg->Request->getVal( 'action' ), array( 'edit', 'submit' ) ) ) {
			$trackingCode .= AnalyticsEngine::track(
				'QuantServe',
				AnalyticsEngine::EVENT_PAGEVIEW,
				array(),
				array( 'extraLabels'=> array( 'mobilebrowser' ) )
			) .
		   	AnalyticsEngine::track(
				'Comscore',
				AnalyticsEngine::EVENT_PAGEVIEW
			);
		}

		//Stats for Gracenote reporting
		if ( $this->wg->cityId == self::LYRICSWIKI_ID ){
			$trackingCode .= AnalyticsEngine::track('GA_Urchin', 'lyrics');
		}

		$trackingCode .= AnalyticsEngine::track( 'GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW ).
			AnalyticsEngine::track( 'GA_Urchin', 'onewiki', array( $this->wg->cityId ) ).
			AnalyticsEngine::track( 'GA_Urchin', 'pagetime', array( 'wikiamobile' ) ).
			AnalyticsEngine::track( 'GA_Urchin', 'varnish-stat').
			AnalyticsEngine::track( 'GAS', 'usertiming' );

		$this->response->setVal( 'trackingCode', $trackingCode );

		$this->wf->profileOut( __METHOD__ );
	}
}