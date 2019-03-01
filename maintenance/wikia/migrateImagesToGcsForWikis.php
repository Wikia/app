<?php

require_once( __DIR__ . '/../Maintenance.php' );

class MigrateImagesForWikis extends Maintenance {

	/** @var bool */
	private $dryRun;
	/** @var bool */
	private $allWikis;
	/** @var string */
	private $wikiPrefix;

	/**
	 * Define available options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Run generic code on a single cluster from on PHP process";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'wiki-prefix', 'Prefix for wikis', false, true, 'p' );
		$this->addOption( 'all-wikis', 'Which cluster to run on', false, false, 'a' );
	}


	public function execute() {
		$this->dryRun = $this->hasOption( 'dry-run' );
		$this->wikiPrefix = $this->getOption( 'wiki-prefix' );
		$this->allWikis = $this->hasOption( 'all-wikis' );

		if ( !$this->wikiPrefix && !$this->allWikis ) {
			throw new RuntimeException( 'No wiki prefix provided, but "allWikis" option has not been selected' );
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
				$this->runMigrateImagesToGcs( $row->city_id, unserialize( $row->cv_value ) );
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

	/**
	 * @param $wikiId
	 * @param $uploadPath
	 * @throws Exception
	 */
	private function runMigrateImagesToGcs( $wikiId, $uploadPath ) {
		// if not running on all wikis, verify the bucket matches our prefix as we may have selected a bit more
		if ( !$this->allWikis ) {
			$path = trim( parse_url( $uploadPath, PHP_URL_PATH ), '/' );
			$bucket = substr( $path, 0, - 7 );

			if ( substr( $bucket, 0, strlen( $this->wikiPrefix ) ) !== $this->wikiPrefix ) {
				$this->output( "Wiki's ({$wikiId}) upload path ({$uploadPath}) matched prefix ({$this->wikiPrefix})" .
							   " but the actual bucket does not: '{$bucket}'\n" );

				return;
			}
		}

		$this->output( "Migrating images for {$wikiId}\n" );
		$command = "php -d display_errors=1 migrateImagesToGcs.php";


		if ( $this->isQuiet() ) {
			$command = $command . " --quiet";
		}
		if ( $this->dryRun ) {
			$command = $command . " --dry-run";
		}
		$this->output( $command . "\n" );

		$environ = [ 'SERVER_ID' => $wikiId ];

		$output = wfShellExec( $command, $exitStatus, $environ );

		if ( $exitStatus === 0 ) {
			$this->output( "Migration success for {$wikiId}:\n" );
			$this->output( $output . "\n\n" );
		} else {
			$this->error( "Migration failure for {$wikiId}:{$output}\n" );
			throw new RuntimeException( "Failure to migrate images for wiki {$wikiId}\n" );
		}
	}
}

$maintClass = "MigrateImagesForWikis";
require_once( RUN_MAINTENANCE_IF_MAIN );
