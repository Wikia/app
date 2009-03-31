<?php

/**
 * Helper class for the manage.php script
 *
 * @ingroup Extensions
 * @author Alexandre Emsenhuber
 */
class ConfigurationManager {
	public function __construct( $options ){
		$this->options = $options;
	}

	public function run(){
		global $wgConf;
		if( !$wgConf instanceof WebConfiguration ){
			echo "You need to call efConfigureSetup() to use this maintenance script.";
			die( 1 );
		}
		foreach( $this->options as $name => $arg ){
			$function = 'Do' . ucfirst( $name );
			$callback = array( $this, $function );
			if( !is_callable( $callback ) )
				// Ingnore silenty
				continue;
			call_user_func_array( $callback, array( $arg ) );
		}
	}

	protected function getDeleter(){
		global $wgConf, $wgConfigureHandler;
		$class = 'ConfigurationDeleter' . ucfirst( $wgConfigureHandler );
		return new $class( $wgConf );
	}

	protected function DoDelete( $version ){
		$deleter = $this->getDeleter();
		$deleter->doDelete( $version );
	}

	protected function DoList(){
		global $wgConf;
		echo implode( "\n", $wgConf->listArchiveVersions() ) . "\n";
	}

	protected function DoRevert( $version ){
		global $wgConf;
		$arr = $wgConf->getOldSettings( $version );
		if( !count( $arr ) ){
			fwrite( STDERR, "revert: The version given ($version) is invalid\n" );
			return;
		}
		$wgConf->saveNewSettings( $arr, null );
	}

	protected function DoHelp(){
		echo "Script that helps to do maintenance with configuration files.\n";
		echo "\n";
		echo "Usage:\n";
		echo "  php manage.php [--revert version] [--list] [--delete version] [--help]\n";
		echo "\n";
		echo "options:\n";
		echo "--help: display this screen\n";
		echo "--list: list all configurations files\n";
		echo "--delete: delete the file corresponding to the given version\n";
		echo "--revert: revert the working config to the given version\n";
		echo "\n";
	}
}

/**
 * Class used to delete configuration files
 */
class ConfigurationDeleterFiles {
	protected $mConf;

	function __construct( WebConfiguration $conf ){
		$this->mConf = $conf;
	}

	function doDelete( $version ){
		$file = $this->mConf->getHandler()->getArchiveFileName( $version );
		if( !file_exists( $file ) ){
			fwrite( STDERR, "delete: The version given ($version) does not exist.\n" );
			return;
		}
		unlink( $file );
	}
}

/**
 * Class used to delete configuration stored in the database
 */
class ConfigurationDeleterDb {
	protected $mConf;

	function __construct( WebConfiguration $conf ){
		$this->mConf = $conf;
	}

	function doDelete( $version ){
		$dbw = $this->mConf->getHandler()->getMasterDB();
		$rev = $dbw->selectRow( 'config_version', '*', array( 'cv_timestamp' => $version ), __METHOD__ );
		if( !isset( $rev->cv_id ) ){
			fwrite( STDERR, "delete: The version given ($version) does not exist.\n" );
			return;
		}

		$id = $rev->cv_id;
		$dbw->begin();
		$dbw->delete( 'config_version', array( 'cv_id' => $id ), __METHOD__ );
		$dbw->delete( 'config_setting', array( 'cs_id' => $id ), __METHOD__ );
		$dbw->commit();
	}
}
