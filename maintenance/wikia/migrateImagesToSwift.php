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

	private $swiftServer;
	private $swiftConfig;
	private $swiftToken;
	/* @var CF_Connection $swiftConn */
	private $swiftConn;
	/* @var CF_Container $swiftConntainer */
	private $swiftContainer; // e.g. "poznan"
	private $swiftPathPrefix; // e.g. "pl/images"
	private $swiftContainerName;

	private $imagesCnt = 0;
	private $migratedImagesCnt = 0;
	private $migratedImagesFailedCnt = 0;
	private $migratedImagesSize = 0;

	private $time = 0;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Copies files from file system to distributed storage';
	}

	/**
	 * Set up the config variables
	 */
	private function init() {
		global $wgUploadDirectory, $wgFSSwiftContainer, $wgFSSwiftConfig, $wgFSSwiftServer, $wgDBname;

		// Swift server and config
		$this->swiftConfig = $wgFSSwiftConfig;
		$this->swiftServer = 'http://' . $wgFSSwiftServer;

		// parse upload paths and generate proper container mapping
		// wgFSSwiftContainer: poznan/pl
		// swiftContainerName: poznan
		// swiftPathPrefix: /pl/images
		$path = $wgFSSwiftContainer . '/images';

		list($this->swiftContainerName, $this->swiftPathPrefix) = explode('/', $path, 2);
		$this->swiftPathPrefix = $this->swiftPathPrefix . '/';

		$this->output("Migrating images on {$wgDBname} - <{$wgUploadDirectory}> -> <{$this->swiftServer}/{$this->swiftContainerName}/{$this->swiftPathPrefix}>...\n");
	}

	/**
	 * Connects to Swift and grab the container
	 *
	 * @return bool success?
	 */
	private function connectToSwift() {
		$auth = new CF_Authentication(
			$this->swiftConfig['swiftUser'],
			$this->swiftConfig['swiftKey'],
			null,
			$this->swiftConfig['swiftAuthUrl']
		);

		try {
			$auth->authenticate();
			$this->swiftConn = new CF_Connection( $auth );
		}
		catch(Exception $ex) {
			Wikia::log(__METHOD__, '::exception', $ex->getMessage());
			return false;
		}

		$this->swiftToken = $auth->auth_token;

		return true;
	}

	/**
	 * Get (created if necessary) the container
	 * 
	 * @param $containerName string container name
	 * @return CF_Container object
	 */
	private function getContainer($containerName) {
		try {
			$container = $this->swiftConn->get_container($containerName);
		}
		catch(NoSuchContainerException $ex) {
			$container =  $this->swiftConn->create_container($containerName);
		}
		catch(Exception $ex) {
			Wikia::log(__METHOD__, '::exception', $ex->getMessage());
			return false;
		}

		// set public ACL
		// http://s3.dfs-s1/swift/v1/firefly
		$url = "{$this->swiftServer}/swift/v1/{$containerName}";
		wfDebug(__METHOD__ . "::setACL: {$url}\n");

		/* @var $req CurlHttpRequest */
		$req = MWHttpRequest::factory( $url, array( 'method' => 'POST', 'noProxy' => true ) );
		$req->setHeader( 'X-Auth-Token', $this->swiftToken );
		$req->setHeader( 'X-Container-Read', '.r:*' );

		$status = $req->execute();

		return $status->isOK() ? $container : false;
	}

	/**
	 * Store given file on Swift
	 *
	 * @param $localFile string path to a local file
	 * @param $remotePath string remote path
	 * @param $mimeType string|bool MIME type of uploaded file to be set (false = try to detect it)
	 * @param $sha1Hash string|bool SHA-1 hash of the file contents in base 36 format (false = don't set it)
	 * @return CF_Object|bool object instance or false
	 */
	private function store($localFile, $remotePath, $mimeType = false, $sha1Hash = false) {
		$remotePath = $this->swiftPathPrefix . $remotePath;

		wfDebug(__METHOD__ . ": {$localFile} -> {$remotePath}\n");

		$time = microtime(true);

		try {
			$fp = @fopen($localFile, 'r');
			if (!$fp) {
				Wikia::log(__METHOD__, 'fopen', "{$localFile} doesn't exist");
				return false;
			}

			// check file size - sending empty file results in "HTTP 411 MissingContentLengh"
			$size = fstat($fp)['size'];
			if ($size === 0) {
				Wikia::log(__METHOD__, 'fstat', "{$localFile} is empty");
				return false;
			}

			$object = $this->swiftContainer->create_object($remotePath);

			// medata
			if (is_string($mimeType)) {
				$object->content_type = $mimeType;
			}

			if (is_string($sha1Hash)) {
				$object->setMetadataValues([
					'Sha1base36' => $sha1Hash
				]);
			}

			$object->write($fp, $size);
			fclose($fp);
		}
		catch(Exception $ex) {
			Wikia::log(__METHOD__, 'exception - ' . $localFile, $ex->getMessage());
			return false;
		}

		$time = round((microtime(true) - $time) * 1000);
		wfDebug(__METHOD__ . ": {$localFile} uploaded in {$time} ms\n");

		return $object;
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
	 * @return string|bool image path or false if storage_key is empty
	 */
	private function getRemovedImagePath(Array $row) {
		$hash = $row['storage_key'];

		if ($hash === '') return false;

		return sprintf(
			'deleted/%s/%s/%s/%s',
			$hash{0},
			$hash{1},
			$hash{2},
			$row['storage_key']
		);
	}

	/**
	 * Copy given file to Swift storage
	 *
	 * @param $path string full file path to be migrated
	 * @param $path array image info
	 */
	private function copyFile($path, Array $row) {
		global $wgUploadDirectory;

		if ($path === false) return;

		$this->migratedImagesSize += $row['size'];
		$this->migratedImagesCnt++;

		$mime = "{$row['major_mime']}/{$row['minor_mime']}";
		$hash = isset($row['hash']) ? $row['hash'] : false;

		$res = $this->store($wgUploadDirectory . '/' . $path, $path, $mime, $hash);

		if ($res === false) {
			$this->migratedImagesFailedCnt++;
		}

		// "progress bar"
		if ($this->migratedImagesCnt % 5 === 0) {
			// estimate remaining time
			$filesPerSec = ($this->migratedImagesCnt) / (time() - $this->time);
			$remainingSeconds = round(($this->imagesCnt - $this->migratedImagesCnt) / $filesPerSec);
			$remainingMinutes = floor($remainingSeconds / 60);

			$this->output(sprintf(
				"%d%%: %s/%s - %.2f files/sec, %.2f kB/s [ETA %d h %02d min %02d sec]     \r",
				round($this->migratedImagesCnt / $this->imagesCnt * 100),
				$this->migratedImagesCnt,
				$this->imagesCnt,
				$filesPerSec,
				($this->migratedImagesSize / 1024) / (time() - $this->time),
				floor($remainingMinutes / 60),
				$remainingMinutes % 60,
				$remainingSeconds % 60
			));
		}
	}

	public function execute() {
		global $wgCityId;
		$this->init();
		$dbr = $this->getDB( DB_SLAVE );

		// one migration is enough
		global $wgEnableCephFileBackend, $wgEnableUploads, $wgDBname;
		if (!empty($wgEnableCephFileBackend)) {
			#$this->error("\$wgEnableCephFileBackend = true - new files storage enabled on {$wgDBname} wiki!", 1);
		}

		if (empty($wgEnableUploads)) {
			#$this->error("\$wgEnableUploads = false - migration is already running on {$wgDBname} wiki!", 1);
		}

		$this->time = time();

		// connect to Swift
		if (!$this->connectToSwift()) {
			$this->error('Can\'t connect to Swift', 2);
		}

		// get / create container
		if (($this->swiftContainer = $this->getContainer($this->swiftContainerName)) === false) {
			$this->error('Can\'t get Swift container', 3);
		}

		Wikia::log(__CLASS__, false, 'migration started');

		// block uploads via WikiFactory
		WikiFactory::setVarByName('wgEnableUploads',     $wgCityId, false, self::REASON);
		WikiFactory::setVarByName('wgUploadMaintenance', $wgCityId, true,  self::REASON);

		$this->output("Uploads and image operations disabled\n\n");

		// get images count
		$tables = [
			'filearchive',
			'image',
			'oldimage',
		];

		foreach($tables as $table) {
			$count = $dbr->selectField($table, 'count(*)');
			$this->output("* {$table}:\t{$count}\n");

			$this->imagesCnt += $count;
		}

		$this->output("\n{$this->imagesCnt} image(s) will be migrated...\n");

		// prepare the list of files to migrate to new storage
		// (a) current revisions of images
		// @see http://www.mediawiki.org/wiki/Image_table
		$this->output("\nA) Current revisions of images - /images\n");

		$res = $dbr->select('image', [
			'img_name AS name',
			'img_size AS size',
			'img_sha1 AS hash',
			'img_major_mime AS major_mime',
			'img_minor_mime AS minor_mime',
		]);

		while($row = $res->fetchRow()) {
			$path = $this->getImagePath($row);
			$this->copyFile($path, $row);
		}

		// (b) old revisions of images
		// @see http://www.mediawiki.org/wiki/Oldimage_table
		$this->output("\nB) Old revisions of images - /archive\n");

		$res = $dbr->select('oldimage', [
			'oi_name AS name',
			'oi_archive_name AS archived_name',
			'oi_size AS size',
			'oi_sha1 AS hash',
			'oi_major_mime AS major_mime',
			'oi_minor_mime AS minor_mime',
		]);

		while($row = $res->fetchRow()) {
			$path = $this->getOldImagePath($row);
			$this->copyFile($path, $row);
		}

		// (c) deleted images
		// @see http://www.mediawiki.org/wiki/Filearchive_table
		$this->output("\nC) Deleted images - /deleted\n");

		$res = $dbr->select('filearchive', [
			'fa_name AS name',
			'fa_storage_key AS storage_key',
			'fa_size AS size',
			'fa_major_mime AS major_mime',
			'fa_minor_mime AS minor_mime',
		]);

		while($row = $res->fetchRow()) {
			$path = $this->getRemovedImagePath($row);
			$this->copyFile($path, $row);
		}

		// summary
		$report = sprintf('Migrated %d files (%d MB) with %d fails in %d min (%.2f files/sec, %.2f kB/s)',
			$this->migratedImagesCnt,
			round($this->migratedImagesSize / 1024 / 1024),
			$this->migratedImagesFailedCnt,
			ceil((time() - $this->time) / 60),
			floor($this->imagesCnt) / (time() - $this->time),
			($this->migratedImagesSize / 1024) / (time() - $this->time)
		);

		$this->output("\n{$report}\n");
		Wikia::log(__CLASS__, false, 'migration completed:  ' . $report);

		// update wiki configuration
		// enable Swift storage via WikiFactory
		WikiFactory::setVarByName('wgEnableCephFileBackend', $wgCityId, true, self::REASON);

		$this->output("\nNew storage enabled\n");

		// enable uploads via WikiFactory
		// wgEnableUploads = true / wgUploadMaintenance = false (remove values from WF to give them the default value)
		WikiFactory::removeVarByName('wgEnableUploads',     $wgCityId, self::REASON);
		WikiFactory::removeVarByName('wgUploadMaintenance', $wgCityId, self::REASON);

		$this->output("\nUploads and image operations enabled\n");

		$this->output("\nDone!\n");
	}
}

$maintClass = "MigrateImagesToSwift";
require_once( RUN_MAINTENANCE_IF_MAIN );
