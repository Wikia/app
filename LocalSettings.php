<?php
// IP stands for Installation Path, the top folder of MediaWiki codebase.
$IP = __DIR__;

// Register some $IP subdirectories in include_path to speed up imports with
// relative paths.
ini_set( 'include_path', "$IP:$IP/includes:$IP/languages:$IP/lib/vendor:.:" );

// FANDOM-specific constants.
require "$IP/includes/wikia/Defines.php";

/**
 * @global string $wgWikiaLocalSettingsPath
 * This is used by some maintenance scripts that execute other maintenance
 * scripts and need to point them to the right LocalSettings.php.
 * @deprecated Maintenance scripts must not require --conf
 */
$wgWikiaLocalSettingsPath = __FILE__;
// CONFIG_REVISION: retire $wgWikiaLocalSettingsPath completely

/**
 * @global string $wgWikiaDatacenter
 * Runtime datacenter discovered from the environment variable.
 * @deprecated Code portability: do not add more dc-specific code.
 */
$wgWikiaDatacenter = getenv( 'WIKIA_DATACENTER' );

/**
 * @global string $wgWikiaEnvironment
 * Runtime environment discovered from the environment variable.
 * @deprecated Code portability: do not add more environment-specific code.
 */
$wgWikiaEnvironment = getenv( 'WIKIA_ENVIRONMENT' );

// CONFIG_REVISION: remove $wgWikiaDatacenter and $wgWikiaEnvironment from the global scope and only use it to load configuration

// the rest of the old contents
require "$IP/../config/LocalSettings.php";
require_once "$IP/includes/wikia/Extensions.php";

/* @var $wgDBcluster string */
// in some cases $wgMemc is still null at this point, let's initialize it (SUS-2699)
$wgMemc = wfGetMainCache();

// disabled wikis do not have $wgDBcluster set at this point, skip the following check
// to allow update.php and other maintenance scripts to process such wikis (SUS-3589)
if ( is_string( $wgDBcluster ) && WikiFactoryLoader::checkPerClusterReadOnlyFlag( $wgDBcluster ) ) {
	$wgReadOnly = WikiFactoryLoader::PER_CLUSTER_READ_ONLY_MODE_REASON;
}

// This is to discard permission changes made by WikiFactory and extensions
// setups.
require "$IP/lib/Wikia/src/Service/User/Permissions/data/PermissionsDefinesAfterWikiFactory.php";

// The above has originally been loaded before the statement below. Yet, the
// old comment brings confusion:
// 
// this has to be fired after extensions - because any extension may add some
// new permissions (initialized with their default values)
// CONFIG_REVISION: clarify the confusion with permissions and WikiFactory
if ( !empty( $wgGroupPermissionsLocal ) ) {
	WikiFactoryLoader::LocalToGlobalPermissions( $wgGroupPermissionsLocal );
}