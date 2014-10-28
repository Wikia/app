<?php
/**
 *
 */

putenv("SERVER_ID=177");

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Class FSCKVideos
 */
class MCCLI extends Maintenance {

	protected $verbose = false;
	protected $test    = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "";
		$this->addOption( 'test', 'Test mode; make no changes', false, false, 't' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
		$this->addOption( 'action', '', false, true, 'a' );
		$this->addOption( 'key', '', false, true, 'k' );
		$this->addOption( 'class', '', false, false, 'c' );
		$this->addOption( 'servers', '', false, false, 's' );
	}

	public function execute() {
		$this->test    = $this->hasOption('test');
		$this->verbose = $this->hasOption('verbose');
		$action  = $this->getOption('action');
		$key  = $this->getOption('key');
		$class = $this->hasOption("class");
		$servers = $this->hasOption("servers");

		if ($class) {
			global $gMemCachedClass;
			echo get_class(F::app()->wg->Memc->getClient())."\n";
		}

		if ($servers) {
			//print_r( F::app()->wg->Memc->getClient() );
			//echo "\n\n";
			foreach ( F::app()->wg->Memc->getClient()->_servers as $stuff ) {
				print_r($stuff);
				echo "\n";
			}
		}

		$memc = F::app()->wg->Memc;

		if ( $action == 'get' ) {
			print_r($memc->get($key));
		}

		if ( $action == 'delete' ) {
			print_r($memc->delete($key));
		}

	}

	/**
	 * Print the message if verbose is enabled
	 * @param $msg - The message text to echo to STDOUT
	 */
	private function debug( $msg ) {
		if ( $this->verbose ) {
			echo $msg;
		}
	}
}

$maintClass = "MCCLI";
require_once( RUN_MAINTENANCE_IF_MAIN );