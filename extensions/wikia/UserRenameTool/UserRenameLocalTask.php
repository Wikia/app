<?php
if( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

class UserRenameLocalTask extends BatchTask {

	const TTL = 36000;//10hrs

	private $mParams;

	/**
	 * contructor
	 * @access public
	 */
	public function  __construct() {
		$this->mType = "renameuser_local";
		$this->mVisible = true;
		$this->mTTL = self::TTL;
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
		global $IP, $wgWikiaLocalSettingsPath, $wgWikiaAdminSettingsPath;
		
		$this->mParams = unserialize($params->task_arguments);
		$noErrors = true;

		$process = RenameUserProcess::newFromData(array_merge($this->mParams,array('local_task'=>$this)));
		
		if(defined('ENV_DEVBOX')){
			$process->addLogDestination(RenameUserProcess::LOG_BATCH_TASK, $this);
		}
		else{
			$process->setLogDestination(RenameUserProcess::LOG_BATCH_TASK, $this);
		}
		
		//$process->setRequestorUser();
		
		$process->addLog('User rename local task start.');
		
		$oldUsername = $this->mParams['rename_old_name'];
		$requestorID = (int)$this->mParams['requestor_id'];

		foreach($this->mParams as $key => &$param){
			if($key == 'city_ids') continue;
			if (empty($param)) {
				$param = "'{$param}'";
			} else {
				$param = escapeshellarg($param);
			}
		}
		
		if(is_array($this->mParams['city_ids'])){
			foreach($this->mParams['city_ids'] as $cityId){

				$process->addLog("Processing wiki with ID {$cityId}.");

				/**
				 * execute maintenance script
				 */
				$aconf = $wgWikiaAdminSettingsPath;
				
				if (defined('ENV_DEVBOX') && ENV_DEVBOX){
					$aconf = preg_replace("/\\.\\.\\//","",$aconf);
				}
				
				$cmd = "SERVER_ID={$cityId} php {$IP}/maintenance/wikia/RenameUser_local.php ".
					"--rename-user-id {$this->mParams['rename_user_id']} --rename-old-name {$this->mParams['rename_old_name']} ".
					"--rename-new-name {$this->mParams['rename_new_name']} --rename-fake-user-id {$this->mParams['rename_fake_user_id']} ".
					"--phalanx-block-id {$this->mParams['phalanx_block_id']} ".
					"--task-id {$this->mTaskID} --requestor-id {$this->mParams['requestor_id']} --reason {$this->mParams['reason']} ".
					"--global-task-id {$this->mParams['global_task_id']} --conf {$wgWikiaLocalSettingsPath} --aconf {$aconf}";
				
				$this->addLog("Running {$cmd}");
				$exitCode = null;
				$output = wfShellExec($cmd, $exitCode);

				if($exitCode == 1) $noErrors = false;

				$this->addLog( "--- Command output ---\n{$output}\n--- End of command output ---" );

				$process->addLog("End processing wiki with ID {$cityId}.");
			}
		}

		$process->addLog("Cleaning up pre-process setup.");
		$process->cleanup();

		$process->addLog("Fetching email address for notification of completed process.");

		$requestorUser = User::newFromId($requestorID);
		
		//send e-mail to the user that rename process has finished
		if($requestorUser->getEmail() != null){
			$requestorUser->sendMail(
				wfMsgForContent('renameuser-finished-email-subject'),
				wfMsgForContent('renameuser-finished-email-body-text', $oldUsername),
				null, //from
				null, //replyto
				'UserRenameProcessFinishedNotification',
				wfMsgForContent('renameuser-finished-email-body-html', $oldUsername)
			);
			$process->addLog("Notification sent.");
		}
		else{
			$process->addLog("Cannot send email, requestor user has no email address.");
		}

		$process->addLog("User rename local task end.");
		return $noErrors;
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
