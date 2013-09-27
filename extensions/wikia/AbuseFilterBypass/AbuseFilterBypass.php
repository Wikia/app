<?php
/**
 * AbuseFilterBypass
 *
 * Hooks into AbuseFilter::filterAction() and decides if a user can bypass the filter check
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 1 );
}

$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'name' => 'Abuse Filter Bypass',
	'author' => 'Nelson Monterroso',
	'version' => '1.0.0',
);

$dir = dirname( __FILE__ );

// classes
$wgAutoloadClasses[ 'AbuseFilterBypass' ] = "{$dir}/AbuseFilterBypass.class.php";

// perms
$wgAvailableRights[ ] = AbuseFilterBypass::PERM_NAME;
$wgGroupPermissions[ '*' ][ AbuseFilterBypass::PERM_NAME ] = false;
$wgGroupPermissions[ 'staff' ][ AbuseFilterBypass::PERM_NAME ] = true;

// hooks
$wgHooks[ 'AbuseFilterShouldFilter' ][ ] = 'AbuseFilterBypass::onBypassCheck';