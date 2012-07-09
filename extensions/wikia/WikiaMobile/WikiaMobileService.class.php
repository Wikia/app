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
		F::build('JSMessages')->enqueuePackage('WkMbl', JSMessages::INLINE);

		$this->skin = $this->wg->User->getSkin();
		$this->templateObject = $this->app->getSkinTemplateObj();
	}

	public function index() {
		$this->wf->profileIn( __METHOD__ );
		$title = $this->app->wg->Title;

		//Bottom Scripts
		//do not run this hook, all the functionalities hooking in this don't take into account the pecularity of the mobile skin
		//$this->wf->RunHooks( 'SkinAfterBottomScripts', array ( $this->wg->User->getSkin(), &$bottomscripts ) );

		//AppCache will be disabled for the first several releases
		//$this->appCacheManifestPath = ( $this->wg->DevelEnvironment && !$this->wg->Request->getBool( 'appcache' ) ) ? null : self::CACHE_MANIFEST_PATH . "&{$this->wg->StyleVersion}";

		//head items
		$this->mimeType = $this->templateObject->get( 'mimetype' );
		$this->charSet = $this->templateObject->get( 'charset' );
		$this->headItems = $this->skin->getHeadItems();
		$this->languageCode = $this->templateObject->get( 'lang' );
		$this->languageDirection = $this->templateObject->get( 'dir' );
		$this->headLinks = $this->wg->Out->getHeadLinks();
		$this->pageTitle = $this->wg->Out->getHTMLTitle();

		if( !$title->exists() &&
			!( $title->getNamespace() == NS_CATEGORY && Category::newFromTitle( $title )->getPageCount() ) ) {
			//"404" Page - on title that do not exists
			$this->forward( 'WikiaMobileErrorService', WikiaMobileErrorService::PAGENOTFOUND, false );
		} else {
			//Normal Page
			$this->forward( 'WikiaMobileService', 'viewArticle' , false );
		}
		$this->wf->profileOut( __METHOD__ );
	}

	function viewArticle(){
		$this->wf->profileIn( __METHOD__ );

		$jsHeadPackages = array( 'wikiamobile_js_head' );
		$jsBodyPackages = array( 'wikiamobile_js_body' );
		$scssPackages = array( 'wikiamobile_scss' );
		$cssLinks = '';
		$jsBodyFiles = '';
		$jsHeadFiles = '';
		$styles = $this->skin->getStyles();
		$scripts = $this->skin->getScripts();
		$assetsManager = F::build( 'AssetsManager', array(), 'getInstance' );

		//force main SCSS as first to make overriding it possible
		foreach ( $assetsManager->getURL( $scssPackages ) as $s ) {
			//packages/assets are enqueued via an hook, let's make sure we should actually let them through
			if ( $assetsManager->checkAssetUrlForSkin( $s, $this->skin ) ) {
				//W3C standard says type attribute and quotes (for single non-URI values) not needed, let's save on output size
				$cssLinks .= "<link rel=stylesheet href=\"" . $s . "\"/>";
			}
		}

		foreach ( $styles as $s ) {
			//safe URL's as getStyles performs all the required checks
			//W3C standard says type attribute and quotes (for single non-URI values) not needed, let's save on output size
			$cssLinks .= "<link rel=stylesheet href=\"{$s['url']}\"/>";//this is a strict skin, getStyles returns only elements with a set URL
		}

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

		//core JS in the head section, definitely safe
		$srcs = $assetsManager->getURL( $jsHeadPackages );

		foreach ( $srcs as $src ) {
			//HTML5 standard, no type attribute required == smaller output
			$jsHeadFiles .= "<script src=\"{$src}\"></script>";
		}

		foreach ( $assetsManager->getURL( $jsBodyPackages ) as $s ) {
			//packages/assets are enqueued via an hook, let's make sure we should actually let them through
			if ( $assetsManager->checkAssetUrlForSkin( $s, $this->skin ) ) {
				//HTML5 standard, no type attribute required == smaller output
				$jsBodyFiles .= "<script src=\"{$s}\"></script>";
			}
		}

		foreach ( $scripts as $s ) {
			//safe URL's as getScripts performs all the required checks
			//HTML5 standard, no type attribute required == smaller output
			$jsBodyFiles .= "<script src=\"{$s['url']}\"></script>";
		}

		//body items
		$this->bodyClasses = array( 'wkMobile', $this->templateObject->get( 'pageclass' ) );
		$this->cssLinks = $cssLinks;
		$this->jsBodyFiles = $jsBodyFiles;
		$this->showAllowRobotsMetaTag = !$this->wg->DevelEnvironment;
		$this->globalVariablesScript = Skin::makeGlobalVariablesScript( $this->templateObject->get( 'skinname' ) );
		$this->jsHeadFiles = $jsHeadFiles;
		$this->wikiaNavigation = $this->app->renderView( 'WikiaMobileNavigationService', 'index' );
		$this->advert = $this->app->renderView( 'WikiaMobileAdService', 'index' );
		$this->pageContent = $this->app->renderView( 'WikiaMobileBodyService', 'index', array(
			'bodyText' => $this->templateObject->get( 'bodytext' ),
			'categoryLinks' => $this->templateObject->get( 'catlinks')
		) );
		//$this->wikiaFooter = $this->app->renderView( 'WikiaMobileFooterService', 'index', array(
		//	'copyrightLink' => str_replace( 'CC-BY-SA', $this->wf->msg( 'wikiamobile-footer-link-license' ), $this->templateObject->get( 'copyright' ) )
		//) );
		$this->wikiaFooter = $this->app->renderView( 'WikiaMobileFooterService', 'index' );

		//global variables
		//from Output class
		//and from ResourceLoaderStartUpModule
		$res = new ResourceVariablesGetter();
		$vars = array_diff_key(
		//I found that this array merge is the fastest
			$this->wg->Out->getJSVars() + $res->get(),
			array_flip( $this->wg->WikiaMobileExcludeJSGlobals )
		);

		$this->topScripts = $this->skin->getTopScripts();
		$this->globalVariablesScript = WikiaSkin::makeInlineVariablesScript( $vars );

		//tracking
		$trackingCode = '';

		if(!in_array( $this->wg->request->getVal( 'action' ), array( 'edit', 'submit' ) ) ) {
			$this->quantcastTracking = AnalyticsEngine::track(
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