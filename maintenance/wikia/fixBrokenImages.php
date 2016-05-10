<?php

/**
 * Script that tries to fix the following images:
 *
 * - image was uploaded but file cannot be found on the filesystem (delete image through normal MW methods)
 * - image was uploaded and then moved, the file exists under the old name (fix file position)
 * - image has size set to zero (get file's size from FS and correct database entry)
 *
 * @author Macbre
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class FixBrokenImages extends Maintenance {

	const REASON = 'Removing broken images';
	const USER = 'WikiaBot';
	const LOG_GROUP = 'swift-fix-images';

	const RESULT_EXISTS = 1;
	const RESULT_RESTORED = 2;
	const RESULT_NOT_RESTORED = 3;

	/* @var $repo LocalRepo */
	private $repo;
	private $isDryRun;
	private $otherLocation;
	private $foundMissing = [];

	/* @var $dbr DatabaseBase */
	private $dbr;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'dry-run', 'Don\'t perform any operations' );
		$this->addOption( 'other-location', 'Check images in other location then MW images directory/DFS' );
		$this->mDescription = 'This script tries to fix broken images';
	}

	/**
	 * Log to /var/log/private file
	 *
	 * @param $method string method
	 * @param $msg string message to log
	 */
	public static function log( $method, $msg ) {
		Wikia::log( self::LOG_GROUP . '-WIKIA', false, $method . ': ' . $msg, true /* $force */ );
	}

	/**
	 * Gets titles given file could be moved from
	 *
	 * This will allow us (to try) to get original image and move it to the proper destination path
	 *
	 * @param LocalFile $file
	 * @return Title[] array of titles
	 */
	private function getCandidates( $file ) {
		$titles = [];

		// select page_title from redirect join page on page_id = rd_from where rd_namespace = 6 AND rd_title = "PRO_006_Breaker.png";
		$res = $this->dbr->select(
			['redirect', 'page'],
			'page_title',
			[
				'rd_namespace' => NS_FILE,
				'rd_title' => $file->getName()
			],
			__METHOD__,
			[],
			[
				'page' => ['JOIN', 'page_id = rd_from']
			]
		);

		while ( $row = $res->fetchRow() ) {
			$titles[] = Title::newFromText( $row['page_title'], NS_FILE );
		}

		return $titles;
	}

	private function checkOtherLocation( File $file ) {
		global $wgUploadDirectory;
		$srcPath = $this->otherLocation . '/' . $file->getUrlRel();

		// check in other location
		$candidates = [];
		if ( file_exists( $srcPath ) ) {
			$candidates[] = basename( $srcPath );
			$orgSrcPath = $wgUploadDirectory . '/' . $file->getUrlRel();
			if ( !$this->isDryRun ) {
				copy( $srcPath, $orgSrcPath );
			}
			$this->foundMissing[] = $orgSrcPath;
		}
		return $candidates;
	}

	/**
	 * @param File $file file to check
	 * @see BAC-773
	 */
	private function checkFileSize( File $file ) {
		global $wgUploadDirectory;
		$size = $file->getSize();

		// we're fine
		if ( $size > 0 ) return;

		$path = $wgUploadDirectory . '/' . $file->getUrlRel();

		if ( file_exists( $path )  && ( $size = filesize( $path ) ) ) {
			if ( !$this->isDryRun ) {
				$dbw = wfGetDB( DB_MASTER );
				$dbw->update(
					'image',
					[
						'img_size' => $size
					],
					[
						'img_name' => $file->getName()
					],
					__METHOD__
				);
			}

			$res = true;
		}
		else {
			$res = false;
		}

		$this->output(
			sprintf(
				"'%s' has img_size = 0 (checking <%s>) - [%s]\n",
				$file->getTitle(),
				$path,
				$res ? ( 'done - set to ' . $size ) : 'err'
			)
		);
	}

	/**
	 * @param LocalFile $file file to check
	 * @return int RESULT_* flag
	 * @see BAC-731
	 */
	private function processMissingFile( File $file ) {
		global $wgUploadDirectory, $wgCityId;

		try {
			$exists = $this->repo->fileExists( $file->getPath() );
		}
		catch ( Exception $ex ) {
			$exists = true;
			$this->error( sprintf( "%s caught: %s", get_class( $ex ), $ex->getMessage() ) );
		}

		// file is fine, continue...
		if ( $exists ) {
			return self::RESULT_EXISTS;
		}

		$restored = false;

		$this->output( sprintf( "'%s' doesn't exist (%s)\n", $file->getTitle(), $file->getUrlRel() ) );

		// let's assume that given file was moved from A
		// let's get all possible A's and try to find images for them
		$candidates = $this->getCandidates( $file );
		
		if ( empty( $candidates ) && !empty( $this->otherLocation ) ) {
			# check other location - maybe this file is there :)
			$candidates = $this->checkOtherLocation( $file );
		}

		if ( !empty( $candidates ) ) {
			$this->output( sprintf( "  %d candidate(s) found...\n", count( $candidates ) ) );

			foreach ( $candidates as $candidate ) {
				$srcFile = LocalFile::newFromTitle( $candidate, $this->repo );
				$srcPath = $wgUploadDirectory . '/' . $srcFile->getUrlRel();

				// check on FS storage
				$foundOnFS = file_exists( $srcPath );

				$this->output( sprintf( "    '%s' -> <%s> [%s]\n", $srcFile->getName(), $srcPath, $foundOnFS ? 'found' : 'not found' ) );

				// check the next candidate (or if --dry-run)
				if ( !$foundOnFS || $this->isDryRun ) {
					continue;
				}

				// upload found image to Swift
				$swift = \Wikia\SwiftStorage::newFromWiki( $wgCityId );

				$metadata = [
					'Sha1Base36' => $file->getSha1()
				];
				$status = $swift->store( $srcPath, $file->getUrlRel(), $metadata, $file->getMimeType() );

				if ( $status->isOK() ) {
					self::log( 'restored', $file->getName() );
					$restored = true;
					break;
				}
			}

			$this->output( "\n" );
		}

		// remove an image if it can't be restored
		if ( !$restored && !$this->isDryRun ) {
			$file->delete( self::REASON );

			$this->output( sprintf( "  Removed '%s'!\n", $file->getName() ) );
			self::log( 'removed', $file->getName() );
		}

		return $restored ? self::RESULT_RESTORED : self::RESULT_NOT_RESTORED;
	}

	public function execute() {
		global $wgUser;
		$wgUser = User::newFromName( self::USER );

		$this->isDryRun = $this->hasOption( 'dry-run' );
		$this->otherLocation = $this->getOption( 'other-location' );

		$this->repo = RepoGroup::singleton()->getLocalRepo();
		$this->dbr = $this->getDB( DB_SLAVE );

		$images = 0;
		$imagesMissing = 0;
		$imagesFixed = 0;

		$res = $this->dbr->select( 'image', LocalFile::selectFields(), '', __METHOD__ );
		$count = $res->numRows();

		$this->output( sprintf( "Checking all images (%d images)%s...\n\n", $count, ( $this->isDryRun ? ' in dry run mode' : '' ) ) );

		while ( $row = $res->fetchObject() ) {
			$file = LocalFile::newFromRow( $row, $this->repo );

			// 1. check file size (img_size = 0 in image table)
			$this->checkFileSize( $file );

			// 2. check for missing files on FS / Swift storage
			$result = $this->processMissingFile( $file );

			switch( $result ) {
				case self::RESULT_RESTORED:
					$imagesFixed++;
					$imagesMissing++;
					break;

				case self::RESULT_NOT_RESTORED:
					$imagesMissing++;
					break;
			}

			// progress
			if ( ++$images % 100 ) {
				$this->output( sprintf( "%d%%\r", ( $images / $count ) * 100 ) );
			}
		}

		// summary
		if ( !empty( $this->otherLocation ) ) {
			$this->output( sprintf( "Restored %d images from second location \n", count( $this->foundMissing ) ) );
			$this->output( "List of restored files: \n" );
			$this->output( sprintf( "%s\n\n", implode( "\t\n", $this->foundMissing ) ) );
		}
		$this->output( sprintf( "Detected %d missing images (%.2f%% of %d images) and fixed %d images\n\n", $imagesMissing, ( $imagesMissing / $count ) * 100 , $count, $imagesFixed ) );
	}
}

$maintClass = "FixBrokenImages";
require_once( RUN_MAINTENANCE_IF_MAIN );
