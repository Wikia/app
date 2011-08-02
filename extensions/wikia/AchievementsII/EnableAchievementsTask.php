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
        $this->mType = 'enableachivements';
		$this->mVisible = false; //we don't show form for this, it already exists
		$this->mParams = $params;
		$this->mTTL = 60 * 60 * 24; // 24 hours
		parent::__construct () ;
	}

	function execute ($params = null) {
		global $IP, $wgWikiaLocalSettingsPath ;

		$this->mTaskID = $params->task_id;
		$oUser = User::newFromId( $params->task_user_id );

		if ( $oUser instanceof User ) {
			$oUser->load();
			$this->mUser = $oUser->getName();
		} else {
			$this->log("Invalid user - id: " . $params->task_user_id );
			return true;
		}

		# task params 
		$data = unserialize($params->task_arguments);
				
		# user 
		if ( isset($data["user"]) ) {
			// proper validation is done in the maint script
			$username = escapeshellarg($data["user"]);
		} else {
			$this->addLog( 'Username not given, aborting.' );
			return false;
		}

		# start task
		$this->addLog('Starting task.');

		# command
		$sCommand  = "SERVER_ID={$oWiki->city_id} php " . dirname( __FILE__ )  '/awardCreatorBadge.php';
		$sCommand .= "--u " . $username . " ";
		$sCommand .= "--conf $wgWikiaLocalSettingsPath";

		$log = wfShellExec( $sCommand, $retval );
		if ($retval) {
			$this->log ('Article editing error! (' . $city_url . '). Error code returned: ' .  $retval . ' Error was: ' . $log);
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

}
