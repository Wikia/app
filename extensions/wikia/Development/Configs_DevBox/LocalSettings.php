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
