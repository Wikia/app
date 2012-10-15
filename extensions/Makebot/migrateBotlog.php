<?php
/**
 * Script to migrate the bot status log to the user rights log
 * 
 * @ingroup Maintenance
 */

if ( getenv( 'MW_INSTALL_PATH' ) ) {
    $IP = getenv( 'MW_INSTALL_PATH' );
} else {
    $IP = dirname(__FILE__).'/../..';
}

require_once( "$IP/maintenance/Maintenance.php" );

class migrateBotlog extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Migrate the bot status log to the user rights log";
	}
	
	public function execute() {

		$dbw = wfGetDb( DB_MASTER );

		// Determining what groups the account was in before the change
		// would be difficult and unnecessary 99.9% of the time, so we just
		// assume the account was in no other groups
		$params = array( 'grant' => "\nbot", 'revoke' => "bot\n" );

		$logrows = $dbw->select( 'logging',
			array( 'log_id', 'log_action' ),
			array( 'log_type' => 'makebot',
				'log_action' => array('grant','revoke') ), // sanity check
			__METHOD__
		);
		$count = $logrows->numRows();	
		$this->output( "Updating $count entries in the logging table\n" );
		
		$batch = 0;
		foreach ( $logrows as $row ) {
			$dbw->update( 'logging',
				array( 'log_action' => 'rights', 'log_type'=>'rights',
					'log_params' => $params[$row->log_action] ),
				array( 'log_id' => $row->log_id ),
				__METHOD__
			);
			$batch++;
			if( $batch == 100 ) {
				wfWaitForSlaves( 5 );
				$batch = 0;
			}
		}

		$rcrows = $dbw->select( 'recentchanges',
			array( 'rc_id', 'rc_log_action' ),
			array( 'rc_log_type' => 'makebot',
				'rc_log_action' => array('grant','revoke') ), // sanity check
			__METHOD__
		);
		$count = $rcrows->numRows();	
		$this->output( "Updating $count entries in the recentchanges table\n" );
		foreach ( $rcrows as $row ) {
			$dbw->update( 'recentchanges',
				array( 'rc_log_action' => 'rights', 'rc_log_type'=>'rights', 'rc_params' => $params[$row->rc_log_action] ),
				array( 'rc_id' => $row->rc_id ),
				__METHOD__
			);
		}
		$this->output( "Done!\n" );
	}
}

$maintClass = "migrateBotlog";
require_once( DO_MAINTENANCE );

