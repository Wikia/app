<?php

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
require_once( dirname( $wgWikiaLocalSettingsPath ) . "/../DB.{$wgWikiaDatacenter}-dev.php" );

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

		require_once( "$IP/extensions/wikia/Development/ExternalStoreDBFetchBlobHook.php" );
		break;
}

// Swift storage setup
$wgFSSwiftDC = [
	'sjc' => [
		'server' => 's3.dev-dfs-s1',
		'config' => [
			'swiftUser'    => 'development:swift',
			'swiftKey'     => '6pS1+dRQuqtI7SSIZM2q6Dfwe6FR4O4zL12JZ5IF',
			'swiftAuthUrl' => "http://s3.dev-dfs-s1/auth",
			'debug'        => false,
		]
	],
	'poz' => [
		'server' => 's3.dev-dfs-p1',
		'config' => [
			'swiftUser'    => 'development:swift',
			'swiftKey'     => 'yA3P1uh+gin4iX8exjnNmOLisiWOPwwyq8og40Z0',
			'swiftAuthUrl' => "http://s3.dev-dfs-p1/auth",
			'debug'        => false,
		]
	]
];

$wgFSSwiftServer = $wgFSSwiftDC[ $wgWikiaDatacenter ][ 'server' ];
$wgFSSwiftConfig = $wgFSSwiftDC[ $wgWikiaDatacenter ][ 'config' ];

$wgDevboxDefaultWikiDomain = 'www.wikia.com';
#$wgDevboxSkipWikiFactoryVariables = true; // uncomment to skip loading of wiki-specific setup from WikiFactory

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

// set allinone to 1 by default (you can always overwrite this value in DevBoxSettings.php)
$wgAllInOne = true;

// Life is easier if we have Special:WikiFactory
$wgWikiaEnableWikiFactoryExt = true;

$wgEnableUserChangesHistoryExt = false;

$wgEnableFixRecoveredUsersExt = false;

// enable ExternalUsers
$wgExternalUserEnabled = true;

// antispoof extension needs statsdb setup, only on prod for now
$wgEnableAntiSpoofExt = false;

//disabling TorBlock on devboxes because it is soooooo slow
$wgEnableTorBlockExt = false;

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

#
# phalanx as service section
#
$wgPhalanxServiceUrl = "http://phalanx-dev";
$wgPhalanxServiceOptions = [];

##### /MAKE ANY CHANGES _BEFORE_ HERE THAT YOU  WANT TO SHOW UP ON DEVBOXES BY DEFAULT BUT STILL BE OVERRIDABLE #####
// don't include DevBoxSettings when running unit tests (BugId:93186)
if (empty($wgRunningUnitTests)) {
	require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../DevBoxSettings.php' );
}

# Overwrite some variables, load extensions, etc.
# Former CustomSettings.php
#
require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../CommonExtensions.php' );

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

//rebulild message cache when ?rebuildmessages is appended to url
$wgLocalisationCacheConf[ "manualRecache" ] = !array_key_exists( 'rebuildmessages', $_GET );

// disable irc feed
$wgRC2UDPEnabled = false;

// static assets host
$wgCdnRootUrl = "http://{$wgDevelEnvironmentName}.wikia-dev.com";

if (!empty($wgEnableSwiftFileBackend)) {
	$wgDevBoxImageServerOverride ="static.{$wgDevelEnvironmentName}.wikia-dev.com";
}
else {
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
