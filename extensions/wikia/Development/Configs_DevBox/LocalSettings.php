<?php

// NOTE: SINCE DevBoxes ARE A SPECIAL CASE, THIS FILE IS CONTAINED IN /extensions/wikia/Development/Configs_DevBox AND
// IS COPIED OVER TO THE DOCROOT WHEN updateDevBox.sh IS RUN.

// IT IS NOT RECOMMENDED TO MODIFY THIS FILE DIRECTLY BECAUSE IT WILL BE OVERWRITTEN THE NEXT TIME YOU RUN updateDevBox.sh
// INSTEAD, MODIFY THE DevBoxSettings.php WHICH IS IN THE DOCROOT DIRECTORY. IT IS DESIGNED FOR MAKING CHANGES JUST ON YOUR
// DEVBOX.

error_reporting(E_ALL & ~ E_STRICT);
ini_set('display_errors', '1');
$wgShowExceptionDetails = true;

// include chef generated variables: $wgWikiaDatacenter
require_once('/usr/wikia/devbox/DevBoxVariables.php');

$IP = '/usr/wikia/source/wiki';
$wgWikiaLocalSettingsPath  = '/usr/wikia/docroot/wiki.factory/LocalSettings.php';
$wgWikiaAdminSettingsPath = dirname( $wgWikiaLocalSettingsPath ) . "/../AdminSettings.php";

$wgDevelEnvironment = true;
$wgWikicitiesReadOnly = false;

require_once("$IP/extensions/wikia/WikiFactory/Loader/WikiFactoryLoader.php");

# Initialize variables, load some extensions, etc.
# Former DefaultSettings.php
#
require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../CommonSettings.php' );

#
# initialize Connection Poll
#
require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../DB.sjc-dev.php' );

/**
 * Definition of global memcached servers
 *
 * Before altering the wgMemCachedServers array below, make sure you planned
 * your changes. Memcached computes a hash of the data and given the hash
 * assigns the value one of the servers.
 * If you remove / comment / change order of the servers, the hash will miss
 * and that can result in bad performance for the cluster!
 */
switch($wgWikiaDatacenter) {
	case 'sjc':
		$wgMemCachedServers = array(
			# ACTIVE LIST
			# PLEASE MOVE SERVERS TO THE DOWN LIST RATHER THAN COMMENTING THEM OUT IN-PLACE
			# If a server goes down, you must replace its slot with another server
			# You can take a server for the spare list

			# SLOT	HOST
			0 => "10.8.44.110:11000", # dev-memcached1
			1 => "10.8.36.107:11000", # dev-memcached2
		);

		$wgSessionMemCachedServers = array(
			# SLOT	HOST
			0 => "10.8.44.110:11000", # dev-memcached1
			1 => "10.8.36.107:11000", # dev-memcached2
		);
		break;

	case 'poz':
		$wgMemCachedServers = array(
			# ACTIVE LIST
			# PLEASE MOVE SERVERS TO THE DOWN LIST RATHER THAN COMMENTING THEM OUT IN-PLACE
			# If a server goes down, you must replace its slot with another server
			# You can take a server for the spare list

			# SLOT	HOST
			0 => "10.14.30.143:11000", # dev-memcached-p1
			1 => "10.14.30.143:11000", # dev-memcached-p2
		);

		$wgSessionMemCachedServers = array(
			# SLOT	HOST
			0 => "10.14.30.143:11000", # dev-memcached-p1
			1 => "10.14.30.143:11000", # dev-memcached-p2
		);
		break;
}

# NOTE: THIS MUST BE DONE _BEFORE_ CALLING WikiFactory::execute IF WIKIFACTORY IS BEING USED.
include("$IP/extensions/wikia/Development/SpecialDevBoxPanel/Special_DevBoxPanel.php");

#
# Load all variables for the given wikia from a wiki.factory database
#
$oWiki = new WikiFactoryLoader();
$wgCityId = $oWiki->execute();

##### MAKE ANY CHANGES HERE THAT YOU  WANT TO SHOW UP ON DEVBOXES BY DEFAULT BUT STILL BE OVERRIDABLE #####
$wgCookieDomain = ".wikia-dev.com";
$wgCheckSerialized = true;

