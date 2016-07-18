<?php
/**
 * WikiaMobile skin entry point
 *
 * @author Jakub Olek <jakubolek(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileService extends WikiaService {
	const LYRICSWIKI_ID = 43339;

	/**
	* @var $skin WikiaSkin
	*/
	private $skin;

	/**
	 * @var $templateObject SkinTemplate
	 */
	private $templateObject;

	private $jsBodyPackages = [];
	private $jsExtensionPackages = [];
	private $scssPackages = [];

	private $globalVariables = [];

	/**
	 * @var $assetsManager AssetsManager
	 */
	private $assetsManager;

	function init(){
		$this->skin = RequestContext::getMain()->getSkin();
		$this->templateObject = $this->app->getSkinTemplateObj();
		$this->assetsManager = AssetsManager::getInstance();
	}

	private function handleAds(){
		wfProfileIn( __METHOD__ );

		$topLeaderBoardAd = '';

		$mobileAdService = new WikiaMobileAdService();

		if ( $mobileAdService->shouldShowAds() ) {
			$this->jsBodyPackages[] = 'wikiamobile_ads_js';

			if ( $this->wg->AdDriverTrackState ) {
				$this->globalVariables['wgAdDriverTrackState'] = $this->wg->AdDriverTrackState;
			}

			$topLeaderBoardAd = $this->app->renderView( 'WikiaMobileAdService', 'topLeaderBoard' );
		}

		$this->response->setVal( 'topLeaderBoardAd', $topLeaderBoardAd );

		wfProfileOut( __METHOD__ );
	}

	private function handleAssets( $type = '' ){
		wfProfileIn( __METHOD__ );

		$cssLinks = '';
		$jsBodyFiles = '';
		$jsExtensionFiles = '';
		$scripts = $this->skin->getScripts();

		if ( $type == 'preview' ) {
			array_unshift( $this->jsBodyPackages, 'wikiamobile_js_preview' );
			array_unshift( $this->scssPackages, 'wikiamobile_scss_preview' );
		} else {
			array_unshift( $this->jsBodyPackages, 'wikiamobile_js_body_full' );
			array_unshift( $this->scssPackages, 'wikiamobile_scss' );
		}

		//let extensions manipulate the asset packages (e.g. ArticleComments,
		//this is done to cut down the number or requests)
		$this->app->runHook(
			'WikiaMobileAssetsPackages',
			[
				//This should be a static package - files that need to be loaded on EVERY page
				&$this->jsBodyPackages,
				//All the rest can go here ie. assets for FilePage, special pages and so on
				&$this->jsExtensionPackages,
				&$this->scssPackages
			]
		);

		// SASS files requested via WikiaMobileAssetsPackages hook
		$sassFiles = [];
		foreach ( $this->assetsManager->getURL( $this->scssPackages ) as $src ) {
			if ( $this->assetsManager->checkAssetUrlForSkin( $src, $this->skin ) ) {
				$sassFiles[] = $src;
			}
		}

		// try to fetch all SASS files using a single request (CON-1487)
		$cssLinks .= $this->skin->getStylesWithCombinedSASS($sassFiles);

		if ( is_array( $this->jsExtensionPackages ) ) {
			//core JS in the head section, definitely safe
			foreach ( $this->assetsManager->getURL( $this->jsExtensionPackages ) as $src ) {
				$jsExtensionFiles .= "<script src='{$src}'></script>";
			}
		}

		if ( is_array( $this->jsBodyPackages ) ) {
			foreach ( $this->assetsManager->getURL( $this->jsBodyPackages ) as $s ) {
				//packages/assets are enqueued via an hook, let's make sure we should actually let them through
				if ( $this->assetsManager->checkAssetUrlForSkin( $s, $this->skin ) ) {
					$jsBodyFiles .= "<script src='{$s}'></script>";
				}
			}
		}

		if ( is_array( $scripts ) ) {
			foreach ( $scripts as $s ) {
				//safe URLs as getScripts performs all the required checks
				$jsBodyFiles .= "<script src='{$s['url']}'></script>";
			}
		}

		$this->response->setVal( 'jsExtensionPackages', $jsExtensionFiles );
		$this->response->setVal( 'cssLinks', $cssLinks );
		$this->response->setVal( 'jsBodyFiles', $jsBodyFiles );

		wfProfileOut( __METHOD__ );
	}

	private function handleTracking(){
		wfProfileIn( __METHOD__ );

		$trackingCode = '';

		if ( !in_array( $this->wg->Request->getVal( 'action' ), [ 'edit', 'submit' ] ) ) {
			$trackingCode .= AnalyticsEngine::track(
					'QuantServe',
					AnalyticsEngine::EVENT_PAGEVIEW,
					['extraLabels'=> ['Category.MobileWeb.WikiaMobile']]
				) .
				AnalyticsEngine::track(
					'Comscore',
					AnalyticsEngine::EVENT_PAGEVIEW
				);
		}

		//Stats for Gracenote reporting
		$trackingCode .= AnalyticsEngine::track( 'GoogleUA', 'usertiming' );

		$this->response->setVal( 'trackingCode', $trackingCode );

		wfProfileOut( __METHOD__ );
	}

	private function handleSmartBanner(){
		wfProfileIn( __METHOD__ );

		//Add GameGuides SmartBanner promotion on Gaming Vertical
		if ( !empty( $this->wg->EnableWikiaMobileSmartBanner )
			&& !empty( $this->wg->WikiaMobileSmartBannerConfig )
			&& empty( $this->wg->WikiaMobileSmartBannerConfig['disabled'] )
		) {
			$this->jsExtensionPackages[] = 'wikiamobile_smartbanner_init_js';

			$this->globalVariables['wgAppName'] = $this->wg->WikiaMobileSmartBannerConfig['name'];
			$this->globalVariables['wgAppIcon'] = $this->wg->WikiaMobileSmartBannerConfig['icon'];

			$this->response->setVal( 'smartBannerConfig', $this->wg->WikiaMobileSmartBannerConfig['meta'] );
		}

		wfProfileOut( __METHOD__ );
	}

	private function handleMessages(){
		JSMessages::enqueuePackage( 'WkMbl', JSMessages::INLINE );
	}

	private function handleContent($content = ''){
		wfProfileIn( __METHOD__ );

		if( !empty( $content ) ) {

			$this->response->setVal( 'pageContent',
				$this->app->renderView( 'WikiaMobileBodyService', 'index', [
						'bodyText' => $content
					]
				)
			);

		} else {
			$this->response->setVal( 'wikiaNavigation',
				$this->app->renderView( 'WikiaMobileNavigationService', 'index' )
			);

			$this->response->setVal( 'pageContent',
				$this->app->renderView( 'WikiaMobileBodyService', 'index', [
						'bodyText' => $this->templateObject->get( 'bodytext' ),
						'categoryLinks' => $this->templateObject->get( 'catlinks')
					]
				)
			);

			$this->response->setVal( 'wikiaFooter',
				$this->app->renderView( 'WikiaMobileFooterService', 'index' )
			);
		}

		wfProfileOut( __METHOD__ );
	}

	private function isArticleView() {
		global $wgRequest, $wgTitle;

		$action = $wgRequest->getVal( 'action', 'view' );
		$namespace = $wgTitle->getNamespace();;

		return ( ( $action === 'view' || $action === 'ajax' ) &&
			$wgTitle->getArticleId() !== 0 &&
			( $namespace !== NS_USER && $namespace !== NS_BLOG_ARTICLE ) // skip user profile and user blog pages
		);
	}

	private function handleToc() {
		$toc = '';

		//Enable TOC only on view action and on real articles and preview
		if ( $this->isArticleView() ) {
			$this->jsExtensionPackages[] = 'wikiamobile_js_toc';
			$this->scssPackages[] = 'wikiamobile_scss_toc';

			$toc = $this->app->renderPartial( 'WikiaMobileService', 'toc' );
		}

		$this->response->setVal( 'toc', $toc );
	}

	private function handleWikiaWidgets() {
		if ( $this->isArticleView() ) {
			$this->jsExtensionPackages[] = 'wikiamobile_widget_iframe_unwrapper';
		}
	}

	private function disableSiteCSS() {
		global $wgUseSiteCss;
		$wgUseSiteCss = false;
	}

	public function index() {
		wfProfileIn( __METHOD__ );

		$this->disableSiteCSS();
		$this->handleMessages();
		$this->handleSmartBanner();
		$this->handleContent();
		$this->handleAds();
		$this->handleToc();
		$this->handleWikiaWidgets();
		$this->handleAssets();
		$this->handleTracking();

		//We were able to push all JS to bottom of a page
		//js class is used to style some element on a page therefore it is better to apply it as soon as possible
		$this->response->setVal( 'jsClassScript', '<script>document.documentElement.className = "js";</script>' );
		$this->response->setVal( 'allowRobots', ( !$this->wg->DevelEnvironment ) );
		$this->response->setVal( 'mimeType', $this->templateObject->get( 'mimetype' ) );
		$this->response->setVal( 'charSet', $this->templateObject->get( 'charset' ) );
		$this->response->setVal( 'headItems', $this->skin->getHeadItems() );
		$this->response->setVal( 'languageCode', $this->templateObject->get( 'lang' ) );
		$this->response->setVal( 'languageDirection', $this->templateObject->get( 'dir' ) );
		$this->response->setVal( 'headLinks', $this->wg->Out->getHeadLinks() );
		$this->response->setVal( 'pageTitle', htmlspecialchars( $this->wg->Out->getHTMLTitle() ) );
		$this->response->setVal( 'bodyClasses', [ 'wkMobile', $this->templateObject->get( 'pageclass' ) ] );
		$this->response->setVal( 'globalVariablesScript', $this->skin->getTopScripts( $this->globalVariables ) );

		wfProfileOut( __METHOD__ );
	}

	public function preview() {
		wfProfileIn( __METHOD__ );

		$content = $this->request->getVal( 'content' );

		$this->handleMessages();
		$this->handleToc();
		$this->handleContent( $content );
		$this->handleWikiaWidgets();
		$this->handleAssets( 'preview' );

		$this->response->setVal( 'jsClassScript', '<script>document.documentElement.className = "js";</script>' );
		$this->response->setVal( 'globalVariablesScript', $this->skin->getTopScripts( $this->globalVariables ) );

		wfProfileOut( __METHOD__ );
	}
}
