<?php

/**
 * Maintenance script that helps to do maintenance with configuration files.
 *
 * @file
 * @ingroup Extensions
 * @author Alexandre Emsenhuber
 * @license GPLv2 or higher
 */

define( 'EXT_CONFIGURE_NO_EXTRACT', true );

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false )
	$IP = dirname( __FILE__ ) . '/../../..';

require_once( "$IP/maintenance/Maintenance.php" );

class ConfigurationManager extends Maintenance {
	public function __construct(){
		parent::__construct();
		$this->mDescription = 'Script that helps to do maintenance with configuration files.';
		$this->addOption( 'list', 'list all configurations files' );
		$this->addOption( 'delete', 'delete the file corresponding to the given version', false, true );
		$this->addOption( 'revert', 'revert the working config to the given version', false, true );
		
	}

	public function execute(){
		global $wgConf;
		if( !$wgConf instanceof WebConfiguration ){
			$this->error( "You need to call efConfigureSetup() to use this maintenance script.", true );
		}

		$actions = array( 'list', 'revert', 'delete' );

		foreach( $actions as $name ){
			if ( $this->hasOption( $name ) ) {
				$arg = $this->getOption( $name );
				$function = 'Do' . ucfirst( $name );
				$callback = array( $this, $function );
				call_user_func_array( $callback, array( $arg ) );
			}
		}
	}

	protected function DoDelete( $version ){
		global $wgConfigureHandler;

		$func = 'DoDelete' . ucfirst( $wgConfigureHandler );
		$this->$func( $version );
	}

	function DoDeleteFiles( $version ){
		global $wgConf;

		$file = $wgConf->getHandler()->getArchiveFileName( $version );
		if( !file_exists( $file ) ){
			$this->error( "delete: The version given ($version) does not exist.\n" );
			return;
		}
		unlink( $file );
	}

	function doDeleteDb( $version ){
		global $wgConf;

		$dbw = $wgConf->getHandler()->getMasterDB();
		$rev = $dbw->selectRow( 'config_version', '*', array( 'cv_timestamp' => $version ), __METHOD__ );
		if( !isset( $rev->cv_id ) ){
			$this->error( "delete: The version given ($version) does not exist.\n" );
			return;
		}

		$id = $rev->cv_id;
		$dbw->begin();
		$dbw->delete( 'config_version', array( 'cv_id' => $id ), __METHOD__ );
		$dbw->delete( 'config_setting', array( 'cs_id' => $id ), __METHOD__ );
		$dbw->commit();
	}

	protected function DoList(){
		global $wgConf;
		echo implode( "\n", $wgConf->listArchiveVersions() ) . "\n";
	}

	protected function DoRevert( $version ){
		global $wgConf;
		$arr = $wgConf->getOldSettings( $version );
		if( !count( $arr ) ){
			$this->error( "revert: The version given ($version) is invalid\n" );
			return;
		}
		$wgConf->saveNewSettings( $arr, null, "Reverting to verion $version" );
	}
}

$maintClass = 'ConfigurationManager';
require_once( DO_MAINTENANCE );
