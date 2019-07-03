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
		$this->mDescription = 'Downloads XML dump for given wiki and uploads it to Spectrum S3 bucket';
		$this->addArg( 'AWSAccessKey', 'Spectrum AWS access key', true );
		$this->addArg( 'AWSSecretKey', 'Spectrum AWS secret key', true );
		$this->addArg( 'bucketName', 'S3 bucket name', true );
		$this->addOption( 'saveChanges', 'Get XML dump and save it in s3 bucket', false, false, 'd' );
	}

	public function execute() {

		global $wgMaxShellTime, $wgMaxShellFileSize, $wgDumpsDisabledWikis;

		$AWSAccessKey = $this->getArg( 0 );
		$AWSSecretKey = $this->getArg( 1 );
		$bucketName =  $this->getArg( 2 );
		$saveChanges = $this->hasOption( 'saveChanges' );

		$range = array();
		$range[] = "city_public = 1";

		if( !empty( $wgDumpsDisabledWikis ) && is_array( $wgDumpsDisabledWikis ) ) {
			$range[] = 'city_id NOT IN (' . implode( ',', $wgDumpsDisabledWikis ) . ')';
		}

		$wgMaxShellTime = 0;
		$wgMaxShellFileSize = 0;

		$dbw = Wikifactory::db( DB_MASTER );
		$sth = $dbw->select(
			array( "city_list" ),
			array( "city_id", "city_dbname" ),
			$range,
			__METHOD__,
			array( "ORDER BY" => "city_id" )
		);

		while( $row = $dbw->fetchObject( $sth ) ) {
			$this->output( "Preparing XML dump for {$row->city_id} - {$row->city_dbname}\n" );
			if ( $saveChanges ) {
				$this->runBackup( $AWSAccessKey, $AWSSecretKey, $bucketName, $row,
					sprintf( "%s/%s_pages_current.xml.7z", sys_get_temp_dir(), $row->city_dbname ),
					[ '--current' ] );
				$this->output( "Done, XML dump saved in S3 bucket\n" );

			}
		}

	}

	private function putToAmazonS3( string $sPath, bool $bPublic, string $sMimeType, string $AWSAccessKey, string
	$AWSSecretKey, string $bucketName )  {

		$size = filesize( $sPath );

		$s3 = new S3( $AWSAccessKey, $AWSSecretKey );
		S3::setExceptions( true );

		$file = fopen( $sPath, 'rb' );
		$resource = S3::inputResource( $file, $size );
		$remotePath = DumpsOnDemand::getPath( basename( $sPath ) );

		$s3->putObject(
			$resource,
			$bucketName,
			$remotePath,
			$bPublic ? S3::ACL_PUBLIC_READ : S3::ACL_PRIVATE,
			[],
			[
				'Content-Disposition' => 'attachment',
				'Content-Type' => $sMimeType
			]
		);
	}

	private function runBackup( $AWSAccessKey, $AWSSecretKey, $bucketName, $row, $path, array $args = [] ) {
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
				), $AWSAccessKey, $AWSSecretKey, $bucketName );
				$this->output("XML dump was successful\n");
			} catch( S3Exception $ex ) {
				$this->output( "Failed to put XML dump to bucket {$ex}\n" );
				exit( 1 );
			}
			unlink( $path );
		}
		else {
			$this->output( "Skipped XML dump creation\n" );
			exit( 2 );
		}
	}
}

$maintClass = 'UploadXmlDumpToSpectrumS3Bucket';
require_once RUN_MAINTENANCE_IF_MAIN;
