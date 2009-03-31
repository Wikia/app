<?php

/**
 * Helper class for the migrateToDB.php script
 *
 * @ingroup Extensions
 * @author Alexandre Emsenhuber
 */
class FilesToDB {
	protected $mFilesHandler;
	protected $mDBHandler;
	protected $mOptions;
	protected $mPreviousVersion = array();
	protected $mLatest = array();

	public function __construct( $options ){
		$this->mOptions = $options;
		$this->mFilesHandler = new ConfigureHandlerFiles();
		$this->mDBHandler = new ConfigureHandlerDb();
	}

	public function run(){
		if( isset( $this->mOptions['help'] ) ){
			$this->doHelp();
			return;
		}
		if( !$this->doChecks() )
			return;
		$this->saveLatest();
		foreach( $this->getVersions() as $version ){
			$this->migrateVersion( $version );
		}
		$this->restoreLatest();
		echo "done\n";
	}

	protected function doChecks(){
		$ret = $this->mDBHandler->doChecks();
		if( count( $ret ) ){
			fwrite( STDERR, "You have an error with your database, please check it and then run this script again.\n" );
			return false;
		} else {
			return true;
		}
	}

	protected function saveLatest(){
		$db = $this->mDBHandler->getMasterDB();
		$res = $db->select( 'config_version', array( 'cv_id', 'cv_wiki' ), array( 'cv_is_latest' => 1 ), __METHOD__ );
		foreach( $res as $row ){
			$this->mLatest[$row->cv_wiki] = $row->cv_id;
			echo "{$row->cv_wiki}: {$row->cv_id}\n";
		}
	}

	protected function restoreLatest(){
		$dbw = $this->mDBHandler->getMasterDB();
		foreach( $this->mLatest as $wiki => $id ){
			$dbw->update( 'config_version', array( 'cv_is_latest' => 0 ), array( 'cv_wiki' => $wiki ), __METHOD__ );
			$dbw->update( 'config_version', array( 'cv_is_latest' => 1 ), array( 'cv_id' => $id ), __METHOD__ );
		}
	}

	protected function getVersions(){
		return array_reverse( $this->mFilesHandler->listArchiveVersions() );
	}

	protected function migrateVersion( $version ){
		$now = $this->mFilesHandler->getOldSettings( $version );
		echo "doing $version...\n";
		foreach( $now as $wiki => $settings ){
			if( !isset( $this->mPreviousVersion[$wiki] ) || $this->mPreviousVersion[$wiki] != $settings ){
				echo "	$wiki...";
				$this->mDBHandler->saveNewSettings( $now, $wiki, $version );
				echo "ok\n";
			}
		}
		$this->mPreviousVersion = $now;
	}

	protected function doHelp(){
		echo "Maintenance script that migrate configuration from files to database.\n";
		echo "\n";
		echo "Usage:\n";
		echo "  php migrateToDB.php [--help]\n";
		echo "\n";
		echo "options:\n";
		echo "--help: display this screen\n";
		echo "\n";
	}
}
