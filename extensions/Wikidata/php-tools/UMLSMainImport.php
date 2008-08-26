<?php

define('MEDIAWIKI', true );

require_once("../../../includes/Defines.php");
require_once("../../../includes/ProfilerStub.php");
require_once("../../../LocalSettings.php");
require_once("Setup.php");
require_once("../OmegaWiki/WikiDataAPI.php");
require_once("../OmegaWiki/Transaction.php");
require_once('XMLImport.php');
require_once('2GoMappingImport.php');
require_once("UMLSImport.php");
require_once("../../../includes/Namespace.php");

ob_end_flush();

global
	$beginTime, $wgCommandLineMode, $wgUser, $numberOfBytes, $wdDefaultViewDataSet;

function getUserId($real_name){
	$dbr = &wfGetDB(DB_SLAVE);
	$queryResult = $dbr->query( "SELECT user_id FROM user where user_real_name = '$real_name'" );
	if ( $row = $dbr->fetchObject( $queryResult ) ){
		return( $row->user_id );
	}
	else{
		return( -1 );
	}
}

$beginTime = time();
$wgCommandLineMode = true;
$wdDefaultViewDataSet = 'umls';

$arg = reset( $argv ); 
if ( $arg !== false ){
 	$wdDefaultViewDataSet = next( $argv );
}

/*
 * User IDs to use during the import of both UMLS and Swiss-Prot
 */
$nlmUserID = getUserId( $wdDefaultViewDataSet );
if ( $nlmUserId == -1 ){
	echo "Swiss-Prot user not defined in the database.\n";
	die; 
}

$wgUser->setID($nlmUserID);
startNewTransaction($nlmUserID, 0, "UMLS Import");
echo "Importing UMLS\n";
$umlsImport = importUMLSFromDatabase("localhost", "umls2007aa", "root", "crosby9");//, array("NCI", "GO"));
//$umlsImport = importUMLSFromDatabase("localhost", "umls", "root", "nicheGod", array("GO", "SRC", "NCI", "HUGO"));
//$umlsImport = importUMLSFromDatabase("localhost", "umls", "root", NULL, array("GO", "SRC", "NCI", "HUGO"));


$endTime = time();
echo "\n\nTime elapsed: " . durationToString($endTime - $beginTime); 

?>
