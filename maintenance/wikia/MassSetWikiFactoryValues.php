<?php

require_once __DIR__ . '/../Maintenance.php';

# format of the data should follow the 
# https://docs.google.com/spreadsheets/d/1vGuJEZ0ncVQSXTrABM3YYHg2P531sWZosgNsq-uMy5M/edit#gid=2073314697

class MassSetWikiFactoryValues extends Maintenance {
	protected $dryRun = false;
	
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Sets Wiki Factory variable values based on CSV';
		$this->addArg( 'file', 'CSV file with the list of wikis and vars' );
		$this->addOption( 'dry-run', 'Dry-run mode, do not actually chnage any values', false, false, 'd' );
	}
	
	private function readFromCSV() {
		$fileName = $this->getArg( 0 );
		
		$fileHandle = fopen( $fileName, 'r' );

		if ( !$fileHandle ) {
			$this->error( "Unable to open {$fileName} for reading\n", 1 );
			return [];
		}

		$index = 0;
		$headers = [];
		$communityData = [];

		while ( ( $data = fgetcsv( $fileHandle ) ) !== false ) {
			if ( is_null( $data[0] ) ) {
				continue;
			}
			
			if ($index === 0) {
				// read headers, we'll use that to get the info
				$headers = $data;
			} else {
				// actually read the vars and add to `communityData`
				$newVariablesData = [];
				foreach( $data as $k => $v ) {
					if ( array_key_exists( $k, $headers ) ) {
						$newVariablesData[$headers[$k]] = $v;
					}
				}

				$communityData[] = $newVariablesData;
			}

			$index++;
		}

		fclose( $fileHandle );
		
		return $communityData;
	}

	private function filterVariables($communityData) {
		$variables = [];

		foreach ( $communityData as $varName => $varValue ) {
			// if key starts with `wg` it's a WikiFactory Variable
			if ( substr_compare( $varName, 'wg', 0, strlen( 'wg' ) ) === 0 ) {
				$variables[$varName] = $varValue;
			}
		}

		return $variables;
	}

	private function setVariable( $wikiId, $varName, $varValue ) {
		$currentVarData = (array) WikiFactory::getVarByName( $varName, $wikiId, true );
		$currentVarValue = array_key_exists( 'cv_value', $currentVarData ) ? $currentVarData['cv_value'] : '';

		$message = "{$wikiId}: `{$varName}`=`{$varValue}` (previously: `{$currentVarValue}`)";

		if ( !$this->dryRun ) {
			$status = WikiFactory::setVarByName( $varName, $wikiId, $varValue, 'Set though MassSetWikiFactoryValues' );

			if ( !$status ) {
				$this->output( "Error: Variable SET ERROR on {$message}\n" );
			} else {
				$this->output( "Variable SET OK on {$message}\n" );
			}
		} else {
			$this->output( "Variable NOT SET on {$message}\n" );
		}
	}

	public function execute() {
		$this->dryRun = $this->hasOption( 'dry-run' );
		$communities = $this->readFromCSV();

		// read the variables
		foreach ( $communities as $community ) {
			$wikiId = intval( $community['wikiId'], 10 );

			if ( $wikiId > 0) {
				$variables = $this->filterVariables( $community );

				if ( !$this->dryRun ) {
					$this->output( "Setting variables for {$wikiId}\n" );
				} else {
					$this->output( "Dry run of setting variables for {$wikiId}\n" );
				}
				

				foreach ( $variables as $varName => $varValue ) {
						$this->setVariable( $wikiId, $varName, $varValue );
				}

				if ( !$this->dryRun ) {
					// free cache
					$this->output( "Clearing cache for {$wikiId}\n" );
					WikiFactory::clearCache( $wikiId );
				}
			}
		}
	}
}

$maintClass = 'MassSetWikiFactoryValues';
require_once RUN_MAINTENANCE_IF_MAIN;
