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
	}

	function execute($par){
		global $wgRequest, $wgOut;
		global $wgAdsInterstitialsEnabled;
		global $wgUser;

		$url = trim($wgRequest->getVal( 'u' ));
		$noAutoRedirect = ( $wgRequest->getText( 'noredirect' ) == 1 ) ? true : false;

		if(($wgAdsInterstitialsEnabled) && (!$wgUser->isLoggedIn())){

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

			$skin = RequestContext::getMain()->getSkin();
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

				$adCode = $oTmpl->render($adTemplate);
				$oTmpl->set_vars(
					array(
						'adCode' => $adCode,
						'athenaInitStuff' => $athenaInitStuff,
						'pageType' => 'interstitial',
						'redirectDelay' => ( $noAutoRedirect ? 0 : $this->redirectDelay ),
						'skip' => wfMsg('interstitial-skip-ad'),
						'url' => $url,
					)
				);

				$wgOut->clearHTML();
				$wgOut->addHTML( $oTmpl->render( 'page' ) );
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
