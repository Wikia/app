<?php
/**
 * Parser hook extension to add a <randomimage> tag
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
	'name'           => 'Piwik Integration',
	'version'        => '0.2.5rev0.7.5 (1.0-RC1)',
	'svn-date'       => '$LastChangedDate: 2008-07-07 17:06:18 +0000 (Mon, 07 Jul 2008) $',
	'svn-revision'   => '$LastChangedRevision: 37267 $',
	'author'         => 'Isb1009',
	'description'    => 'Inserts Piwik script into MediaWiki pages for tracking and adds [[Special:Piwik|some stats]]. Based on Google Analytics Integration by Tim Laqua.',
	'descriptionurl' => 'piwik-desc',
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

function efPiwikHookText(&$skin, &$text='') {
	$text .= efAddPiwik();
	return true;
}

function efAddPiwik() {
	global $wgPiwikIDSite, $wgPiwikURL, $wgPiwikIgnoreSysops, $wgPiwikIgnoreBots, $wgUser, $wgScriptPath, $wgPiwikCustomJS, $wgPiwikActionName, $wgTitle, $wgPiwikUsePageTitle;
	if (!$wgUser->isAllowed('bot') || !$wgPiwikIgnoreBots) {
		if (!$wgUser->isAllowed('protect') || !$wgPiwikIgnoreSysops) {
			if ( !empty($wgPiwikIDSite) AND !empty($wgPiwikURL)) {
if ($wgPiwikUsePageTitle == true ) {
$wgPiwikPageTitle = $wgTitle->getPrefixedText();

$wgPiwikFinalActionName = $wgPiwikActionName;
$wgPiwikFinalActionName .= $wgPiwikPageTitle;
} else {
$wgPiwikFinalActionName = $wgPiwikActionName;
}
				$funcOutput = <<<PIWIK
<!-- Piwik -->
<a href="http://piwik.org" title="Web analytics" onclick="window.open(this.href);return(false);">
<script language="javascript" src="{$wgScriptPath}/extensions/piwik/piwik-mw.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
piwik_action_name = '{$wgPiwikFinalActionName}';
piwik_idsite = {$wgPiwikIDSite};
piwik_url = '{$wgPiwikURL}piwik.php';
piwik_log(piwik_action_name, piwik_idsite, piwik_url);
{$wgPiwikCustomJS}
//-->
</script><object>
<noscript><p>Web analytics <img src="{$wgPiwikURL}/piwik.php" style="border:0" alt="piwik"/></p>
</noscript></object></a>
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
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['Piwik'] = $dir . 'Piwik_specialpage.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['Piwik'] = $dir . 'Piwik.i18n.php';
$wgSpecialPages['Piwik'] = 'Piwik'; # Let MediaWiki know about your new special page.
$wgHooks['LanguageGetSpecialPageAliases'][] = 'Piwik'; # Add any aliases for the special page.

function Piwik(&$specialPageArray, $code) {
  # The localized title of the special page is among the messages of the extension:

  wfLoadExtensionMessages('Piwik');
  $text = wfMsg('piwik');

  # Convert from title in text form to DBKey and put it into the alias array:
  $title = Title::newFromText($text);
  $specialPageArray['Piwik'][] = $title->getDBKey();

  return true;
}

///Alias for efAddPiwik - backwards compatibility.
function addPiwik() { return efAddPiwik(); }
