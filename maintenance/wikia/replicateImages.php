<?php
/**
 * Replicate images through file servers
 * 
 * @addto maintenance
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 * 
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

$sLogsDb = '_wikialogs_';
$aFileServers = isset($options['server']) ? explode(',', $options['server']) : array();
$iImageLimit = isset($options['limit']) ? $options['limit'] : 10; 
$sUserLogin = isset($options['u']) ? $options['u'] : 'cron';
$bIsDryRun = isset($options['dryrun']) ? true : false;

$dbr = wfGetDB(DB_SLAVE);
$dbw = wfGetDB(DB_MASTER);

$dbr->selectDB($sLogsDb);
$dbw->selectDB($sLogsDb);

$oResource = $dbr->query("SELECT up_id, up_path FROM upload_path WHERE up_sent<>'y' ORDER BY up_created ASC" . ($iImageLimit ? " LIMIT " . addslashes($iImageLimit) : ""));

if($oResource) {
 while($oResultRow = $dbr->fetchObject($oResource)) {
 	$bFileCopied = true;
 	$sDestPath = $oResultRow->up_path;
 	foreach($aFileServers as $sServerName) {
 		if($sServerName == 'file3') {
 			$sDestPath = preg_replace("!^/images/(.)!", "/raid/images/by_id/$1/$1", $sDestPath);
 		}
 		$sScpCommand = '/usr/bin/scp -p ' . $oResultRow->up_path . ' ' . $sUserLogin . '@' . $sServerName . ':' . $sDestPath;
 		$sScpCommand.= ' >/dev/null 2>&1';
 		
 		if($bIsDryRun) {
 			print($sScpCommand . "\n");
 		}
 		else {
	 		$aOutput = null;
	 		$iReturnValue = 1;
	 		@exec($sScpCommand, $aOutput, $iReturnValue);
	
	 		if($iReturnValue > 0) {
	 			print("ERROR: $sScpCommand - command failed.\n\n");
	 			$bFileCopied = false;
	 			break;
	 		}
 		}
 	}
 	
 	if($bFileCopied && !$bIsDryRun) {
 		// update flag in db
 		$dbw->query("UPDATE upload_path SET up_sent='y' WHERE up_id='" . $oResultRow->up_id . "'");
		 $dbw->immediateCommit();
 	}
 }
 
}
else {
	print("No new images to be replicated.\n");
}
