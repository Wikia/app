<?php
class UserPathPredictionModel {

	const S3_ARCHIVE = "s3://one_dot_archive/";
	const SAVE_PATH = "/tmp/UserPathPredictionRawData/";
	const PARSED_DATA_PATH = "/tmp/UserPathPredictionParsedData/";
	
	private $files;
	private $excludePaths = array( ".", ".." );
	
	function __construct() {}

	private function createDir( $folder ) {
		if( !is_dir( $folder )) {
			return mkdir( $folder, 0777, true );
		}
	}
	
	private function removeDir($dir) {
		if ( is_dir( $dir ) ) {
			$objects = scandir( $dir );
			
			foreach ( $objects as $object ) {
				if ( !in_array( $object, $this->$excludePaths ) ) {
					$path = "{$dir}/{$object}";
					
					if ( filetype( $path ) == 'dir' ) {
						$this->removeDir( $path );
					} else {
						unlink( $path );
					}
				}
			}
			
			reset( $objects );
			rmdir( $dir );
		}
	} 
	
	function gets3Data( $timestr ) {
		$this->removeDir(self::SAVE_PATH);
		$s3directory = self::S3_ARCHIVE . "{$timestr}/";
		$this->createDir( self::SAVE_PATH );
		echo shell_exec( "s3cmd get --recursive {$s3directory} " . self::SAVE_PATH );
		
		$tmpFiles = scandir( self::SAVE_PATH );
		
		if ( count( $tmpFiles )  > 2 ) {
			$this->files = array_slice( $tmpFiles, 2 );
			return true;
		}
		
		return false;
	}
	
	function getDataFilePath() {
		$read = next( $this->files );

		if($read === false) {
			reset( $this->files );
			return false;
		} 
		
		return self::SAVE_PATH . $read;
	}
	
	function saveParsedData( $domain, $data ) {
		if( !is_dir( self::PARSED_DATA_PATH )) {
				$this->createDir( self::PARSED_DATA_PATH );
		}
		
		file_put_contents( self::PARSED_DATA_PATH . $domain, serialize( $data ) . "\n", FILE_APPEND );
	}
	
	function getWikis() {
		//TODO: get data from WF
		return array(
			"490" => array(
				"db_name" => "wowwiki",
				"domain_name" => "wowwiki.com"
			),
			"10150" => array(
				"db_name" => "dragonage",
				"domain_name" => "dragonage.wikia.com"
			),
			"3125" => array(
				"db_name" => "callofduty",
				"domain_name" => "callofduty.wikia.com"
			)
		);
	}
	
	function cleanParsedDataFolder() {
		$this->removeDir( self::PARSED_DATA_PATH );
	}
	
	function cleanSourceFolder() {
		$this->removeDir( self::SAVE_PATH );
	}
}
