<?php

/**
 * @author Sean Colombo
 *
 * Special page which shows an actual interstital before sending the user on their way.
 *
 * TODO: What if the user has hit the page-before-interstitial limit, then opens a bunch of pages in tabs.  The Interstitial page itself should check that it
 * has been hit on the correct page view number before displaying so that it only displays on the 1/y of those pages.
 */
class Interstitial extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( INTERSTITIALS_SP /*class*/ );
		wfLoadExtensionMessages( INTERSTITIALS_SP ); // Load internationalization messages
	}

	function execute(){
		global $wgRequest, $wgOut;
		global $wgAdsInterstitialsEnabled;
		global $wgUser;

		$url = $wgRequest->getVal( 'u' );

		if(($wgAdsInterstitialsEnabled) && (!$wgUser->isLoggedIn())){
			global $wgAdsInterstitialsCampaignCode, $wgExtensionsPath, $wgStyleVersion;
			wfLoadExtensionMessages(INTERSTITIALS_SP);

			$redirectDelay = (empty($wgAdsInterstitialsDurationInSeconds)?INTERSTITIAL_DEFAULT_DURATION_IN_SECONDS:$wgAdsInterstitialsDurationInSeconds);
			$code = (empty($wgAdsInterstitialsCampaignCode)?wfMsg('interstitial-default-campaign-code'):$wgAdsInterstitialsCampaignCode);
			$skip = wfMsg('interstitial-skip-ad');

			// Set up the CSS
			$wgOut->setArticleBodyOnly(true);

			$skin = $wgUser->getSkin();
			$skinName = get_class($skin);

			//load this for all skins, even non-monaco.
			//exit page depends on having a .color1 and .color2 defined.
			//needs to be before call to setupUserCss so that other css can override
			$wgOut->addStyle('monaco/css/root.css');

			// add MW CSS
			$skin->setupUserCss($wgOut);

			// this may not be set yet
			if ($skin->getSkinName() == '') {
				$skin->skinname = substr($skinName, 4);
			}
			if ($skinName == 'SkinMonaco') {
				$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

				// Run this so that the correct CSS files can be set up (we need StaticChute).
				$tpl = $skin->setupTemplate( 'MonacoTemplate', 'skins' );
				if( !wfRunHooks( 'SkinTemplateOutputPageBeforeExec', array( &$skin, &$tpl ) ) ) {
					wfDebug( __METHOD__ . ": Hook SkinTemplateOutputPageBeforeExec broke outputPage execution!\n" );
				}

				global $wgAllInOne;
				$wgAllInOne = true;
				$StaticChute = new StaticChute('css');
				$StaticChute->useLocalChuteUrl();

				// Monaco themes
				if ($skinName == 'SkinMonaco' && !empty($skin->themename)) {
					switch($skin->themename) {
						case 'custom':
							//custom skin is included via setupUserCss
							//which is ontop of root base, included above that
							break;

						case 'sapphire':
							//is just root on its own, included above
							break;

						default:
							//themes layer ontop of root
							$wgOut->addStyle('monaco/' . $skin->themename . '/css/main.css');
							$StaticChute->setTheme($skin->themename);
							break;
					}
				}
				$wgOut->addStyle( "$wgExtensionsPath/wikia/Interstitial/Interstitial.css?$wgStyleVersion" );
				
				$css = $StaticChute->getChuteHtmlForPackage('monaco_css');
				$css .= $wgOut->buildCssLinks();

				
				


	// TODO: REMOVE THIS!!! JUST FOR TESTING
	$redirectDelay = 120;

				$oTmpl->set_vars(
						array(
							'url' => $url,
							'code' => $code,
							'skip' => $skip,
							'css' => $css,
							'redirectDelay' => $redirectDelay,
				//			'athenaInitStuff' => $athenaInitStuff,
				//			'imagesPath' => $wgExtensionsPath . '/wikia/OutboundScreen/images',
				//			'userloginTitle' => Title::newFromText( 'Special:Userlogin' ),
				//			'adLayout' => $oTmpl->execute($adTemplate)
						)
				);

				$wgOut->clearHTML();
				$wgOut->addHTML( $oTmpl->execute( 'page' ) );
			} else {
				return $this->redirectTo($url);
			}
		} else if(trim($url) == ""){

			// TODO: Nowhere to go.  Display an appropriate explanation (either wgAdsInterstitialsEnabled is false or the user is logged in).

		} else {
			// Since interstitials aren't enabled or the user is logged in, just redirect to the destination URL immediately.
			return $this->redirectTo($url);
		}
	}

	private function redirectTo($url){
		global $wgOut;
		$wgOut->redirect( htmlspecialchars_decode( $url ) );
		return true;
	}
}
