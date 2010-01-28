<?php
/**
 * Interstitials - allows interstitial ads for each wiki which work according
 * to WikiFactory variables.
 *
 * @author Sean Colombo (forgive me)
 */

$wgExtensionMessagesFiles['Interstitials'] = dirname(__FILE__) . '/Interstitials.i18n.php';
$wgHooks['BeforePageDisplay'][] = 'installInterstitials';
$wgHooks['MakeGlobalVariablesScript'][] = 'interstitialsJsGlobalVariables';

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

	$vars['wgCookieDomain'] = $wgCookieDomain;
	$vars['wgCookiePath'] = $wgCookiePath;

	$vars['wgAdsInterstitialsEnabled'] = $wgAdsInterstitialsEnabled;
	$vars['wgAdsInterstitialsPagesBeforeFirstAd'] = (empty($wgAdsInterstitialsPagesBeforeFirstAd)?INTERSTITIAL_DEFAULT_PAGES_BEFORE_FIRST_AD:$wgAdsInterstitialsPagesBeforeFirstAd);
	$vars['wgAdsInterstitialsPagesBetweenAds'] = (empty($wgAdsInterstitialsPagesBetweenAds)?INTERSTITIAL_DEFAULT_PAGES_BETWEEN_ADS:$wgAdsInterstitialsPagesBetweenAds);
	$vars['wgAdsInterstitialsDurationInSeconds'] = (empty($wgAdsInterstitialsDurationInSeconds)?INTERSTITIAL_DEFAULT_DURATION_IN_SECONDS:$wgAdsInterstitialsDurationInSeconds);
	return true;
} // end interstitialsJsGlobalVariables()

/**
 * Hooks into 'BeforePageDisplay' to cram the interstitial code
 * in if needed.
 */
function installInterstitials( &$out, &$sk ){
	global $wgAdsInterstitialsEnabled;
	if($wgAdsInterstitialsEnabled){
		global $wgExtensionsPath, $wgStyleVersion;
		wfLoadExtensionMessages('Interstitials');

		$out->addStyle( "$wgExtensionsPath/wikia/Interstitials/Interstitials.css?$wgStyleVersion" );
	}

	return true;
} // end installInterstitials()

/**
 * Returns a string containing the HTML for the interstitial div. It will
 * be display:none by default and should be shown any time that wgAdsInterstitialsEnabled
 * is set to true.  Whether or not the interstitial shows up will be controlled by javascript.
 */
function interstitialHtml(){
	global $wgAdsInterstitialsEnabled;
	$html = "";
	if($wgAdsInterstitialsEnabled){
		global $wgAdsInterstitialsCampaignCode;
		wfLoadExtensionMessages('Interstitials');

		$code = (empty($wgAdsInterstitialsCampaignCode)?wfMsg('interstitial-default-campaign-code'):$wgAdsInterstitialsCampaignCode);
		$skip = wfMsg('interstitial-skip-ad');
		$html = <<<CHUNK
				<div id="interstitial_foreground" class="interstitial_foreground">
					$code
					<a href = "javascript:void(0)" onclick = "document.getElementById('interstitial_foreground').style.display='none';document.getElementById('interstitial_background').style.display='none'">$skip</a>
				</div>
				<div id="interstitial_background" class="interstitial_background"></div>
CHUNK;
	}
	return $html;
} // end interstitialHtml()

?>
