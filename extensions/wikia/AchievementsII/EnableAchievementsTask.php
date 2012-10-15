<?php

/**
 * @package MediaWiki
 * @subpackage BatchTask
 * @author Lucas 'TOR' Garczewski <tor@wikia-inc.com>
 * @copyright (C) 2011, Wikia Inc.
 * @license GNU General Public Licence 2.0 or later
 * @version: $Id$
 */


class EnableAchievementsTask extends BatchTask {
	public
		$mType,
		$mVisible,
		$mUser;

	/* constructor */
	function __construct( $params = array() ) {
		$this->mType = 'enableachievements';
		$this->mVisible = false; //we don't show form for this, it already exists
		$this->mParams = $params;
		$this->mTTL = 60 * 60 * 24; // 24 hours
		parent::__construct () ;
	}

	function execute ($params = null) {
		global $wgWikiaLocalSettingsPath, $wgMaxShellMemory, $wgMaxShellFileSize, $wgMaxShellTime;

		// per moli, seriously frakked
		$wgMaxShellMemory = 0;
		$wgMaxShellFileSize = 0;
		$wgMaxShellTime = 0;

		$this->mTaskID = $params->task_id;

		// task params
		$data = unserialize($params->task_arguments);

                // start task
		$this->addLog('Starting task.');

		// command
		$sCommand  = "SERVER_ID={$data['wiki']} php " . dirname( __FILE__ ) . "/awardCreatorBadge.php --conf $wgWikiaLocalSettingsPath";
		$this->addLog( $sCommand );

		$log = wfShellExec( $sCommand, $retval );
		if ($retval) {
			$this->log ('Achievement awarding error! (City ID: ' . $data['wiki'] . '). Error code returned: ' .  $retval . ' Error was: ' . $log);
		}
		else {
			$this->log ("Log: \n" . $log ."\n");
		}

		return true ;
	}

	function getType() {
		return $this->mType;
	}

	function isVisible() {
		return $this->mVisible;
	}

	function getForm($title, $errors = false ) {
		return true ;
	}

	function submitForm() {
		global $wgUser, $wgExternalSharedDB;

		if ( empty($this->mParams) ) {
			return false;
		}

		$sParams = serialize( $this->mParams );

		$dbw = wfGetDB( DB_MASTER, null, $wgExternalSharedDB );
		$dbw->insert(
				"wikia_tasks",
				array(
					"task_user_id" => $wgUser->getID(),
					"task_type" => $this->mType,
					"task_priority" => 1,
					"task_status" => 1,
					"task_added" => wfTimestampNow(),
					"task_started" => "",
					"task_finished" => "",
					"task_arguments" => $sParams
				     )
			    );

		$task_id = $dbw->insertId() ;
		$dbw->commit();
		return $task_id ;

	}
}
