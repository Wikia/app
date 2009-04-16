<?php
/**
 * AdsInContent Extension - Displays ad boxes inside article content
 *
 * @author Maciej Brencz <macbre(at)no-spam-wikia.com>
 * @author Adrian Wieczorek <adi(at)wikia.com>
 *
 */

if(!defined('MEDIAWIKI')) {
	echo("This file is an extension to the MediaWiki software and cannot be used standalone.\n");
	die();
}

$wgExtensionCredits['other'][] = array(
	'name' => 'AdsInContent',
	'author' => array('[http://www.wikia.com/wiki/User:Macbre Maciej Brencz]', '[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek]'),
	'description' => 'Displays ad boxes inside article content',
	'version' => 1.1
);

$wgAdsInContentExtensionConfig = array(
	'topAdUnit' => false,
	'bottomAdUnit' => false,
	'insideAdUnit' => array( /* secttions range => array of section numbers */
		'3-7' => array(2,5),
		'8-*' => array(2,5,8),
//		'9-*' => array(3,6,8)
	),
	'insideAdUnitConfig' => array(
 		'google'     => array(
			0 => array(
				'width' => 200,
				'height' => 200,
				'align' => 'left',
				'float' => true,
//				'googleAdChannel' => '9100000016') // 012
				'googleAdChannel' => 'INCONTENT_BOXAD')
 																	),
	),
	'limit' => array(
		'google' => 4,
	)
);

$wgExtensionFunctions[] = 'wfAdsInContentSetup';


/**
 * AdsInContent Extension setup function
 */
function wfAdsInContentSetup() {
	global $wgAutoloadClasses, $wgHooks;

	$wgAutoloadClasses['AdsInContent'] = dirname(__FILE__) . '/AdsInContent_body.php';
	$wgHooks['OutputPageBeforeHTML'][] = 'wfAdsInContentHook';
}

/**
 * AdsInContent Extenssion hook handler
 */
function wfAdsInContentHook(&$out, &$text) {
	global $wgAdsInContentExtensionConfig, $wgTitle, $wgUser, $wgHooks, $wgOut;

	$loggedIn = $wgUser->isLoggedIn();
	$ns = $wgTitle->getNamespace();

	// show only for anon user in the main namespace (if article exists)
	if( ($ns == NS_MAIN) && !$loggedIn && $wgTitle->exists() && !AdsInContent::isMainPage()) {
		$wgHooks['SkinAfterBottomScripts'][] = 'AdsInContent::applyTopSectionJSFix';
		$wgOut->addHtml(
'<script type="text/javascript" src="http://partner.googleadservices.com/gampad/google_service.js">
</script>
<script type="text/javascript">
  GS_googleAddAdSenseService("ca-pub-4086838842346968");
  GS_googleEnableAllServices();
</script>
<script type="text/javascript">
  GA_googleAddSlot("ca-pub-4086838842346968", "INCONTENT_BOXAD");
  GA_googleAddAdSensePageAttr("google_ad_channel", "4974569436");
</script>
<script type="text/javascript">
  GA_googleFetchAds();
</script>'
		);

		$adsInContent = new AdsInContent($text, $wgAdsInContentExtensionConfig);
		$adsInContent->execute();
	}
	return true;
}
