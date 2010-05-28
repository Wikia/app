<?php

// NOTE: SINCE DevBoxes ARE A SPECIAL CASE, THIS FILE IS CONTAINED IN /extensions/wikia/Development/Configs_DevBox AND
// IS COPIED OVER TO THE DOCROOT WHEN updateDevBox.sh IS RUN.

// IT IS NOT RECOMMENDED TO MODIFY THIS FILE DIRECTLY BECAUSE IT WILL BE OVERWRITTEN THE NEXT TIME YOU RUN updateDevBox.sh
// INSTEAD, MODIFY THE DevBoxSettings.php WHICH IS IN THE DOCROOT DIRECTORY. IT IS DESIGNED FOR MAKING CHANGES JUST ON YOUR
// DEVBOX.

error_reporting(E_ALL);
ini_set('display_errors', '1');
$wgShowExceptionDetails = true;

$IP = '/usr/wikia/source/wiki';
$wgWikiaLocalSettingsPath  = __FILE__;
$wgWikiaAdminSettingsPath = dirname( $wgWikiaLocalSettingsPath ) . "/../AdminSettings.php";

$wgDevelEnvironment = true;
$wgWikicitiesReadOnly = true;

require_once("$IP/extensions/wikia/WikiFactory/Loader/WikiFactoryLoader.php");

# Initialize variables, load some extensions, etc.
# Former DefaultSettings.php
#
require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../CommonSettings.php' );

#
# initialize Connection Poll
#
require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../DB.sjc-dev.php' );

$wgSessionsInMemcached = true;
$wgSessionsInTokyoTyrant = !$wgSessionsInMemcached;

/**
 * Definition of global memcached servers
 *
 * Before altering the wgMemCachedServers array below, make sure you planned
 * your changes. Memcached computes a hash of the data and given the hash
 * assigns the value one of the servers.
 * If you remove / comment / change order of the servers, the hash will miss
 * and that can result in bad performance for the cluster!
 */
$wgMemCachedServers = array(
	# ACTIVE LIST
	# PLEASE MOVE SERVERS TO THE DOWN LIST RATHER THAN COMMENTING THEM OUT IN-PLACE
	# If a server goes down, you must replace its slot with another server
	# You can take a server for the spare list

	# SLOT	HOST
	0 => "10.8.36.106:11000", # dev-memcached1
	1 => "10.8.36.107:11000", # dev-memcached2

/**** DOWN *****

***** SPARE ****
	X => "10.8.2.65:11000",		# memcached6
	X => "10.8.2.61:11000",		# memcached4
	X => "10.8.2.182:11000",	# memcached1
	X => "10.8.2.44:11000",		# memcached2
	X => "10.8.2.62:11000",		# memcached5
****************/
);

$wgSessionMemCachedServers = array(
	# SLOT	HOST
	0 => "10.8.36.106:11000", # dev-memcached1
	1 => "10.8.36.107:11000", # dev-memcached2
);



# NOTE: THIS MUST BE DONE _BEFORE_ CALLING WikiFactory::execute IF WIKIFACTORY IS BEING USED.
include("$IP/extensions/wikia/Development/SpecialDevBoxPanel/Special_DevBoxPanel.php");

#
# Load all variables for the given wikia from a wiki.factory database
#
$oWiki = new WikiFactoryLoader();
$wgCityId = $oWiki->execute();

require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../DevBoxSettings.php' );

####
# To fake any Wiki Factory settings, put them here:

$wgExtensionsPath = "{$wgScriptPath}/extensions";
$wgAllInOne = false;


# End of fake Wiki Factory settings.
####

# Overwrite some variables, load extensions, etc.
# Former CustomSettings.php
#
require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../CommonExtensions.php' );

$wgArticlePath = "/wiki/$1";
$wgCookieDomain = ".wikia-dev.com";

// Just in case this has been reset somewhere else in here.
error_reporting(E_ALL);
ini_set('display_errors', '1');
$wgShowExceptionDetails = true;
$wgDebugLogFile = "/tmp/debug.log";
