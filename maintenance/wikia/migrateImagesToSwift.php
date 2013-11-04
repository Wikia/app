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

	const FILES_PER_SEC = 10;
	const KB_PER_SEC = 800;

	// log groups
	const LOG_MIGRATION_PROGRESS = 'swift-migration-progress';
	const LOG_MIGRATION_ERRORS = 'swift-migration-errors';

	/* @var \Wikia\SwiftStorage $swift */
	private $swift;

	// stats
	private $imagesCnt = 0;
	private $imagesSize = 0;
	private $migratedImagesCnt = 0;
	private $migratedImagesFailedCnt = 0;
	private $migratedImagesSize = 0;

	private $time = 0;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'force', 'Perform the migration even when $wgEnableSwiftFileBackend = true' );
		$this->addOption( 'stats-only', 'Show stats (number of files and total size) and then exit' );
		$this->mDescription = 'Copies files from file system to distributed storage';
	}

	/**
	 * Set up the config variables
	 */
	private function init() {
		global $wgUploadDirectory, $wgDBname, $wgCityId;
		$this->swift = \Wikia\SwiftStorage::newFromWiki( $wgCityId );
		$remotePath = $this->swift->getUrl( '' );

		$this->output( "Migrating images on {$wgDBname} - <{$wgUploadDirectory}> -> <{$remotePath}>...\n" );
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
	private function getImagePath( Array $row ) {
		$hash = md5( $row['name'] );

		return sprintf(
			'%s/%s%s/%s',
			$hash { 0 } ,
			$hash { 0 } ,
			$hash { 1 } ,
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
	private function getOldImagePath( Array $row ) {
		// /0/0a/UploadTest.png -> /archive/0/0a/20120924125348!UploadTest.png
		$hash = md5( $row['name'] );

		return sprintf(
			'archive/%s/%s%s/%s',
			$hash { 0 } ,
			$hash { 0 } ,
			$hash { 1 } ,
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
	 * @return string|bool image path or false if storage_key is empty
	 */
	private function getRemovedImagePath( Array $row ) {
		$hash = $row['storage_key'];

		if ( $hash === '' ) return false;

		return sprintf(
			'deleted/%s/%s/%s/%s',
			$hash { 0 } ,
			$hash { 1 } ,
			$hash { 2 } ,
			$row['storage_key']
		);
	}

	/**
	 * Copy given file to Swift storage
	 *
	 * @param $path string full file path to be migrated
	 * @param $path array image info
	 */
	private function copyFile( $path, Array $row ) {
		global $wgUploadDirectory, $wgCityId, $wgDBname;

		if ( $path === false ) return;

		// set metadata
		$metadata = [];
		$mime = "{$row['major_mime']}/{$row['minor_mime']}";

		if ( !empty( $row['hash'] ) ) {
			$metadata['Sha1Base36'] = $row['hash'];
		}

		$res = $this->swift->store( $wgUploadDirectory . '/' . $path, $path, $metadata, $mime );

		if ( !$res->isOK() ) {
			self::log( __METHOD__, "error storing <{$path}>", self::LOG_MIGRATION_ERRORS );
			$this->migratedImagesFailedCnt++;
		}
		else {
			$mwStorePath = sprintf( 'mwstore://swift-backend/%s/images/%s', $wgDBname, $path );
						
			Wikia\SwiftSync\Queue::newFromParams( [
				'city_id' => $wgCityId,
				'op' => 'store',
				'src' => $wgUploadDirectory . '/' . $path,
				'dst' => $mwStorePath
			] )->add();
					
			$this->migratedImagesSize += $row['size'];
			$this->migratedImagesCnt++;
		}

		// "progress bar"
		if ( $this->migratedImagesCnt % 5 === 0 ) {
			$elapsed = time() - $this->time + 1;

			// estimate remaining time
			$filesPerSec = $this->migratedImagesCnt /  $elapsed;
			$remainingSeconds = $filesPerSec ? round( ( $this->imagesCnt - $this->migratedImagesCnt ) / $filesPerSec ) : 0;

			$this->output( sprintf(
				"%d%%: %s/%s - %.2f files/sec, %.2f kB/s [ETA %s]     \r",
				round( $this->migratedImagesCnt / $this->imagesCnt * 100 ),
				$this->migratedImagesCnt,
				$this->imagesCnt,
				$filesPerSec,
				( $this->migratedImagesSize / 1024 ) / ( $elapsed ),
				Wikia::timeDuration($remainingSeconds)
			) );
		}
	}

	/**
	 * Log to /var/log/private file
	 *
	 * @param $method string method
	 * @param $msg string message to log
	 * @param $group string file to log to
	 */
	private static function log($method, $msg, $group) {
		\Wikia::log($group . '-WIKIA', false, $method . ': ' . $msg, true /* $force */);
	}

	public function execute() {
		global $wgCityId, $wgExternalSharedDB;

		$this->init();
		$dbr = $this->getDB( DB_SLAVE );

		$isForced = $this->hasOption( 'force' );

		// one migration is enough
		global $wgEnableSwiftFileBackend, $wgEnableUploads, $wgDBname;
		if ( !empty( $wgEnableSwiftFileBackend ) && !$isForced ) {
			$this->error( "\$wgEnableSwiftFileBackend = true - new files storage already enabled on {$wgDBname} wiki!", 1 );
		}

		if ( empty( $wgEnableUploads ) && !$isForced ) {
			$this->error( "\$wgEnableUploads = false - migration is already running on {$wgDBname} wiki!", 1 );
		}

		// get images count
		$tables = [
			'filearchive' => 'fa_size',
			'image' => 'img_size',
			'oldimage' => 'oi_size',
		];

		foreach ( $tables as $table => $sizeField ) {
			$row = $dbr->selectRow( $table, [
					'count(*) AS cnt',
					"SUM({$sizeField}) AS size"
				],
				[],
				__METHOD__
			);

			$this->output( sprintf( "* %s:\t%d images (%d MB)\n",
				$table,
				$row->cnt,
				round( $row->size / 1024 / 1024 )
			) );

			$this->imagesCnt += $row->cnt;
			$this->imagesSize += $row->size;
		}

		$this->output( sprintf( "\n%d image(s) (%d MB) will be migrated (should take ~ %s with %d kB/s / ~ %s with %d files/sec)...\n",
			$this->imagesCnt,
			round( $this->imagesSize / 1024 / 1024 ),
			Wikia::timeDuration($this->imagesSize / 1024 / self::KB_PER_SEC),
			self::KB_PER_SEC,
			Wikia::timeDuration($this->imagesCnt / self::FILES_PER_SEC),
			self::FILES_PER_SEC
		) );

		if ( $this->hasOption( 'stats-only' ) ) {
			return;
		}

		// ok, so let's start...
		$this->time = time();

		self::log( __CLASS__, 'migration started', self::LOG_MIGRATION_PROGRESS );

		// wait a bit to prevent deadlocks (from 0 to 2 sec)
		usleep( mt_rand(0,2000) * 1000 );

		// lock the wiki
		$dbw = $this->getDB( DB_MASTER, array(), $wgExternalSharedDB );
		$dbw->replace( 'city_image_migrate', [ 'city_id' ], [ 'city_id' => $wgCityId, 'locked' => 1 ], __CLASS__ );

		// block uploads via WikiFactory
		WikiFactory::setVarByName( 'wgEnableUploads',     $wgCityId, false, self::REASON );
		WikiFactory::setVarByName( 'wgUploadMaintenance', $wgCityId, true,  self::REASON );

		$this->output( "Uploads and image operations disabled\n\n" );

		// prepare the list of files to migrate to new storage
		// (a) current revisions of images
		// @see http://www.mediawiki.org/wiki/Image_table
		$this->output( "\nA) Current revisions of images - /images\n" );

		$res = $dbr->select( 'image', [
			'img_name AS name',
			'img_size AS size',
			'img_sha1 AS hash',
			'img_major_mime AS major_mime',
			'img_minor_mime AS minor_mime',
		] );

		while ( $row = $res->fetchRow() ) {
			$path = $this->getImagePath( $row );
			$this->copyFile( $path, $row );
		}

		// (b) old revisions of images
		// @see http://www.mediawiki.org/wiki/Oldimage_table
		$this->output( "\nB) Old revisions of images - /archive\n" );

		$res = $dbr->select( 'oldimage', [
			'oi_name AS name',
			'oi_archive_name AS archived_name',
			'oi_size AS size',
			'oi_sha1 AS hash',
			'oi_major_mime AS major_mime',
			'oi_minor_mime AS minor_mime',
		] );

		while ( $row = $res->fetchRow() ) {
			$path = $this->getOldImagePath( $row );
			$this->copyFile( $path, $row );
		}

		// (c) deleted images
		// @see http://www.mediawiki.org/wiki/Filearchive_table
		$this->output( "\nC) Deleted images - /deleted\n" );

		$res = $dbr->select( 'filearchive', [
			'fa_name AS name',
			'fa_storage_key AS storage_key',
			'fa_size AS size',
			'fa_major_mime AS major_mime',
			'fa_minor_mime AS minor_mime',
		] );

		while ( $row = $res->fetchRow() ) {
			$path = $this->getRemovedImagePath( $row );
			$this->copyFile( $path, $row );
		}

		// summary
		$report = sprintf( 'Migrated %d files (%d MB) with %d fails in %s (%.2f files/sec, %.2f kB/s)',
			$this->migratedImagesCnt,
			round( $this->migratedImagesSize / 1024 / 1024 ),
			$this->migratedImagesFailedCnt,
			Wikia::timeDuration( time() - $this->time ),
			floor( $this->imagesCnt ) / ( time() - $this->time ),
			( $this->migratedImagesSize / 1024 ) / ( time() - $this->time )
		);

		$this->output( "\n{$report}\n" );
		self::log( __CLASS__, 'migration completed - ' . $report, self::LOG_MIGRATION_PROGRESS );

		// unlock the wiki
		$dbw->replace( 'city_image_migrate', [ 'city_id' ], [ 'city_id' => $wgCityId, 'locked' => 0 ], __CLASS__ );

		// update wiki configuration
		// enable Swift storage via WikiFactory
		WikiFactory::setVarByName( 'wgEnableSwiftFileBackend', $wgCityId, true, self::REASON );

		$this->output( "\nNew storage enabled\n" );

		// enable uploads via WikiFactory
		// wgEnableUploads = true / wgUploadMaintenance = false (remove values from WF to give them the default value)
		WikiFactory::removeVarByName( 'wgEnableUploads',     $wgCityId, self::REASON );
		WikiFactory::removeVarByName( 'wgUploadMaintenance', $wgCityId, self::REASON );

		$this->output( "\nUploads and image operations enabled\n" );

		$this->output( "\nDone!\n" );
	}
}

$maintClass = "MigrateImagesToSwift";
require_once( RUN_MAINTENANCE_IF_MAIN );
