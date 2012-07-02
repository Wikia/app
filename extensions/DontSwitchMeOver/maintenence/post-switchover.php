<?php

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

class PostSwitchover extends Maintenance {
	const REPORTING_INTERVAL = 1000;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Migrate users that indicated they didn't want to be switched over back to the old defaults.";
		$this->addArg( 'start', "User ID to start from. Use this to resume an aborted run", false );
		$this->addOption( 'maxlag', 'Maximum database slave lag in seconds (5 by default)', false, true );
	}

	public function execute() {
		$start = intval( $this->getOption( 'start', 0 ) );
		$maxlag = intval( $this->getOption( 'maxlag', 5 ) );
		
		$dbr = wfGetDb( DB_SLAVE );
		$maxUserID = $dbr->selectField( 'user', 'MAX(user_id)', false );
		
		$this->output( "Starting from user_id $start of $maxUserID\n" );
		for ( $i = $start; $i < $maxUserID; $i++ ) {
			$this->fixUser( $i );
			if ( $i % self::REPORTING_INTERVAL == 0 ) {
				$this->output( "$i\n" );
				wfWaitForSlaves( $maxlag );
			}
		}
		$this->output( "All done\n" );
	}
	
	private function fixUser( $i ) {
		global $wgDontSwitchMeOverPrefs;
		$user = User::newFromId( $i );
		
		// If the user doesn't exist or doesn't have our preference enabled, skip
		if ( $user->isAnon() || !$user->getOption( 'dontswitchmeover' ) ) {
			return;
		}
		
		$changed = false;
		foreach ( $wgDontSwitchMeOverPrefs as $pref => $oldVal ) {
			if ( $user->getOption( $pref ) == User::getDefaultOption( $pref ) ) {
				$user->setOption( $pref, $oldVal );
				$changed = true;
			}
		}
		if ( $changed ) {
			$user->saveSettings();
		}
	}
}

$maintClass = "PostSwitchover";
require_once( DO_MAINTENANCE );
