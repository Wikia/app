<?php
/**
 * Interstitials - allows interstitial ads for each wiki which work according
 * to WikiFactory variables.
 *
 * @author Sean Colombo (forgive me)
 */

$wgHooks['MakeGlobalVariablesScript'][] = 'interstitialsJsGlobalVariables';

define('INTERSTITIALS_SP', 'Interstitial'); // name of the Special Page and associated resources
$wgExtensionMessagesFiles[INTERSTITIALS_SP] = dirname(__FILE__) . '/Interstitial.i18n.php';
$wgSpecialPages[INTERSTITIALS_SP] = INTERSTITIALS_SP;
$wgAutoloadClasses['Interstitial'] = dirname( __FILE__ ) . '/SpecialInterstitial_body.php';

define('INTERSTITIAL_DEFAULT_PAGES_BEFORE_FIRST_AD', 5);
define('INTERSTITIAL_DEFAULT_PAGES_BETWEEN_ADS', 8);
define('INTERSTITIAL_DEFAULT_DURATION_IN_SECONDS', 10);

/**
 * Adds the WikiFactory settings for interstitials into the global JS.
 * @return true to allow subsequent functions for same hook to run.
 */
function interstitialsJsGlobalVariables(&$vars){
	global $wgCookieDomain, $wgCookiePath;
	global $wgAdsInterstitialsEnabled, $wgAdsInterstitialsPagesBeforeFirstAd, $wgAdsInterstitialsPagesBetweenAds;
	global $wgAdsInterstitialsDurationInSeconds;
	global $wgAdsInterstitialsCampaignCode;

	wfLoadExtensionMessages(INTERSTITIALS_SP);

	$vars['wgCookieDomain'] = $wgCookieDomain;
	$vars['wgCookiePath'] = $wgCookiePath;
	$vars['wgAdsInterstitialsEnabled'] = $wgAdsInterstitialsEnabled;
	$vars['wgAdsInterstitialsPagesBeforeFirstAd'] = (empty($wgAdsInterstitialsPagesBeforeFirstAd)?INTERSTITIAL_DEFAULT_PAGES_BEFORE_FIRST_AD:$wgAdsInterstitialsPagesBeforeFirstAd);
	$vars['wgAdsInterstitialsPagesBetweenAds'] = (empty($wgAdsInterstitialsPagesBetweenAds)?INTERSTITIAL_DEFAULT_PAGES_BETWEEN_ADS:$wgAdsInterstitialsPagesBetweenAds);
// TODO: FIXME: CLEAN UP THIS WHOLE METHOD TO ONLY OUTPUT THE VARS THAT WILL BE NEEDED WITH THE NEW METHODOLOGY.
//	$vars['wgAdsInterstitialsDurationInSeconds'] = (empty($wgAdsInterstitialsDurationInSeconds)?INTERSTITIAL_DEFAULT_DURATION_IN_SECONDS:$wgAdsInterstitialsDurationInSeconds);
	$vars['wgMsgInterstitialSkipAd'] = wfMsg('interstitial-skip-ad');

	$code = (empty($wgAdsInterstitialsCampaignCode)?wfMsg('interstitial-default-campaign-code'):$wgAdsInterstitialsCampaignCode);
	$vars['wgAdsInterstitialsCampaignCode'] = $code;

	global $wgScriptPath;
	$special = SpecialPage::getTitleFor( INTERSTITIALS_SP );
	$vars['wgInterstitialPath'] = $special->getFullUrl("u=");
	return true;
} // end interstitialsJsGlobalVariables()

/**
 * Returns a string containing the HTML for the interstitial div. It will
 * be display:none by default and should be shown any time that wgAdsInterstitialsEnabled
 * is set to true.  Whether or not the interstitial shows up will be controlled by javascript.
 *
 * TODO: MOVE THIS TO A TEMPLATE FOR SpecialInterstitials_body TO CALL!
 */
function interstitialHtml(){
	global $wgAdsInterstitialsEnabled;
	$html = "";
	if($wgAdsInterstitialsEnabled){
		global $wgAdsInterstitialsCampaignCode;
		wfLoadExtensionMessages(INTERSTITIALS_SP);

		$code = (empty($wgAdsInterstitialsCampaignCode)?wfMsg('interstitial-default-campaign-code'):$wgAdsInterstitialsCampaignCode);
		$skip = wfMsg('interstitial-skip-ad');
		// FIXME: If there is any way to do the same styling gracefully without using repeated IDs from the main part of the page, that would be much preferable.
		$html = <<<CHUNK
			<div id="interstitial_fg" class="interstitial_fg">
				<div class='interstitial_fg_top color1'>
					<a href = "javascript:void(0)" class='wikia_button' onclick = "document.getElementById('interstitial_fg').style.display='none';document.getElementById('interstitial_bg').style.display='none'"><span>$skip</span></a>
				</div>
				<div class='interstitial_fg_body'>
					$code
				</div>
			</div>
			<div id="interstitial_bg" class="interstitial_bg">
				<div class='interstitial_bg_top color2'>
					<div id="wikia_header">
						<div class="monaco_shinkwrap">
							<div id="wikiaBranding">
								<div id="wikia_logo">Wikia</div>
							</div>
						</div>
					</div>
				</div>
				<div id='background_strip' class='interstitial_bg_middle'>
					&nbsp;
				</div>
				<div class='color2 interstitial_bg_bottom'>
					&nbsp;
				</div>
			</div>
CHUNK;
	}
	return $html;
} // end interstitialHtml()

?>
