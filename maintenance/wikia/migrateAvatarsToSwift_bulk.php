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
class MigrateAvatarsToSwiftBulk2 extends Maintenance {
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

	private $uploadDir;
	private $section;

	// stats
	private $imagesCnt = 0;
	private $imagesSize = 0;
	private $migratedImagesCnt = 0;
	private $migratedImagesFailedCnt = 0;
	private $migratedImagesSize = 0;

	private $time = 0;

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
		$this->addOption( 'debug', 'Show a lot of debugging stuff.' );
		$this->addOption( 'diff', 'Use incremental strategy while uploading files.' );
		$this->addOption( 'no-deletes', 'Do not remove orphans in ceph' );
		$this->addOption( 'threads', 'Total number of threads (gets split across DCs) (default: '.self::THREADS_DEFAULT.', max. '.self::THREADS_MAX.').' );
		$this->addOption( 'local', 'Read files from local file system (uses: /raid/images/by_id/).' );
		$this->addOption( 'wait', 'Add en extra 180 seconds sleep after disabling uploads.' );
		$this->addOption( 'section', 'Section - directory prefix too look at.' );
		$this->addOption( 'hammer', 'Hammer a single host.' );
		$this->mDescription = 'Copies files from file system to distributed storage';
	}

	/**
	 * Set up the config variables
	 */
	private function init() {
		global $wgUploadDirectory, $wgDBname, $wgCityId;

		$this->setupMd5Cache();

		$dcs = explode(',', $this->getOption('dc', 'sjc,res'));

		foreach($dcs as $dc) {
			// force a different bucket name via --bucket
			$swiftBackend = \Wikia\SwiftStorage::newFromContainer( 'common', '/avatars', $dc );

			$remotePath = $swiftBackend->getUrl( '' );
			$this->output( "Migrating avatars - <{$this->uploadDir}> -> <{$remotePath}> [dc: {$dc}]...\n" );

			$this->swiftBackends[$dc] = $swiftBackend;
			$this->timePerDC[$dc] = 0;
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

	private function system_extension_mime_types() {
		# Returns the system MIME type mapping of extensions to MIME types, as defined in /etc/mime.types.
		$out = array();
		$file = fopen('/etc/mime.types', 'r');
		while(($line = fgets($file)) !== false) {
			$line = trim(preg_replace('/#.*/', '', $line));
			if(!$line)
				continue;
			$parts = preg_split('/\s+/', $line);
			if(count($parts) == 1)
				continue;
			$type = array_shift($parts);
			foreach($parts as $part)
				$out[$part] = $type;
		}
		fclose($file);
		return $out;
	}

	private function system_extension_mime_type($file) {
		# Returns the system MIME type (as defined in /etc/mime.types) for the filename specified.
		#
		# $file - the filename to examine
		static $types;
		if(!isset($types))
			$types = $this->system_extension_mime_types();
		$ext = pathinfo($file, PATHINFO_EXTENSION);
		if(!$ext)
			$ext = $file;
		$ext = strtolower($ext);
		return isset($types[$ext]) ? $types[$ext] : null;
	}
	private function getMimeType( $path ) {
		return $this->system_extension_mime_type($path);
	}

	private function processItem( $localPath, $remotePath ) {
		if ( is_file($localPath) ) {
			if ( is_readable($localPath) ) {
				$metadata = array();
				$mime = $this->getMimeType($localPath);
				$this->allFiles[] = array(
					'src' => $localPath,
					'dest' => $remotePath,
					'metadata' => $metadata,
					'mime' => $mime,
					'size' => filesize($localPath),
					'md5' => $this->md5Cache->get($localPath),
				);
			} else {
				$this->logError("File could not be read: ".$localPath);
			}
		} else if ( is_dir($localPath) ) {
			$this->logInfo("processItem: directory: {$localPath}");
			$items = scandir($localPath);
			foreach ($items as $item) {
				if ( $item == '.' || $item == '..' )
					continue;
				$this->processItem($localPath.'/'.$item,$remotePath.'/'.$item);
			}
		}
	}

	private function processPath( $rootPath, $remotePath, $relPath ) {
		$rootPath = rtrim($rootPath,'/') . '/';
		$remotePath = rtrim($remotePath,'/') . '/';
		$relPath = trim($relPath,'/');
		$this->processItem($rootPath.$relPath,$remotePath.$relPath);
	}

	private function parseSection() {
		$sectionReq = $this->getOption('section','');
		$m = array();
		$section = '';
		if ( preg_match("/^([0-9a-f])([0-9a-f]?)\$/",$sectionReq,$m) ) {
			$section .= '/'.$m[1];
			if ( array_key_exists(2,$m) && $m[2] !== '' ) {
				$section .= '/'.$m[1].$m[2];
			}
		}
		$this->section = $section;
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
		global $wgDBname, $wgCityId, $wgExternalSharedDB, $wgAvatarsMaintenance;

		$this->debug = $this->hasOption( 'debug' );

		$this->logger = new \Wikia\Swift\Logger\Logger($this->debug ? 10 : 10,-1,10);
		$this->logger->setFile('/var/log/migration/'.$wgDBname.'.log');
		$this->logger = $this->logger->prefix($wgDBname);

		$isForced = $this->hasOption( 'force' );
		$isDryRun = $this->hasOption( 'dry-run' );

		$this->useDiff = $this->getOption('diff',false);
		$this->useLocalFiles = $this->getOption('local',false);
		$this->useDeletes = !$this->hasOption('no-deletes');

		$this->threads = intval($this->getOption('threads',self::THREADS_DEFAULT));
		$this->threads = min(self::THREADS_MAX,max(1,$this->threads));

		$this->hammer = $this->getOption('hammer',null);
		$this->parseSection();

		$uploadDir = "/images/c/common/avatars" . $this->section;
		$uploadDir = $this->rewriteLocalPath($uploadDir);
		$this->uploadDir = $uploadDir;

		$this->init();


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
		if ( empty( $wgAvatarsMaintenance ) && !$isDryRun ) {
			$this->error( "\$wgAvatarsMaintenance = false - avatars maintenance is not switched on, cannot proceed!", 1 );
		}

		// ok, so let's start...
		$this->time = time();

		$this->output("Collecting files to upload...\n\n");
		foreach (str_split('0123456789abcdef') as $p) {
			$this->processPath($uploadDir,'avatars'.$this->section,$p);
		}
		$this->output(sprintf("Found %d files...\n\n",count($this->allFiles)));

		if ( $this->hasOption( 'stats-only' ) ) {
			return;
		}


		self::logWikia( __CLASS__, 'migration started', self::LOG_MIGRATION_PROGRESS );

		// block uploads via WikiFactory
		if (!$isDryRun) {
			$this->output( "Uploads and avatars operations disabled\n\n" );
		}
		else {
			$this->output( "Performing dry run...\n\n" );
		}

		$this->processQueue();

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
			$container = new \Wikia\Swift\Entity\Container('common');
			$targets[] = new \Wikia\Swift\Wiki\Target($cluster,$container);
		}

		if ( empty($targets) ) {
			$this->logError("No DC remaining after applying --hammer");
			return;
		}

		$files = $this->allFiles;

		if ( $this->useDiff ) {
			$migration = new \Wikia\Swift\Wiki\DiffMigration($targets,$files);
			$remoteFilter = new \Wikia\Swift\Wiki\AvatarFilesFilter('/avatars');
			$migration->setRemoteFilter($remoteFilter);
			$migration->setUseDeletes($this->useDeletes);
		} else {
			$migration = new \Wikia\Swift\Wiki\SimpleMigration($targets,$files);
		}
		$migration->setThreads($this->threads);
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

}

$maintClass = "MigrateAvatarsToSwiftBulk2";
require_once( RUN_MAINTENANCE_IF_MAIN );
