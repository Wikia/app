<?php

if ( !defined( 'MEDIAWIKI' ) )
	die( "This is a MediaWiki extension definition file; it is not a valid entry point." );

/**#@+
 * Provides integration with Project Honey Pot for MediaWiki sites.
 * Requires
 *
 * @file
 * @ingroup Extensions
 *
 *
 * @author Andrew Garrett <andrew@werdn.us>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$dir = dirname( __FILE__ );
$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'HoneypotIntegration',
	'author'         => 'Andrew Garrett',
	'descriptionmsg' => 'honeypot-desc',
);

$wgExtensionMessagesFiles['HoneypotIntegration'] =  "$dir/HoneypotIntegration.i18n.php";
$wgAutoloadClasses[ 'HoneypotIntegration' ] = "$dir/HoneypotIntegration.class.php";

// Stuff that's been sort of semi-implemented, but we don't want to activate yet.
//  Keeping commented-out so it doesn't get lost.
#$wgHooks['AbuseFilter-filterAction'][] = 'HoneypotIntegration::onAbuseFilterFilterAction';
#$wgHooks['AbuseFilter-builder'][] = 'HoneypotIntegration::onAbuseFilterBuilder';
// $wgHooks['GetUserPermissionsErrorsExpensive'][] =
// 	'HoneypotIntegration::onGetUserPermissionsErrorsExpensive';

$wgHooks['EditPage::showEditForm:fields'][] = 'HoneypotIntegration::onShowEditForm';
$wgHooks['RecentChange_save'][] = 'HoneypotIntegration::onRecentChangeSave';

$wgHoneypotURLSource = '';

$wgHoneypotTemplates = array(
	'<a href="honeypoturl"><!-- randomtext --></a>',
);

$wgHoneypotAutoLoad = false;

$wgHoneypotDataFile = false;

