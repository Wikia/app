<?php

/**
 * @package MediaWiki
 * @subpackage BatchTask
 * @author Maciej Błaszkowski <marooned at wikia.com> for Wikia.com
 * @copyright (C) 2008, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension and cannot be used standalone.\n";
	exit( 1 ) ;
}

if (!defined('MSG_STATUS_DB')) {
	define('MSG_STATUS_DB', wfSharedTable('messages_status'));
}
if (!defined('MSG_STATUS_UNSEEN')) {
	define('MSG_STATUS_UNSEEN', '0');
}
if (!defined('MSG_STATUS_DISMISSED')) {
	define('MSG_STATUS_DISMISSED', '2');
}

#--- messages file
$wgExtensionMessagesFiles['SWMSendToGroupTask'] = dirname(__FILE__) . '/SWMSendToGroupWikiTask/SWMSendToGroupTask.i18n.php';

class SWMSendToGroupTask extends BatchTask {
	public $mType, $mVisible, $mParams, $mFounder, $mStaff;
	public $mWikiParams, $mWikiID, $mTaskParams, $mData;

	/**
	 * contructor
	 */
	function  __construct() {
		$this->mType = 'SWMSendToGroup';
		$this->mVisible = false;
		$this->mTTL = 3600; #--- one hour
		parent::__construct();
	}

	/**
	 * execute
	 *
	 * entry point for TaskExecutor
	 *
	 * @access public
	 * @author Maciej Błaszkowski (Marooned) <marooned at wikia.com>
	 *
	 * @param mixed $params default null - task data from wikia_tasks table
	 *
	 * @return boolean - status of operation
	 */
	function execute( $params = null ) {
		$this->mData = $params;
		//set task id for future use (logs, for example)
		$this->mTaskID = $params->task_id;
		$args = unserialize($params->task_arguments) ;

		$result = false;
		$this->addLog("Begin process of sending messages [wiki mode: {$args['sendModeWikis']}, user mode: {$args['sendModeUsers']}].");
		switch ($args['sendModeWikis']) {
			case 'ALL':
				switch ($args['sendModeUsers']) {
					case 'ACTIVE':
						$this->sendMessageToActive($args);
						break;

					case 'GROUP':
						$this->sendMessageToGroup($args);
						break;
				}
				break;

			case 'HUB':
				switch ($args['sendModeUsers']) {
					case 'ALL':
					case 'ACTIVE':
						$this->sendMessageToHub($args);
						break;

					case 'GROUP':
						$this->sendMessageToGroupOnHub($args);
						break;
				}
				break;

			case 'WIKI':
				switch ($args['sendModeUsers']) {
					case 'GROUP':
						$result = $this->sendMessageToWiki($args);
						break;
				}
				break;
		}
		return (boolean)$result;
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

	/**
	 * getDescription
	 *
	 * description of task, used in task listing.
	 *
	 * @access public
	 * @author Maciej Błaszkowski (Marooned) <marooned at wikia.com>
	 *
	 * @return string: task description
	 */
	public function getDescription() {
		$desc = $this->getType();
		if( !is_null( $this->mData ) ) {
			$args = unserialize( $this->mData->task_arguments );
			if (!isset($args['sendModeWikis'])) {	//backward compatibility
				$desc = $args['taskType'] == 'GROUP' ?
					sprintf('SiteWideMessages :: Send to a group<br/>' .
					'Group: %s, Wiki: %s<br/>' .
					'Sender: %s [id: %d]',
					$args['groupName'],
					($args['groupMode'] == 'ALL' ? '<i>ALL</i>' : $args['groupWikiName']),
					$args['senderName'],
					$args['senderId']
				) :
					sprintf('SiteWideMessages :: Send to a hub<br/>' .
					'Hub ID: %s<br/>' .
					'Sender: %s [id: %d]',
					$args['hubId'],
					$args['senderName'],
					$args['senderId']
				);
			} else {
				switch ($args['sendModeWikis']) {
					case 'ALL':
						switch ($args['sendModeUsers']) {
							case 'ACTIVE':
								$desc = sprintf('SiteWideMessages :: Send to active users<br/>' .
									'Sender: %s [id: %d]',
									$args['senderName'],
									$args['senderId']
								);
								break;

							case 'GROUP':
								$desc = sprintf('SiteWideMessages :: Send to a group on all wikis<br/>' .
									'Group: %s, Wiki: <i>ALL</i><br/>' .
									'Sender: %s [id: %d]',
									$args['groupName'],
									$args['senderName'],
									$args['senderId']
								);
								break;
						}
						break;

					case 'HUB':
						switch ($args['sendModeUsers']) {
							case 'ALL':
							case 'ACTIVE':
								$desc = sprintf('SiteWideMessages :: Send to a hub<br/>' .
									'Hub ID: %s<br/>' .
									'Sender: %s [id: %d]',
									$args['hubId'],
									$args['senderName'],
									$args['senderId']
								);
								break;

							case 'GROUP':
								$desc = sprintf('SiteWideMessages :: Send to a group on a hub<br/>' .
									'Group: %s, Hub ID: %s<br/>' .
									'Sender: %s [id: %d]',
									$args['groupName'],
									$args['hubId'],
									$args['senderName'],
									$args['senderId']
								);
								break;
						}
						break;

					case 'WIKI':
						switch ($args['sendModeUsers']) {
							case 'GROUP':
								$desc = sprintf('SiteWideMessages :: Send to a group on one wiki<br/>' .
									'Group: %s, Wiki: %s<br/>' .
									'Sender: %s [id: %d]',
									$args['groupName'],
									$args['wikiName'],
									$args['senderName'],
									$args['senderId']
								);
								break;
						}
						break;
				}
			}
		}
		return $desc;
	}

	/**
	 * sendMessageToGroup
	 *
	 * sends a message to specified group of users
	 *
	 * @access private
	 * @author Maciej Błaszkowski (Marooned) <marooned at wikia.com>
	 *
	 * @param mixed $params - task arguments
	 *
	 * @return boolean: result of sending
	 */
	private function sendMessageToGroup($params) {
		$result = true;

		$DB = wfGetDB(DB_SLAVE);

		//step 1 of 3: get list of all active wikis
		$this->addLog('Step 1 of 3: get list of all active wikis');
		$dbResult = $DB->Query (
			  'SELECT city_id, city_dbname'
			. ' FROM ' . wfSharedTable('city_list')
			. ' WHERE city_public = 1'
			. ' AND city_useshared = 1'
			. ';'
			, __METHOD__
		);

		$wikisDB = array();
		while ($row = $DB->FetchObject($dbResult)) {
			$wikisDB[$row->city_id] = $row->city_dbname;
		}
		$DB->FreeResult($dbResult);

		$result = $this->sendMessageHelperToGroup($DB, $wikisDB, $params);

		return $result;
	}

	/**
	 * sendMessageToWiki
	 *
	 * sends a message to specified group of users
	 *
	 * @access private
	 * @author Maciej Błaszkowski (Marooned) <marooned at wikia.com>
	 *
	 * @param mixed $params - task arguments
	 *
	 * @return boolean: result of sending
	 */
	private function sendMessageToWiki($params) {
		$result = true;

		$wikiID = null;
		$wikiDomains = array('', '.wikia.com', '.sjc.wikia-inc.com');
		foreach($wikiDomains as $wikiDomain) {
			if(!is_null($wikiID = WikiFactory::DomainToID($params['wikiName'] . $wikiDomain))) {
				break;
			}
		}
		if (is_null($wikiID)) {
			return false;
		}

		$DB = wfGetDB(DB_SLAVE);
		$dbResult = $DB->Query (
			  'SELECT city_useshared'
			. ' FROM ' . wfSharedTable('city_list')
			. " WHERE city_id = $wikiID"
			. ';'
			, __METHOD__
		);

		if($row = $DB->FetchObject($dbResult)) {
			if ($row->city_useshared != '1') {
				$this->addLog("Wiki [wiki_id = $wikiID] does not use shared database. Message was not sent.");
				return false;
			}
		}
		$DB->FreeResult($dbResult);

		$this->addLog("Look into selected wiki for users that belong to a specified group [wiki_id = $wikiID, wiki_db = $wikiDB]");
		$wikiDB = WikiFactory::IDtoDB($wikiID);
		$DB->selectDB($wikiDB);
		$dbResult = $DB->Query (
			  'SELECT ug_user'
			. ' FROM user_groups'
			. ' WHERE ug_group = ' . $DB->AddQuotes($params['groupName'])
			. ';'
			, __METHOD__
		);

		$sqlValues = array();
		while ($row = $DB->FetchObject($dbResult)) {
			$sqlValues[] = "($wikiID, {$row->ug_user}, {$params['messageId']}, " . MSG_STATUS_DISMISSED . ')';
		}
		$DB->FreeResult($dbResult);
		$this->addLog("Add records about new message to right users [wiki_id = $wikiID, wiki_db = $wikiDB, number of users = " . count($sqlValues) . "]");
		if (count($sqlValues)) {
			$result = $this->sendMessageHelperToUsers($sqlValues);
		}
		unset($sqlValues);
		return $result;
	}

	/**
	 * sendMessageToHub
	 *
	 * sends a message to active users on wikis in specified hub
	 *
	 * @access private
	 * @author Maciej Błaszkowski (Marooned) <marooned at wikia.com>
	 *
	 * @param mixed $params - task arguments
	 *
	 * @return boolean: result of sending
	 */
	private function sendMessageToHub($params) {
		$result = true;

		$DB = wfGetDB(DB_SLAVE);

		//step 1 of 3: get list of all active wikis
		$this->addLog('Step 1 of 3: get list of all active wikis belonging to a specified hub');
		$dbResult = $DB->Query (
			  'SELECT city_id, city_dbname'
			. ' FROM ' . wfSharedTable('city_list')
			. ' JOIN ' . wfSharedTable('city_cat_mapping') . ' USING (city_id)'
			. ' WHERE city_public = 1'
			. ' AND city_useshared = 1'
			. ' AND cat_id = ' . $params['hubId']
			. ';'
			, __METHOD__
		);

		$wikisDB = array();
		while ($row = $DB->FetchObject($dbResult)) {
			$wikisDB[$row->city_id] = $row->city_dbname;
		}
		$DB->FreeResult($dbResult);

		$result = $this->sendMessageHelperToActive($DB, $wikisDB, $params);

		return $result;
	}

	/**
	 * sendMessageToGroupOnHub
	 *
	 * sends a message to active users on wikis in specified hub
	 *
	 * @access private
	 * @author Maciej Błaszkowski (Marooned) <marooned at wikia.com>
	 *
	 * @param mixed $params - task arguments
	 *
	 * @return boolean: result of sending
	 */
	private function sendMessageToGroupOnHub($params) {
		$result = true;

		$DB = wfGetDB(DB_SLAVE);

		//step 1 of 3: get list of all active wikis
		$this->addLog('Step 1 of 3: get list of all active wikis belonging to a specified hub');
		$dbResult = $DB->Query (
			  'SELECT city_id, city_dbname'
			. ' FROM ' . wfSharedTable('city_list')
			. ' JOIN ' . wfSharedTable('city_cat_mapping') . ' USING (city_id)'
			. ' WHERE city_public = 1'
			. ' AND city_useshared = 1'
			. ' AND cat_id = ' . $params['hubId']
			. ';'
			, __METHOD__
		);

		$wikisDB = array();
		while ($row = $DB->FetchObject($dbResult)) {
			$wikisDB[$row->city_id] = $row->city_dbname;
		}
		$DB->FreeResult($dbResult);

		$result = $this->sendMessageHelperToGroup($DB, $wikisDB, $params);

		return $result;
	}

	/**
	 * sendMessageToActive
	 *
	 * sends a message to active users on all wikis
	 *
	 * @access private
	 * @author Maciej Błaszkowski (Marooned) <marooned at wikia.com>
	 *
	 * @param mixed $params - task arguments
	 *
	 * @return boolean: result of sending
	 */
	private function sendMessageToActive($params) {
		$result = true;

		$DB = wfGetDB(DB_SLAVE);

		//step 1 of 3: get list of all active wikis
		$this->addLog('Step 1 of 3: get list of all active wikis');
		$dbResult = $DB->Query (
			  'SELECT city_id, city_dbname'
			. ' FROM ' . wfSharedTable('city_list')
			. ' WHERE city_public = 1'
			. ' AND city_useshared = 1'
			. ';'
			, __METHOD__
		);

		$wikisDB = array();
		while ($row = $DB->FetchObject($dbResult)) {
			$wikisDB[$row->city_id] = $row->city_dbname;
		}
		$DB->FreeResult($dbResult);

		$result = $this->sendMessageHelperToActive($DB, $wikisDB, $params);

		return $result;
	}

	/**
	 * sendMessageToUser
	 *
	 * add record about new message for specified users
	 *
	 * @access private
	 * @author Maciej Błaszkowski (Marooned) <marooned at wikia.com>
	 *
	 * @param mixed $userId - User ID
	 *
	 * @return boolean: result of operation
	 */
	private function sendMessageHelperToUsers(&$sqlValues) {
		$DB = wfGetDB(DB_MASTER);
		$dbResult = (boolean)$DB->Query (
			  'INSERT INTO ' . MSG_STATUS_DB
			. ' (msg_wiki_id, msg_recipient_id, msg_id, msg_status)'
			. ' VALUES ' . implode(',', $sqlValues)
			. ';'
			, __METHOD__
		);
		return $dbResult;
	}

	/**
	 * sendMessageHelperToActive
	 *
	 * send message to active users on provided wikis
	 *
	 * @access private
	 * @author Maciej Błaszkowski (Marooned) <marooned at wikia.com>
	 *
	 * @param mixed $wikisDB - arary of wikis
	 *
	 * @return boolean: result of operation
	 */
	private function sendMessageHelperToActive(&$DB, &$wikisDB, &$params) {
		$result = true;
		$usersSent = array();

		//step 2 of 3: look into each wiki for active users
		$this->addLog('Step 2 of 3: look into each wiki for active users [number of wikis = ' . count($wikisDB) . ']');
		foreach($wikisDB as $wikiID => $wikiDB) {
			$DB->selectDB($wikiDB);
			if (!$DB->tableExists('local_users')) {
				continue;
			}
			$dbResult = $DB->Query (
				  'SELECT user_id'
				. ' FROM local_users'
				. ';'
				, __METHOD__
			);

			//step 3 of 3: add records about new message to right users
			$sqlValues = array();
			while ($row = $DB->FetchObject($dbResult)) {
				if (empty($usersSent[$row->user_id])) {
					$sqlValues[] = "($wikiID, {$row->user_id}, {$params['messageId']}, " . MSG_STATUS_DISMISSED . ')';
					$usersSent[$row->user_id] = true;
				}
			}
			$DB->FreeResult($dbResult);
			if (count($sqlValues)) {
				//remove line below if log is too long
				$this->addLog("Step 3 of 3: add records about new message to right users [wiki_id = $wikiID, wiki_db = $wikiDB, number of users = " . count($sqlValues) .	"]");
				$result &= $this->sendMessageHelperToUsers($sqlValues);
			}
			unset($sqlValues);
		}
		return $result;
	}

	/**
	 * sendMessageHelperToGroup
	 *
	 * send message to active users on provided wikis
	 *
	 * @access private
	 * @author Maciej Błaszkowski (Marooned) <marooned at wikia.com>
	 *
	 * @param mixed $wikisDB - arary of wikis
	 *
	 * @return boolean: result of operation
	 */
	private function sendMessageHelperToGroup(&$DB, &$wikisDB, &$params) {
		$usersSent = array();

		//step 2 of 3: look into each wiki for users that belong to a specified group
		$this->addLog('Step 2 of 3: look into each wiki for users that belong to a specified group [number of wikis = ' . count($wikisDB) . ']');
		foreach($wikisDB as $wikiID => $wikiDB) {
			$DB->selectDB($wikiDB);
			$dbResult = $DB->Query (
				  'SELECT ug_user'
				. ' FROM user_groups'
				. ' WHERE ug_group = ' . $DB->AddQuotes($params['groupName'])
				. ';'
				, __METHOD__
			);

			//for log purpose
			$wikiIDorg = $wikiID;
			//if the group is 'staff' - display (==send) the message on a local wiki [John's request, 2008-03-06] - Marooned
			if ($params['groupName'] == 'staff') {
				$wikiID = null;
			}

			//step 3 of 3: add records about new message to right users
			$sqlValues = array();
			while ($row = $DB->FetchObject($dbResult)) {
				if (empty($usersSent[$row->ug_user])) {
					$sqlValues[] = "($wikiID, {$row->ug_user}, {$params['messageId']}, " . MSG_STATUS_DISMISSED . ')';
					$usersSent[$row->ug_user] = true;
				}
			}
			$DB->FreeResult($dbResult);
			if (count($sqlValues)) {
				//remove line below if log is too long
				$this->addLog("Step 3 of 3: add records about new message to right users [wiki_id = $wikiIDorg, wiki_db = $wikiDB, number of users = " . count($sqlValues) .	"]");
				$result &= $this->sendMessageHelperToUsers($sqlValues);
			}
			unset($sqlValues);
		}
	}
}