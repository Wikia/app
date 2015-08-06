<?php
/**
 * RerunRenameUserLocal maintenance script
 *
 * This script is an answer to a lot of unfinished and broken user rename processes. It allows
 * you to easily rerun the RenameUser_local.php script on every wikia that a user has contributed at.
 */
require_once( __DIR__ . '/../Maintenance.php' );

class RerunRenameUserLocal extends Maintenance {

	const RERUN_RENAME_DATE_FORMAT = 'Y-m-d H:i:s';

	private
		$userId,
		$oldName,
		$newName,
		$log = '',
		$startTime,
		$endTime;

	function __construct() {
		parent::__construct();
		$this->addOption( 'userId', 'An ID of the renamed user', true, true, 'u' );
		$this->addOption( 'oldName', 'An old name of the renamed user', true, true, 'o' );
		$this->addOption( 'newName', 'An old name of the renamed user', true, true, 'n' );
	}

	public function execute() {
		$this->getOptions();

		/**
		 * Fetch IDs of wikias that a user has contributed at.
		 */
		$user = User::newFromId( $this->userId );
		$wikis = $user->getWikiasWithUserContributions();

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
					$wikiId, $dir, $this->userId, $this->oldName, $this->newName );

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

		/**
		 * Save and return the logs as a subpage of a user page
		 */
		return $this->saveLog( $user );
	}

	private function getOptions() {
		$this->userId = intval( $this->getOption( 'userId' ) );
		$this->oldName = $this->getOption( 'oldName' );
		$this->newName = $this->getOption( 'newName' );
	}

	/**
	 * Adds a text to logs and outputs it to console.
	 * @param $s
	 */
	private function addLog( $s ) {
		$s = "\n\n{$s}\n\n";
		$this->output( $s );
		$this->log .= $s;
	}

	/**
	 * Creates a subpage of a user's page and saves the process logs there.
	 * If the edit fails it logs the exception to Kibana with the
	 * class name RerunRenameUserLocal as its message.
	 */
	private function saveLog() {
		$logTitleText = sprintf( '%s/%s to %s rename rerun log',
			$this->newName, $this->oldName, $this->newName );

		$logTitle = Title::newFromText( $logTitleText, NS_USER );

		try {
			if ( $logTitle === null ) {
				$wikiPage = new WikiPage( $logTitle );
				$wikiaBot = User::newFromName( 'WikiaBot' );
				$wikiPage->doEdit( $this->log,
					'Logs from an operation of renaming the user.',
					EDIT_NEW | EDIT_FORCE_BOT | EDIT_SUPPRESS_RC,
					false,
					$wikiaBot
				);
			} else {
				throw new RerunRenameUserLocalException( $logTitleText );
			}
		} catch ( Exception $e ) {
			$msg = $e->getMessage();
			$this->addLog( "Saving logs to a subpage failed: {$msg}" );
			$this->logException( $e );
		}

		return $this->log;
	}

	/**
	 * Log an exception to Kibana
	 * @param Exception $e
	 */
	private function logException( Exception $e ) {
		$logger = Wikia\Logger\WikiaLogger::instance();
		$logger->error( __CLASS__, [
			'excptMsg' => $e->getMessage(),
			'excptTrace' => $e->getTrace()
		] );
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
