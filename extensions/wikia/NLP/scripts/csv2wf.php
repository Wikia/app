<?php
/**
 * Import WF variables into CSV. The CSV must take the following format:
 * wiki_id,variable_id,variable_value
 * NOTE: variable value _must_ be serialized.
 * @package MediaWiki
 * @addtopackage maintenance
 */
require_once( "../../../../maintenance/commandLine.inc" );

$rowCounter = 0;
if ( ( $handle = fopen( $argv[0], 'r' ) ) !== false ) {
	while ( ( $row = fgetcsv( $handle ) ) !== false ) {
		try {
			$wikiId = $row[0];
			$variableId = $row[1];
			$variableValue = $row[2];
			if ( ( $valArray = unserialize( $variableValue ) ) !== false ) {
				WikiFactory::setVarById( $variableId, $wikiId, $valArray );
			}
			if ( $rowCounter++ % 1000 == 0 ) {
				echo "{$rowCounter}\n";
			}
		} catch ( Exception $e ) {
			echo "Problem with {$wikiId}: {$e}\n";
		}
	}
	fclose( $handle );
} else {
	echo "{$argv[0]} could not be opened";
}

