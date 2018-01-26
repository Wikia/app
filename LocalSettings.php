<?php
require_once "$IP/includes/wikia/Defines.php";
require_once "$IP/includes/wikia/DefaultSettings.php";
require_once "$IP/includes/wikia/GlobalFunctions.php";

// TODO: Get rid of those. No DC detection, no DC-specific code.
$wgWikiaDatacenter = getenv( 'WIKIA_DATACENTER' );
$wgWikiaEnvironment = getenv( 'WIKIA_ENVIRONMENT' );

// TODO: Move it together with wgStyleVersion, include one file, no extra filesystem checks.
$wgWikiaIsDeployed = is_file( "$IP/../config/wikia.version.txt" );

// TODO: Defaulting to production is not a good idea. Production env should be explicitly
// indicated, never a default.
$wgDevelEnvironment = $wgStagingEnvironment = false;

$wgWikiaBaseDomain = "wikia.com";
$wgWikiaNocookieDomain = "wikia.nocookie.net";

// TODO: Find a person who would like to have that tattooed instead of some folk wisdom
// such as "born to write portable code".
if ( $wgWikiaEnvironment == WIKIA_ENV_DEV ) {
	$wgDevelEnvironment = true;
	$wgDevDomain = getenv( 'WIKIA_DEV_DOMAIN' );
} else if ( $wgWikiaEnvironment == WIKIA_ENV_PREVIEW
	|| $wgWikiaEnvironment == WIKIA_ENV_VERIFY
	|| $wgWikiaEnvironment == WIKIA_ENV_SANDBOX
	|| $wgWikiaEnvironment == WIKIA_ENV_STABLE
) {
	$wgStagingEnvironment = true;
} else if ( $wgWikiaEnvironment == WIKIA_ENV_STAGING ) {
	$wgWikiaBaseDomain = "wikia-staging.com";
	$wgWikiaNocookieDomain = "wikia-staging.nocookie.net";
}

// TODO: Get rid of those. No DC detection, no DC-specific code.
if ( empty( $wgWikiaDatacenter ) ) {
	throw new FatalError( 'Cannot determine the datacenter.' );
}

if ( empty( $wgWikiaEnvironment ) ) {
	throw new FatalError( 'Cannot determine the environment.' );
}

if ( $wgDevelEnvironment ) {
	$wgMedusaHostPrefix = '';
} else {
	$wgMedusaHostPrefix = "slot1.";
}

if ( empty($wgWikiaLocalSettingsPath) ) {
	$wgWikiaLocalSettingsPath = __FILE__;
}

require __DIR__.'/../config/LocalSettings.php';
