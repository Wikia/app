<?php
if ( !defined('MEDIAWIKI') ) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}
/**
 *
 * @package MediaWiki
 * @subpackage SponsorshipDashboard
 * @author Jakub Kurcek
 *
 * To use this extension $wgEnableSponsorshipDashboardExt = true
 */

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['SponsorshipDashboard']	= $dir . 'SponsorshipDashboard.body.php';

$wgExtensionMessagesFiles['SponsorshipDashboard'] = $dir . 'SponsorshipDashboard.i18n.php';

$wgSpecialPages['SponsorshipDashboard']		= 'SponsorshipDashboard';
$wgSpecialPageGroups['SponsorshipDashboard']	= 'wikia';

