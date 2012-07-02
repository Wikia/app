<?php

/**
 * Extension registration file for Special:VipsTest. The VipsScaler extension
 * must be enabled.
 */

if ( !defined( 'MEDIAWIKI' ) ) exit( 1 );

/**
 * The host to send the request to when doing the scaling remotely. Set this to
 * null to do the scaling on the same server that receives the request.
 */
$wgVipsThumbnailerHost = null;

/**
 * The cache expiry time in seconds to use for images that we stream out.
 */
$wgVipsTestExpiry = 3600;

$dir = dirname( __FILE__ );

/** Registration */
$wgAutoloadClasses['SpecialVipsTest'] = "$dir/SpecialVipsTest.php";
$wgExtensionMessagesFiles['VipsTestAlias']    = "$dir/VipsScaler.alias.php";
$wgAvailableRights[] = 'vipsscaler-test';
$wgGroupPermissions['*']['vipsscaler-test'] = true;
$wgSpecialPages['VipsTest'] = 'SpecialVipsTest';

/**
 * Disable VipsScaler for ordinary image scaling so that the test has something
 * to compare against.
 */
$wgVipsOptions = array();

