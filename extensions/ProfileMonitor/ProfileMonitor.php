<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Special page to retrieve profiling information about a particular
 * profiling task; acts as a convenient access point for casual queries
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

$wgExtensionFunctions[] = 'efProfileMonitor';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'ProfileMonitor',
	'svn-date' => '$LastChangedDate: 2008-09-05 16:09:21 +0200 (ptk, 05 wrz 2008) $',
	'svn-revision' => '$LastChangedRevision: 40488 $',
	'author' => 'Rob Church',
	'description' => 'Special page to search and inspect profiling data',
	'descriptionmsg' => 'profiling-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:ProfileMonitor',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['ProfileMonitor'] = $dir . 'ProfileMonitor.i18n.php';
$wgExtensionAliasesFiles['ProfileMonitor'] = $dir . 'ProfileMonitor.alias.php';
$wgAutoloadClasses['ProfileMonitor'] = $dir . 'ProfileMonitor.class.php';
$wgSpecialPages['Profiling'] = 'ProfileMonitor';

function efProfileMonitor() {
	$wgHooks['SkinTemplateSetupPageCss'][] = 'efProfileMonitorCss';
}

function efProfileMonitorCss( &$css ) {
	global $wgTitle;
	if( $wgTitle->isSpecial( 'Profiling' ) ) {
		$file = dirname( __FILE__ ) . '/ProfileMonitor.css';
		$css .= "/*<![CDATA[*/\n" . htmlspecialchars( file_get_contents( $file ) ) . "\n/*]]>*/";
	}
	return true;
}
