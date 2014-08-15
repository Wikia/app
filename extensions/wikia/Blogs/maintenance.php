<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );
require_once( "commandLine.inc" );

foreach (BlogArticle::wfMaintenance() as $key => $result) {
	echo "{$key}... {$result}\n";
};
