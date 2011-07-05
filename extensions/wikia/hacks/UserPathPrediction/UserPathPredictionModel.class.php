<?php
class UserPathPredictionModel {

	const S3_ARCHIVE = "s3://one_dot_archive/";
	const SAVE_PATH = "/tmp/UserPathPredictionRawData/";
	const SPLIT_DIR = "/tmp/UserPathPredictionParsedData/";
	
	private $files;
	
	function __construct() {
		
	}
	


	private function createDir( $folder ) {
		if( !is_dir( $folder )) {
			return mkdir( $folder, 0777, true );
		}
	}
	
	private function removeDir($dir) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
				}
			}
		reset($objects);
		rmdir($dir);
		}
	} 
	
	function gets3Data( $timestr ) {
		$this->removeDir(self::SAVE_PATH);
		$s3directory = self::S3_ARCHIVE . "{$timestr}/";
		$this->createDir( self::SAVE_PATH );
		echo shell_exec( "s3cmd get --recursive {$s3directory} " . self::SAVE_PATH );
		
		$tmpFiles = scandir( self::SAVE_PATH );
		
		if(count( $tmpFiles )  > 2 ) {
			$this->files = array_slice($this->files,2);	
			return true;
		}
		
		return false;
	}
	
	function getContent() {
		$read = next($this->files);

		if($read === false) {
			reset($this->files);
		} 
		
		return $read;
	}
	
	function resetParsedData() {
		$this->removeDir(self::SPLIT_DIR);
	}
	
	function saveParsedData( $domain, $a, $c, $ra, $lv ) {
		if( !is_dir( self::SPLIT_DIR )) {
				$this->createDir( self::SPLIT_DIR );
		}
		
		file_put_contents( self::SPLIT_DIR . $domain, serialize( array("a" => $a, "c" => $c, "ra" => $ra, "lv" => $lv)) . "\n", FILE_APPEND );
	}
	
	function getWikis() {
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
	
	function cleanSourceFolder() {
		$this->removeDir( self::SAVE_PATH );
	}
}