// Life is easier if we have Special:WikiFactory
$wgWikiaEnableWikiFactoryExt = true;

$wgEnableUserChangesHistoryExt = false;

$wgAllInOne = false;
$wgEnableFixRecoveredUsersExt = false;

// enable ExternalUsers
$wgExternalUserEnabled = true;

// antispoof extension needs statsdb setup, only on prod for now
$wgEnableAntiSpoofExt = false;

// Google Maps key for wikia-dev.com (different than the key for wikia.com).
$wgGoogleMapsKey = 'ABQIAAAAH6bdoxGNhXgildFjnRAQjBTsndpDQKTEb03AQ6hTlU-KPVq60xQdoVVgLuXn-IrTw3LW8MYBMaYx9Q';

// Staff should be able to change all groups on the devboxes.
$wgAddGroups['staff'] = true;
$wgRemoveGroups['staff'] = true;

if ( is_null( $wgDBcluster ) ) {
	$wgDBcluster = 'c1';
}
// default LB section for database connection
$wgLBDefaultSection = 'c1';

##### /MAKE ANY CHANGES _BEFORE_ HERE THAT YOU  WANT TO SHOW UP ON DEVBOXES BY DEFAULT BUT STILL BE OVERRIDABLE #####
// don't include DevBoxSettings when running unit tests (BugId:93186)
if (empty($wgRunningUnitTests)) {
	require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../DevBoxSettings.php' );
}

# Overwrite some variables, load extensions, etc.
# Former CustomSettings.php
#
require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../CommonExtensions.php' );

// The list of cached i18n files is "fixed" too early as a side effect
// of extension init functions which check user options (like FBConnect)
// this speeds up devboxes a lot because init() is faster than recache()
// TODO: I think this affects production also
Language::getLocalisationCache()->unloadAll();

$wgArticlePath = "/wiki/$1";

// Just in case this has been reset somewhere else in here.
error_reporting(E_ALL & ~ E_STRICT);
ini_set('display_errors', '1');
$wgShowExceptionDetails = true;
$wgMemCachedDebug = true;
$wgDebugLogFile = "/tmp/debug.log";
$wgDefaultExternalStore = array( "DB://dev-archive");

// OpenXSPC
$wgEnableOpenXSPC = true;

// generate cache on every request
$wgLocalisationCacheConf[ "manualRecache" ] = false;

// disable irc feed
$wgRC2UDPEnabled = false;

// static assets host
switch($wgWikiaDatacenter) {
	case 'poz':
		$wgCdnRootUrl = "http://{$wgDevelEnvironmentName}.pl.wikia-dev.com";
		$wgDevBoxImageServerOverride ="images.{$wgDevelEnvironmentName}.pl.wikia-dev.com";
		break;

	default:
		$wgCdnRootUrl = "http://{$wgDevelEnvironmentName}.wikia-dev.com";
		$wgDevBoxImageServerOverride ="images.{$wgDevelEnvironmentName}.wikia-dev.com";
}

// macbre: generate proper paths for static assets on devboxes (BugId:6809)
$wgCdnStylePath = "{$wgCdnRootUrl}/__cb{$wgStyleVersion}"; // paths for images requested from CSS/SASS
$wgStylePath = "{$wgCdnStylePath}/skins";
$wgExtensionsPath = "{$wgCdnStylePath}/extensions";
$wgResourceBasePath = $wgCdnStylePath;

// fetch GoogleMaps resources from devboxes
$wgGoogleMapsUrlPath = $wgExtensionsPath . '/3rdparty/GoogleMaps';

// Facebook App for devboxes
$fbAppId = '116800565037587';

// reCAPTCHA for devboxes
$recaptcha_public_key = '6LehHs0SAAAAALuvvzioNdf8_xBXmc6_xW8rWw0d';
$recaptcha_private_key = '6LehHs0SAAAAABYaeCiC0ockp0NsY-H7wEiPZk7i';

$wgConf->localVHosts = array(
	'wikia-dev.com'
);
