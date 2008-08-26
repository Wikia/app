<?php

/**
 * Use this script to recreate indexes for all configured wiki data tables. 
 * Recreating indexes is profitable because:
 * 
 * 1) Different indexes are better for different purposes
 * 2) After a while index fragmentation can occur, degrading performance
 * 
 * The script takes the following parameters: 
 * 1) dataset: for which dataset should the indexes be created, if ommitted recreate for all datasets
 * 2) purpose: can be either WebSite or MassUpdate
 * 3) table: optionally specify a table to recreate the indexes for, if ommitted recreate for all tables in the dataset 
 * 
 * Usage example:
 *   prompt> php "RecreateIndexes.php" --dataset=uw --purpose=WebSite --table=objects
 */

define('MEDIAWIKI', true );

require_once("../../../../StartProfiler.php");
require_once("../../../../LocalSettings.php");
require_once("../../php-tools/ProgressBar.php");
require_once("DatabaseUtilities.php");
require_once("Setup.php");
require_once("../../Console/CommandLine.php");
require_once("../../OmegaWiki/WikiDataTables.php");

ob_end_flush();

/*
 * This function wil retrieve a list of the data sets defined in this
 * database and return it as an array
 */
function retrieve_datasets(){
	$prefixes = array();
	$dbr = &wfGetDB(DB_SLAVE);
	$queryResult = $dbr->query("select set_prefix from wikidata_sets");
	while ($datasetRecord = $dbr->fetchObject($queryResult) ) {
		array_push( $prefixes, $datasetRecord->set_prefix );
	}
	return $prefixes;
}

function addIndexesForTable($table, $purpose) {
	$tableIndexes = $table->getIndexes($purpose);
	$indexes = array();
	
	foreach ($tableIndexes as $tableIndex) {
		$index = array();
		
		foreach ($tableIndex->getColumns() as $column) {
			$indexColumn = '`' . $column->getIdentifier() . '`';
			$length = $column->getLength();
			
			if ($length != null)
				$indexColumn .= " (" . $length . ")";
				
			$index[] = $indexColumn; 
		}
		
		$indexes[$tableIndex->getName()] = $index;
	}
	
	addIndexes($table->getIdentifier(), $indexes);	
}

function recreateIndexesForTable(Table $table, $purpose) {
	echo "Dropping indices from table " . $table->getIdentifier() . ".\n";
	dropAllIndicesFromTable($table->getIdentifier());

	echo "Creating new indices for table " . $table->getIdentifier() . ".\n";
	addIndexesForTable($table, $purpose);	
}

global
	$beginTime, $wgCommandLineMode;

$beginTime = time();
$wgCommandLineMode = true;

$options = parseCommandLine(array(
	new CommandLineOption("purpose", true, array("WebSite", "MassUpdate")), 
	new CommandLineOption("dataset", false),
	new CommandLineOption("table", false)
));

$purpose = $options["purpose"];

if (isset($options["dataset"]))
	$prefixes = array($options["dataset"]);
else
	$prefixes = retrieve_datasets();

foreach ($prefixes as $prefix) {
	$dataSet = new WikiDataSet($prefix);
	
	if (isset($options["table"]))
		$tables = array($dataSet->getTableWithIdentifier($options["table"]));
	else
		$tables = $dataSet->getAllTables();
	
	foreach ($tables as $table)
		recreateIndexesForTable($table, $purpose);
}

$endTime = time();
echo("\n\nTime elapsed: " . durationToString($endTime - $beginTime)); 


