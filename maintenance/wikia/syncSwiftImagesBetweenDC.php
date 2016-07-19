<?php

/**
 * Script that ensures secondary DC has all files that are present in primary DC
 *
 * @see http://www.mediawiki.org/wiki/Manual:Image_administration#Data_storage
 *
 * @author Macbre
 * @author wladek
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );
require_once( __DIR__ . '/../../includes/wikia/swift/all.php' );

/**
 * Maintenance script class
 */
class SyncSwiftImagesBetweeenDC extends Maintenance {

	const SOURCE_DC_DEFAULT = WIKIA_DC_SJC;
	const DESTINATION_DC_DEFAULT = WIKIA_DC_RES;

	private $debug;
	private $dryRun;
	private $sourceDC;
	private $destDCs;

	/* @var \Wikia\SwiftStorage[] $swiftBackends */
	private $swiftBackends;
	private $timePerDC = [];

	// stats
	private $imagesCnt = 0;
	private $imagesSize = 0;
	private $checkedImagesCnt = 0;
	private $migratedImagesCnt = 0;
	private $migratedImagesFailedCnt = 0;
	private $migratedImagesSize = 0;

	private $time = 0;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'debug', 'Print additional debugging information.' );
		$this->addOption( 'source-dc', sprintf('Source DC name (default: "%s")',self::SOURCE_DC_DEFAULT) );
		$this->addOption( 'dc', sprintf('Destination DC name (default: "%s")',self::DESTINATION_DC_DEFAULT) );
		$this->addOption( 'dry-run', 'Print what would be done only.' );
		$this->mDescription = 'Copies files from file system to distributed storage';
	}

	/**
	 * Set up the config variables
	 */
	private function init() {
		global $wgUploadDirectory, $wgDBname;

		$this->getRemoteItems($this->sourceDC);

		foreach($this->destDCs as $dc) {
			// use bucket name taken from wiki upload path
			$swiftBackend = $this->getSwiftBackend($dc);

			$remotePath = $swiftBackend->getUrl( '' );
			$this->output( "Syncing images on {$wgDBname} - <{$wgUploadDirectory}> -> <{$remotePath}> [dc: {$dc}]...\n" );

			$this->swiftBackends[$dc] = $swiftBackend;
			$this->timePerDC[$dc] = 0;

			$this->getRemoteItems($dc);
		}
	}

	/**
	 * Get an instance of SwiftStorage associated with specified DC
	 *
	 * @param $dc
	 * @return \Wikia\SwiftStorage
	 */
	private function getSwiftBackend( $dc ) {
		global $wgCityId;
		static $cache = array();
		if ( empty($cache[$dc]) ) {
			$cache[$dc] = \Wikia\SwiftStorage::newFromWiki( $wgCityId, $dc );
		}
		return $cache[$dc];
	}

	private function getSourceSwiftBackend() {
		return $this->getSwiftBackend($this->sourceDC);
	}

	private function getRemoteItems( $dc ) {
		global $wgFSSwiftDC;
		static $cache = array();
		if ( !array_key_exists($dc,$cache) ) {
			$this->output("Getting object list for DC: $dc\n");
			$swift = $this->getSwiftBackend($dc);

			// Collect all configuration for Bucket
			$hostnames = $wgFSSwiftDC[$dc]['servers'];
			$authConfig = $wgFSSwiftDC[$dc]['config'];
			$cluster = new \Wikia\Swift\Net\Cluster($dc,$hostnames,$authConfig);
			$container = new \Wikia\Swift\Entity\Container($swift->getContainerName());
			$bucket = new Wikia\Swift\S3\Bucket($cluster,$container);

			// Get list of objects in the buckets
			$items = $bucket->getItems();
			$this->debug(sprintf(" * received total of %d files\n",count($items)));

			$this->debug(" * filtering out non-MediaWiki objects\n");
			// Filter out items that don't belong to MediaWiki
			$filter = new Wikia\Swift\Wiki\WikiFilesFilter($swift->getPathPrefix());
			$items = $filter->filter($items);

			$this->debug(sprintf(" * done! got %d entries\n",count($items)));
			$cache[$dc] = $items;
		}
		return $cache[$dc];
	}

	/**
	 * @param $dc
	 * @param $path
	 * @return \Wikia\Swift\Entity\Remote|null
	 */
	private function getRemoteItem( $dc, $path ) {
		$pathPrefix = $this->getSwiftBackend($dc)->getPathPrefix();
		$path = ltrim( $pathPrefix . ($pathPrefix ? '/' : '') . $path, '/' );
		$items = $this->getRemoteItems($dc);
		return !empty($items[$path]) ? $items[$path] : null;
	}

	private function needsUpdate( $path ) {
		$source = $this->getRemoteItem($this->sourceDC,$path);
		if ( $source === null ) {
			$this->debug("(info) File not found in source DC: $path\n");
			return false;
		}
		foreach ( $this->destDCs as $dc ) {
			$dest = $this->getRemoteItem($dc,$path);
			if ( $dest === null ) {
				$this->debug("(info) File not found in destination DC($dc): $path\n");
				return true;
			}
			if ( $source->getMd5() !== $dest->getMd5() ) {
				$this->debug("(info) Md5 differs (src: {$source->getMd5()} vs {$dc}:{$dest->getMd5()}): $path\n");
				return true;
			}
			if ( $source->getSize() !== $dest->getSize() ) {
				$this->debug("(info) Size differs (src: {$source->getSize()} vs {$dc}:{$dest->getSize()}): $path\n");
				return true;
			}
		}
		return false;
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
		global $wgCityId, $wgDBname;

		if ( $path === false ) return;

		$this->checkedImagesCnt++;

		if ( !$this->needsUpdate($path) ) {
			return;
		}

		// set metadata
		$metadata = [];
		$mime = "{$row['major_mime']}/{$row['minor_mime']}";

		if ( !empty( $row['hash'] ) ) {
			$metadata['Sha1Base36'] = $row['hash'];
		}

		$res = Status::newGood();

		// download file
		$stream = $this->fetchFile($path);
		if ( !is_resource($stream) ) {
			$res->fatal(sprintf("[ERR ] Could not download file from source DC: %s",$path));
		}

		// migrate to all requested DCs
		if ( $res->isGood() ) {
			foreach($this->swiftBackends as $dc => $swift) {
				if ( $this->dryRun ) {
					$this->output(sprintf("(dry-run) would copy \"%s\" to %s\n",$path,$dc));
					continue;
				}
				$streamCopy = $this->dupeStream($stream);
				if ( empty($streamCopy) ) {
					$res->fatal("[ERR ] Could not copy source stream for DC: $dc");
					continue;
				}
				$then = microtime(true);
				$res->merge( $swift->store( $streamCopy, $path, $metadata, $mime ) );
				$this->timePerDC[$dc] += microtime(true) - $then;
				// in most cases SwiftStorage::store() closes the stream, but in case of error it doesn't
				@fclose($streamCopy);
			}
		}

		// close memory file
		fclose($stream);

		// check results
		if ( !$res->isOK() ) {
			$this->output(sprintf("[FAIL] cityId=%d dbname=%s path=%s\n",$wgCityId,$wgDBname,$path));

			$this->error( __METHOD__, [
				'exception' => new Exception(),
				'path' => $path,
				'status' => $res
			] );

			$this->migratedImagesFailedCnt++;
		}
		else {
			$this->output(sprintf("[DONE] cityId=%d dbname=%s path=%s\n",$wgCityId,$wgDBname,$path));
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

	private function fetchFile( $path ) {
		$sourceSwift = $this->getSourceSwiftBackend();
		$url = $sourceSwift->getUrl($path);
		$this->debug("Fetching file: $url\n");

		$stream = null;
		$content = file_get_contents($url);
		if ( $content ) {
			$size = strlen($content);
			$stream = fopen('php://memory','wb+');
			if ( $size === fwrite($stream,$content) ) {
				fseek($stream,0);
			} else {
				fclose($stream);
				$stream = null;
			}
		}
		return $stream;
	}

	private function dupeStream( $stream ) {
		fseek($stream,0,SEEK_END);
		$size = ftell($stream);
		rewind($stream);
		$newStream = fopen('php://memory','wb+');
		$copied = stream_copy_to_stream($stream,$newStream);
		if ( $copied !== $size ) {
			fclose($newStream);
			return null;
		}
		rewind($newStream);
		return $newStream;
	}

	private function debug( $msg ) {
		if ( $this->debug ) {
			$this->output($msg);
		}
	}

	public function execute() {
		global $wgExternalSharedDB;

		// force migration of wikis with read-only mode
		if (wfReadOnly()) {
			global $wgReadOnly;
			$wgReadOnly = false;
		}

		$this->debug = $this->hasOption('debug');
		$this->dryRun = $this->hasOption('dry-run');
		$this->sourceDC = $this->getOption('source-dc',self::SOURCE_DC_DEFAULT);
		$this->destDCs = explode(',',$this->getOption('dc',self::DESTINATION_DC_DEFAULT));

		$this->init();
		$dbr = $this->getDB( DB_SLAVE );

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

		$this->output( sprintf( "\n%d image(s) (%d MB) will be checked...\n",
			$this->imagesCnt,
			round( $this->imagesSize / 1024 / 1024 )
		) );

		if ( $this->hasOption( 'stats-only' ) ) {
			return;
		}

		// ok, so let's start...
		$this->time = time();

		// block uploads via WikiFactory
		$this->output( "Starting sync...\n\n" );

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

		// stats per DC
		$statsPerDC = [];
		foreach ($this->timePerDC as $dc => $time) {
			$statsPerDC[] = sprintf("%s took %s", $dc, Wikia::timeDuration(round($time)));
		}

		// summary
		$totalTime = time() - $this->time;

		$report = sprintf( 'Checked %d files and copied %d files (%d MB) with %d fails in %s',
			$this->checkedImagesCnt,
			$this->migratedImagesCnt,
			round( $this->migratedImagesSize / 1024 / 1024 ),
			$this->migratedImagesFailedCnt,
			Wikia::timeDuration( $totalTime )
		);

		$this->output( "\n{$report}\n" );

		$this->output( "\nDone!\n" );
	}
}

$maintClass = "SyncSwiftImagesBetweeenDC";
require_once( RUN_MAINTENANCE_IF_MAIN );
