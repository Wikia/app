<?php

/**
 * @package MediaWiki
 * @subpackage BatchTask
 * @author Bartek Lapinski <bartek@wikia.com> for Wikia.com, Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @copyright (C) 2007-2009, Wikia Inc.
 * @license GNU General Public Licence 2.0 or later
 * @version: $Id$
 */


class MultiMoveTask extends BatchTask {
	public
		$mType,
		$mVisible,
		$mUser;

	/* constructor */
	function __construct( $params = array() ) {
        $this->mType = 'multimove';
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
		
		# old article
		$oOldTitle = ( isset($data['page']) ) ? Title::newFromText($data['page']) : null;
		if ( !is_object($oOldTitle) ) {
			$this->log("Page " . @$data['page'] . " is invalid - task was terminated ");
			return true;
		}
		if( !$oOldTitle->exists() ) {
			$this->log("Page " . @$data['page'] . " doesn't exist - task was terminated ");
			return true;
		}
		$this->namespace = $oOldTitle->getNamespace();
		$this->title = str_replace( ' ', '_', $oOldTitle->getText() );
		$resultTitle = $oOldTitle->getFullText();
				
		# new article
		$oNewTitle = ( isset($data['newpage']) ) ? Title::newFromText($data['newpage']) : null;
		if ( !is_object($oNewTitle) ) {
			$this->log("Page to move: " . @$data['newpage'] . " is invalid - task was terminated ");
			return true;
		}
		if( $oNewTitle->exists() ) {
			$this->log("Page to move: " . @$data['newpage'] . " exists - task was terminated ");
			return true;
		}
		$this->newnamespace = $oNewTitle->getNamespace();
		$this->newtitle = str_replace( ' ', '_', $oNewTitle->getText() );
		$newResultTitle = $oNewTitle->getFullText();
				
		# user 
		$username = ( isset($data["user"]) ) ? escapeshellarg($data["user"]) : 'Maintenance script';
		$oUser = User::newFromName( $username );
		if ( !is_object($oUser) ) {
			$username = '';
		}

		# redirect
		$redirect = ( isset($data["redirect"]) ) ? $data["redirect"] : 0 ;

		# watch the new page
		$watch = ( isset($data["watch"]) ) ? $data["watch"] : 0;
		
		# reason
		$reason = ( isset($data["reason"]) ) ? escapeshellarg($data["reason"]) : "";
				
		# lang
		$lang = ( isset($data["lang"]) ) ? $data["lang"] : null;
		
		# cat
		$cat = ( isset($data["cat"]) ) ? intval($data["cat"]) : null;
		
		# wikis
		$range = ( isset($data["range"]) ) ? escapeshellarg($data["range"]) : null;
		$selwikia = ( isset($data["selwikia"]) ) ? intval($data["selwikia"]) : null;
		$wikis = ( isset($data["wikis"]) ) ? $data["wikis"] : null;
		$pre_wikis = array();
		if ( !empty($wikis) ) {
			$pre_wikis = explode( ",", $wikis );
		}
		$wikiList = $this->fetchWikis($pre_wikis, $lang, $cat, $selwikia);

		# start task
		$this->addLog('Starting task.');
		$this->addLog('Page ' . @$data['page'] . ' is moved by ' . $this->mUser . ' (as ' . $username . ') to ' . @$data['newpage'] );

		$this->log("Found " . count($wikiList) . " Wikis to proceed");
		if ( !empty($wikiList) ) {
			foreach ( $wikiList as $city_id => $oWiki ) {
				$retval = "";
				$city_url = WikiFactory::getVarValueByName( "wgServer", $oWiki->city_id );
				$city_path = WikiFactory::getVarValueByName( "wgScript", $oWiki->city_id );
				
				if ( empty($city_url) ) {
					$city_url = 'wiki id in WikiFactory: ' . $oWiki->city_id;
				}
				# command
				$sCommand  = "SERVER_ID={$oWiki->city_id} php $IP/maintenance/wikia/moveOn.php ";
				$sCommand .= "--u " . $username . " ";
				$sCommand .= "--ot " . escapeshellarg($this->title) . " ";
				$sCommand .= "--on " . $this->namespace . " ";
				$sCommand .= "--nt " . escapeshellarg($this->newtitle) . " ";
				$sCommand .= "--nn " . $this->newnamespace . " ";			
				if ( $reason ) 
					$sCommand .= "--r " . $reason . " ";
				if ( $redirect ) 
					$sCommand .= "--redirect 1 ";
				if ( $watch ) 
					$sCommand .= "--watch 1 ";
				$sCommand .= "--conf $wgWikiaLocalSettingsPath";

				$log = wfShellExec( $sCommand, $retval );
				if ($retval) {
					$this->log ('Article editing error! (' . $city_url . '). Error code returned: ' .  $retval . ' Error was: ' . $log);
				}
				else {
					$nTitle = $oNewTitle->getFullText();
					$this->log ('<a href="' . $city_url . $city_path . '?title=' . wfEscapeWikiText($nTitle) . '">' . $city_url . $city_path . '?title=' . $nTitle . '</a>');
					$this->log ("Log: \n" . $log ."\n");
				}
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

	function getForm($title, $errors = false ) {
		return true ;
	}

	function submitForm() {
		global $wgRequest, $wgOut, $IP, $wgUser, $wgExternalSharedDB;

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
			$args = @unserialize( $this->mData->task_arguments );
			$admin = @$args["admin"];
			$oUser = User::newFromName ($admin);
			if (is_object ($oUser)) {
				$oUser->load();
				$userLink = $oUser->getUserPage()->getLocalUrl();
				$userName = $oUser->getName();
			} else {
				$userLink = '';
				$userName = '';
			}

			$title = $namespace = '';
			$newtitle = $newnamespace = '';

			if ( isset($args["page"]) ) {			
				$page = Title::newFromText($args["page"]);
				if ( !is_object($page) ) {
					$title = $args["page"];
				} else {
					$namespace = $page->getNamespace();
					$title = str_replace( ' ', '_', $page->getText() );
				}
			}
			
			if ( isset($args["newpage"]) ) {			
				$newpage = Title::newFromText($args["newpage"]);
				if ( !is_object($newpage) ) {
					$newtitle = $args["newpage"];
				} else {
					$newnamespace = $newpage->getNamespace();
					$newtitle = str_replace( ' ', '_', $newpage->getText() );
				}
			}			

			$desc = sprintf (
				"multimove page: %s (namespace: %d),<br/> new page: %s (namespace: %d) <br/>by user: <a href=\"%s\">%s</a>",
				$title,
				$namespace,
				$newtitle,
				$newnamespace,
				$userLink,
				$userName
			);
		}
		return $desc;
	}

	/**
	 * fetchWikis
	 *
	 * return number of wikis for params
	 *
	 * @access private
	 *
	 * @return integer (count of wikis)
	 */
	private function fetchWikis($wikis = array(), $lang = '', $cat = 0, $wikiaId = 0) {
		global $wgExternalSharedDB ;
		$dbr = wfGetDB (DB_SLAVE, array(), $wgExternalSharedDB);

		$where = array("city_public" => 1);
		$count = 0;
		if ( !empty($lang) ) {
			$where['city_lang'] = $lang;
		}
		else if (!empty($cat)) {
			$where['cat_id'] = $cat;
		}

		if ( !empty($wikiaId) ) {
			$where['city_list.city_id'] = $wikiaId;
		}

		if ( empty($wikis) ) {
			$oRes = $dbr->select(
				array( "city_list join city_cat_mapping on city_cat_mapping.city_id = city_list.city_id" ),
				array( "city_list.city_id, city_dbname, city_url, '' as city_server, '' as city_script" ),
				$where,
				__METHOD__
			);
		} else {
			$where[] = "city_list.city_id = city_domains.city_id";
			$where[] = " city_domain in ('" . implode("','", $wikis) . "') ";

			$oRes = $dbr->select(
				array( "city_list", "city_domains" ),
				array( "city_list.city_id, city_dbname, city_url, '' as city_server, '' as city_script" ),
				$where,
				__METHOD__
			);
		}

		$wiki_array = array();
		while ($oRow = $dbr->fetchObject($oRes)) {
			$oRow->city_server = WikiFactory::getVarValueByName( "wgServer", $oRow->city_id );
			$oRow->city_script = WikiFactory::getVarValueByName( "wgScript", $oRow->city_id );
			array_push($wiki_array, $oRow) ;
		}
		$dbr->freeResult ($oRes) ;

		return $wiki_array;
	}
}
