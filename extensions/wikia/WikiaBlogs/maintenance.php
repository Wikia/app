<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );
require_once( "commandLine.inc" );

BlogArticle::wfMaintenance();
