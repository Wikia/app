<?php
if( !defined( 'MEDIAWIKI' ) ) die();
/*
Creates a link in the toolbox to a special page showing who watches that page

Usage:
Add
	include_once ( "extensions/Watchers/Watchers.php" ) ;
to your LocalSettings.php. It should be (one of) the first extension(s) to include, as it adds to the toolbox in the sidebar.
Other extensions might add a new box there, putting the "Watchers" link in the wrong box.

After inclusion in LocalSettings.php, you can set $wgWatchersLimit
to a number to anonymize results ("X or more" / "Fewer than X" people watching this page)
*/

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Watchers',
	'version'        => '0.3',
	'author'         => 'Magnus Manske',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Watchers',
	'description'    => 'An extension to show who is watching a page.',
	'descriptionmsg' => 'watchers-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionAliasesFiles['Watchers'] = $dir . 'Watchers.alias.php';
$wgExtensionMessagesFiles['Watchers'] = $dir . 'Watchers.i18n.php';
$wgAutoloadClasses['SpecialWatchers'] = $dir . 'Watchers_body.php';

$wgAvailableRights[] = 'watchers-list';
$wgGroupPermissions['sysop']['watchers-list'] = true;

$wgSpecialPages['Watchers'] = 'SpecialWatchers';

$wgHooks['SkinTemplateToolboxEnd'][] = 'wfWatchersExtensionAfterToolbox';

/**
 * Set this to a number to anonymize results ("X or more" / "Less that X" people watching this page)
 * This does not affect users having watchers-list right
 */
$wgWatchersLimit = null;

/**
 * Display link in toolbox
*/
function wfWatchersExtensionAfterToolbox( &$tpl ) { # Checked for HTML and MySQL insertion attacks
	global $wgTitle;
	if( $wgTitle->isTalkPage() ) {
		# No talk pages please
		return true;
	}

	if( $wgTitle->getNamespace() < 0 ) {
		# No special pages please
		return true;
	}

	wfLoadExtensionMessages( 'Watchers' );

	echo '<li id="t-watchers"><a href="' ;
	$nt = SpecialPage::getTitleFor( 'Watchers' );
	echo $nt->escapeLocalURL( 'page=' . $wgTitle->getPrefixedDBkey() );
	echo '">';
	echo wfMsgHtml( 'watchers_link_title' );
	echo "</a></li>\n";

	return true;
}
