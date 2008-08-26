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
			call_user_func_array( $callback, $arg );	
		}
	}

	protected function DoDelete( $version ){
		global $wgConf;
		$file = $wgConf->getArchiveFileName( $version );
		if( !file_exists( $file ) ){
			fwrite( STDERR, "delete: The version given ($version) does not exist.\n" );
			return;	
		}
		unlink( $file );
	}
	
	protected function DoList(){
		global $wgConf;
		echo implode( "\n", $wgConf->listArchiveFiles() ) . "\n";
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
		echo "  php findSettings.php [--revert version] [--list] [--delete version] [--help]\n";
		echo "\n";
		echo "options:\n";
		echo "--help: display this screen\n";
		echo "--list: list all configurations files\n";
		echo "--delete: delete the file corresponding to the given version\n";
		echo "--revert: revert the working config to the given version\n";
		echo "\n";
	}
}