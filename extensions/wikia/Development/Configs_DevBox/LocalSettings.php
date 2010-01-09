<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$IP = '/usr/wikia/source/wiki';
$wgWikiaLocalSettingsPath  = __FILE__;
$wgWikiaAdminSettingsPath = dirname( $wgWikiaLocalSettingsPath ) . "/../AdminSettings.php";

$wgDevelEnvironment = true;

require_once("$IP/extensions/wikia/WikiFactory/Loader/WikiFactoryLoader.php");

# Initialize variables, load some extensions, etc.
# Former DefaultSettings.php
#
require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../CommonSettings.php' );

#
# initialize Connection Poll
#
require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../DB.sjc-dev.php' );

#
# Load all variables for the given wikia from a wiki.factory database
#
$oWiki = new WikiFactoryLoader();
$wgCityId = $oWiki->execute();

####
# To fake any Wiki Factory settings, put them here:

$wgExtensionsPath = "/extensions";

# End of fake Wiki Factory settings.
####

# Overwrite some variables, load extensions, etc.
# Former CustomSettings.php
#
require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../CommonExtensions.php' );

include("$IP/extensions/wikia/Development/SpecialDevBoxPanel/Special_DevBoxPanel.php");
