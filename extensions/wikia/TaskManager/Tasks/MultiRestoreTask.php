<?php

/**
 * @package MediaWiki
 * @subpackage BatchTask
 * @author Bartek Łapiński <bartek@wikia.com> for Wikia.com
 * @copyright (C) 2007-2008, Wikia Inc.
 * @license GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

/*
	multidelete anti-task
	this undoes changes made by a particular multidelete task
	that is precisely: attempts to restore every article targeted by the multidelete task
*/

class MultiRestoreTask extends BatchTask {
	var $mType, $mVisible, $mSingle, $mArguments, $mMode, $mAdmin ;
	var $mUser, $mMotherTask ;

	/* constructor */
	function __construct ($single = false) {
        	$this->mType = 'multirestore' ;
		$this->mVisible = false ; //we don't show form for this, it already exists
		$this->mSingle = $single ; //single wiki or not (need that for a reason)
		parent::__construct () ;
	}

	function execute ($params = null) {
		global $IP, $wgWikiaLocalSettingsPath ;

		$this->mTaskID = $params->task_id ;
		$oUser = User::newFromId( $params->task_user_id );
                $oUser->load();
		$this->mUser = $oUser->getName () ;

		$data = unserialize ($params->task_arguments) ;
		$articles = $data ["articles"] ;
		$username = escapeshellarg ($data ["username"]) ;
		$this->addLog ("Starting task.") ;
		$this->addLog ("List of restored articles (by " . $this->mUser . ' as ' . $username . "):") ;

		for ($i = 0 ; $i < count ($articles) ; $i++) {
			$titleobj = Title::makeTitle ($articles [$i]["namespace"], $articles [$i]["title"]) ;
			$article_to_do = $titleobj->getText () ;
			$namespace = intval($articles [$i]["namespace"]);

			$reason = $articles [$i]['reason'] ? (' -r ' . escapeshellarg($articles [$i]['reason'])) : '';
			$sCommand = "SERVER_ID=".$articles [$i]["wikiid"]." php $IP/maintenance/wikia/restoreOn.php -u ".$username." -t " . escapeshellarg ($article_to_do) . " -n " . $namespace . $reason . " --conf " . escapeshellarg ($wgWikiaLocalSettingsPath);
			$city_url  = WikiFactory::getVarValueByName( "wgServer", $articles [$i]["wikiid"] ) ;
			if (empty ($city_url)) {
				$city_url = 'wiki id in WikiFactory: ' . $articles [$i]["wikiid"]  ;
			}

			$city_path  = WikiFactory::getVarValueByName( "wgScript", $articles [$i]["wikiid"] ) ;			
			$actual_title = wfShellExec( $sCommand, $retval ) ;

			if ($retval) {
				$this->addLog ('Article undeleting error! (' . $city_url . '). Error code returned: ' .  $retval . ' Error was: ' . $actual_title) ;
			} else {
	 			$this->addLog ('<a href="' . $city_url . $city_path . '?title=' . $actual_title  . '">' . $city_url . $city_path . '?title=' . $actual_title . '</a>') ;
			}
		}
		return true ;
	}

	function getType() {
		return $this->mType;
	}

	function isVisible() {
		return $this->mVisible;
	}

	function getForm ($title, $errors = false ) {
		// this has no form, it's inserted semi-automatically
		return true ;
	}

	function submitForm () {
		global $wgRequest, $wgOut, $IP, $wgUser ;

		$articles = $this->mArguments ;
		$mode = $this->mMode ;
		$username = "Restore page script" ;
		$tempUser = User::newFromName ($username) ;

		#--- all should be correct at this point
		#--- first prepare serialized info with params
		
		$sel_articles = $articles ;		
		$sParams = serialize(array(
					"articles" => $sel_articles ["articles"] ,
					"username" => $username ,
					"mode" => $mode ,
					"admin" => $this->mAdmin ,
					"motherTask" => $this->mMotherTask , 
					));

		$dbw = wfGetDB( DB_MASTER );
		$dbw->selectDB( "wikicities" );

		$dbw->insert( "wikia_tasks", array(
					"task_user_id" => $wgUser->getID(),
					"task_type" => $this->mType,
					"task_priority" => 10, // this should be given HIGHEST priority, since
							       // it is to counter admin abuse... 10 is enough
					"task_status" => 1,
					"task_added" => wfTimestampNow(),
					"task_started" => "",
					"task_finished" => "",
					"task_arguments" => $sParams,
					));
		$task_id = $dbw->insertId () ;		
		$dbw->close();
		return $task_id ;
	}

	/**
	 * getDescription
	 *
	 * description of task, used in task listing.
	 *
	 * @access public
	 * @author eloy@wikia, bartek@wikia
	 *
	 * @return string: task description
	 */
	public function getDescription() {
		$desc = $this->getType();
		if( !is_null( $this->mData ) ) {
			$args = unserialize( $this->mData->task_arguments );
			$mode = $args ["mode"] ;
			$admin = $args ["username"] ;
                        $oUser = User::newFromName ($admin) ;
                        if (is_object ($oUser)) {
                                $oUser->load() ;
                                $userLink = $oUser->getUserPage()->getLocalUrl() ;
                                $userName = $oUser->getName() ;
                        } else {
                                $userLink = '' ;
                                $userName = '' ;
                        }

			if ("single" != $mode) {
				$article = str_replace ("_", " ", $args ["articles"][0]["title"]) ; 
				$desc = sprintf(
						"undo for task: %s,<br/> article: %s, namespace %d <br/>as user: <a href=\"%s\">%s</a>",
						$args ["motherTask"] ,
						$article ,
						$args ["articles"][0]["namespace"] ,
						$userLink ,
						$userName
					       );
			} else {
				$url = $args ["articles"][0]["url"] ;
				$desc = sprintf(
						"undo for task: %s,<br/>wiki: <a href=\"%s\">%s</a>,<br/>user: <a href=\"%s\">%s</a>",
						$args ["motherTask"] ,
						$url ,
						$url ,
						$userLink ,
						$userName
					       );
			}
		}
		return $desc;
	}
}
?>
