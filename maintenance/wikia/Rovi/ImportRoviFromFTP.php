<?php
require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class ImportRoviFromFTP extends Maintenance {
	const TMP_DIR = '/tmp';
	const ROVI_FTP = 'ftp.rovicorp.com';
	const SHARED_DB = "wikicities";
	const FILE_MASK = "/RVU2-0_Infrm/Series/Series_%s_Differential_Delta.zip";
	const FILE_BUFFER = 512;
	const UTF16_TAG = "\xFF\xFE";
	protected $FTPConnID;
	protected $tmpdir;
	protected $dataFiles = [ "Series.txt", "Episode_Sequence.txt" ];

	public function __construct() {
		parent::__construct();
		$this->addOption( 'roviUser', 'Username' );
		$this->addOption( 'roviPassowrd', 'Password' );
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
			$this->error( "No last delta info available. Import full DB and\n
						create variable wgLastRoviUpdate with the import date like 'YYYY-MM-DD'\n\n", true );
		}
		$files = $this->getNewFileList( $lastDelta );
		if ( !count( $files ) ) {
			$this->error( "No new files available\n", true );
		}
		$res = $this->downloadFiles( $files );
		var_dump( $res );
	}

	protected function makeTempDir() {
		$tempfile = tempnam( self::TMP_DIR, '' );
		if ( file_exists( $tempfile ) ) {
			unlink( $tempfile );
		}
		mkdir( $tempfile );
		if ( is_dir( $tempfile ) ) {
			return $tempfile;
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
				if ( substr( $fileData, 0,2 ) === self::UTF16_TAG ) {
					$fileData = iconv( "UTF-16", "UTF-8", $fileData );
				}
				$plainName = $file[ "date" ] . $unpacked;
				file_put_contents( $this->tmpdir . "/" . $plainName, $fileData );
			}
			$files[ $k ][ "plain" ][ $unpacked ] = $plainName;

		}
		return $files;
	}


	protected function getNewFileList( $lastDelta ) {
		$timestamp = strtotime( $lastDelta );
		$files = [ ];
		while ( true ) {
			$timestamp = strtotime( "+ 1 day", $timestamp );
			$file = sprintf( self::FILE_MASK, date( 'Ymd', $timestamp ) );
			if ( !$this->FTPFileExists( $file ) ) {
				break;
			}
			$files[ ] = [ 'name' => $file, 'date' => date( 'Y-m-d', $timestamp ) ];
		}
		return $files;
	}

	protected function getLastUpdateDelta() {
		return "2014-04-01";
		return WikiFactory::getVarByName( 'wgLastRoviUpdate', WikiFactory::DBtoID( self::SHARED_DB ) );
	}

	protected function setLastUpdateDelta( $value ) {
		WikiFactory::setVarByName( 'wgLastRoviUpdate', WikiFactory::DBtoID( self::SHARED_DB ), $value );
	}

	protected function getFTPConnection() {
		$username = $this->getOption( 'roviUser', '' );
		$password = $this->getOption( 'roviPassword', '' );
		$connId = ftp_connect( self::ROVI_FTP );
		if ( !$connId ) {
			$this->error( "Unable to connect to ROVI ", true );
		}
		$loginResult = ftp_login( $connId, $username, $password );
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
