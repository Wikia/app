<?php
/**
 * Maintenance script to check if old SVG uploads still pass filters.
 */

require_once( __DIR__ . "/Maintenance.php" );
require_once( __DIR__ . '/../includes/upload/UploadBase.php' );

class CheckSVGs extends Maintenance {
	private $lastFileName;
	private $verifier;

	public function __construct() {
		parent::__construct();
		$this->addDescription( 'Check old svgs to see if they are still valid' );
		$this->addOption( 'until', 'Optional timestamp to stop checking', false, true );
		$this->addOption( 'max-size', 'Max size to check (in bytes)', false, true );
		$this->setBatchSize( 500 );
	}


	/**
	 * This is meant to connect to a tool labs db.
	 */
	private function getDBConnection() {
		$db = wfGetDB( DB_SLAVE );
		if ( !$db ) {
			$this->error( 'Could not get db' );
			exit( 1 );
		}

		return $db;
	}

	public function execute() {
		global $wgDBname, $wgCityId;

		$this->output( "Checking SVG images from a wiki " . WikiFactory::DBtoUrl( $wgDBname ) . " (cityId ${wgCityId})\n" );

		$this->db = $this->getDBConnection();
		$this->verifier = new SVGVerifier;
		$total = 0;
		$bad = 0;
		$errors = 0;

		$repo = RepoGroup::singleton()->getLocalRepo();
		$fileBackend = $repo->getBackend();

		while ( $candidates = $this->getCandidates() ) {
			foreach ( $candidates as $candidate ) {
				$total++;
				$file = $repo->newFileFromRow( $candidate );

				// Put file title and image url in the logs for easier investigation of suspicious files.
				$globalTitle = GlobalTitle::newFromText( $file->getTitle()->getText(), $file->getTitle()->getNamespace(), $wgCityId );
				$details = $globalTitle->getFullURL() . " (" . $file->getUrl() . ")";

				$path = $file->getPath();
				if ( !$path ) {
					$this->output( "\tError while getting path for ${details}\n" );
					$errors++;
					continue;
				}

				$fileContents = $fileBackend->getFileContents( [ 'src' => $path ] );
				if ( !$fileContents ) {
					$this->output( "\tError while getting contents of ${details}\n" );
					$errors++;
					continue;
				}

				$tmpFile = tempnam( wfTempDir(), 'img' ) . '.svg';
				file_put_contents( $tmpFile, $fileContents );
				$res = $this->isFileInvalid( $tmpFile );
				unlink( $tmpFile );
				if ( $res !== false ) {
					$bad++;
					$this->output( "\tValidation error " . json_encode( $res ) . " while checking ${details}\n" );
				}
			}
			$this->output( "Done batch ${total} - at: " . $candidates[ count( $candidates ) - 1 ]->img_name . "\n" );
		}
		$this->output( "Complete: ${total} total; ${bad} bad, ${errors} errors\n" );
	}

	private function isFileInvalid( $file ) {
		return $this->verifier->containsScripts( $file );
	}

	private function getCandidates() {
		// 1. Get SVG images
		$conds = [
			'img_size < ' . ( (int)$this->getOption( 'max-size', 1024 * 1024 * 10 ) ),
			'img_major_mime' => 'image',
			'img_minor_mime' => 'svg+xml',
			'img_media_type' => 'DRAWING',
		];
		// In case of batch calls, pick up where we finished (we sort by img_name)
		if ( $this->lastFileName ) {
			$conds[] = 'img_name > ' . $this->db->addQuotes( $this->lastFileName );
		}
		// If 'until' timestamp was specified, scan only files older than that
		$until = $this->getOption( 'until' );
		if ( $until ) {
			$conds[] =
				'img_timestamp < ' . $this->db->addQuotes( $until );
		}

		$res = $this->db->select(
			'image',
			'*',
			$conds,
			__METHOD__,
			[
				'ORDER BY' => 'img_name asc',
				'LIMIT'    => $this->mBatchSize,

			]
		);

		$actualResults = [];
		foreach ( $res as $row ) {
			$actualResults[] = $row;
			$this->lastFileName = $row->img_name;
		}

		return $actualResults;
	}
}

class SVGVerifier extends UploadBase {
	public function initializeFromRequest( &$request ) {
	}

	/**
	 * @param String Full path to svg file
	 *
	 * @return mixed false of the file is verified (does not contain scripts), array otherwise.
	 */
	public function containsScripts( $file ) {
		return $this->detectScriptInSvg( $file );
	}
}

$maintClass = 'CheckSVGs';
require_once RUN_MAINTENANCE_IF_MAIN;
