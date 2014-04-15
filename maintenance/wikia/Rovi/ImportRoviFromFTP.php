<?php
require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class ImportRoviFromFTP extends Maintenance {
	const TMP_DIR = '/tmp';
	const TMP_DIR_PREFIX = "rovi_";
	const SHARED_DB = "wikiaglobal";
	const UPLOAD_SCRIPT_MASK = "/usr/bin/php ImportRoviData.php %s";
	const FILE_MASK = "/RVU2-0_Infrm/Series/Series_%s_Differential_Delta.zip";
	const FILE_BUFFER = 512;
	const DELTA_VARIABLE_NAME = "wgLastRoviUpdate";
	const UTF16_TAG = "\xFF\xFE";
	protected $FTPConnID;
	protected $tmpdir;
	protected $dataFiles = [
		"seriesFile" => "Series.txt",
		"episodesFile" => "Episode_Sequence.txt"
	];

	public function __construct() {
		parent::__construct();
		register_shutdown_function( [ $this, 'cleanup' ] );
	}

	protected function cleanup() {
		$this->rrmdir( $this->tmpdir );
	}

	protected function rrmdir( $dir ) {
		foreach ( glob( $dir . '/*' ) as $file ) {
			if ( is_dir( $file ) ) {
				rrmdir( $file );
			} else {
				unlink( $file );
			}
		}
		rmdir( $dir );
	}

	public function execute() {
		$this->FTPConnID = $this->getFTPConnection();
		$this->tmpdir = $this->makeTempDir();
		if ( !$this->tmpdir ) {
			$this->error( "unable to create temporary dir\n", true );
		}
		$this->output( "tmp_dir:" . $this->tmpdir . "\n" );

		$lastDelta = $this->getLastUpdateDelta();
		if ( !$lastDelta ) {
			$this->error( "No last delta info available. Import full DB and\n"
				. "create variable " . self::DELTA_VARIABLE_NAME . " with the import date like 'YYYY-MM-DD'\n\n", true );
		}
		$this->output( "Last delta: $lastDelta \n" );
		$files = $this->getNewFileList( $lastDelta );
		if ( !count( $files ) ) {
			$this->output( "No new files available\n" );
			exit(0);
		}
		$files = $this->downloadFiles( $files );
		$this->loadDataToDb( $files );
		//$this->cleanup();
	}

	protected function loadDataToDb( $files ) {
		foreach ( $files as $file ) {
			$retVal = 255;
			$filesArg = '';
			foreach ( $this->dataFiles as $argName => $value ) {
				$filesArg .= " --$argName=" . $file[ 'plain' ][ $value ];
			}
			$command = sprintf( self::UPLOAD_SCRIPT_MASK, $filesArg );
			$this->output( "Run command: $command\n" );
			$response = wfShellExec( $command, $retVal );
			$this->output( $response );
			if ( $retVal !== 0 ) {
				$this->error( "Command:$command failed.\n", true );
			}
			$this->setLastUpdateDelta( $file[ 'date' ] );
		}
	}

	protected function makeTempDir() {
		do{
			$tempdir = self::TMP_DIR."/".uniqid(self::TMP_DIR_PREFIX);
		}while(file_exists($tempdir));

		if ( mkdir($tempdir) ) {
			return $tempdir;
		}
		return false;
	}


	protected function downloadFiles( $files ) {
		$zip = new ZipArchive();
		foreach ( $files as $k => $file ) {
			$local = $this->getFileFromFTP( $file[ 'name' ] );
			if ( !$zip->open( $local ) ) {
				$this->error( "Unable to open file: $local (" . $file[ 'name' ] . ")", true );
			}

			foreach ( $this->dataFiles as $unpacked ) {
				$stream = $zip->getStream( $unpacked );
				$fileData = "";
				while ( !feof( $stream ) ) {
					$fileData .= fread( $stream, self::FILE_BUFFER );
				}
				fclose( $stream );
				if ( substr( $fileData, 0, 2 ) === self::UTF16_TAG ) {
					$fileData = iconv( "UTF-16", "UTF-8", $fileData );
				}
				$plainName = $this->tmpdir . "/" . $file[ "date" ] . $unpacked;
				file_put_contents( $plainName, $fileData );
				$files[ $k ][ "plain" ][ $unpacked ] = $plainName;
			}
		}
		return $files;
	}


	protected function getNewFileList( $lastDelta ) {
		$timestamp = strtotime( $lastDelta );
		$today = mktime(0,0,0);
		$files = [ ];
		do {
			$timestamp = strtotime( "+ 1 day", $timestamp );
			$file = sprintf( self::FILE_MASK, date( 'Ymd', $timestamp ) );
			if ( $this->FTPFileExists( $file ) ) {
				$files[ ] = [ 'name' => $file, 'date' => date( 'Y-m-d', $timestamp ) ];
			}
		} while( $timestamp < $today);
		return $files;
	}

	protected function getLastUpdateDelta() {
		$var = WikiFactory::getVarByName( self::DELTA_VARIABLE_NAME, WikiFactory::DBtoID( self::SHARED_DB ) );
		if ( $var ) {
			return unserialize( $var->cv_value );
		}
		return false;
	}

	protected function setLastUpdateDelta( $value ) {
		WikiFactory::setVarByName( self::DELTA_VARIABLE_NAME, WikiFactory::DBtoID( self::SHARED_DB ), $value );
	}

	protected function getFTPConnection() {
		global $wgRoviAccount;
		$connId = ftp_connect( $wgRoviAccount[ "host" ] );
		if ( !$connId ) {
			$this->error( "Unable to connect to ROVI ", true );
		}
		$loginResult = ftp_login( $connId, $wgRoviAccount[ "username" ], $wgRoviAccount[ "password" ] );
		if ( !$loginResult ) {
			$this->error( "Unable to login to ROVI ", true );
		}
		return $connId;
	}

	protected function getFileFromFTP( $fileName ) {
		$localFile = tempnam( $this->tmpdir, 'rovi_' );
		$this->output( "Downloading file $fileName to $localFile\n" );
		if ( ftp_get( $this->FTPConnID, $localFile, $fileName, FTP_BINARY ) ) {
			echo "OK";
		} else {
			$this->error( "Unable to download file $fileName", true );
		}
		return $localFile;
	}

	protected function FTPFileExists( $fileName ) {
		return ftp_mdtm( $this->FTPConnID, $fileName ) !== -1;
	}

}

$maintClass = 'ImportRoviFromFTP';
require( RUN_MAINTENANCE_IF_MAIN );
