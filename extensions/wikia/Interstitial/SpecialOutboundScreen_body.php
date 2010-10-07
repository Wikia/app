<?php

// If we extend Interstitial, then the page just redirects to Special:Interstitial.  In the future,
// we may want to make them both extend from a similar superclass (eg: "UnlistedSpecialPage" -> "AdPage" -> {"Outbound", "Interstitial"}).
class Outbound extends UnlistedSpecialPage {
	private $redirectDelay = 0; // in seconds
	private $adLayoutMode;

	/**
	 * Constructor
	 */
	public function __construct() {
		global $wgOutboundScreenConfig;

		$this->redirectDelay = $wgOutboundScreenConfig['redirectDelay'];
		$this->adLayoutMode = strtoupper($wgOutboundScreenConfig['adLayoutMode']);

		parent::__construct( 'Outbound' /*class*/ );
		wfLoadExtensionMessages( 'Outbound' ); // Load internationalization messages
		wfLoadExtensionMessages( INTERSTITIALS_SP ); // Load internationalization messages for the interstitial
	}

	function execute() {
		global $wgOut, $wgUser, $wgRequest, $wgExtensionsPath, $wgOutboundScreenConfig, $wgCityId, $wgEnableOutboundScreenExt;

		$url = $wgRequest->getText( 'u' );
		$noAutoRedirect = ( $wgRequest->getText( 'noredirect' ) == 1 ) ? true : false;

		$loggedIn = $wgUser->isLoggedIn();
		if(trim($url) == ""){
			// Nowhere to go.  Display an appropriate explanation (nowhere to go).
			$wgOut->addWikiText( wfMsg('outbound-screen-already-logged-in-no-link') );
		} else if((($wgOutboundScreenConfig['anonsOnly'] == true) && $loggedIn) || empty($wgEnableOutboundScreenExt)){
			$wgOut->redirect( htmlspecialchars_decode( $url ) );
			return true;
		} else {

			// output only template content
			$wgOut->setArticleBodyOnly(true);

			// render template
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

			// Need to have the skinname correct before calling Athena.
			$skin = $wgUser->getSkin();
			$skinName = get_class($skin);

			// this may not be set yet (and needs to be before setupUserCss in order for the right CSS$
			if ($skin->getSkinName() == '') {
				$skin->skinname = strtolower(substr($skinName, 4));
			}

			$adSlots = array(
			'INVISIBLE' => AdEngine::getInstance()->getAd('EXIT_STITIAL_INVISIBLE'),
			'BOXAD_1' => AdEngine::getInstance()->getAd('EXIT_STITIAL_BOXAD_1'),
			//'BOXAD_1' => AdEngine::getInstance()->getAd('TOP_RIGHT_BOXAD'), // for dev testing
			'BOXAD_2' => AdEngine::getInstance()->getAd('EXIT_STITIAL_BOXAD_2')
			//'BOXAD_2' => AdEngine::getInstance()->getAd('TOP_RIGHT_BOXAD') // for dev testing
			);

			$oTmpl->set_vars(
				array(
						'adSlots' => $adSlots
				)
			);

			switch($this->adLayoutMode) {
				case 'V1':
					$adTemplate = 'adLayoutV1';
					break;
				case 'V2':
					$adTemplate = 'adLayoutV2';
					break;
				case 'V3':
					$adTemplate = 'adLayoutV3';
					break;
				case 'V4':
					$adTemplate = 'adLayoutV4';
					break;
				case 'CLASSIC':
				default:
					$adTemplate = 'adLayoutClassic';
			}

			$athenaInitStuff = AdProviderAthena::getInstance()->getSetupHtml();
			$athenaInitStuff .= AdEngine::getInstance()->providerValuesAsJavascript($wgCityId);

			// Create the JS-includes for the tracking code and jQuery - will just use StaticChute because it should be in user's cache by now.
			$StaticChute = new StaticChute('js');
			$StaticChute->useLocalChuteUrl();
			if($wgUser->isLoggedIn()){
				$package = 'monaco_loggedin_js';
			} else {
				$package = 'monaco_anon_article_js';
			}
			$jsIncludes = $StaticChute->getChuteHtmlForPackage($package);

			$adCode = $oTmpl->execute($adTemplate);
			$loginMsg = wfMsgExt('outbound-screen-login-text', array('parseinline', 'content'));
			$pageBarMsg = wfMsg('outbound-screen-you-are-leaving');
			$jsGlobals = Skin::makeGlobalVariablesScript( array('skinname' => $skinName) );
			$oTmpl->set_vars(
				array(
					'adCode' => $adCode,
					'athenaInitStuff' => $athenaInitStuff,
					'css' => Interstitial::getCss(),
					'loginMsg' => $loginMsg,
					'jsGlobals' => $jsGlobals,
					'jsIncludes' => $jsIncludes,
					'pageBarMsg' => $pageBarMsg,
					'pageType' => 'exitPage',
					'redirectDelay' => ( $noAutoRedirect ? 0 : $this->redirectDelay ),
					'skip' => wfMsg('interstitial-skip-ad'),
					'url' => htmlspecialchars_decode($url),
				)
			);

			// just output content of template
			$wgOut->clearHTML();
			$wgOut->addHTML( $oTmpl->execute('page') );
		}
	}
}
