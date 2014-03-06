<?php
/**
 * Import WF variables into CSV. The CSV must take the following format:
 * wiki_id,variable_id,variable_value
 * @package MediaWiki
 * @addtopackage maintenance
 */
require_once( "../../../../maintenance/commandLine.inc" );

global $wgContentNamespaces, $wgExtraNamespaces;
$wgUser = User::newFromName('Owen Davis');
$wgTitle = Title::newMainPage();
$c = RequestContext::getMain();
$c->setUser($wgUser);
$c->setTitle($wgTitle);

$rowCounter = 0;
if ( ( $handle = fopen( $argv[1], 'r' ) ) !== false ) {
	while ( ( $row = fgetcsv( $handle ) ) !== false ) {
		try {
			$wikiId = $row[0];
			$variableId = $row[1];
			$variableValue = $row[2];
			WikiFactory::setVarById( $variableId, $wikiId, $variableValue );
			if ( $rowCounter++ % 1000 == 0 ) {
				echo "{$rowCounter}\n";
			}
		} catch ( Exception $e ) {
			echo "Problem with {$wikiId}: {$e}\n";
		}
	}
	fclose( $handle );
} else {
	echo "{$argv[1]} could not be opened";
}

