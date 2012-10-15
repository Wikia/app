<?php

/**
 * Maintenance script to provide an easy way to clear the cached <email> images
 * -> copy this script into the maintenance directory and run it there
 *
 * @package MediaWiki
 * @subpackage Maintenance
 * @author Tino Reichardt
 */

require_once('commandLine.inc');

echo( "deleting cache ...\n\n" );

$wgShowExceptionDetails = true;
$dbw =& wfGetDB( DB_MASTER );
$gb = $dbw->tableName('objectcache');
$sql="TRUNCATE TABLE mw_objectcache";
$res = $dbw->query($sql, 'wfClearCache');
$obj = $dbw->fetchObject($res);
$dbw->freeResult($res);

?>
