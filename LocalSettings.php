<?php
$IP = __DIR__;

require_once "$IP/../config/LocalSettings.php";
require_once "$IP/includes/wikia/Extensions.php";

/* @var $wgDBcluster string */
// in some cases $wgMemc is still null at this point, let's initialize it (SUS-2699)
$wgMemc = wfGetMainCache();

// disabled wikis do not have $wgDBcluster set at this point, skip the following check
// to allow update.php and other maintenance scripts to process such wikis (SUS-3589)
if ( is_string( $wgDBcluster ) && WikiFactoryLoader::checkPerClusterReadOnlyFlag( $wgDBcluster ) ) {
	$wgReadOnly = WikiFactoryLoader::PER_CLUSTER_READ_ONLY_MODE_REASON;
}

# this has to be fired after extensions - because any extension may add some new permissions (initialized with their default values)
if ( !empty( $wgGroupPermissionsLocal ) ) {
	WikiFactoryLoader::LocalToGlobalPermissions( $wgGroupPermissionsLocal );
}

if (!empty($wgInjectorCacheClassProvider)) {
	\Wikia\DependencyInjection\InjectorInitializer::init($wgInjectorCacheClassProvider());
} else {
	\Wikia\DependencyInjection\InjectorInitializer::init();
}

