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

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'Abuse Filter Bypass',
	'author' => 'Nelson Monterroso',
	'version' => '1.0.0',
	'descriptionmsg' => 'abusefilterbypass-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AbuseFilterBypass',
	
);

$dir = dirname( __FILE__ );

// classes
$wgAutoloadClasses[ 'AbuseFilterBypass' ] = "{$dir}/AbuseFilterBypass.class.php";

// hooks
$wgHooks[ 'AbuseFilterShouldFilter' ][ ] = 'AbuseFilterBypass::onBypassCheck';

//i18n

