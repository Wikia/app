<?php

/**
 * Script that tries to fix the following images:
 *
 * - image was uploaded but file cannot be found on the filesystem (delete image through normal MW methods)
 * - image was uploaded and then moved, the file exists under the old name (fix file position)
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

	/* @var $repo LocalRepo */
	private $repo;
	private $isDryRun;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'dry-run', 'Don\'t perform any operations' );
		$this->mDescription = 'This script tries to fix broken images';
	}

	/**
	 * @param LocalFile $file file to process
	 * @return bool true if file exists
	 */
	private function processFile(File $file) {
		try {
			$exists = $this->repo->fileExists( $file->getPath() );
		}
		catch(Exception $ex) {
			$exists = true;
			$this->error( sprintf("%s caught: %s", get_class($ex), $ex->getMessage()) );
		}

		if (!$exists) {
			$this->output( sprintf("'%s' doesn't exist (%s)\n", $file->getTitle(), $file->getPath()) );
		}

		return $exists;
	}

	public function execute() {
		$this->repo = RepoGroup::singleton()->getLocalRepo();

		#$this->isDryRun = $this->hasOption( 'dry-run' );
		$this->isDryRun = true;

		$dbr = $this->getDB( DB_SLAVE );

		$images = 0;
		$imagesMissing = 0;

		$res = $dbr->select( 'image', LocalFile::selectFields(), '', __METHOD__ );
		$count = $res->numRows();

		$this->output( sprintf("Checking all images (%d images)...\n\n", $count) );

		while ( $row = $res->fetchObject() ) {
			$file = LocalFile::newFromRow($row, $this->repo);
			$exists = $this->processFile($file);

			if (!$exists) {
				$imagesMissing++;
			}

			// progress
			if (++$images % 20) {
				$this->output( sprintf("%d%%\r", ($images / $count) * 100) );
			}
		}

		// summary
		$this->output( sprintf("Detected %d missing images (%.2f%% of %d images)\n\n", $imagesMissing, ($imagesMissing / $count) * 100 , $count) );
	}
}

$maintClass = "FixBrokenImages";
require_once( RUN_MAINTENANCE_IF_MAIN );
