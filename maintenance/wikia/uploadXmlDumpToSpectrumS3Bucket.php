<?php

require_once __DIR__ . '/../Maintenance.php';

/**
 * PLATFORM-4161: uploads XML dumps for public wikis to S3 bucket.
 *
 * Script need to be executed with 2 arguments: AWSAccessKey, AWSSecretKey and bucket name.
 *
 * use --saveChanges to actually prepare and save XML dumps
 */

class UploadXmlDumpToSpectrumS3Bucket extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Downloads XML dump for all public wikis and uploads it to Spectrum S3 bucket';
		$this->addOption( 'AWSAccessKey', 'Spectrum AWS access key', true, true, 'a' );
		$this->addOption( 'AWSSecretKey', 'Spectrum AWS secret key', true, true, 's' );
		$this->addOption( 'bucketName', 'S3 bucket name', true, true, 'b' );
		$this->addOption( 'fromWikiId', 'start running script from specific wiki ID', false, true, 'i' );
		$this->addOption( 'saveChanges', 'Get XML dump and save it in s3 bucket', false, false, 'd' );
	}

	public function execute() {

		global $wgMaxShellTime, $wgMaxShellFileSize, $wgDumpsDisabledWikis;

		$AWSAccessKey = $this->getOption( 'AWSAccessKey' );
		$AWSSecretKey = $this->getOption( 'AWSSecretKey' );
		$bucketName =  $this->getOption( 'bucketName' );
		$fromWikiId =  $this->getOption( 'fromWikiId' );
		$saveChanges = $this->hasOption( 'saveChanges' );

		$range = array();
		$range[] = "city_public = 1";

		if( !empty( $wgDumpsDisabledWikis ) && is_array( $wgDumpsDisabledWikis ) ) {
			$range[] = 'city_id NOT IN (' . implode( ',', $wgDumpsDisabledWikis ) . ')';
		}

		if ( $fromWikiId !== false ) {
			$range[] = sprintf( "city_id >= %d", $fromWikiId );
		}

		$wgMaxShellTime = 0;
		$wgMaxShellFileSize = 0;

		$dbw = Wikifactory::db( DB_SLAVE );
		$sth = $dbw->select(
			array( "city_list" ),
			array( "city_id", "city_dbname" ),
			$range,
			__METHOD__,
			array( "ORDER BY" => "city_id" )
		);

		$s3 = new S3( $AWSAccessKey, $AWSSecretKey );

		while( $row = $dbw->fetchObject( $sth ) ) {
			$this->output( "Preparing XML dump for {$row->city_id} - {$row->city_dbname}\n" );
			if ( $saveChanges ) {
				$this->runBackup( $bucketName, $s3, $row,
					sprintf( "%s/%s_pages_current.xml.7z", sys_get_temp_dir(), $row->city_dbname ),
					[ '--current' ] );
				$this->output( "Done, XML dump saved in S3 bucket\n" );

			}
		}

	}

	private function putToAmazonS3( string $sPath, bool $bPublic, string $sMimeType, string $bucketName, $s3 )  {

		$size = filesize( $sPath );

		S3::setExceptions( true );

		$file = fopen( $sPath, 'rb' );
		$resource = S3::inputResource( $file, $size );
		$remotePath = DumpsOnDemand::getPath( basename( $sPath ) );

		$s3->putObject(
			$resource,
			$bucketName,
			$remotePath,
			'bucket-owner-full-control', //Required by spectrum, but does not exist as a constant in AWS SDK
			[],
			[
				'Content-Disposition' => 'attachment',
				'Content-Type' => $sMimeType
			]
		);
	}

	private function runBackup( $bucketName, $s3, $row, $path, array $args = [] ) {
		global $IP, $wgWikiaLocalSettingsPath, $options;

		$server = wfGetDB( DB_SLAVE, 'dumps', $row->city_dbname )->getProperty( "mServer" );
		$cmd = implode( ' ', array_merge( [
			"SERVER_ID={$row->city_id}",
			"php -d display_errors=1",
			"{$IP}/maintenance/dumpBackup.php",
			"--conf {$wgWikiaLocalSettingsPath}",
			"--xml",
			"--quiet",
			"--server=$server",
			"--output=".DumpsOnDemand::DEFAULT_COMPRESSION_FORMAT.":{$path}"
		], $args ) );

		$cmd .= ' 2>&1';
		wfShellExec( $cmd, $status );

		if ( $status === 0 ) {
			try {
				$this->putToAmazonS3( $path, !isset( $options[ "hide" ] ),  MimeMagic::singleton()->guessMimeType(
					$path
				), $bucketName, $s3 );
				$this->output("XML dump was successful\n");
			} catch( S3Exception $ex ) {
				$this->output( "Failed to put XML dump for {$row->city_id} ({$row->city_dbname}) to bucket {$ex}\n" );
				exit( 1 );
			}
			unlink( $path );
		}
		else {
			$this->output( "Skipped XML dump creation for {$row->city_id} ({$row->city_dbname})\n" );
			exit( 2 );
		}
	}
}

$maintClass = 'UploadXmlDumpToSpectrumS3Bucket';
require_once RUN_MAINTENANCE_IF_MAIN;
