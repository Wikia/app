<?php
/**
 * Interstitials - allows interstitial ads for each wiki which work according
 * to WikiFactory variables.
 *
 * @author Sean Colombo (forgive me)
 * @author Bernhard Schmidt (remember me)
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
	global $wgOut, $wgStylePath, $wgSitename;
	
	$wgOut->addScript('<script src="'. $wgStylePath .'/oasis/js/Exitstitial.js"></script>'); // @TODO move to StaticChute.
	
	wfLoadExtensionMessages(INTERSTITIALS_SP);
	
	$vars['wgExitstitialTitle'] =  wfMsg('exitstitial-title') .$wgSitename;
	$vars['wgExitstitialRegister'] = wfMsg('exitstitial-register');
	$vars['wgExitstitialButton'] = wfMsg('exitstitial-button');
	
	$vars['wgCookieDomain'] = $wgCookieDomain;
	$vars['wgCookiePath'] = $wgCookiePath;
	$vars['wgAdsInterstitialsEnabled'] = $wgAdsInterstitialsEnabled;
	$vars['wgAdsInterstitialsPagesBeforeFirstAd'] = (empty($wgAdsInterstitialsPagesBeforeFirstAd)?INTERSTITIAL_DEFAULT_PAGES_BEFORE_FIRST_AD:$wgAdsInterstitialsPagesBeforeFirstAd);
	$vars['wgAdsInterstitialsPagesBetweenAds'] = (empty($wgAdsInterstitialsPagesBetweenAds)?INTERSTITIAL_DEFAULT_PAGES_BETWEEN_ADS:$wgAdsInterstitialsPagesBetweenAds);
	
	global $wgScriptPath;
	$special = SpecialPage::getTitleFor( INTERSTITIALS_SP );
	$vars['wgInterstitialPath'] = $special->getFullUrl("u=");
	return true;
} // end interstitialsJsGlobalVariables()

?>
