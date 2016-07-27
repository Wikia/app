<?php

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ALL );

require_once( __DIR__ . '/../Maintenance.php' );

class UpdateImageReview extends Maintenance {
	private $dryRun;
	private $debug;

	public function __construct() {
		parent::__construct();
		$this->addOption( 'dry-run', 'Do not update anything.' );
		$this->addOption( 'debug', 'Show debugging information.' );
		$this->mDescription = "Update page index in dataware";
	}

	public function execute() {
		global $wgCityId;
		$this->dryRun = $this->getOption( 'dry-run' );
		$this->debug = $this->getOption( 'debug' );

		$this->addRuntimeStatistics( [
			'dry_run_bool' => boolval( $this->dryRun ),
		] );

		$this->output( "Started updateImageReview.php for wiki id = $wgCityId...\n" );

		$localFiles = $this->getLocalFiles();
		$imageReviewFiles = $this->getImageReviewFiles();

		$this->compareFiles( $localFiles, $imageReviewFiles );
		$this->output( "Finished.\n" );
	}

	private function getLocalFiles() {
		$this->output( "Fetching local list of files...\n" );

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			[ 'page', 'revision' ],
			[
				'page_id',
				'page_latest',
				'page_title',
				'page_namespace',
				'max(rev_timestamp) as page_last_edited',
				'rev_user'
			],
			[
				'page_namespace' => NS_FILE,
			],
			__METHOD__,
			[
				'GROUP BY' => 'page_id',
				'ORDER BY' => 'page_id',
			],
			[
				'revision' => [ 'INNER JOIN', 'rev_page = page_id' ],
			]
		);

		$pages = array();
		/** @var stdClass $row */
		foreach ( $res as $row ) {
			if ( !preg_match( "/\\.(png|bmp|gif|jpg|ico|svg)\$/i", $row->page_title ) ) {
				continue;
			}
			$row->page_latest = intval( $row->page_latest );
			$row->page_last_edited = $row->page_last_edited ? wfTimestamp( TS_DB, $row->page_last_edited ) : null;
			$row->rev_user = intval( $row->rev_user );
			$this->attachTextualTitle( $row );
			$pages[$row->page_id] = $row;
		}
		$res->free();

		$this->output( "Got " . count( $pages ) . " local files.\n" );
		$this->addRuntimeStatistics( [
			'local_files_count_int' => count( $pages ),
		] );

		return $pages;
	}

	private function attachTextualTitle( $page ) {
		$nsText = '';
		if ( $page->page_namespace ) {
			$nsText = MWNamespace::getCanonicalName( $page->page_namespace );
			if ( !$nsText ) {
				$nsText = $page->page_namespace;
			}
			$nsText .= ':';
		}

		$page->page_textual_title = "{$nsText}{$page->page_title} (id={$page->page_id})";
	}

	private function getImageReviewFiles() {
		global $wgCityId, $wgExternalDatawareDB;

		$this->output( "Fetching file index from image_review...\n" );

		$dbr = wfGetDB( DB_SLAVE, [ ], $wgExternalDatawareDB );
		$res = $dbr->select(
			'image_review',
			[
				'wiki_id',
				'page_id',
			],
			[
				'wiki_id' => $wgCityId,
			],
			__METHOD__
		);

		$pages = [ ];
		/** @var stdClass $row */
		foreach ( $res as $row ) {
			$pages[$row->page_id] = $row;
		}
		$res->free();

		$this->output( "Got " . count( $pages ) . " pages from dataware.\n" );
		$this->addRuntimeStatistics( [
			'image_review_files_count_int' => count( $pages ),
		] );

		return $pages;
	}

	private function compareFiles( $localFiles, $imageReviewFiles ) {
		global $wgExternalDatawareDB;

		$ids = array_merge( array_keys( $localFiles ), array_keys( $imageReviewFiles ) );
		$ids = array_unique( $ids );

		$this->output( "Comparing files between local list and image_review...\n" );
		$dbw = wfGetDB( DB_MASTER, null, $wgExternalDatawareDB );

		$top200 = $this->isTop200( $dbw );

		$stats = [
			'added' => 0,
		];
		foreach ( $ids as $id ) {
			$localFile = isset( $localFiles[$id] ) ? $localFiles[$id] : null;
			$imageReviewFile = isset( $imageReviewFiles[$id] ) ? $imageReviewFiles[$id] : null;

			if ( $localFile && !$imageReviewFile ) {
				if ( $this->updateDatawareFile( $dbw, $top200, $localFile, $imageReviewFile ) ) {
					$stats['added']++;
				}
			}
		}
		$this->output( "Update statistics: added={$stats['added']}.\n" );
		$this->addRuntimeStatistics( [
			'files_added_int' => $stats['added'],
		] );

		wfWaitForSlaves( $wgExternalDatawareDB );
	}

	/**
	 * @param DatabaseBase $dbw
	 * @param $imageReviewFile
	 */
	private function updateDatawareFile( $dbw, $top200, $localFile, $imageReviewFile ) {
		global $wgCityId;

		$action = $imageReviewFile ? "Updating image_review:" : "Adding to image_review:";
		$this->output( "{$action} {$localFile->page_textual_title}...\n" );

		if ( $this->debug ) {
			$this->output( "  * local file: " . json_encode( $localFile ) . "\n" );
			$this->output( "  * image_review: " . json_encode( $imageReviewFile ) . "\n" );
		}

		if ( $this->dryRun ) {
			return;
		}

		$title = Title::newFromID( $localFile->page_id );
		if ( ImagesService::isLocalImage( $title ) ) {
			$dbw->replace(
				'image_review',
				[
					'wiki_id',
					'page_id',
				],
				[
					'wiki_id' => $wgCityId,
					'page_id' => $localFile->page_id,
					'revision_id' => $localFile->page_latest,
					'user_id' => $localFile->rev_user,
					'last_edited' => $localFile->page_last_edited,
					'top_200' => $top200,
				],
				__METHOD__
			);

			return true;
		}

		return false;
	}


	/**
	 * @param DatabaseBase $dbw
	 */
	private function isTop200( $dbw ) {
		global $wgCityId;
		$top200 = $dbw->selectField(
			'image_review',
			'top_200',
			[
				'wiki_id' => $wgCityId,
			],
			__METHOD__ );

		if ( !$top200 ) {
			$top200 = 0;
		}

		return $top200;
	}

}

$maintClass = 'UpdateImageReview';
require_once( RUN_MAINTENANCE_IF_MAIN );
