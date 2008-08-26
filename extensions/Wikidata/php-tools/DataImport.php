<?php

define('MEDIAWIKI', true );

require_once("../../../includes/Defines.php");
require_once("../../../includes/ProfilerStub.php");
require_once("../../../LocalSettings.php");
require_once("Setup.php");
require_once("../OmegaWiki/WikiDataAPI.php");
require_once("../OmegaWiki/Transaction.php");
require_once('SwissProtImport.php');
require_once('XMLImport.php');
require_once('2GoMappingImport.php');
require_once("UMLSImport.php");
require_once("../Console/CommandLine.php");
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

$options = parseCommandLine(array(new CommandLineOption("dataset", true)));
$datasetName = $options["dataset"];

$beginTime = time();
$wgCommandLineMode = true;
$wdDefaultViewDataSet = $datasetName;

global
	$dataSet;

$dataSet = new WikiDataSet(wdGetDataSetContext());

//$arg = reset( $argv ); 
//if ( $arg !== false ){
// 	$wdDefaultViewDataSet = next( $argv );
//}

/*
 * User IDs to use during the import of both UMLS and Swiss-Prot
 */
//$nlmUserID = 8;
// check the user ids as provided in the database

$sibUserID = getUserId( $wdDefaultViewDataSet );
if ( $sibUserId == -1 ){
	echo "Swiss-Prot user not defined in the database.\n";
	die; 
}

//$linkEC2GoFileName = "LinksEC2Go.txt";
//$linkSwissProtKeyWord2GoFileName = "LinksSP2Go.txt";
//$swissProtXMLFileName =  "C:\Documents and Settings\mulligen\Bureaublad\uniprot_sprot.xml";
$swissProtXMLFileName =  "C:\Documents and Settings\mulligen\Bureaublad\uniprot_sprot.xml";
//$swissProtXMLFileName =  "100000lines.xml";
//$swissProtXMLFileName =  "C:\Documents and Settings\mulligen\Bureaublad\SPentriesForWPTest.xml";
//$swissProtXMLFileName =  "C:\Users\mulligen\Desktop\SPentriesForWPTest.xml";

//$nlmUserID = $sibUserID;
//$wgUser->setID($nlmUserID);
//startNewTransaction($nlmUserID, 0, "UMLS Import");
//echo "Importing UMLS\n";
//$umlsImport = importUMLSFromDatabase("localhost", "umls", "root", "", array("NCI", "GO"));
//$umlsImport = importUMLSFromDatabase("localhost", "umls", "root", "nicheGod", array("GO", "SRC", "NCI", "HUGO"));
//$umlsImport = importUMLSFromDatabase("localhost", "umls", "root", NULL, array("GO", "SRC", "NCI", "HUGO"));

//$EC2GoMapping = loadEC2GoMapping($linkEC2GoFileName);
//$SP2GoMapping = loadSwissProtKeyWord2GoMapping($linkSwissProtKeyWord2GoFileName);

ini_set('memory_limit', '256M');

$wgUser->setID($sibUserID);
startNewTransaction($sibUserID, 0, "Swiss-Prot Import");
echo "\nImporting Swiss-Prot\n";
#$nsstore=wfGetNamespaceStore();
#print_r($nsstore->nsarray);
#"Namespace id for expression=" . Namespace::getIndexForName('expression');

//$umlsImport = new UMLSImportResult;
//$umlsImport->umlsCollectionId = 5;
//$umlsImport->sourceAbbreviations['GO'] = 30; 
//$umlsImport->sourceAbbreviations['HUGO'] = 69912;

//importSwissProt($swissProtXMLFileName, $umlsImport->umlsCollectionId, $umlsImport->sourceAbbreviations['GO'], $umlsImport->sourceAbbreviations['HUGO'], $EC2GoMapping, $SP2GoMapping);
importSwissProt($swissProtXMLFileName);

$endTime = time();
echo "\n\nTime elapsed: " . durationToString($endTime - $beginTime); 

//function echoNofLines($fileHandle, $numberOfLines) {
//	$i = 0;
//	do {
//		$buffer = fgets($fileHandle);
//		$buffer = rtrim($buffer,"\n");
//		echo $buffer;
//		$i += 1;
//	} while($i < $numberOfLines || strpos($buffer, '</entry>') === false);
//	echo "</uniprot>";
//}
//
//function echoLinesUntilText($fileHandle, $text) {
//	$found = false;
//	do {
//		$buffer = fgets($fileHandle);
//		$buffer = rtrim($buffer,"\n");
//		echo $buffer;
//		$found = strpos($buffer, $text) !== false;		
//	} while(!$found || strpos($buffer, '</entry>') === false);
//	echo "</uniprot>";
//}


