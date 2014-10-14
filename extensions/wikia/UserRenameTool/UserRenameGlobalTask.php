<?php
if( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension and cannot be used standalone.\n";
	exit( 1 ) ;
}

class UserRenameGlobalTask extends BatchTask {

	private $mParams;

	/**
	 * contructor
	 * @access public
	 */
	public function  __construct() {
		$this->mType = "renameuser_global";
		$this->mVisible = true;
		parent::__construct();

		$this->mDebug = false;
	}

	/**
	 * execute
	 *
	 * entry point for TaskExecutor
	 *
	 * @access public
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 *
	 * @param mixed $params default null - task data from wikia_tasks table
	 *
	 * @return boolean - status of operation
	 */
	public function execute( $params = null ) {
		global $wgStatsDB, $wgStatsDBEnabled;

		//no working stats DB instance on devboxes
		if( !defined('ENV_DEVBOX') && !empty($wgStatsDBEnabled) ) {

			$this->mParams = unserialize( $params->task_arguments );
			$process = RenameUserProcess::newFromData( array_merge( $this->mParams, array( 'local_task' => $this ) ) );

			if( defined( 'ENV_DEVBOX' ) ) {
				$process->addLogDestination( RenameUserProcess::LOG_BATCH_TASK, $this );
			} else {
				$process->setLogDestination( RenameUserProcess::LOG_BATCH_TASK, $this );
			}

			$process->addLog( 'Updating global shared database: stats' );

			$dbw = wfGetDB(DB_MASTER, array(), $wgStatsDB);
			$dbw->begin();

			$tasks = $this->mParams['tasks'];

			$hookName = 'UserRename::Stats';
			$process->addLog( "Broadcasting hook: {$hookName}" );
			wfRunHooks( $hookName, array( $dbw, $this->mParams['rename_user_id'], $this->mParams['rename_old_name'], $this->mParams['rename_new_name'], $this, &$tasks ) );

			foreach( $tasks as $task ) {
				$process->addLog( "Updating stats: {$task['table']}:{$task['username_column']}" );
				$process->renameInTable( $dbw, $task['table'], $this->mParams['rename_user_id'], $this->mParams['rename_old_name'], $this->mParams['rename_new_name'], $task );
			}

			$hookName = 'UserRename::AfterStats';
			$process->addLog( "Broadcasting hook: {$hookName}" );
			wfRunHooks( $hookName, array( $dbw, $this->mParams['rename_user_id'], $this->mParams['rename_old_name'], $this->mParams['rename_new_name'], $this, &$tasks ) );

			$dbw->commit();
			$process->addLog( 'Finished updating shared database: stats' );
		}

		return true;
	}

	/**
	 * getForm
	 *
	 * this task is not visible in selector so it doesn't have real HTML form
	 *
	 * @access public
	 * @author eloy@wikia
	 *
	 * @param Title $title: Title struct
	 * @param mixes $data: params from HTML form
	 *
	 * @return false
	 */
	public function getForm( $title, $data = false ) {
	   return false;
	}

	/**
	 * getType
	 *
	 * return string with codename type of task
	 *
	 * @access public
	 * @author eloy@wikia
	 *
	 * @return string: unique name
	 */
	public function getType() {
	   return $this->mType;
	}

	/**
	 * isVisible
	 *
	 * check if class is visible in TaskManager from dropdown
	 *
	 * @access public
	 * @author eloy@wikia
	 *
	 * @return boolean: visible or not
	 */
	public function isVisible() {
		return $this->mVisible;
	}

	/**
	 * submitForm
	 *
	 * since this task is invisible for form selector we use this method for
	 * saving request data in database
	 *
	 * @access public
	 * @author eloy@wikia
	 *
	 * @return true
	 */
	public function submitForm() {
		return true;
	}
}
