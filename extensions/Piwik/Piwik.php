<?php
/**
 * Inserts Piwik script into MediaWiki pages for tracking and adds some stats
 *
 * @addtogroup Extensions
 * @author Isb1009 <isb1009 at gmail dot com>
 * @copyright © 2008 Isb1009
 * @licence GNU General Public Licence 2.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Piwik Integration',
	'version'        => '1.5.1-piwik0.4.3',
	'author'         => 'Isb1009',
	'description'    => 'Inserts Piwik script into MediaWiki pages for tracking and adds [[Special:Piwik|some stats]]. Based on Google Analytics Integration by Tim Laqua.',
	'descriptionmsg' => 'piwik-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Piwik_Integration',
);

$wgHooks['SkinAfterBottomScripts'][]  = 'efPiwikHookText';

$wgPiwikIDSite = "";
$wgPiwikURL = "";
$wgPiwikIgnoreSysops = true;
$wgPiwikIgnoreBots = true;
$wgPiwikCustomJS = "";
$wgPiwikUsePageTitle = false;
$wgPiwikActionName = "";

function efPiwikHookText( $skin, &$text = '' ) {
	$text .= efAddPiwik();
	return true;
}

function efAddPiwik() {
	global $wgPiwikIDSite, $wgPiwikURL, $wgPiwikIgnoreSysops, $wgPiwikIgnoreBots, $wgUser, $wgScriptPath, $wgPiwikCustomJS, $wgPiwikActionName, $wgTitle, $wgPiwikUsePageTitle;
	if ( !$wgUser->isAllowed( 'bot' ) || !$wgPiwikIgnoreBots ) {
		if ( !$wgUser->isAllowed( 'protect' ) || !$wgPiwikIgnoreSysops ) {
			if ( !empty( $wgPiwikIDSite ) AND !empty( $wgPiwikURL ) ) {
				if ( $wgPiwikUsePageTitle == true ) {
					$wgPiwikPageTitle = $wgTitle->getPrefixedText();

					$wgPiwikFinalActionName = $wgPiwikActionName;
					$wgPiwikFinalActionName .= $wgPiwikPageTitle;
				} else {
					$wgPiwikFinalActionName = $wgPiwikActionName;
				}
				$funcOutput = <<<PIWIK
<!-- Piwik -->
<script type="text/javascript">
/* <![CDATA[ */
var pkBaseURL = (("https:" == document.location.protocol) ? "https://{$wgPiwikURL}" : "http://{$wgPiwikURL}");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
/* ]]> */
</script>
<script type="text/javascript">
/* <![CDATA[ */
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", {$wgPiwikIDSite});
piwikTracker.setDocumentTitle("{$wgPiwikFinalActionName}");
piwikTracker.setIgnoreClasses("image");
{$wgPiwikCustomJS}
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
/* ]]> */
</script><noscript><p><img src="http://{$wgPiwikURL}piwik.php?idsite={$wgPiwikIDSite}" style="border:0" alt=""/></p></noscript>
<!-- /Piwik -->
PIWIK;
			} else {
				$funcOutput = "\n<!-- You need to set the settings for Piwik -->";
			}
		} else {
			$funcOutput = "\n<!-- Piwik tracking is disabled for users with 'protect' rights (i.e., sysops) -->";
		}
	} else {
		$funcOutput = "\n<!-- Piwik tracking is disabled for bots -->";
	}

	return $funcOutput;
}

$wgGroupPermissions['sysop']['viewpiwik'] = true; # Which users can see the special page?
$wgAvailableRights[] = 'viewpiwik';

$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['Piwik'] = $dir . 'Piwik_specialpage.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['Piwik'] = $dir . 'Piwik.i18n.php';
$wgExtensionAliasesFiles['Piwik'] = $dir . 'Piwik.alias.php';
$wgSpecialPages['Piwik'] = 'Piwik'; # Let MediaWiki know about your new special page.

// /Alias for efAddPiwik - backwards compatibility.
function addPiwik() { return efAddPiwik(); }
