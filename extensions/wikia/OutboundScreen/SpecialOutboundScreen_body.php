<?php

class Outbound extends UnlistedSpecialPage {
	private $redirectDelay = 0; // in seconds

	/**
	 * Constructor
	 */
	public function __construct() {
		global $wgOutboundScreenConfig;

		$this->redirectDelay = $wgOutboundScreenConfig['redirectDelay'];

		parent::__construct( 'Outbound'/*class*/ );
		wfLoadExtensionMessages( 'Outbound' ); // Load internationalization messages
	}

	function execute() {
		global $wgOut, $wgUser, $wgRequest, $wgExtensionsPath, $wgOutboundScreenConfig, $wgCityId;

		$url = $wgRequest->getText( 'u' );
		$noAutoRedirect = ( $wgRequest->getText( 'noredirect' ) == 1 ) ? true : false;

		$loggedIn = $wgUser->isLoggedIn();
		if(($wgOutboundScreenConfig['anonsOnly'] == true) && $loggedIn) {
			$wgOut->redirect( $url );
			return true;
		}

		// output only template content
		$wgOut->setArticleBodyOnly(true);

		$skin = $wgUser->getSkin();
		$skinName = get_class($skin);

		// this may not be set yet
		if ($skin->getSkinName() == '') {
			$skin->skinname = substr($skinName, 4);
		}

		// add MW CSS
		$skin->setupUserCss($wgOut);

		// Monaco themes
		if ($skinName == 'SkinMonaco' && !empty($skin->themename)) {
			switch($skin->themename) {
				case 'custom':
					break;

				case 'sapphire':
					$wgOut->addStyle('monaco/css/root.css');
					break;

				default:
					$wgOut->addStyle('monaco/' . $skin->themename . '/css/main.css');
					break;
			}
		}

		// render <link> tags
		$css = $wgOut->buildCssLinks();

		// render template
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$adSlots = array(
		'INVISIBLE' => AdEngine::getInstance()->getAd('EXIT_STITIAL_INVISIBLE'),
		'BOXAD_1' => AdEngine::getInstance()->getAd('EXIT_STITIAL_BOXAD_1'),
		//'BOXAD_1' => AdEngine::getInstance()->getAd('HOME_TOP_LEADERBOARD'), // for dev testing
		'BOXAD_2' => AdEngine::getInstance()->getAd('EXIT_STITIAL_BOXAD_2')
		//'BOXAD_2' => AdEngine::getInstance()->getAd('HOME_TOP_LEADERBOARD') // for dev testing
		);

		$athenaInitStuff = AdProviderAthena::getInstance()->getSetupHtml();
		$athenaInitStuff .= AdEngine::getInstance()->providerValuesAsJavascript($wgCityId);

		$oTmpl->set_vars(
				array(
					'url' => $url,
					'css' => $css,
					'athenaInitStuff' => $athenaInitStuff,
					'redirectDelay' => ( $noAutoRedirect ? 0 : $this->redirectDelay ),
					'imagesPath' => $wgExtensionsPath . '/wikia/OutboundScreen/images',
					'adSlots' => $adSlots
				)
		);

		// just output content of template
		$wgOut->clearHTML();
		$wgOut->addHTML( $oTmpl->execute('page') );
	}
}
