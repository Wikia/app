<?php

/**
 * This script will upload Video to a wiki.
 */

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

/**
 * Maintenance script class
 */
class UploadVideo extends Maintenance {

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

		$this->mDescription = 'This script uploads video to a wiki';

		$this->addOption( 'file-list', "List of files to upload in format 'provide:filename'", true );
	}

	/**
	 * @param string $fileName
	 * @return mixed
	 */
	private function uploadVideo( $fileName ) {
		$videoService = new VideoService();
		return $videoService->addVideo( $fileName );
	}

	public function execute() {
		global $wgUser, $wgDBname;

		$fileList = realpath( $this->getOption( 'file-list' ) );
		if ( !file_exists( $fileList ) ) {
			$this->error( "File with list of files to upload does not exists: $fileList", 1 );
		}

		$files = file( $fileList, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );

		if ( !$files ) {
			$this->error( "Could not read list of files to upload: $fileList", 2 );
		}

		// perform video uploads as FANDOMbot
		$wgUser = User::newFromName( Wikia::BOT_USER );
		$cnt = 0;

		foreach ( $files as $fileName ) {
			++$cnt;
			$fileName = trim( $fileName );
			$this->output( sprintf( "%s: uploading file: %s  ...\n", $wgDBname, $fileName ) );
			$res = $this->uploadVideo( $fileName );
			if ( !is_array( $res ) ) {
				$this->error( sprintf( "%s: error uploading file: %s\n", $wgDBname, $res ) );
			} else {
				$this->output( sprintf( "%s: file uploaded: %s\n", $wgDBname, $fileName ) );
			}
		}

		$this->output( sprintf( "%s: videos uploaded %d\n", $wgDBname, $cnt ) );
	}
}

$maintClass = UploadVideo::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
