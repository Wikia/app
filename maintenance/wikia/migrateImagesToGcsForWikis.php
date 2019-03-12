<?php

require_once( __DIR__ . '/../Maintenance.php' );

class MigrateImagesForWikis extends Maintenance {

	/** @var bool */
	private $dryRun;
	/** @var bool */
	private $allWikis;
	/** @var string */
	private $wikiPrefix;
	private $centralDbr;
	private $parallel;
	private $wikiId;

	/**
	 * Define available options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Run generic code on a single cluster from on PHP process";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'wiki-prefix', 'Prefix for wikis', false, true, 'p' );
		$this->addOption( 'wiki-id', 'Specific wiki ID', false, true, 'i' );
		$this->addOption( 'all-wikis', 'Run on all wikis', false, false, 'a' );
		$this->addOption( 'parallel', 'How many threads per wiki', false, true, 'm' );
	}


	public function execute() {
		$this->dryRun = $this->hasOption( 'dry-run' );
		$this->wikiPrefix = $this->getOption( 'wiki-prefix' );
		$this->allWikis = $this->hasOption( 'all-wikis' );
		$this->parallel = $this->getOption( 'parallel', 1 );
		$this->wikiId = $this->getOption( 'wiki-id' );

		if ( empty( $this->wikiPrefix ) && empty( $this->wikiId ) && !$this->allWikis ) {
			throw new RuntimeException( 'No wiki prefix provided, but "allWikis" option has not been selected' );
		}

		if ( !empty( $this->wikiId ) ) {
			$this->runMigrateImagesToGcs( $this->wikiId );
		}

		( new \WikiaSQL() )->SELECT( "wikicities.city_list.city_id, wikicities.city_variables.cv_value" )
			->FROM( 'wikicities.city_list' )
			->JOIN( 'wikicities.city_variables' )
			->ON( 'wikicities.city_list.city_id = wikicities.city_variables.cv_city_id' )
			->JOIN( 'wikicities.city_variables_pool' )
			->ON( 'wikicities.city_variables.cv_variable_id = wikicities.city_variables_pool.cv_id' )
			->WHERE( 'wikicities.city_variables.cv_value' )
			->LIKE( $this->getUploadPathCondition() )
			->AND_( 'wikicities.city_variables_pool.cv_name' )
			->EQUAL_TO( 'wgUploadPath' )
			->runLoop( $this->getCentralDbr(), function ( &$pages, $row ) {
				if ( $this->bucketMatches( $row->city_id, unserialize( $row->cv_value ) ) ) {
					$this->runMigrateImagesToGcs( $row->city_id );
				}
			} );
	}

	private function getUploadPathCondition() {
		if ( $this->allWikis ) {
			return '%';
		} else {
			return '%' . $this->wikiPrefix . '%';
		}
	}

	private function getCentralDbr() {
		if ( empty( $this->centralDbr ) ) {
			$this->centralDbr = wfGetDB( DB_SLAVE, null, 'wikicities' );
		}

		return $this->centralDbr;
	}

	private function bucketMatches( $wikiId, $uploadPath ) {
		if ( $this->allWikis ) {
			return true;
		}
		// if not running on all wikis, verify the bucket matches our prefix as we may have selected a bit more
		$path = trim( parse_url( $uploadPath, PHP_URL_PATH ), '/' );
		$bucket = substr( $path, 0, - 7 );
		if ( substr( $bucket, 0, strlen( $this->wikiPrefix ) ) !== $this->wikiPrefix ) {
			$this->output( "Wiki's ({$wikiId}) upload path ({$uploadPath}) matched prefix ({$this->wikiPrefix})" .
						   " but the actual bucket does not: '{$bucket}'\n" );

			return false;
		} else {
			return true;
		}
	}

	/**
	 * @param $wikiId
	 * @param $uploadPath
	 * @throws Exception
	 */
	private function runMigrateImagesToGcs( $wikiId ) {
		global $wgWikiaDatacenter, $wgWikiaEnvironment;

		$this->output( "Migrating images for {$wikiId}\n" );
		$command = "php -d display_errors=1 migrateImagesToGcs.php";

		if ( $this->isQuiet() ) {
			$command = $command . " --quiet";
		}
		if ( $this->dryRun ) {
			$command = $command . " --dry-run";
		}

		if ( $this->parallel > 1 ) {
			$fullCommand =
				"parallel \"$command --parallel={$this->parallel} --thread={}\"  --args{} :::";
			for ( $i = 0; $i < $this->parallel; ++ $i ) {
				$fullCommand = $fullCommand . " {$i}";
			}
		} else {
			$fullCommand = $command;
		}

		$this->output( $fullCommand . "\n" );

		$environ = [
			'SERVER_ID' => $wikiId,
			'WIKIA_DATACENTER' => $wgWikiaDatacenter,
			'WIKIA_ENVIRONMENT' => $wgWikiaEnvironment,
		];

		$output = wfShellExec( $fullCommand, $exitStatus, $environ );

		if ( $exitStatus === 0 ) {
			$this->output( "Migration success for {$wikiId}:\n" );
			$this->output( $output . "\n\n" );
		} else {
			$this->error( "Migration failure for {$wikiId}:{$output}\n" );
		}
	}
}


$maintClass = "MigrateImagesForWikis";
require_once( RUN_MAINTENANCE_IF_MAIN );
