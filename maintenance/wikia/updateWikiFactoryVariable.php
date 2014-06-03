<?php

/**
* Maintenance script to update and remove WikiFactory variable
* This is one time use script
* @author Saipetch Kongkatong
*/

use \Wikia\Logger\WikiaLogger;

/**
 * Get wikis that use the variable
 * @param integer $varId
 * @param integer $limit
 * @param string $fromValue
 * @param interger $wikiId
 * @return array
 */
function getWikiIds( $varId, $limit, $fromValue = '', $wikiId = 0 ) {
	$db = WikiFactory::db( DB_MASTER );
	$sql = ( new WikiaSQL() )
		->SELECT( 'cv_city_id' )
		->FROM( 'city_variables' )
		->WHERE( 'cv_variable_id' )->EQUAL_TO( $varId )
		->LIMIT( $limit );

	if ( !empty( $fromValue ) ) {
		$sql->AND_( 'cv_value' )->EQUAL_TO( $fromValue );
	}

	if ( !empty( $wikiId ) ) {
		$sql->AND_( 'cv_city_id' )->EQUAL_TO( $wikiId );
	}

	$wikis = $sql->runLoop( $db, function( &$wikis, $row ) {
		$wikis[] = $row->cv_city_id;
	});

	return $wikis;
}

/**
 * Check if the variable is used in the wiki
 * @param integer $varId
 * @param integer $wikiId
 * @return boolean
 */
function isUsed( $varId, $wikiId ) {
	$wikiIds = getWikiIds( $varId, 1, '', $wikiId );
	return !empty( $wikiIds );
}

/**
 * Remove variable from the wiki
 * @param array $varData
 * @param integer $wikiId
 * @return Status
 */
function removeVariableFromWiki( $varData, $wikiId ) {
	$log = WikiaLogger::instance();

	$resp = WikiFactory::removeVarById( $varData['cv_id'], $wikiId );
	$logData = $varData + [ 'wikiId' => $wikiId ];
	if ( $resp ) {
		$log->info( "Remove variable from city_variables table.", $logData );
		$status = Status::newGood();
	} else {
		$log->error( "Cannot remove variable from city_variables table.", $logData );
		$status = Status::newFatal( "Cannot remove variable from the wiki." );
	}

	return $status;
}

/**
 * Remove variable from WikiFactory (delete from city_variables_pool table)
 * @param array $varData
 * @return Status
 */
function removeFromVariablesPool( $varData ) {
	$log = WikiaLogger::instance();

	$dbw = WikiFactory::db( DB_MASTER );
	$dbw->begin();
	try {
		$dbw->delete(
			"city_variables_pool",
			array ( "cv_variable_id" => $varData['cv_id'] ),
			__METHOD__
		);
		$log->info( "Remove variable from city_variables_pool table.", $varData );
		$dbw->commit();
		$status = Status::newGood();
	} catch ( DBQueryError $e ) {
		$log->error( "Database error: Cannot remove variable from city_variables_pool table.", $varData );
		$dbw->rollback();
		$status = Status::newFatal( "Database error: Cannot remove variable from city_variables_pool table (".$e->getMessage().")." );
	}

	return $status;
}

/**
 * Print status
 * @global integer $failed
 * @param Status $status
 */
function printStatus( $status ) {
	global $failed;

	if ( $status->isGood() ) {
		echo " ... DONE.\n";
	} else {
		$failed++;
		echo " ... FAILED (".$status->getMessage().").\n";
	}
}

// ----------------------------- Main ------------------------------------

ini_set( 'include_path', dirname( __FILE__ )."/../" );
ini_set( 'display_errors', 1 );

require_once( "commandLine.inc" );

if ( isset( $options['help'] ) ) {
	die( "Usage: php updateWikiFactoryVariable.php [--help] [--name=wgXyz] [--dry-run] [--remove] [--removeFromWF] [--wikiId=123] [--limit=10]
	--name             WikiFactory variable name
	--remove           remove the variable from the Wiki
	--removeFromWF     remove the variable from WikiFactory (delete from city_variables_pool table)
	--wikiId           Wiki Id
	--limit            limit
	--dry-run          dry run
	--help             you are reading it right now\n\n" );
}

$dryRun = isset( $options['dry-run'] );
$varName = isset( $options['name'] ) ? $options['name'] : '';
$wikiId = isset( $options['wikiId'] ) ? $options['wikiId'] : '';
$remove = isset( $options['remove'] );
$removeFromWF = isset( $options['removeFromWF'] );
$limit = empty( $options['limit'] ) ? 1000 : $options['limit'];

if ( empty( $varName ) ) {
	die( "Error: Empty variable name.\n" );
}

$varData = (array) WikiFactory::getVarByName( $varName, false, true );
if ( empty( $varData['cv_id'] ) ) {
	die( "Error: $varName not found.\n" );
}

$varData['cv_id'] = (int) $varData['cv_id'];

echo "Variable: $varName (Id: $varData[cv_id])\n";

// for debugging
//echo "Variable data: ".json_encode( $varData )."\n";

$wgUser = User::newFromName( 'WikiaBot' );
$wgUser->load();

if ( $removeFromWF ) {
	$wikiIds = getWikiIds( $varData['cv_id'], 1 );
	if ( empty( $wikiIds ) ) {
		echo "\tRemove $varName from WikiFactory";

		if ( $dryRun ) {
			$status = Status::newGood();
		} else {
			$status = removeFromVariablesPool( $varData );
		}

		printStatus( $status );
	} else {
		echo "Warning: Cannot remove $varName from WikiFactory (The variable is used in some wikis).\n";
	}

	exit();
}

$total = 0;
$failed = 0;

if ( empty( $wikiId ) ) {
	$wikiIds = getWikiIds( $varData['cv_id'], $limit );
} else {
	if ( isUsed( $varData['cv_id'], $wikiId ) ) {
		$wikiIds = [ $wikiId ];
	} else {
		echo "SKIP: Cannot remove $varName from wikiId $wikiId (Variable is not used).\n";
		exit();
	}
}

foreach ( $wikiIds as $id ) {
	$total++;

	if ( $remove ) {
		echo "\tRemove $varName from wikiId $id";

		if ( $dryRun ) {
			$status = Status::newGood();
		} else {
			$status = removeVariableFromWiki( $varData, $id );
		}

		printStatus( $status );
	}
}

echo "\nTotal wikis: ".$total.", Success: ".( $total - $failed ).", Failed: $failed\n\n";
