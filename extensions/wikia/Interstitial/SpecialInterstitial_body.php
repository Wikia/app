<?php

/**
 * @author Sean Colombo
 *
 * Special page which shows an actual interstital before sending the user on their way.
 *
 * TODO: Now that we're using Athena ad-code to the EXIT-STITIAL, these two classes might be able to be combined even more.
 */
class Interstitial extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( INTERSTITIALS_SP /*class*/ );
		wfLoadExtensionMessages( INTERSTITIALS_SP ); // Load internationalization messages
	}
	
	/**
	 * Returns the HTML for importing the CSS needed to make interstitials/exitstitials look right.
	 * The results of this function should be displayed inside of the <head> tag.
	 */
	static public function getCss(){
		global $wgUser, $wgOut, $wgExtensionsPath, $wgStyleVersion;
		$css = "";

		$skin = $wgUser->getSkin();
		$skinName = get_class($skin);
		
		// this may not be set yet (and needs to be before setupUserCss in order for the right CSS file to be included)
		if ($skin->getSkinName() == '') {
			$skin->skinname = substr($skinName, 4);
		}

		//load this for all skins, even non-monaco.
		//exit page depends on having a .color1 and .color2 defined.
		//needs to be before call to setupUserCss so that other css can override
		$wgOut->addStyle('monaco/css/root.css');

		// add MW CSS
		$skin->setupUserCss($wgOut);

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

		$css = $StaticChute->getChuteHtmlForPackage('monaco_css') . "\n\t\t";
		$css .= $wgOut->buildCssLinks();

		return $css;
	}

	function execute(){
		global $wgRequest, $wgOut;
		global $wgAdsInterstitialsEnabled;
		global $wgUser, $wgCityId;

		$url = trim($wgRequest->getVal( 'u' ));
		$noAutoRedirect = ( $wgRequest->getText( 'noredirect' ) == 1 ) ? true : false;
		
		if(($wgAdsInterstitialsEnabled) && (!$wgUser->isLoggedIn())){
			global $wgExtensionsPath;
			wfLoadExtensionMessages(INTERSTITIALS_SP);

			$COOKIE_KEY = "IntPgCounter";
			$pageCounter = (isset($_COOKIE[$COOKIE_KEY])?$_COOKIE[$COOKIE_KEY]:0);

			// By incrementing the count even for interstitials, we can know when to avoid repeated interstitials for tabbed-browsing.
			// In the calculations for when to display the interstitial, however, this is not considered a "page" (we add 1 to wgAdsInterstitialsPagesBetweenAds to accomplish this).
			global $wgCookiePath, $wgCookieDomain;
			setcookie($COOKIE_KEY, $pageCounter + 1, 0, $wgCookiePath, $wgCookieDomain);

			// If the user shouldn't be seeing an interstitial on this pv, then assume that we are only here because of the user opening many tabs and just redirect to destination right away.
			global $wgAdsInterstitialsPagesBeforeFirstAd;
			global $wgAdsInterstitialsPagesBetweenAds;
			$numToSkip = 2; // skip the interstitial and the page it was blocking as candidates
			if(($url != "") &&
				(!(	($wgAdsInterstitialsPagesBeforeFirstAd == $pageCounter - 1) ||
					(($pageCounter > $wgAdsInterstitialsPagesBeforeFirstAd) && ((($pageCounter - $wgAdsInterstitialsPagesBeforeFirstAd -1) % ($wgAdsInterstitialsPagesBetweenAds+$numToSkip)) == 0)))
				)
			){
				return $this->redirectTo($url);
			}

			$redirectDelay = (empty($wgAdsInterstitialsDurationInSeconds)?INTERSTITIAL_DEFAULT_DURATION_IN_SECONDS:$wgAdsInterstitialsDurationInSeconds);

			// Set up the CSS
			$wgOut->setArticleBodyOnly(true);

			$skin = $wgUser->getSkin();
			$skinName = get_class($skin);
			
			// this may not be set yet (and needs to be before setupUserCss in order for the right CSS file to be included)
			if ($skin->getSkinName() == '') {
				$skin->skinname = substr($skinName, 4);
			}
			
			if ($skinName == 'SkinMonaco') {
				$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

				$adSlots = array(
					'INVISIBLE' => '&nbsp;',
					'BOXAD_1' => AdEngine::getInstance()->getAd('SPECIAL_INTERSTITIAL_BOXAD_1'),
					'BOXAD_2' => '&nbsp;'
				);

				$oTmpl->set_vars(
					array(
							'adSlots' => $adSlots
					)
				);

				$adTemplate = 'adLayoutClassic';

				$athenaInitStuff = AdProviderAthena::getInstance()->getSetupHtml();
				$athenaInitStuff .= AdEngine::getInstance()->providerValuesAsJavascript($wgCityId);

				// Create the JS-includes for the tracking code and jQuery - will just use StaticChute because it should be in user's cache by now.
				$adCode = $oTmpl->execute($adTemplate);
				$StaticChute = new StaticChute('js');
				$StaticChute->useLocalChuteUrl();
				$package = 'monaco_anon_article_js';
				$jsIncludes = $StaticChute->getChuteHtmlForPackage($package);
				$jsGlobals = Skin::makeGlobalVariablesScript( array('skinname' => $skinName) );
				$oTmpl->set_vars(
					array(
						'adCode' => $adCode,
						'athenaInitStuff' => $athenaInitStuff,
						'css' => Interstitial::getCss(),
						'jsGlobals' => $jsGlobals,
						'jsIncludes' => $jsIncludes,
						'pageType' => 'interstitial',
						'redirectDelay' => ( $noAutoRedirect ? 0 : $this->redirectDelay ),
						'skip' => wfMsg('interstitial-skip-ad'),
						'url' => $url,
					)
				);

				$wgOut->clearHTML();
				$wgOut->addHTML( $oTmpl->execute( 'page' ) );
			} else {
				return $this->redirectTo($url);
			}
		} else if($url == ""){
			// Nowhere to go.  Display an appropriate explanation (either wgAdsInterstitialsEnabled is false or the user is logged in).
			if($wgUser->isLoggedIn()){
				$wgOut->addWikiText( wfMsg('interstitial-already-logged-in-no-link') . wfMsg('interstitial-link-away') );
			} else {
				$wgOut->addWikiText( wfMsg('interstitial-disabled-no-link') . wfMsg('interstitial-link-away') );
			}
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
