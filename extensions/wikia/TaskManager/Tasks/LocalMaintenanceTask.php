<?php

/**
 * @file
 * @package MediaWiki
 * @ingroup BatchTask
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @copyright Copyright © Krzysztof Krzyżaniak for Wikia Inc.
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @date 2009-03-17
 * @version 1.0
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Generic Task, will run maintenance task for specified city_id
 */
class LocalMaintenanceTask extends BatchTask {

	private $mParams, $mWikiId, $mUseTemplate;

	/**
	 * contructor
	 * @access public
	 */
	public function  __construct() {

		parent::__construct();
		$this->mType = "local-maintenance";
		$this->mVisible = false;
		$this->mTTL = 1800;
		$this->mDebug = false;
		$this->mUseTemplate = false;
	}

	/**
	 * execute
	 *
	 * entry point for TaskExecutor
	 *
	 * @access public
	 * @author eloy@wikia
	 *
	 * @param mixed $params default null - task data from wikia_tasks table
	 *
	 * @return boolean - status of operation
	 */
	public function execute( $params = null ) {
		global $IP, $wgWikiaLocalSettingsPath, $wgWikiaAdminSettingsPath,
			$wgExtensionMessagesFiles;

		$this->mTaskID = $params->task_id;
		$this->mParams = unserialize( $params->task_arguments );

		$city_id = $this->mParams[ "city_id" ];
		$command = $this->mParams[ "command" ];
		$type    = $this->mParams[ "type" ];

		if( $city_id && $command ) {
			$this->mWikiId = $city_id;
			/**
			 * execute maintenance script
			 */
			$cmd = sprintf( "SERVER_ID={$city_id} php {$IP}/{$command} --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}" );
			$this->addLog( "Running {$cmd}" );
			$retval = wfShellExec( $cmd, $status );
			$this->addLog( $retval );

			if( $type == "ACWLocal" ) {
				$cmd = sprintf( "SERVER_ID={$city_id} php {$IP}/maintenance/initStats.php --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}" );
				$this->addLog( "Running {$cmd}" );
				$retval = wfShellExec( $cmd, $status );
				$this->addLog( $retval );

				$cmd = sprintf( "SERVER_ID={$city_id} php {$IP}/maintenance/refreshLinks.php --new-only --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}" );
				$this->addLog( "Running {$cmd}" );
				$retval = wfShellExec( $cmd, $status );
				$this->addLog( $retval );

				$this->addLog( "Remove edit lock" );
				$oVariable = WikiFactory::getVarByName( 'wgReadOnly', $city_id );
				if ( isset($oVariable->cv_variable_id) ) {
					WikiFactory::removeVarById($oVariable->cv_variable_id, $city_id);
					WikiFactory::clearCache( $city_id );
				}
			}

			$dbname = WikiFactory::IDtoDB($city_id);			
			$cmd = sprintf( "perl $IP/../backend/bin/wikia_local_users.pl --usedb={$dbname} " );
			$this->addLog( "Running {$cmd}" );
			$retval = wfShellExec( $cmd, $status );
			$this->addLog( $retval );

			/**
			 * once again clear cache at the very end
			 */
			$wgMemc = wfGetMainCache();
			$wgMemc->delete( WikiFactory::getVarsKey( $city_id ) );
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
