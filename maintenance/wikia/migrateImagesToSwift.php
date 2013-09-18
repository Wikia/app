<?php

/**
 * Script that copies files from file system to distributed storage
 *
 * @see http://www.mediawiki.org/wiki/Manual:Image_administration#Data_storage
 *
 * @author Macbre
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class MigrateImagesToSwift extends Maintenance {

	const REASON = 'Images migration script';

	private $migratedImagesCnt = 0;
	private $migratedImagesSize = 0;
	private $notExistingImages = [];

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( "dry-run", "Do not move any files, just list them" );
		$this->addOption( "verbose", "Be more noisy" );
		$this->mDescription = 'Copies files from file system to distributed storage';
	}

	/**
	 * Get local path to an image
	 *
	 * Example: /6/6b/DSCN0906.JPG
	 *
	 * Add $wgUploadDirectory as a prefix to get full local path to an image
	 *
	 * @param $$row array image data
	 * @return string image path
	 */
	private function getImagePath(Array $row) {
		$hash = md5($row['name']);

		return sprintf(
			'%s/%s%s/%s',
			$hash{0},
			$hash{0},
			$hash{1},
			$row['name']
		);
	}

	/**
	 * Get local path to old image
	 *
	 * Example: /archive/0/0a/20120924125348!UploadTest.png
	 *
	 * Add $wgUploadDirectory as a prefix to get full local path to archived image
	 *
	 * @param $$row array image data
	 * @return string image path
	 */
	private function getOldImagePath(Array $row) {
		// /0/0a/UploadTest.png -> /archive/0/0a/20120924125348!UploadTest.png
		$hash = md5($row['name']);

		return sprintf(
			'archive/%s/%s%s/%s',
			$hash{0},
			$hash{0},
			$hash{1},
			$row['archived_name']
		);
	}

	/**
	 * Get local path to removed image
	 *
	 * Example: /deleted/4/u/m/4um19gqt6qjuq1m8qgqwyf04zgmtk2s.png
	 *
	 * Add $wgUploadDirectory as a prefix to get full local path to archived image
	 *
	 * @param $$row array image data
	 * @return string image path
	 */
	private function getRemovedImagePath(Array $row) {
		$hash = $row['storage_key'];

		return sprintf(
			'deleted/%s/%s/%s/%s',
			$hash{0},
			$hash{1},
			$hash{2},
			$row['storage_key']
		);
	}

	private function logEntry(Array $row, $path) {
		global $wgUploadDirectory;

		if ($this->hasOption('verbose')) {
			$this->output(sprintf("\n* %s - %.2f kB <%s/%s>",
				$row['name'],
				$row['size'] / 1024,
				$wgUploadDirectory,
				$path
			));
		}
	}

	/**
	 * Assert that given file exists on the disk
	 *
	 * @param $path string path to a file
	 * @return bool
	 */
	private function assertFileExists($path) {
		if (!file_exists($path)) {
			$this->notExistingImages[] = $path;
			$this->error("\n\n###### {$path} does not exist!");
			return false;
		}

		return true;
	}

	/**
	 * Copy given file to Swift storage
	 *
	 * @param $path string full file path to be migrated
	 * @param $path array image info
	 */
	private function copyFile($path, Array $row) {
		$this->migratedImagesSize += $row['size'];
		$this->migratedImagesCnt++;
	}

	public function execute() {
		global $wgDBname, $wgEnableCephFileBackend, $wgUploadDirectory;

		$dbr = $this->getDB( DB_SLAVE );
		$isDryRun = $this->hasOption('dry-run');

		$this->output("Migrating images on {$wgDBname} - <{$wgUploadDirectory}>...\n");

		if (!empty($wgEnableCephFileBackend)) {
			#$this->error('$wgEnableCephFileBackend = true - new files storage enabled on this wiki!', 1);
		}

		$tables = [
			'filearchive',
			'image',
			'oldimage',
		];

		foreach($tables as $table) {
			$count = $dbr->selectField($table, 'count(*)');
			$this->output("* {$table}:\t{$count}\n");
		}

		// prepare the list of files to migrate to new storage
		// (a) current revisions of images
		// @see http://www.mediawiki.org/wiki/Image_table
		$this->output("\nA) Getting list of current revisions of images - /images\n");

		$res = $dbr->select('image', [
			'img_name AS name',
			'img_size AS size',
		]);

		while($row = $res->fetchRow()) {
			$path = $this->getImagePath($row);
			$this->logEntry($row, $path);

			#if ($this->assertFileExists($wgUploadDirectory . '/' . $path)) {
				$this->copyFile($path, $row);
			#}
		}

		// (b) old revisions of images
		// @see http://www.mediawiki.org/wiki/Oldimage_table
		$this->output("\nB) Getting list of current revisions of images - /archive\n");

		$res = $dbr->select('oldimage', [
			'oi_name AS name',
			'oi_archive_name AS archived_name',
			'oi_size AS size',
		]);

		while($row = $res->fetchRow()) {
			$path = $this->getOldImagePath($row);
			$this->logEntry($row, $path);

			#if ($this->assertFileExists($wgUploadDirectory . '/' . $path)) {
				$this->copyFile($path, $row);
			#}
		}

		// (c) deleted images
		// @see http://www.mediawiki.org/wiki/Filearchive_table
		$this->output("\nC) Getting list of removed images - /deleted\n");

		$res = $dbr->select('filearchive', [
			'fa_name AS name',
			'fa_storage_key AS storage_key',
			'fa_size AS size',
		]);

		while($row = $res->fetchRow()) {
			$path = $this->getRemovedImagePath($row);
			$this->logEntry($row, $path);

			#if ($this->assertFileExists($wgUploadDirectory . '/' . $path)) {
				$this->copyFile($path, $row);
			#}
		}

		// summary
		$this->output(sprintf("\nMigrated files: %d (%.2f GB)\n",
			$this->migratedImagesCnt,
			$this->migratedImagesSize / 1024 / 1024 / 1024
		));

		/**
		$this->output(sprintf("\nNot existing files: %d\n* %s\n",
				count($this->notExistingImages),
				implode("\n* ", $this->notExistingImages)
		));
		**/
		$this->output("\nDone!\n");
	}
}

$maintClass = "MigrateImagesToSwift";
require_once( RUN_MAINTENANCE_IF_MAIN );
