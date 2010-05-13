<?php

/**
 * @package MediaWiki
 * @subpackage BatchTask
 * @author Bartek Lapinski <bartek@wikia.com> for Wikia.com
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @copyright (C) 2007-2009, Wikia Inc.
 * @license GNU General Public Licence 2.0 or later
 */

class MultiDeleteTask extends BatchTask {
	var $mType, $mVisible, $mArguments, $mMode, $mAdmin;
	var $records, $title, $namespace;
	var $mUser, $mUsername;

	/* constructor */
	function __construct( $params = array() ) {
		$this->mType = 'multidelete';
		$this->mVisible = false; //we don't show form for this, it already exists
		$this->mParams = $params;
		$this->mTTL = 60 * 60 * 24; // 5 hours
		$this->records = 1000;
		parent::__construct ();
	}

	function execute($params = null) {
		global $IP, $wgWikiaLocalSettingsPath;
		/*	go with each supplied wiki and delete the supplied article
			load all configs for particular wikis before doing so
			(from wikifactory, not by _obsolete_ maintenance scripts
			and from LocalSettings as worked on fps)
		*/

		$this->mTaskID = $params->task_id;
		$oUser = User::newFromId( $params->task_user_id );

		if ( $oUser instanceof User ) {
			$oUser->load();
			$this->mUser = $oUser->getName();
		} else {
			$this->log("Invalid user - id: " . $params->task_user_id );
			return true;
		}

		$data = unserialize($params->task_arguments);
		$article = $data['page'];
		$username = escapeshellarg($data["user"]);
		$oUser = User::newFromName( $username );
		if ( !is_object($oUser) ) {
			$username = '';
		}
		$this->addLog('Starting task.');
		$this->addLog('Page to delete by ' . $this->mUser . ' (as ' . $username . '): ' . $article );

		$page = Title::newFromText($article);
		if ( !is_object($page) ) {
			$this->log("Page " . $article . " is invalid - task was terminated ");
			return true;
		}
		$this->namespace = $page->getNamespace();
		$this->title = str_replace( ' ', '_', $page->getText() );
		$resultTitle = $page->getFullText();

		$range = escapeshellarg($data["range"]);
		$selwikia = intval($data["selwikia"]);
		$wikis = $data["wikis"];
		$lang = $data["lang"];
		$cat = intval($data["cat"]);
		$reason = escapeshellarg($data['reason']);

		$pre_wikis = array();
		if ( !empty($wikis) ) {
			$pre_wikis = explode( ",", $wikis );
		}

		$wikiList = $this->fetchWikis($pre_wikis, $lang, $cat, $selwikia);

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
				$sCommand  = "SERVER_ID={$oWiki->city_id} php $IP/maintenance/wikia/deleteOn.php ";
				$sCommand .= "-u " . $username . " ";
				$sCommand .= "-t " . escapeshellarg($this->title) . " ";
				$sCommand .= "-n " . $this->namespace . " ";
				if ( $reason ) {
					$sCommand .= "-r " . $reason . " ";
				}
				$sCommand .= "--conf {$wgWikiaLocalSettingsPath}";

				$actual_title = wfShellExec($sCommand, $retval);

				if ($retval) {
					$this->addLog('Article deleting error! (' . $city_url . '). Error code returned: ' .  $retval . ' Error was: ' . $actual_title);
				} else {
					$this->addLog('Removed: <a href="' . $city_url . $city_path . '?title=' . wfEscapeWikiText($actual_title)  . '">' . $city_url . $city_path . '?title=' . $actual_title . '</a>');
				}
			}
		}
		
		$this->log("Done");
		
		return true;
	}

	function getType() {
		return $this->mType;
	}

	function isVisible() {
		return $this->mVisible;
	}

	function getForm ($title, $errors = false ) {
		return true;
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
	 * @author eloy@wikia, bartek@wikia, marooned@wikia-inc
	 *
	 * @return string: task description
	 */
	public function getDescription() {
		$desc = $this->getType();
		if( !is_null( $this->mData ) ) {
			$args = @unserialize( $this->mData->task_arguments );
			$mode = @$args['mode'];
			$admin = @$args['admin'];

			$oUser = User::newFromName ($admin);
			if (is_object ($oUser)) {
				$oUser->load();
				$userLink = $oUser->getUserPage()->getLocalUrl();
				$userName = $oUser->getName();
			} else {
				$userLink = '';
				$userName = '<i>unknown</i>';
			}
			$desc = sprintf(
				'multidelete as user: <a href="%s">%s</a>',
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
		global $wgExternalSharedDB, $wgExternalDatawareDB ;
		$this->log("Get list of titles");

		$wikiList = array();
		if ( !empty($wikis) ) {
			$dbr = wfGetDB (DB_SLAVE, array(), $wgExternalSharedDB);
			$oRes = $dbr->select(
				array( "city_list", "city_domains" ),
				array( "city_list.city_id" ),
				array(
					"city_list.city_id = city_domains.city_id",
					"city_domain in (" . $dbr->makeList($wikis) . ") "
				),
				__METHOD__
			);
			$wikiArr = array();
			while ( $oRow = $dbr->fetchObject($oRes) ) {
				$wikiList[] = $oRow->city_id;
			}
			$dbr->freeResult ($oRes) ;
		}
		
		$dbr = wfGetDB (DB_SLAVE, 'blobs', $wgExternalDatawareDB);
		$where = array(
			"page_title_lower"	=> strtolower($this->title),
			"page_namespace" 	=> $this->namespace,
			"page_status" 		=> 0
		);
		if ( !empty($wikiaId) ) {
			$where["page_wikia_id"] = $wikiaId;
		}
		
		$oRes = $dbr->select(
			array( "pages" ),
			array( "page_wikia_id as city_id" ),
			$where,
			__METHOD__
		);

		$wikiArr = array();
		while ( $oRow = $dbr->fetchObject($oRes) ) {
			# check exists in array
			if ( !empty($wikiList) && !in_array( $oRow->city_id, $wikiList ) ) continue;
			# add to array
			$wikiArr[$oRow->city_id] = $oRow;
		}
		$dbr->freeResult ($oRes) ;

		$this->log("Found: " . count($wikiArr) . " articles");
		if ( count($wikiArr) ) {
			if ( !empty($lang) || !empty($cat) ) {
				$this->log("Apply filter: language: $lang, category: $cat");

				$where = array("city_public" => 1);
				$count = 0;
				if ( !empty($lang) ) {
					$where['city_lang'] = $lang;
				}
				else if (!empty($cat)) {
					$where['cat_id'] = $cat;
				}

				$dbc = wfGetDB (DB_SLAVE, array(), $wgExternalSharedDB);
				$oRes = $dbc->select ( 
					array( 'city_list', 'city_cat_mapping' ),
					array( 'city_list.city_id' ),
					$where,
					__METHOD__,
					"",
					array(
						'city_cat_mapping' => array(
							'JOIN', 
							'city_cat_mapping.city_id = city_list.city_id',
						)
					)
				);
				
				$filteredWikis = array();

				while ($oRow = $dbc->fetchObject($oRes)) {
					if ( isset($wikiArr[$oRow->city_id]) ) {
						$filteredWikis[$oRow->city_id] = $oRow->city_id;
					}
				}
				$dbc->freeResult ($oRes) ;

				$wikiArr = $filteredWikis;
				$this->log("Found (after filter applying): " . count($wikiArr) . " articles");
			}
		}

		return $wikiArr;
	}
	
}
