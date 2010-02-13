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
		global $wgOut, $wgUser, $wgRequest, $wgExtensionsPath, $wgOutboundScreenConfig, $wgCityId;

		$url = $wgRequest->getText( 'u' );
		$noAutoRedirect = ( $wgRequest->getText( 'noredirect' ) == 1 ) ? true : false;

		$loggedIn = $wgUser->isLoggedIn();
		if(trim($url) == ""){
			// Nowhere to go.  Display an appropriate explanation (nowhere to go).
			$wgOut->addWikiText( wfMsg('outbound-screen-already-logged-in-no-link') );
		} else if(($wgOutboundScreenConfig['anonsOnly'] == true) && $loggedIn) {
			$wgOut->redirect( htmlspecialchars_decode( $url ) );
			return true;
		} else {

			// output only template content
			$wgOut->setArticleBodyOnly(true);

			// render template
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

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

			$adCode = $oTmpl->execute($adTemplate);
			$userLoginTitle = Title::newFromText( 'Special:Userlogin' );
			$loginMsg = wfMsgForContent('outbound-screen-login-text', array( $userLoginTitle->getFullUrl('type=signup'), $userLoginTitle->getFullUrl() ) );
			$pageBarMsg = wfMsg('outbound-screen-you-are-leaving');
			$oTmpl->set_vars(
					array(
						'url' => $url,
						'css' => Interstitial::getCss(),
						'skip' => wfMsg('interstitial-skip-ad'),
						'adCode' => $adCode,
						'loginMsg' => $loginMsg,
						'pageBarMsg' => $pageBarMsg,
						'athenaInitStuff' => $athenaInitStuff,
						'redirectDelay' => ( $noAutoRedirect ? 0 : $this->redirectDelay ),
					)
			);

			// just output content of template
			$wgOut->clearHTML();
			$wgOut->addHTML( $oTmpl->execute('page') );
		}
	}
}
