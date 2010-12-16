<?php

/**
 * Maintenance script that migrate configuration from files to database.
 *
 * @file
 * @ingroup Extensions
 * @author Alexandre Emsenhuber
 * @license GPLv2 or higher
 */

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false )
	$IP = dirname( __FILE__ ) . '/../../..';

require_once( "$IP/maintenance/Maintenance.php" );

class FilesToDB extends Maintenance {
	protected $mFilesHandler;
	protected $mDBHandler;
	protected $mOptions;
	protected $mPreviousVersion = array();
	protected $mLatest = array();

	public function __construct(){
		parent::__construct();
		$this->mDescription = "Maintenance script that migrate configuration from files to database";
	}

	public function execute(){
		$this->mFilesHandler = new ConfigureHandlerFiles();
		$this->mDBHandler = new ConfigureHandlerDb();

		if( !$this->doChecks() )
			return;

		$this->saveLatest();

		foreach( $this->getVersions() as $version ){
			$this->migrateVersion( $version );
		}
		$this->restoreLatest();
		$this->output( "done\n" );
	}

	protected function doChecks(){
		$ret = $this->mDBHandler->doChecks();
		if( count( $ret ) ){
			$this->error( "You have an error with your database, please check it and then run this script again.\n" );
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
		$this->output( "doing $version...\n" );
		foreach( $now as $wiki => $settings ){
			if( !isset( $this->mPreviousVersion[$wiki] ) || $this->mPreviousVersion[$wiki] != $settings ){
				$this->output( "	$wiki..." );
				$this->mDBHandler->saveNewSettings( $now, $wiki, $version );
				$this->output( "ok\n" );
			}
		}
		$this->mPreviousVersion = $now;
	}
}

$maintClass = 'FilesToDB';
require_once( DO_MAINTENANCE );

