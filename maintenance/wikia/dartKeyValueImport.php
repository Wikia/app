<?php

require_once __DIR__ . '/../Maintenance.php';

class DartKeyValueImport extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->addDescription( 'Import DART custom key-values into WikiFactory from CSV file' );

		$this->addOption( 'source-file', 'CSV file to import', true, true );
		$this->addOption( 'dry-run', 'Only do a test import, don\'t save anything to WikiFactory' );
	}

	public function execute() {
		global $wgUser;

		$wgUser = User::newFromName( Wikia::BOT_USER );

		$csvName = $this->getOption( 'source-file' );
		$csvFile = fopen( $csvName, 'r' );

		$total = $success = $failed = 0;

		// ignore CSV headers
		fgets( $csvFile );

		while ( $entry = fgetcsv( $csvFile, 0, ',' ) ) {
			list( $domain, $dbNameInput, $dartValues ) = $entry;
			// strip leading underscore _ from DB name from CSV
			$wikiId = WikiFactory::DBtoID( substr( $dbNameInput, 1 ) );

			if ( $wikiId ) {
				$this->updateValuesFor( $wikiId, $domain, $dartValues ) && ++$success || ++$failed;
			} else {
				$this->error( "Invalid wiki - $domain does not exist.\n" );
				$failed++;
			}

			$total++;
		}

		$this->output( "Done, $success wikis were updated and $failed failed out of $total total.\n" );

		fclose( $csvFile );
	}

	private function updateValuesFor( int $wikiId, string $domain, string $dartValues ): bool {
		if ( $this->hasOption( 'dry-run' ) ) {
			$this->output( "DRY RUN - would update values on $domain (ID: $wikiId) to $dartValues\n" );
			return true;
		}

		$res = WikiFactory::setVarByName( 'wgDartCustomKeyValues', $wikiId, $dartValues, 'Updating DART values' );

		if ( $res ) {
			$this->output( "Updated values for $domain (ID: $wikiId)\n" );
		} else {
			$this->output( "Failed to update values for $domain (ID: $wikiId)\n" );
		}

		return $res;
	}
}

$maintClass = DartKeyValueImport::class;
require_once RUN_MAINTENANCE_IF_MAIN;
