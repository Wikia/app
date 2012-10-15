<?php
/**
 * Inserts Piwik script into MediaWiki pages for tracking and adds some stats
 *
 * @file
 * @ingroup Extensions
 * @author Isb1009 <isb1009 at gmail dot com>
 * @copyright © 2008-2010 Isb1009
 * @licence GNU General Public Licence 2.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Piwik Integration',
	'version'        => '1.5.2-piwik0.5.5',
	'author'         => 'Isb1009',
	'descriptionmsg' => 'piwik-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Piwik_Integration',
);

$wgHooks['SkinAfterBottomScripts'][]  = 'efPiwikHookText';

$wgPiwikIDSite = "";
$wgPiwikURL = "";
$wgPiwikIgnoreSysops = true;
$wgPiwikIgnoreBots = true;
$wgPiwikCustomJS = "";
$wgPiwikUsePageTitle = false;
$wgPiwikActionName = "";
$wgPiwikSpecialPageDate = 'yesterday';

function efPiwikHookText( $skin, &$text = '' ) {
	$text .= efAddPiwik( $skin->getTitle() );
	return true;
}

function efAddPiwik( $title ) {
	global $wgPiwikIDSite, $wgPiwikURL, $wgPiwikIgnoreSysops, $wgPiwikIgnoreBots, $wgUser, $wgScriptPath, $wgPiwikCustomJS, $wgPiwikActionName, $wgPiwikUsePageTitle;
	if ( !$wgUser->isAllowed( 'bot' ) || !$wgPiwikIgnoreBots ) {
		if ( !$wgUser->isAllowed( 'protect' ) || !$wgPiwikIgnoreSysops ) {
			if ( !empty( $wgPiwikIDSite ) AND !empty( $wgPiwikURL ) ) {
				if ( $wgPiwikUsePageTitle ) {
					$wgPiwikPageTitle = $title->getPrefixedText();

					$wgPiwikFinalActionName = $wgPiwikActionName;
					$wgPiwikFinalActionName .= $wgPiwikPageTitle;
				} else {
					$wgPiwikFinalActionName = $wgPiwikActionName;
				}
				// Stop xss since page title's can have " and stuff in them.
				$wgPiwikFinalActionName = Xml::encodeJsVar( $wgPiwikFinalActionName );
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
piwikTracker.setDocumentTitle({$wgPiwikFinalActionName});
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
$wgExtensionMessagesFiles['PiwikAlias'] = $dir . 'Piwik.alias.php';
$wgSpecialPages['Piwik'] = 'Piwik'; # Let MediaWiki know about your new special page.
