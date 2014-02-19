<?php

/**
 * Script that copies files from file system to distributed storage
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
class MigrateImagesToSwiftBulk2 extends Maintenance {
	use \Wikia\Swift\Logger\LoggerFeature;

	const REASON = 'Images migration script';

	const FILES_PER_SEC = 10;
	const KB_PER_SEC = 800;
	const THREADS_MAX = 400;
	const THREADS_DEFAULT = 100;

	const SWIFT_BUCKET_NAME_MIN_LENGTH = 3;

	// log groups
	const LOG_MIGRATION_PROGRESS = 'swift-migration-progress';
	const LOG_MIGRATION_ERRORS = 'swift-migration-errors';

	const LOCAL_PATH = '/raid/images/by_id/';

	const MD5_CACHE_DIRECTORY = '/raid/migration/md5';

	// connections to Swift backends images will be migrated to
	/* @var \Wikia\SwiftStorage[] $swiftBackends */
	private $swiftBackends;
	private $timePerDC = [];

	private $shortBucketNameFixed = false;

	private $areUploadsDisabled = false;
	/** @var \Wikia\Swift\File\Md5Cache $md5Cache */
	private $md5Cache;

	// stats
	private $imagesCnt = 0;
	private $imagesSize = 0;
	private $migratedImagesCnt = 0;
	private $migratedImagesFailedCnt = 0;
	private $migratedImagesSize = 0;

	private $time = 0;

	private $pathPrefix = null;
	private $useDiff = false;
	private $useLocalFiles = false;
	private $useDeletes = true;
	private $threads = self::THREADS_DEFAULT;
	private $hammer = null;

	private $debug = false;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'force', 'Perform the migration even if $wgEnableSwiftFileBackend = true' );
		$this->addOption( 'stats-only', 'Show stats (number of files and total size) and then exit' );
		$this->addOption( 'dry-run', 'Migrate images, but don\'t disable uploads and don\'t switch wiki to Swift backend' );
		$this->addOption( 'dc', 'Comma separated list of DCs to migrate images to (defaults to "sjc,res")' );
		$this->addOption( 'bucket', 'Force a different bucket name than the default one (for testing only!)' );
		$this->addOption( 'debug', 'Show a lot of debugging stuff.' );
		$this->addOption( 'diff', 'Use incremental strategy while uploading files.' );
		$this->addOption( 'no-deletes', 'Do not remove orphans in ceph' );
		$this->addOption( 'threads', 'Total number of threads (gets split across DCs) (default: '.self::THREADS_DEFAULT.', max. '.self::THREADS_MAX.').' );
		$this->addOption( 'local', 'Read files from local file system (uses: /raid/images/by_id/).' );
		$this->addOption( 'wait', 'Add en extra 180 seconds sleep after disabling uploads.' );
		$this->addOption( 'hammer', 'Hammer a single host.' );
		$this->mDescription = 'Copies files from file system to distributed storage';
	}

	/**
	 * Set up the config variables
	 */
	private function init() {
		global $wgUploadDirectory, $wgDBname, $wgCityId;

		$this->setupMd5Cache();

		$this->shortBucketNameFixed = $this->fixShortBucketName();

		$bucketName = $this->getOption('bucket', false);
		$dcs = explode(',', $this->getOption('dc', 'sjc,res'));

		foreach($dcs as $dc) {
			if (!is_string($bucketName)) {
				// use bucket name taken from wiki upload path
				$swiftBackend = \Wikia\SwiftStorage::newFromWiki( $wgCityId, $dc );
			}
			else {
				// force a different bucket name via --bucket
				$swiftBackend = \Wikia\SwiftStorage::newFromContainer( $bucketName, '/images', $dc );
			}

			$remotePath = $swiftBackend->getUrl( '' );
			$this->output( "Migrating images on {$wgDBname} - <{$wgUploadDirectory}> -> <{$remotePath}> [dc: {$dc}]...\n" );

			$this->swiftBackends[$dc] = $swiftBackend;
			$this->timePerDC[$dc] = 0;

			$this->pathPrefix = $swiftBackend->getPathPrefix();
		}
	}

	/**
	 * Try to "fix" wikis with too short (less than 3 characters) bucket names
	 *
	 * $wgUploadDirectory = '/images/v/vs/pl/images'
	 * wgUploadPath = 'http://images.wikia.com/vs/pl/images'
	 *
	 * Migrate to:
	 *
	 * $wgUploadDirectory = '/images/v/vs_/pl/images'
	 * wgUploadPath = 'http://images.wikia.com/vs_/pl/images'
	 *
	 * Container name: "vs_"
	 *
	 * This method sets $wgUploadDirectoryNFS WF variable.
	 * It is used when synchronizing Swift operations back to NFS storage.
	 *
	 * @return boolean true if the "fix" was applied
	 */
	private function fixShortBucketName() {
		global $wgUploadDirectory, $wgUploadPath, $wgUploadDirectoryNFS;

		$nfsUploadDirectory = !empty($wgUploadDirectoryNFS) ? $wgUploadDirectoryNFS : $wgUploadDirectory;

		$parts = explode('/', trim($nfsUploadDirectory, '/')); // images, first bucket name letter, <bucket name>, ...
		$bucketName = $parts[2];

		// bucket name is fine, leave now
		if (strlen($bucketName) >= self::SWIFT_BUCKET_NAME_MIN_LENGTH) {
			return false;
		}

		// keep the old path
		$wgUploadDirectoryNFS = $nfsUploadDirectory;

		// fill with underscores
		$bucketName = str_pad($bucketName, self::SWIFT_BUCKET_NAME_MIN_LENGTH, '_', STR_PAD_RIGHT);

		// update $wgUploadDirectory and wgUploadPath accordingly
		$parts[2] = $bucketName;
		$wgUploadDirectory = '/' . join('/', $parts);
		$wgUploadPath = 'http://images.wikia.com/' . join('/', array_slice($parts, 2)); // remove /images/ and first letter parts

		self::logWikia( __CLASS__, "short bucket name fix applied - '{$bucketName}', <{$wgUploadPath}>, <{$wgUploadDirectory}>, NFS: <{$wgUploadDirectoryNFS}>" , self::LOG_MIGRATION_PROGRESS );
		return true;
	}

	protected function setupMd5Cache() {
		global $wgDBname;
		$md5Cache = \Wikia\Swift\File\Md5Cache::getInstance();
		$md5CacheFile = sprintf("%s/%s/%s/%s.md5list",self::MD5_CACHE_DIRECTORY,substr($wgDBname,0,1),substr($wgDBname,0,2),$wgDBname);
		$md5Cache->setCacheFile($md5CacheFile);
		$this->md5Cache = $md5Cache;
	}

	protected function rewriteLocalPath( $path ) {
		if ( $this->useLocalFiles ) {
			$path = preg_replace("#^/images/by_id/#",self::LOCAL_PATH,$path);
			$path = preg_replace("#^/images/#",self::LOCAL_PATH,$path);
		}
		return $path;
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

	protected $allFiles = array();

	/**
	 * Copy given file to Swift storage
	 *
	 * @param $path string full file path to be migrated
	 * @param $path array image info
	 */
	private function queueFile( $path, Array $row ) {
		global $wgUploadDirectory, $wgUploadDirectoryNFS;

		if ( $path === false ) return;

		$uploadDir = !empty($wgUploadDirectoryNFS) ? $wgUploadDirectoryNFS : $wgUploadDirectory;

		// set metadata
		$metadata = [];
		$mime = "{$row['major_mime']}/{$row['minor_mime']}";

		if ( !empty( $row['hash'] ) ) {
			$metadata['Sha1Base36'] = $row['hash'];
		}

		$src = $this->rewriteLocalPath( $uploadDir . '/' . $path );

		$this->allFiles[] = array(
			'row' => $row,
			'src' => $src,
			'dest' => ltrim( $this->pathPrefix . '/' . $path, '/'),
			'metadata' => $metadata,
			'mime' => $mime,
		);
	}

	/**
	 * Log to /var/log/private file
	 *
	 * @param $method string method
	 * @param $msg string message to log
	 * @param $group string file to log to
	 */
	private static function logWikia($method, $msg, $group) {
		\Wikia::log($group . '-WIKIA', false, $method . ': ' . $msg, true /* $force */);
	}

	private function fatal($method, $msg, $group) {
		\Wikia::log($group . '-WIKIA', false, $method . ': ' . $msg, true /* $force */);
		$this->logError($msg);
		die($msg . PHP_EOL);
	}

	public function execute() {
		global $wgDBname, $wgCityId, $wgExternalSharedDB, $wgUploadDirectory, $wgUploadDirectoryNFS;

		$this->debug = $this->hasOption( 'debug' );

		$this->logger = new \Wikia\Swift\Logger\Logger($this->debug ? 10 : 10,-1,10);
		$this->logger->setFile('/var/log/migration/'.$wgDBname.'.log');
		$this->logger = $this->logger->prefix($wgDBname);

		// force migration of wikis with read-only mode
		if (wfReadOnly()) {
			global $wgReadOnly;
			$wgReadOnly = false;
		}

		$this->init();
		$dbr = $this->getDB( DB_SLAVE );

		$isForced = $this->hasOption( 'force' );
		$isDryRun = $this->hasOption( 'dry-run' );

		$this->useDiff = $this->getOption('diff',false);
		$this->useLocalFiles = $this->getOption('local',false);
		$this->useDeletes = !$this->hasOption('no-deletes');

		$this->threads = intval($this->getOption('threads',self::THREADS_DEFAULT));
		$this->threads = min(self::THREADS_MAX,max(1,$this->threads));

		$this->hammer = $this->getOption('hammer',null);

		$uploadDir = !empty($wgUploadDirectoryNFS) ? $wgUploadDirectoryNFS : $wgUploadDirectory;
		$uploadDir = $this->rewriteLocalPath($uploadDir);
		if ( !is_dir($uploadDir) ) {
			$this->fatal(__CLASS__,"Could not read the source directory: {$uploadDir}",self::LOG_MIGRATION_ERRORS);
		}

		// just don't fuck everything!
		if ( $this->useLocalFiles && !$isDryRun ) {
			if ( gethostname() !== 'file-s4' ) {
				$this->fatal(__CLASS__,"Incremental upload requires access to master file system (don't use --local)",self::LOG_MIGRATION_ERRORS);
			}
		}
		if ( !empty($this->hammer) && !$isDryRun ) {
			$this->fatal(__CLASS__,"Hammer option not supported when not using --dry-run",self::LOG_MIGRATION_ERRORS);
		}

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

		self::logWikia( __CLASS__, 'migration started', self::LOG_MIGRATION_PROGRESS );

		// wait a bit to prevent deadlocks (from 0 to 2 sec)
		usleep( mt_rand(0,2000) * 1000 );

		// lock the wiki
		$dbw = $this->getDB( DB_MASTER, array(), $wgExternalSharedDB );
		if (!$isDryRun) {
			$dbw->replace( 'city_image_migrate', [ 'city_id' ], [ 'city_id' => $wgCityId, 'locked' => 1 ], __CLASS__ );
		}

		// block uploads via WikiFactory
		if (!$isDryRun) {
			register_shutdown_function(array($this,'unlockWiki'));
			$this->areUploadsDisabled = true;
			WikiFactory::setVarByName( 'wgEnableUploads',     $wgCityId, false, self::REASON );
			WikiFactory::setVarByName( 'wgUploadMaintenance', $wgCityId, true,  self::REASON );

			$this->output( "Uploads and image operations disabled\n\n" );

			if ( $this->hasOption('wait') ) {
				$this->output( "Sleeping for 180 seconds to let Apache finish uploads...\n" );
				sleep(180);
			}
		}
		else {
			$this->output( "Performing dry run...\n\n" );
		}

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
			$this->queueFile( $path, $row );
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
			$this->queueFile( $path, $row );
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
			$this->queueFile( $path, $row );
		}

		$this->processQueue();

		echo count($this->allFiles) . PHP_EOL;

		// stats per DC
		$statsPerDC = [];
		foreach ($this->timePerDC as $dc => $time) {
			$statsPerDC[] = sprintf("%s took %s", $dc, Wikia::timeDuration(round($time)));
		}



		// summary
		$totalTime = time() - $this->time;

		$report = sprintf( 'Migrated %d files with %d fails in %s',
			$this->migratedImagesCnt,
			$this->migratedImagesFailedCnt,
			Wikia::timeDuration( $totalTime )
		);

		$this->output( "\n{$report}\n" );
		self::logWikia( __CLASS__, 'migration completed - ' . $report, self::LOG_MIGRATION_PROGRESS );

		// if running in --dry-run, leave now
		if ($isDryRun) {
			$this->output( "\nDry run completed!\n" );
			return;
		}

		// unlock the wiki
		$dbw->ping();
		$dbw->replace( 'city_image_migrate', [ 'city_id' ], [ 'city_id' => $wgCityId, 'locked' => 0 ], __CLASS__ );

		$dbr = $this->getDB( DB_MASTER, array(), $wgExternalSharedDB );
		$dbr->ping();

		// update wiki configuration
		// enable Swift storage via WikiFactory
		WikiFactory::setVarByName( 'wgEnableSwiftFileBackend', $wgCityId, true, sprintf('%s - migration took %s', self::REASON, Wikia::timeDuration( $totalTime ) ) );

		$this->output( "\nNew storage enabled\n" );

		// too short bucket name fix
		if ($this->shortBucketNameFixed) {
			global $wgUploadPath, $wgUploadDirectory, $wgUploadDirectoryNFS;
			WikiFactory::setVarByName( 'wgUploadPath',         $wgCityId, $wgUploadPath,         self::REASON );
			WikiFactory::setVarByName( 'wgUploadDirectory',    $wgCityId, $wgUploadDirectory,    self::REASON );
			WikiFactory::setVarByName( 'wgUploadDirectoryNFS', $wgCityId, $wgUploadDirectoryNFS, self::REASON );

			$this->output( "\nNew upload directory set up\n" );
		}

		// enable uploads via WikiFactory
		// wgEnableUploads = true / wgUploadMaintenance = false (remove values from WF to give them the default value)
		WikiFactory::removeVarByName( 'wgEnableUploads',     $wgCityId, self::REASON );
		WikiFactory::removeVarByName( 'wgUploadMaintenance', $wgCityId, self::REASON );
		$this->areUploadsDisabled = false;

		$this->output( "\nUploads and image operations enabled\n" );

		$this->output( "\nDone!\n" );
	}

	protected function processQueue() {
		global $wgFSSwiftDC;

		$this->logDebug(sprintf("Found %d entries in md5 cache",$this->md5Cache->getCachedCount()));

		$targets = array();
		foreach($this->swiftBackends as $dc => $swift) {
			$hostnames = $wgFSSwiftDC[$dc]['servers'];
			if ( $this->hammer !== null ) {
				if ( !in_array($this->hammer,$hostnames) ) {
					$this->logError("Skipping DC {$dc} due to --hammer argument");
					continue;
				} else {
					$hostnames = array( $this->hammer );
					$this->logError("Using only {$this->hammer} for DC {$dc}");
				}
			}
			$authConfig = $wgFSSwiftDC[$dc]['config'];
			$cluster = new \Wikia\Swift\Net\Cluster($dc,$hostnames,$authConfig);
			$container = new \Wikia\Swift\Entity\Container($swift->getContainerName());
			$targets[] = new \Wikia\Swift\Wiki\Target($cluster,$container);
		}

		if ( empty($targets) ) {
			$this->logError("No DC remaining after applying --hammer");
			return;
		}

		$files = $this->allFiles;

		if ( $this->useDiff ) {
			$migration = new \Wikia\Swift\Wiki\DiffMigration($targets,$files);
			$remoteFilter = new \Wikia\Swift\Wiki\WikiFilesFilter($this->pathPrefix);
			$migration->setRemoteFilter($remoteFilter);
			$migration->setUseDeletes($this->useDeletes);
		} else {
			$migration = new \Wikia\Swift\Wiki\SimpleMigration($targets,$files);
		}
		$migration->setThreads(400);
		$migration->copyLogger($this);
		$migration->run();

		$invalid = $migration->getInvalid();
		$completed = $migration->getCompleted();
		$failed = $migration->getFailed();

		$this->migratedImagesCnt = count($invalid);
		foreach($migration->getListNames() as $listName) {
			$completedCount = array_key_exists($listName,$completed) ? count($completed[$listName]) : 0;
			$failedCount = array_key_exists($listName,$failed) ? count($failed[$listName]) : 0;
			$this->logError(sprintf("%s: completed=%d failed=%d invalid=%d",
				$listName,
				$completedCount,
				$failedCount,
				count($invalid)
			));
			$this->migratedImagesCnt += $completedCount;
			$this->migratedImagesCnt += $failedCount;
			$this->migratedImagesFailedCnt += $failedCount;
			$results = $failed[$listName];
			/** @var \Wikia\Swift\Transaction\OperationResult $result */
			foreach ($results as $result) {
				$result->logError($result->getError());
				// re-emit logs with increased severity
				$logs = $result->getLogs();
				foreach ($logs as $message ) {
					$result->logError($message);
				}

			}
		}

		$this->logInfo("Finished migration.");
	}

	public function unlockWiki() {
		global $wgCityId;
		if ( $this->areUploadsDisabled ) {
			WikiFactory::removeVarByName( 'wgEnableUploads',     $wgCityId, self::REASON );
			WikiFactory::removeVarByName( 'wgUploadMaintenance', $wgCityId, self::REASON );
			$this->areUploadsDisabled = false;
		}
	}

}

$maintClass = "MigrateImagesToSwiftBulk2";
require_once( RUN_MAINTENANCE_IF_MAIN );
