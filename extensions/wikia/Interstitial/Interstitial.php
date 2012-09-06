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

$wgHooks['BeforePageDisplay'][] = 'interstitialAddJs';

define('INTERSTITIAL_DEFAULT_PAGES_BEFORE_FIRST_AD', 5);
define('INTERSTITIAL_DEFAULT_PAGES_BETWEEN_ADS', 8);
define('INTERSTITIAL_DEFAULT_DURATION_IN_SECONDS', 10);

/**
 * If interstitials are enabled, add the JS for them.
 */
function interstitialAddJs( OutputPage $out, Skin $sk ){
	global $wgAdsInterstitialsEnabled;

	if (!empty($wgAdsInterstitialsEnabled)) {
		global $wgJsMimeType, $wgExtensionsPath;
		$out->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/Interstitial/Interstitial.js\" ></script>\n");
	}

	return true;
} // end interstitialAddJs()

/**
 * Adds the WikiFactory settings for interstitials into the global JS.
 * @param array $vars
 * @return boolean to allow subsequent functions for same hook to run.
 */
function interstitialsJsGlobalVariables(Array &$vars){
	global $wgAdsInterstitialsEnabled, $wgAdsInterstitialsPagesBeforeFirstAd, $wgAdsInterstitialsPagesBetweenAds, $wgEnableOutboundScreenExt;

	// TODO: load the following on-demand

	// only emit when needed (BugId:20558)
	if (!empty($wgAdsInterstitialsEnabled)) {
		$vars['wgAdsInterstitialsEnabled'] = $wgAdsInterstitialsEnabled;
		$vars['wgAdsInterstitialsPagesBeforeFirstAd'] = (empty($wgAdsInterstitialsPagesBeforeFirstAd)?INTERSTITIAL_DEFAULT_PAGES_BEFORE_FIRST_AD:$wgAdsInterstitialsPagesBeforeFirstAd);
		$vars['wgAdsInterstitialsPagesBetweenAds'] = (empty($wgAdsInterstitialsPagesBetweenAds)?INTERSTITIAL_DEFAULT_PAGES_BETWEEN_ADS:$wgAdsInterstitialsPagesBetweenAds);
	}

	// existitial related variables
	global $wgSitename, $wgTitle;
	$vars['ExitstitialOutboundScreen'] = SpecialPage::getTitleFor('Outbound')->getLocalURL('f='.urlencode($wgTitle->getPrefixedDBkey()));
	$vars['wgExitstitialTitle'] =  wfMsg('exitstitial-title') .$wgSitename;
	$vars['wgExitstitialRegister'] = wfMsg('exitstitial-register');
	$vars['wgExitstitialButton'] = wfMsg('exitstitial-button');

	$special = SpecialPage::getTitleFor( INTERSTITIALS_SP );
	$vars['wgInterstitialPath'] = $special->getFullUrl("u=");

	return true;
} // end interstitialsJsGlobalVariables()
