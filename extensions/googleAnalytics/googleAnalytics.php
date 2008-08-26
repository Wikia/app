<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$wgExtensionCredits['other'][] = array(
	'name'           => 'Google Analytics Integration',
	'version'        => '2.0.1',
	'author'         => 'Tim Laqua',
	'description'    => 'Inserts Google Analytics script (ga.js) in to MediaWiki pages for tracking.',
	'descriptionurl' => 'googleanalytics-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Google_Analytics_Integration',
);

$wgExtensionMessagesFiles['googleAnalytics'] = dirname(__FILE__) . '/googleAnalytics.i18n.php';

$wgHooks['SkinAfterBottomScripts'][]  = 'efGoogleAnalyticsHookText';

$wgGoogleAnalyticsAccount = "";
$wgGoogleAnalyticsIgnoreSysops = true;
$wgGoogleAnalyticsIgnoreBots = true;

function efGoogleAnalyticsHookText(&$skin, &$text='') {
	$text .= efAddGoogleAnalytics();
	return true;
}

function efAddGoogleAnalytics() {
	global $wgGoogleAnalyticsAccount, $wgGoogleAnalyticsIgnoreSysops, $wgGoogleAnalyticsIgnoreBots, $wgUser;
	if (!$wgUser->isAllowed('bot') || !$wgGoogleAnalyticsIgnoreBots) {
		if (!$wgUser->isAllowed('protect') || !$wgGoogleAnalyticsIgnoreSysops) {
			if ( !empty($wgGoogleAnalyticsAccount) ) {
				$funcOutput = <<<GASCRIPT
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("{$wgGoogleAnalyticsAccount}");
pageTracker._initData();
pageTracker._trackPageview();
</script>
GASCRIPT;
			} else {
				$funcOutput = "\n<!-- Set \$wgGoogleAnalyticsAccount to your account # provided by Google Analytics. -->";
			}
		} else {
			$funcOutput = "\n<!-- Google Analytics tracking is disabled for users with 'protect' rights (I.E. sysops) -->";
		}
	} else {
		$funcOutput = "\n<!-- Google Analytics tracking is disabled for bots -->";
	}

	return $funcOutput;
}

///Alias for efAddGoogleAnalytics - backwards compatibility.
function addGoogleAnalytics() { return efAddGoogleAnalytics(); }
