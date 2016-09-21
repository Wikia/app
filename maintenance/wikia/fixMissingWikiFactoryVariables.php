<?php

/**
 * Script that tries to fix missing WikiFactory variables by parsing WikiFactory log
 *
 * @see MAIN-2304
 *
 * @author Macbre
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class FixMissingWikiFactoryVariables extends Maintenance {

	const REASON = 'Fixing missing WikiFactory variable';
	const USER = 'WikiaBot';

	/* @var $dbr DatabaseBase */
	private $dbr;
	private $isDryRun;
	private $cityId = 0 ;

	private $variables = [];
	private $currentVariables = [];

	// a set of regular expressions used to parse WikiFactory log messages
	private $regexs = [
		'#(set value:|to) <strong>(.*)<\/strong>$#',
		// Variable <strong>wgEnableArticleCommentsExt</strong> set value: <strong>true</strong>  (reason: WikiFeatures)
		'#(set value:|to) <strong>(.*)<\/strong>\s+\(reason#',
		// <strong>New value:</strong><pre>array ()</pre>
		'#<strong>New value:<\/strong><pre>(.*)<\/pre>#',
		// set value: <pre>array (\n  0 => 673254,\n  1 => 830766,\n  2 => 648615,\n  3 => 114129,\n)</pre>
		'#set value: <pre>([^<]+)<\/pre>#',
		'#set value: (.*) \(reason\: #',
		'#set value: (.*)$#',
		// to ... (reason:
		'#to (.*) \(reason\: #',
		'#to (.*)$#',

		'#<strong>New value:<\/strong><pre>([^<]+)<\/pre>#',
	];

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'dry-run', 'Don\'t perform any operations' );
		$this->mDescription = 'This script tries to fix missing WikiFactory variables';
	}

	/**
	 * Get the current values of WikiFactory variables directly from the database
	 */
	private function getCurrentVariables() {
		// do not extract the following variables from WF changes log
		$this->currentVariables = [
			'wgUploadMaintenance' => false,
			'wgEnableUploads' => true,
		];

		$res = $this->dbr->select(
			[
				'city_variables',
				'city_variables_pool',
			],
			[
				'cv_name AS name',
				'cv_value AS value'
			],
			[
				'cv_city_id' => $this->cityId
			],
			__METHOD__,
			[],
			[
				'city_variables_pool' => ['JOIN', 'cv_variable_id = cv_id']
			]
		);

		while ( $row = $res->fetchRow() ) {
			$this->currentVariables[ $row['name'] ] = unserialize( $row['value'] );
		}

		$this->output( sprintf( "Existing WikiFactory variables: %d\n", count( $this->currentVariables ) ) );

		# var_dump($this->currentVariables);
	}

	/**
	 * Adds given variable to the list of variables to be set in WikiFactory
	 *
	 * @param $name
	 * @param $value
	 * @param $msg
	 */
	private function pushVariable( $name, $value, $msg ) {
		// check if the variable is in the database
		if ( isset( $this->currentVariables[$name] ) ) {
			return;
		}

		$this->variables[$name] = $value;

		$this->output( sprintf( " * %s = %s (%s)\n", $name, substr( json_encode( $value ), 0, 80 ), $msg ) ); ;
	}

	/**
	 * Get variables from city_list entry
	 */
	private function getVariablesFromWikiData() {
		// map DB columns to WF variables
		$map = [
			'city_dbname' => 'wgDBname',
			'city_cluster' => 'wgDBcluster',
			'city_title' => 'wgSitename',
		];

		$row = $this->dbr->selectRow(
			'city_list',
			array_keys( $map ),
			[
				'city_id' => $this->cityId
			],
			__METHOD__
		);

		foreach ( $row as $name => $value ) {
			$this->pushVariable( $map[$name], $value, 'from city_list' );
		}
	}

	/**
	 * Goes through WikiFactory log and parse it to get missing values
	 *
	 * Values that exist in database will not be updated
	 */
	private function getVariablesFromLog() {
		$res = $this->dbr->select(
			[
				'city_list_log',
				'city_variables_pool',
			],
			[
				'cl_timestamp AS timestamp',
				'cv_name AS name',
				'cl_text AS text',
			],
			[
				'cl_city_id' => $this->cityId
			],
			__METHOD__,
			[
				'ORDER BY' => 'cl_timestamp ASC'
			],
			[
				'city_variables_pool' => ['JOIN', 'city_variables_pool.cv_id = cl_var_id']
			]
		);

		$this->output( sprintf( "Analyzing %d WikiFactory log entries...\n", $this->dbr->affectedRows() ) );

		while ( $row = $res->fetchRow() ) {
			// check if the variable is in the database
			if ( isset( $this->currentVariables[$row['name']] ) ) {
				continue;
			}

			// parse the log message
			$newValue = null;

			foreach ( $this->regexs as $regex ) {
				if ( preg_match( $regex, trim( $row['text'] ), $matches ) ) {
					$newValue = trim( end( $matches ) );
					break;
				}
			}

			if ( !is_null( $newValue ) ) {
				// evaluate the value
				/* @var mixed $__foo */
				$isOk = ( @eval( "\$__foo = $newValue;" ) === null );

				if ( $isOk ) {
					$this->pushVariable( $row['name'], $__foo, 'set @ ' . $row['timestamp'] );
				}
				else {
					$this->output( "!! Value parsing error!\n" );
					var_dump( $row );
					var_dump( $newValue );
				}
			}
			else {
				$this->output( "!! Log message not parsed!\n" );
				print_r( $row );
			}
		}
	}

	private function storeInWikiFactory() {
		$this->output( sprintf( "\nSaving %d restored values in WikiFactory:\n", count( $this->variables ) ) ); ;

		foreach ( $this->variables as $name => $value ) {
			$this->output( sprintf( " * %s = %s\n", $name, json_encode( $value ) ) );

			WikiFactory::setVarByName( $name, $this->cityId, $value, self::REASON );
		}
	}

	public function execute() {
		global $wgUser, $wgDBname, $wgCityId; ;
		$wgUser = User::newFromName( self::USER );

		$this->isDryRun = $this->hasOption( 'dry-run' );
		$this->dbr = WikiFactory::db( DB_SLAVE );
		$this->cityId = $wgCityId;

		$this->output( "Running for '{$wgDBname}' (city #{$this->cityId})...\n" );

		if ( $this->isDryRun ) {
			$this->output( "\n### DRY RUN MODE ###\n\n" );
		}

		// first, get the current values from DB
		$this->getCurrentVariables();

		// now get values from city_list entry
		$this->getVariablesFromWikiData();

		// extract values from WikiFactory log
		$this->getVariablesFromLog();

		// store in DB
		// if not in --dry-run mode
		if ( !$this->isDryRun ) {
			$this->storeInWikiFactory();
		}

		$this->output( "\nDone!\n" );
	}
}

$maintClass = "FixMissingWikiFactoryVariables";
require_once( RUN_MAINTENANCE_IF_MAIN );
