<?php

/**
 * Calculate md5 checksums for images on wiki
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
class CalculateImagesMd5 extends Maintenance {

	const REASON = 'md5 pre-calcutaion';

	const SWIFT_BUCKET_NAME_MIN_LENGTH = 3;

	// log groups
	const LOG_MIGRATION_PROGRESS = 'md5-calculation-progress';
	const LOG_MIGRATION_ERRORS = 'md5-calculation-errors';

	const LOCAL_PATH = '/raid/images/by_id/';

	const MD5_CACHE_DIRECTORY = '/raid/migration/md5';

	/** @var \Wikia\Swift\File\Md5Cache $md5Cache */
	private $md5Cache;

	// stats
	private $imagesCnt = 0;
	private $imagesSize = 0;

	private $useLocalFiles = false;
	private $hammer = null;

	private $debug = false;
	/** @var Wikia\Swift\Logger\Logger $logger */
	private $logger;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'debug', 'Show a lot of debugging stuff.' );
		$this->addOption( 'local', 'Read files from local file system (uses: /raid/images/by_id/).' );
		$this->mDescription = 'Calculate md5 checksums for images';
	}

	/**
	 * Set up the config variables
	 */
	private function init() {
		$this->setupMd5Cache();
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
			'src' => $src,
			'metadata' => $metadata,
			'mime' => $mime,
			'size' => $row['size'],
		);
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

	private function fatal($method, $msg, $group) {
		\Wikia::log($group . '-WIKIA', false, $method . ': ' . $msg, true /* $force */);
		$this->logger->log(0,$msg);
		die($msg . PHP_EOL);
	}

	public function execute() {
		global $wgDBname, $wgCityId, $wgExternalSharedDB, $wgUploadDirectory, $wgUploadDirectoryNFS;

		$this->debug = $this->hasOption( 'debug' );
		$this->logger = new \Wikia\Swift\Logger\Logger($this->debug ? 5 : 0,-1,10);
		$this->logger = $this->logger->prefix($wgDBname);

		// force migration of wikis with read-only mode
		if (wfReadOnly()) {
			global $wgReadOnly;
			$wgReadOnly = false;
		}

		$this->init();
		$dbr = $this->getDB( DB_SLAVE );

		$this->useLocalFiles = true;

		$this->hammer = $this->getOption('hammer',null);

		$uploadDir = !empty($wgUploadDirectoryNFS) ? $wgUploadDirectoryNFS : $wgUploadDirectory;
		$uploadDir = $this->rewriteLocalPath($uploadDir);
		if ( !is_dir($uploadDir) ) {
			$this->fatal(__CLASS__,"Could not read the source directory: {$uploadDir}",self::LOG_MIGRATION_ERRORS);
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

		$this->output( sprintf( "\n%d image(s) (%d MB) will get md5 pre-calculated...\n",
			$this->imagesCnt,
			round( $this->imagesSize / 1024 / 1024 )
		) );

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

		$md5Cache = $this->md5Cache;

		$countStatus = new \Wikia\Swift\Status\CountStatus();
		$countStatus->setTotal($this->imagesCnt);
		$sizeStatus = new Wikia\Swift\Status\SizeStatus();
		$sizeStatus->setTotal($this->imagesSize);

		$statusPrinter = new \Wikia\Swift\Status\StatusPrinter(new \Wikia\Swift\Status\AggregateStatus(array($countStatus,$sizeStatus)));
		$lastStatus = time();
		$statusPrinter->printStatus();
		foreach ($this->allFiles as $file) {
			$path = $file['src'];
			if ( is_file($path) && is_readable($path) ) {
				$md5Cache->get($path);
			}
			$countStatus->completed(1);
			$sizeStatus->completed($file['size']);
			if ( $lastStatus !== time() ) {
				$lastStatus = time();
				$statusPrinter->printStatus();
			}
		}
		$statusPrinter->finish();

		$this->output( "\nDone!\n" );
	}

}

$maintClass = "CalculateImagesMd5";
require_once( RUN_MAINTENANCE_IF_MAIN );
