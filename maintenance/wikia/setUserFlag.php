<?php
/**
 * setUserFlag
 *
 * This script sets local and global flags for a user
 *
 */

putenv( 'SERVER_ID=177' );
ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

class SetUserFlag extends Maintenance {

	const SUCCESS_MSG = "Update %s flag '%s' from '%s' to '%s' for user '%s'\n";

	private $userName;
	private $isGlobal = false;
	private $flag;
	private $value;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Pre-populate LVS suggestions";
		$this->addOption( 'user', 'Username to update', true, true, 'u' );
		$this->addOption( 'global', 'Set a global flag', false, true, 'g' );
		$this->addOption( 'local', 'Set a local flag', false, true, 'l' );
	}

	public function execute() {
		$this->userName = $this->getOption( 'user' );

		if ( $this->hasOption( 'global' ) ) {
			$this->isGlobal = true;
			$this->readFlagAndValue( $this->getOption( 'global' ) );
		} elseif ( $this->hasOption( 'local' ) ) {
			$this->isGlobal = false;
			$this->readFlagAndValue( $this->getOption( 'local' ) );
		} else {
			die("Must pass either --local or --global");
		}

		$user = User::newFromName( $this->userName );

		if ( $this->isGlobal ) {
			$type = 'global';
			$oldValue = $user->getGlobalFlag( $this->flag );
			$user->setGlobalFlag( $this->flag, $this->value );
		} else {
			$type = 'local';
			$oldValue = $user->getLocalFlag( $this->flag );
			$user->setLocalFlag( $this->flag, $this->value );
		}

		$user->saveSettings();
		echo sprintf( self::SUCCESS_MSG, $type, $this->flag, $oldValue, $this->value, $this->userName );
	}

	private function readFlagAndValue( $input ) {
		list( $this->flag, $this->value ) = explode( "=", $input );
	}
}

$maintClass = "SetUserFlag";
require_once( RUN_MAINTENANCE_IF_MAIN );
