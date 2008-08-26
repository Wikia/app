<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set('include_path', dirname(__FILE__) . '/..');
require_once('commandLine.inc');
require_once("$IP/extensions/wikia/SiteWideMessages/SiteWideMessagesMaintenance.php");

$oMaintenance = new SiteWideMessagesMaintenance();
$oMaintenance->execute();
?>