<?php

require_once( __DIR__ . '/../Maintenance.php' );

class HandleDeletedImagesForWikis extends Maintenance {

	/** @var bool */
	private $dryRun;
	/** @var string */
	private $wikiPrefix;
	private $wikiId;
	private $parallel;

	private $centralDbr;
	private $correlationId;

	/**
	 * Define available options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Run generic code on a single cluster from on PHP process";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'wiki-prefix', 'Prefix for wikis', false, true, 'p' );
		$this->addOption( 'wiki-id', 'Specific wiki ID', false, true, 'i' );
		$this->addOption( 'parallel', 'How many threads per wiki', false, true, 'm' );
	}

	public function execute() {
		$this->dryRun = $this->hasOption( 'dry-run' );
		$this->wikiPrefix = $this->getOption( 'wiki-prefix' );
		$this->wikiId = $this->getOption( 'wiki-id' );
		$this->parallel = $this->getOption( 'parallel', 1 );

		$this->correlationId = \Wikia\Tracer\WikiaTracer::instance()->getTraceId();

		if ( empty( $this->wikiPrefix ) && empty( $this->wikiId ) ) {
			throw new RuntimeException( 'No wiki prefix provided' );
		}

		if ( !empty( $this->wikiId ) ) {
			$this->runHandleDeletedImages( $this->wikiId );

			return;
		}

		$migratedCommunities = [];

		( new \WikiaSQL() )->SELECT( "wikicities.city_list.*" )
			->FROM( "wikicities.city_list" )
			->WHERE( "wikicities.city_list.city_dbname" )
			->LIKE( $this->wikiPrefix . '%' )
			->runLoop( $this->getCentralDbr(),
				function ( &$pages, $row ) use ( &$migratedCommunities ) {
					$this->runHandleDeletedImages( $row->city_id );
					$migratedCommunities[$row->city_dbname] = $row->city_url;
				} );

		$this->output( "Run on the following communities:\n" .
					   json_encode( $migratedCommunities ) );
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
	private function runHandleDeletedImages( $wikiId ) {
		global $wgWikiaDatacenter, $wgWikiaEnvironment;

		$this->output( "Migrating images for {$wikiId} with correlation-id={$this->correlationId}\n" );
		$command = "php -d display_errors=1 ./handleDeletedImages.php";

		$command = $command . " --correlation-id={$this->correlationId}";

		if ( $this->dryRun ) {
			$command = $command . " --dry-run";
		}

		if ( $this->parallel > 1 ) {
			$fullCommand =
				"parallel --jobs 0 \"$command --parallel={$this->parallel} --thread={}\"  --args{} :::";
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

$maintClass = "HandleDeletedImagesForWikis";
require_once( RUN_MAINTENANCE_IF_MAIN );
