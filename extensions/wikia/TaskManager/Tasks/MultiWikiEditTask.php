<?php

/**
 * @package MediaWiki
 * @subpackage BatchTask
 * @author Bartek Lapinski <bartek@wikia.com> for Wikia.com
 * @copyright (C) 2007-2008, Wikia Inc.
 * @license GNU General Public Licence 2.0 or later
 * @version: $Id$
 */


class MultiWikiEditTask extends BatchTask {
	var $mType, $mVisible, $mSingle, $mArguments, $mMode, $mAdmin ;
	var $mUser ;

	/* constructor */
	function __construct ($single = false) {
        $this->mType = 'multiwikiedit' ;
		$this->mVisible = false ; //we don't show form for this, it already exists
		$this->mSingle = $single ; //single wiki or not (need that for a reason)
		parent::__construct () ;
	}

	function execute ($params = null) {
		global $IP, $wgWikiaLocalSettingsPath ;
		/*      go with each supplied wiki and edit the supplied article
			load all configs for particular wikis before doing so
		 */

		$this->mTaskID = $params->task_id ;
		$oUser = User::newFromId( $params->task_user_id );
		$oUser->load();
		$this->mUser = $oUser->getName () ;
		
		$data = unserialize ($params->task_arguments) ;

		$articles = $data ["articles"] ;
		$username = escapeshellarg ($data ["username"]) ;
		$text = escapeshellarg ($data ["text"]) ;
		$summary = escapeshellarg ($data ["summary"]) ;
		$summary != '' ? $summary_text = " -s $summary" : $summary_text = "" ;

		$this->addLog ("Starting task.") ;
		$this->addLog ("Article text: ") ;
		$this->addLog ($text) ;

		$this->addLog ("Article summary: ") ;
		$this->addLog ($summary_text) ;

		$options_switches = array ('-m','-b','-a','--no-rc') ;
		$options_descriptions = array (
			'minor edit' ,
			'bot (hidden) edit' ,
			'enable autosummary' ,
			'do not show the change in recent changes'
		) ;

		$this->addLog ("Article flags used with this operation: ") ;

		/* initialize semi-global options */
		$semiglobals = '' ;
		$flags = $data ["flags"] ;
		for ($j = 0; $j < count ($flags); $j++) {
			if ($flags [$j]) {
				$semiglobals .= " " . $options_switches [$j];
				$this->addLog (' - ' . $options_descriptions [$j]) ;
			}
		}

		$this->addLog ("List of edited articles (by" . $this->mUser . ' as ' . $username . "):") ;

		for ($i = 0 ; $i < count ($articles) ; $i++) {

			$titleobj = Title::makeTitle ($articles [$i]["namespace"], $articles [$i]["title"]) ;
			$article_to_do = $titleobj->getText () ;
			$namespace = intval($articles [$i]["namespace"]);

			$sCommand = "SERVER_ID=".$articles [$i]["wikiid"]." php $IP/maintenance/wikia/editOn.php -u ".$username." -t " . escapeshellarg ($article_to_do) . " -n " . $namespace . " -x ".$text." ".$summary_text." $semiglobals --conf " .$wgWikiaLocalSettingsPath ;

                        $city_url  = WikiFactory::getVarValueByName( "wgServer", $articles [$i]["wikiid"] ) ;
                        if (empty ($city_url)) {
                                $city_url = 'wiki id in WikiFactory: ' . $articles [$i]["wikiid"]  ;
                        }

                        $city_path  = WikiFactory::getVarValueByName( "wgScript", $articles [$i]["wikiid"] ) ;

			$actual_title = wfShellExec( $sCommand, $retval ) ;

			wfShellExec( $sCommand, $retval ) ;
			if ($retval) {
                                $this->addLog ('Article editing error! (' . $city_url . '). Error code returned: ' .  $retval . ' Error was: ' . $actual_title) ;
			} else {
                        	$this->addLog ('<a href="' . $city_url . $city_path . '?title=' . $actual_title . '">' . $city_url . $city_path . '?title=' . $actual_title . '</a>') ;
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
	        return true ;
	}

	function submitForm () {
		global $wgRequest, $wgOut, $IP, $wgUser ;
		if (isset ($_SESSION ["MWE_selected_articles"]) ) {
			$articles = $this->mArguments ;
			$mode = $this->mMode ;
			$username = $_SESSION ["MWE_username"] ;
			$text = $_SESSION ["MWE_text"] ;
			$summary = $_SESSION ["MWE_summary"] ;
			$flags = $_SESSION ["MWE_selected_flags"] ;

			$tempUser = User::newFromName ($username) ;

			#--- all should be correct at this point
			#--- first prepare serialized info with params

			if (!$this->mSingle) {
				$sel_articles = array () ;

				for ($i = 0 ; $i < count ($articles) ; $i++) {
					if ($wgRequest->getVal("wpArticle" . $i) == 1) {
						array_push ($sel_articles, $articles [$i]) ;
					}
				}
			} else {
				/* in case of a single (this) wiki deletion, do not need confirmation */
				$sel_articles = $articles ;
			}

			$sParams = serialize ( array(
						"articles" => $sel_articles ,
						"username" => $username ,
						"text" => $text ,
						"summary" => $summary ,
						"flags" => $flags ,
						"mode" => $mode ,
						"admin" => $this->mAdmin
					     ));

			$dbw = wfGetDB( DB_MASTER );
			$dbw->selectDB( "wikicities" );

			$dbw->insert( "wikia_tasks", array(
						"task_user_id" => $wgUser->getID(),
						"task_type" => $this->mType,
						"task_priority" => 1,
						"task_status" => 1,
						"task_added" => wfTimestampNow(),
						"task_started" => "",
						"task_finished" => "",
						"task_arguments" => $sParams
						));
			$task_id = $dbw->insertId () ;
			$dbw->close();
			return $task_id ;
		}
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
						"multiwikiedit mode: %s,<br/> article: %s, namespace %d <br/>as user: <a href=\"%s\">%s</a>",
						$mode ,
						$article ,
						$args ["articles"][0]["namespace"] ,
						$userLink ,
						$userName
					       );
			} else {
				$url = $args ["articles"][0]["url"] ;		
				$desc = sprintf(
						"multiwikiedit mode: %s,<br/>wiki: <a href=\"%s\">%s</a>,<br/>as user: <a href=\"%s\">%s</a>",
						$mode ,
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
