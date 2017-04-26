<?php
/**
 * Maintenance script to check if old SVG uploads still pass filters.
 */

require_once __DIR__ . "/Maintenance.php";
require_once( __DIR__ . '/../includes/upload/UploadBase.php' );

class CheckSVGs extends Maintenance {
	private $lastFileName;
	private $upload;

	public function __construct() {
		parent::__construct();
		$this->addDescription( "Check old svgs to see if they are still valid" );
		$this->addOption( 'until', 'Date to stop checking', false, true );
		$this->addOption( 'max-size', 'Max size to check (in bytes)', false, true );
		$this->setBatchSize( 500 );
	}


	/**
	 * This is meant to connect to a tool labs db.
	 */
	private function getDBConnection() {
		$db = wfGetDB( DB_SLAVE );
		if ( !$db ) {
			$this->error( "Could not get db" );
			exit(1);
		}
		return $db;
	}

	public function execute() {
		global $wgDBname, $wgCityId;

		$this->output("Checking SVG images from a wiki ".WikiFactory::DBtoUrl( $wgDBname )." (cityId ${wgCityId})\n");

		$this->db = $this->getDBConnection();
		$this->upload = new UploadDummy;
		$total = 0;
		$bad = 0;
		$errors = 0;

		$repo = RepoGroup::singleton()->getLocalRepo();
		$fileBackend = $repo->getBackend();

		while ( $candidates = $this->getCandidates() ) {
			foreach( $candidates as $candidate ) {
				$total++;
				$file = $repo->newFileFromRow( $candidate );

				// debugging info
				$globalTitle = GlobalTitle::newFromText( $file->getTitle()->getText(), $file->getTitle()->getNamespace(), $wgCityId );
				$details = $globalTitle->getFullURL() . " (" . $file->getUrl() . ")";

				$path = $file->getPath();
				if (!$path) {
					$this->output("\tError while getting path for ${details}\n");
					$errors++;
					continue;
				}

				$fileContents = $fileBackend->getFileContents( array( 'src' => $path ) );
				if (!$fileContents) {
					$this->output("\tError while getting contents of ${details}\n");
					$errors++;
					continue;
				}

				$tmpFile = tempnam( wfTempDir(), 'img' );
				file_put_contents($tmpFile, $fileContents);
				$res = $this->checkFile( $tmpFile );
				unlink($tmpFile);
				if ( $res !== true ) {
					$bad++;
					$this->output("\tValidation error '${res}' while checking ${details}\n");
				}
			}
			$this->output("Done batch ${total} - at: " . $candidates[count($candidates)-1]->img_name . "\n");
		}
		$this->output("Complete: ${total} total; ${bad} bad, ${errors} errors\n");
	}

	private function checkFile( $file ) {
		return $this->upload->checkFile( $file );
	}

	private function getCandidates() {
		$conds = [
			'img_size < ' . ( (int)$this->getOption( 'max-size', 1024*1024*10 ) ),
			'img_major_mime' => 'image',
			'img_minor_mime' => 'svg+xml',
			'img_media_type' => 'DRAWING'
		];
		if ( $this->lastFileName ) {
			$conds[] = 'img_name > ' . $this->db->addQuotes( $this->lastFileName );
		}

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
				'LIMIT' => $this->mBatchSize

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

class UploadDummy extends UploadBase {
	public function initializeFromRequest( &$request ) {}

	/**
	 * @param String Full contents of svg file
	 *
	 * @return true if ok, or string for error code
	 */
	public function checkFile( $file ) {
		$this->mSVGNSError = false;
		$check = new XmlTypeCheck(
			$file,
			[ $this, 'checkSvgScriptCallback' ],
			[ 'processing_instruction_handler' => 'UploadBase::checkSvgPICallback' ]
		);
		if ( $check->wellFormed !== true ) {
			return 'uploadinvalidxml';
		} elseif ( $check->filterMatch ) {	// validation error
			if ( $this->mSVGNSError ) {
				return $this->mSVGNSError;
			}
			return $check->filterMatchType;
		}
		return true;
	}
}

$maintClass = "CheckSVGs";
require_once RUN_MAINTENANCE_IF_MAIN;
