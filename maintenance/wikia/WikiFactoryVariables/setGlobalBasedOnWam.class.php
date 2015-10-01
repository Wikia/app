<?php
/**
 * Use this script to enable any global variable on wikias based on their WAM rank.
 */
require_once( __DIR__ . '/../../Maintenance.php' );

class SetGlobalBasedOnWam extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->addOption( 'limit', 'How many wikis should I change the variable for?', true, true );
		$this->addOption( 'var', 'What variable should I set?', true, true );
		$this->addOption( 'varValue', 'What value should I set the variable to?', true, true );
		/**
		 * If you want to add an additional condition to what wikis should be chosen - use dependency.
		 * BE AWARE THAT THE RESULT GOES INTO AN IN() MySQL CLAUSE
		 * Please, be sane about the dependency. It makes sense if it limits the results to
		 * a few thousands of wikias, not tens or hundreds of thousands!
		 */
		$this->addOption( 'dependency', 'Should I consider any other variable\'s value when querying for wikis (for example, only touch wikis with wgUseSiteJs set to `true`)?', false, true );
		$this->addOption( 'dependencyValue', 'What should be a value of the dependant variable? Default is `true`.', false, true );
		$this->addOption( 'dry', 'Would you like to try it out first?', false, false );
	}

	public function execute() {
		/**
		 * Get options
		 */
		$limit = (int)$this->getOption( 'limit' );
		$var = $this->getOption( 'var' );
		$varValue = $this->getOption( 'varValue' );
		$dependency = $this->getOption( 'dependency' );
		$dependencyValue = $this->getOption( 'dependencyValue', true );
		$dry = $this->getOption( 'dry' );

		/**
		 * If a dependency is set - this array will be empty and you will get $limit of wikias
		 * only based on the WAM rank.
		 */
		$wikisToOrder = [];

		if ( $dependency !== null ) {
			/**
			 * Convert the value to boolean or integer.
			 * Leave as a string otherwise.
			 */
			$dependencyData = WikiFactory::getVarByName( $dependency );

			if ( $dependencyData->cv_variable_type === 'boolean' ) {
				$dependencyValue = filter_var( $dependencyValue, FILTER_VALIDATE_BOOLEAN );
			} elseif ( $dependencyData->cv_variable_type === 'integer' ) {
				$dependencyValue = (int)$dependencyValue;
			}
			$dependencyId = $dependencyData->cv_id;

			$wikisToOrder = WikiFactory::getCityIDsFromVarValue( $dependencyId, $dependencyValue, '=' );

			$count = count( $wikisToOrder );
			if ( $count === 0 ) {
				$this->output( "No wikias found with {$dependency}={$dependencyValue}.\n\n" );
				return;
			}

			$this->output( "\nFound {$count} wikias with {$dependency}={$dependencyValue}.\n\n" );
		}

		$dataMartService = new DataMartService();
		$wikiIdsToConvert = $dataMartService->getWikisOrderByWam( $limit, $wikisToOrder );
		$count = count( $wikiIdsToConvert );
		$this->output( "Got {$count} wikis to convert ordered by WAM rank.\n\n" );


		/**
		 * Convert the value to boolean or integer.
		 * Leave as a string otherwise.
		 */
		$varData = WikiFactory::getVarByName( $var );
		if ( $varData->cv_variable_type === 'boolean' ) {
			$varValue = filter_var( $varValue, FILTER_VALIDATE_BOOLEAN );
		} elseif ( $varData->cv_variable_type === 'integer' ) {
			$varValue = (int)$varValue;
		}
		$varId = (int)$varData->cv_id;

		$success = $fail = [ ];

		foreach ( $wikiIdsToConvert as $wikiId ) {
			$this->output( "Setting {$var} to {$varValue} for wikiId={$wikiId}\n\n" );

			if ( !$dry ) {
				if ( WikiFactory::setVarById( $varId, $wikiId, $varValue ) ) {
					$success[] = $wikiId;
				} else {
					$fail[] = $wikiId;
				}
			}
		}

		if ( !$dry ) {
			$countFailed = count( $fail );
			if ( $countFailed === 0 ) {
				$this->output( "Results verified! {$count} wikias have {$var}={$varValue}.\n\n" );
			} else {
				$this->output( "Changing {$var} to {$varValue} failed for {$countFailed} wikias! Their IDs are: " . implode( ',', $fail ) . "\n\n" );
			}
		} else {
			$this->output( "A dry run done.\n\n" );
		}
	}
}

$maintClass = 'SetGlobalBasedOnWam';
require_once( RUN_MAINTENANCE_IF_MAIN );
