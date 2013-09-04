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

	function init(){
		$this->skin = RequestContext::getMain()->getSkin();
		$this->templateObject = $this->app->getSkinTemplateObj();
	}

	public function index() {
		wfProfileIn( __METHOD__ );

		$jsBodyPackages = [ 'wikiamobile_js_body_full' ];
		$jsExtensionPackages = [];
		$scssPackages = [ 'wikiamobile_scss' ];
		$cssLinks = '';
		$jsBodyFiles = '';
		$jsExtensionFiles = '';
		$styles = $this->skin->getStyles();
		$scripts = $this->skin->getScripts();
		$assetsManager = AssetsManager::getInstance();
		$floatingAd = '';
		$topLeaderBoardAd = '';
		$inContentAd = '';
		$modalInterstitial = '';
		$globalVariables = [];

		JSMessages::enqueuePackage( 'WkMbl', JSMessages::INLINE );

		$mobileAdService = new WikiaMobileAdService();
		if ($mobileAdService->shouldLoadAssets()) {
			$jsBodyPackages[] = 'wikiamobile_js_ads';

			if ($mobileAdService->shouldShowAds()) {
				$floatingAd = $this->app->renderView( 'WikiaMobileAdService', 'floating' );
				$topLeaderBoardAd = $this->app->renderView( 'WikiaMobileAdService', 'topLeaderBoard' );
				$inContentAd = $this->app->renderView( 'WikiaMobileAdService', 'inContent' );
				$modalInterstitial = $this->app->renderView( 'WikiaMobileAdService', 'modalInterstitial' );
				$globalVariables['wgShowAds'] = true;
			}
		}

		$nav = $this->app->renderView( 'WikiaMobileNavigationService', 'index' );
		$pageContent = $this->app->renderView( 'WikiaMobileBodyService', 'index', [
			'bodyText' => $this->templateObject->get( 'bodytext' ),
			'categoryLinks' => $this->templateObject->get( 'catlinks')
		] );
		$footer = $this->app->renderView( 'WikiaMobileFooterService', 'index' );

		//let extensions manipulate the asset packages (e.g. ArticleComments,
		//this is done to cut down the number or requests)
		$this->app->runHook(
			'WikiaMobileAssetsPackages',
			[
				//This should be a static package - files that need to be loaded on EVERY page
				&$jsBodyPackages,
				//All the rest can go here ie. assets for FilePage, special pages and so on
				&$jsExtensionPackages,
				&$scssPackages
			]
		);

		if ( is_array( $scssPackages ) ) {
			//force main SCSS as first to make overriding it possible
			foreach ( $assetsManager->getURL( $scssPackages ) as $s ) {
				//packages/assets are enqueued via an hook, let's make sure we should actually let them through
				if ( $assetsManager->checkAssetUrlForSkin( $s, $this->skin ) ) {
					//W3C standard says type attribute and quotes (for single non-URI values) not needed, let's save on output size
					$cssLinks .= "<link rel=stylesheet href='{$s}'/>";
				}
			}
		}

		if ( is_array( $styles ) ) {
			foreach ( $styles as $s ) {
				//safe URL's as getStyles performs all the required checks
				$cssLinks .= "<link rel=stylesheet href='{$s['url']}'/>";//this is a strict skin, getStyles returns only elements with a set URL
			}
		}

		if ( is_array( $jsExtensionPackages ) ) {
			//core JS in the head section, definitely safe
			foreach ( $assetsManager->getURL( $jsExtensionPackages ) as $src ) {
				$jsExtensionFiles .= "<script src='{$src}'></script>";
			}
		}

		if ( is_array( $jsBodyPackages ) ) {
			foreach ( $assetsManager->getURL( $jsBodyPackages ) as $s ) {
				//packages/assets are enqueued via an hook, let's make sure we should actually let them through
				if ( $assetsManager->checkAssetUrlForSkin( $s, $this->skin ) ) {
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

		//Add GameGuides SmartBanner promotion on Gaming Vertical
		if ( !empty( $this->wg->EnableWikiaMobileSmartBanner ) ) {
			foreach ( $assetsManager->getURL( 'wikiamobile_smartbanner_init_js' ) as $src ) {
				$jsBodyFiles .= "<script src='{$src}'></script>";
			}

			$globalVariables['wgAppName'] = $this->wg->WikiaMobileSmartBannerConfig['name'];
			$globalVariables['wgAppAuthor'] = $this->wg->WikiaMobileSmartBannerConfig['author'];

			$this->response->setVal( 'smartBannerConfig', $this->wg->WikiaMobileSmartBannerConfig );
		}

		//We were able to push all JS to bottom of a page
		//js class is used to style some element on a page therefore it is better to apply it as soon as possible
		$this->response->setVal( 'jsClassScript', '<script>document.documentElement.className = "js";</script>' );
		$this->response->setVal( 'jsExtensionPackages', $jsExtensionFiles );
		$this->response->setVal( 'allowRobots', ( !$this->wg->DevelEnvironment ) );
		$this->response->setVal( 'cssLinks', $cssLinks );
		$this->response->setVal( 'mimeType', $this->templateObject->get( 'mimetype' ) );
		$this->response->setVal( 'charSet', $this->templateObject->get( 'charset' ) );
		$this->response->setVal( 'headItems', $this->skin->getHeadItems() );
		$this->response->setVal( 'languageCode', $this->templateObject->get( 'lang' ) );
		$this->response->setVal( 'languageDirection', $this->templateObject->get( 'dir' ) );
		$this->response->setVal( 'headLinks', $this->wg->Out->getHeadLinks() );
		$this->response->setVal( 'pageTitle', $this->wg->Out->getHTMLTitle() );
		$this->response->setVal( 'bodyClasses', [ 'wkMobile', $this->templateObject->get( 'pageclass' ) ] );
		$this->response->setVal( 'jsBodyFiles', $jsBodyFiles );
		$this->response->setVal( 'wikiaNavigation', $nav );
		$this->response->setVal( 'pageContent', $pageContent );
		$this->response->setVal( 'wikiaFooter', $footer );
		$this->response->setVal( 'globalVariablesScript', $this->skin->getTopScripts( $globalVariables ) );
		//Ad units
		$this->response->setVal( 'floatingAd', $floatingAd );
		$this->response->setVal( 'topLeaderBoardAd', $topLeaderBoardAd );
		$this->response->setVal( 'inContentAd', $inContentAd );
		$this->response->setVal( 'modalInterstitial', $modalInterstitial );

		//tracking
		$trackingCode = '';

		if ( !in_array( $this->wg->Request->getVal( 'action' ), [ 'edit', 'submit' ] ) ) {
			$trackingCode .= AnalyticsEngine::track(
				'QuantServe',
				AnalyticsEngine::EVENT_PAGEVIEW,
				[],
				['extraLabels'=> ['mobilebrowser']]
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
			AnalyticsEngine::track( 'GA_Urchin', 'onewiki', [$this->wg->cityId] ).
			AnalyticsEngine::track( 'GA_Urchin', 'pagetime', ['wikiamobile'] ).
			AnalyticsEngine::track( 'GA_Urchin', 'varnish-stat').
			AnalyticsEngine::track( 'GAS', 'usertiming' );

		$this->response->setVal( 'trackingCode', $trackingCode );

		wfProfileOut( __METHOD__ );
	}
}
