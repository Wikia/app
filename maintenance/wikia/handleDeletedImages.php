<?php

use Wikia\Rabbit\ConnectionBase;

require_once( __DIR__ . '/../Maintenance.php' );

class HandleDeletedImages extends Maintenance {

	/** @var DatabaseBase */
	private $db;
	/** @var LocalRepo */
	private $repo;
	/** @var string */
	private $bucket;
	/** @var bool */
	private $dryRun;
	/** @var ConnectionBase */
	private $rabbitConnection;
	/** @var string */
	private $correlationId;
	private $parallel;
	private $thread;


	public function __construct() {
		parent::__construct();
		$this->mDescription =
			"Usage SERVER_DBNAME=muppet php -d display_errors=1 ./handleDeletedImages.php";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'parallel', 'How many threads per wiki', false, true, 'm' );
		$this->addOption( 'thread', 'Which thread is running', false, true, 't' );
		$this->addOption( 'correlation-id', 'Correlation id used for this process', true, true,
			'c' );
	}

	public function execute() {
		global $wgGoogleCloudUploaderPublisher, $wgUploadPath;

		$this->correlationId = $this->getOption( "correlation-id" );
		$this->bucket = VignetteRequest::parseBucket( $wgUploadPath );
		$this->dryRun = $this->hasOption( 'dry-run' );
		$this->parallel = $this->getOption( 'parallel', 1 );
		$this->thread = $this->getOption( 'thread', 0 );

		$this->db = wfGetDB( DB_SLAVE );
		$this->repo = RepoGroup::singleton()->getLocalRepo();
		$this->rabbitConnection = new ConnectionBase( $wgGoogleCloudUploaderPublisher );

		try {
			$this->output( "Starting process with id = {$this->correlationId}\n" );
			$this->runForDeletedImages();
		}
		catch ( Exception $e ) {
			$this->error( "Failure to process" . json_encode( $e ) );
		}

		return 0;
	}

	private function runForDeletedImages() {
		( new \WikiaSQL() )->SELECT( "filearchive.*" )
			->FROM( 'filearchive' )
			->WHERE( "MOD(filearchive.fa_id, {$this->parallel})" )
			->EQUAL_TO( $this->thread )
			->runLoop( $this->db, function ( &$pages, $row ) {
				if ( empty( $row->fa_storage_key ) ) {
					$this->error( "Ignoring {$row->fa_id} due to a missing storage key." );

					return;
				}
				$name = $row->fa_name;
				$revision = $this->getRevisionId( $row->fa_archive_name );
				$path = $this->getPath( $name, $revision );

				$this->publishFileDeleteRequest( $path );
			} );
	}

	private function getRevisionId( $archiveName ) {
		if ( empty( $archiveName ) ) {
			return '';
		}

		return substr( $archiveName, 0, strcspn( $archiveName, '!' ) );
	}

	private function getPath( $name, $revision ) {
		$path = $this->repo->getZonePath( 'public' ) . '/';
		if ( !empty( $revision ) ) {
			$path .= 'archive/';
		}
		$path .= $this->repo->getHashPath( $name );
		$path .= empty( $revision ) ? $name : "$revision!$name";

		return $path;
	}

	private function publishFileDeleteRequest( $path ) {
		$bucket = $this->bucket;

		$data = [
			'correlationId' => $this->correlationId,
			'bucket' => $bucket,
			'path' => $path,
			'dryRun' => $this->dryRun,
		];

		$routingKey = "delete-file.{$bucket}";

		$this->output( "Publishing message to {$routingKey}: " . json_encode( $data ) . "\n\n" );
		$this->rabbitConnection->publish( $routingKey, $data );
	}

}

$maintClass = "HandleDeletedImages";
require_once( RUN_MAINTENANCE_IF_MAIN );
