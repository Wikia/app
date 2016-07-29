<?php
/**
 * RerunRenameUserLocal maintenance script
 *
 * This script is an answer to a lot of unfinished and broken user rename processes. It allows
 * you to easily rerun the RenameUser_local.php script on every wikia that a user has contributed at.
 */
require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class RerunRenameUserLocal extends Maintenance {

	const RERUN_RENAME_DATE_FORMAT = 'Y-m-d H:i:s';

	private
		$userId,
		$oldName,
		$newName,
		$wikiId,
		$startTime,
		$endTime;

	function __construct() {
		parent::__construct();
		$this->addOption( 'userId', 'An ID of the renamed user', true, true, 'u' );
		$this->addOption( 'oldName', 'An old name of the renamed user', true, true, 'o' );
		$this->addOption( 'newName', 'An old name of the renamed user', true, true, 'n' );
		$this->addOption( 'wikiId', 'A single wikiId to run the script at. If not provided - all wikis will be retrieved.', false, true, 'w' );
	}

	public function execute() {
		$this->getOptions();

		if ( $this->wikiId === 0 ) {
			/**
			 * Fetch IDs of wikias that a user has contributed at.
			 */
			$user = User::newFromId( $this->userId );
			$wikis = $user->getWikiasWithUserContributions();
		} else {
			$wikis = [ $this->wikiId ];
		}

		/**
		 * If there are any - run RenameUser_local.php for them.
		 */
		if ( !empty( $wikis ) ) {
			/**
			 * Log the start time of the process.
			 */
			$this->startProcedure();

			$dir = __DIR__;
			foreach ( $wikis as $wikiId ) {
				$cmd = sprintf( 'SERVER_ID=%d /usr/bin/php %s/RenameUser_local.php --rename-user-id=%d --rename-old-name="%s" --rename-new-name="%s"',
					intval( $wikiId ), $dir, intval( $this->userId ), wfEscapeShellArg( $this->oldName ), wfEscapeShellArg( $this->newName ) );

				$this->addLog( "Running: {$cmd}" );

				$scriptOutput = wfShellExec( $cmd );
				$this->addLog( $scriptOutput );
			}

			/**
			 * Log the end time of the process.
			 */
			$this->endProcedure();
		} else {
			$this->addLog( 'The user has no contributions.' );
		}
	}

	private function getOptions() {
		$this->userId = (int)$this->getOption( 'userId' );
		$this->oldName = $this->getOption( 'oldName' );
		$this->newName = $this->getOption( 'newName' );
		$this->wikiId = (int)$this->getOption( 'wikiId' );
	}

	/**
	 * Adds a text to logs and outputs it to console.
	 * @param $s
	 */
	private function addLog( $s ) {
		$s = "\n\n{$s}\n\n";
		$this->output( $s );
	}

	/**
	 * Logs the beginning time of the process.
	 */
	private function startProcedure() {
		$this->startTime = new DateTime();
		$this->addLog( sprintf( 'Renaming scripts rerun started at %s.',
			$this->startTime->format( self::RERUN_RENAME_DATE_FORMAT ) ) );
	}

	/**
	 * Logs the end time of the process.
	 */
	private function endProcedure() {
		$this->endTime = new DateTime();
		$this->addLog( sprintf( 'Renaming scripts rerun ended at %s.',
			$this->endTime->format( self::RERUN_RENAME_DATE_FORMAT ) ) );
	}
}

class RerunRenameUserLocalException extends Exception {

	public function __construct( $titleText ) {
		$msg = sprintf( 'The Title object creation for "%s" failed.', $titleText );
		parent::__construct( $msg );
	}
}

$maintClass = 'RerunRenameUserLocal';
require_once( RUN_MAINTENANCE_IF_MAIN );
