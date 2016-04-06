<?php

/**
 * Perform user rename process
 *
 * @author Macbre
 * @ingroup Maintenance
 */

putenv( 'SERVER_ID=177' ); // run in the context of community wiki

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class RenameUserMaintenance extends Maintenance {

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

		$this->addOption( 'old-username', 'User to rename', true );
		$this->addOption( 'new-username', 'New name for the user', true );
		$this->addOption( 'reason', 'The rename reason' );

		$this->mDescription = 'This script performs user rename from the command line';
	}
	/**
	 * Script entry point
	 */
	public function execute() {
		global $wgUser;
		$wgUser = User::newFromName( 'WikiaBot' );

		// get options
		$oldName = $this->getOption( 'old-username' );
		$newName = $this->getOption( 'new-username' );
		$reason = $this->getOption( 'reason', 'User rename' );

		// set up the logger
		$logger = Wikia\Logger\WikiaLogger::instance();
		$logger->pushContext( [
			'old-name' => $oldName,
			'new-name' => $newName,
			'reason'   => $reason
		] );

		$logger->info( __CLASS__ . ': start' );

		$renameProcess = new RenameUserProcess( $oldName, $newName, true, $reason );
		$res = $renameProcess->run();

		if ( $res !== true ) {
			$logger->error( __CLASS__ . ': error', [
				'errors' => $renameProcess->getErrors(),
				'warnings' => $renameProcess->getWarnings(),
			] );

			$this->output( "RenameUserProcess::run failed for {$oldName}\n" );
			$this->output( json_encode( [ 'errors' => $renameProcess->getErrors(), 'warnings' => $renameProcess->getWarnings() ] ) );
			die( 1 );
		}

		$logger->info( __CLASS__ . ': done', [
			'task_id' => $renameProcess->getUserRenameTaskId()
		] );

		$this->output( sprintf( "Renaming of '%s' to '%s' done, task_id is '%s'\n", $oldName, $newName, $renameProcess->getUserRenameTaskId() ) );
	}
}

$maintClass = "RenameUserMaintenance";
require_once( RUN_MAINTENANCE_IF_MAIN );
