<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );
require_once( "commandLine.inc" );

global $wgEnableBacklinksExt;
$wgEnableBacklinksExt = true;

include("$IP/extensions/wikia/Backlinks/Backlinks.setup.php");

echo Backlinks::initTable()."\n";