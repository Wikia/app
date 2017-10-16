<?php

/**
 * @package MediaWiki
 * @subpackage BatchTask
 * @author Maciej Błaszkowski <marooned at wikia-inc.com> for Wikia.com
 * @copyright (C) 2008, Wikia Inc.
 * @license GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension and cannot be used standalone.\n";
	exit( 1 ) ;
}

if (!defined('MSG_STATUS_DB')) {
	define('MSG_STATUS_DB', 'messages_status');
}
if (!defined('MSG_STATUS_UNSEEN')) {
	define('MSG_STATUS_UNSEEN', '0');
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
		$this->mTTL = 60 * 60 * 12; #--- 12 hours
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
		$this->log("Begin process of sending messages [wiki mode: {$args['sendModeWikis']}, user mode: {$args['sendModeUsers']}].");
		switch ($args['sendModeWikis']) {
			case 'ALL':
				switch ($args['sendModeUsers']) {
					case 'ACTIVE':
						$result = $this->sendMessageToActive($args);
						break;

					case 'GROUP':
						$result = $this->sendMessageToGroup($args);
						break;

					case 'USERS':
						$result = $this->sendMessageToList( $args );
						break;

					case 'REGISTRATION':
						$result = $this->sendMessageToRegistered( $args );
						break;

					case 'EDITCOUNT':
						$result = $this->sendMessageByEditcountGlobal( $args );
						break;
				}
				break;

			case 'HUB':
				switch ($args['sendModeUsers']) {
					case 'ALL':
					case 'ACTIVE':
					case 'ANONS':
						$result = $this->sendMessageToHub($args);
						break;

					case 'GROUP':
						$result = $this->sendMessageToGroupOnHub($args);
						break;
				}
				break;

			case 'CLUSTER':
				switch ($args['sendModeUsers']) {
					case 'ALL':
					case 'ACTIVE':
						$result = $this->sendMessageToCluster($args);
						break;

					case 'GROUP':
						$result = $this->sendMessageToGroupOnCluster($args);
						break;
				}
				break;

			case 'WIKI':
				switch ($args['sendModeUsers']) {
					case 'GROUP':
						$result = $this->sendMessageToWiki($args);
						break;

					case 'EDITCOUNT':
						$result = $this->sendMessageByEditcountLocal( $args );
						break;
				}
				break;

			case 'WIKIS':
				switch ( $args['sendModeUsers'] ) {
					case 'ALL':
					case 'ACTIVE':
					case 'GROUP':
					case 'EDITCOUNT':
					case 'ANONS':
						$result = $this->sendMessageToListOfWikis( $args );
						break;
				}
				break;

			case 'CREATED':
				switch ( $args['sendModeUsers'] ) {
					case 'ALL':
					case 'ACTIVE':
					case 'GROUP':
					case 'EDITCOUNT':
					case 'ANONS':
						$result = $this->sendMessageToWikisByCreationDate( $args );
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

							case 'USERS':
								$desc = sprintf('SiteWideMessages :: Send to a list of users on all wikis<br/>' .
									'Number of users: %s, Wiki: <i>ALL</i><br/>' .
									'Sender: %s [id: %d]',
									count( $args['userNames'] ),
									$args['senderName'],
									$args['senderId']
								);
								break;

							case 'REGISTRATION':
								$desc = sprintf('SiteWideMessages :: Send to users by registration date on all wikis<br/>' .
									'Option: %s, Start date: %s, End date: %s, Wiki: <i>ALL</i><br/>' .
									'Sender: %s [id: %d]',
									$args['regOption'],
									$args['regStartDate'],
									( $args['regEndDate'] === false ? '' : $args['regEndDate'] ),
									$args['senderName'],
									$args['senderId']
								);
								break;

							case 'EDITCOUNT':
								$desc = sprintf('SiteWideMessages :: Send to users by editcount on all wikis<br/>' .
									'Option: %s, From: %s, TO: %s, Wiki: <i>ALL</i><br/>' .
									'Sender: %s [id: %d]',
									$args['editCountOption'],
									$args['editCountStart'],
									( $args['editCountEnd'] === false ? '' : $args['editCountEnd'] ),
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

							case 'ANONS':
								$desc = sprintf('SiteWideMessages :: Send to all anon users on a hub<br/>' .
									'Hub ID: %s<br/>' .
									'Sender: %s [id: %d]',
									$args['hubId'],
									$args['senderName'],
									$args['senderId']
								);
								break;
						}
						break;

					case 'CLUSTER':
						switch ($args['sendModeUsers']) {
							case 'ALL':
							case 'ACTIVE':
								$desc = sprintf('SiteWideMessages :: Send to a cluster<br/>' .
									'Cluster: %s<br/>' .
									'Sender: %s [id: %d]',
									$args['clusterId'],
									$args['senderName'],
									$args['senderId']
								);
								break;

							case 'GROUP':
								$desc = sprintf('SiteWideMessages :: Send to a group on a cluster<br/>' .
									'Group: %s, Cluster: %s<br/>' .
									'Sender: %s [id: %d]',
									$args['groupName'],
									$args['clusterId'],
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

							case 'EDITCOUNT':
								$desc = sprintf('SiteWideMessages :: Send to users by editcount on a wiki<br/>' .
									'Option: %s, From: %s, TO: %s, Wiki: %s<br/>' .
									'Sender: %s [id: %d]',
									$args['editCountOption'],
									$args['editCountStart'],
									( $args['editCountEnd'] === false ? '' : $args['editCountEnd'] ),
									$args['wikiName'],
									$args['senderName'],
									$args['senderId']
								);
								break;
						}
						break;

					case 'WIKIS':
						switch ($args['sendModeUsers']) {
							case 'ALL':
							case 'ACTIVE':
								$desc = sprintf('SiteWideMessages :: Send to active users on %s wikis<br/>' .
									'Sender: %s [id: %d]',
									count( $args['wikiNames'] ),
									$args['senderName'],
									$args['senderId']
								);
								break;
							case 'GROUP':
								$desc = sprintf('SiteWideMessages :: Send to a group on %s wikis<br/>' .
									'Group: %s<br/>' .
									'Sender: %s [id: %d]',
									count( $args['wikiNames'] ),
									$args['groupName'],
									$args['senderName'],
									$args['senderId']
								);
								break;

							case 'EDITCOUNT':
								$desc = sprintf('SiteWideMessages :: Send to users by editcount on %s wikis<br/>' .
									'Option: %s, From: %s, TO: %s<br/>' .
									'Sender: %s [id: %d]',
									count( $args['wikiNames'] ),
									$args['editCountOption'],
									$args['editCountStart'],
									( $args['editCountEnd'] === false ? '' : $args['editCountEnd'] ),
									$args['senderName'],
									$args['senderId']
								);
								break;

							case 'ANONS':
								$desc = sprintf('SiteWideMessages :: Send to all anonymous users on %s wikis<br/>' .
									'Sender: %s [id: %d]',
									count( $args['wikiNames'] ),
									$args['senderName'],
									$args['senderId']
								);
								break;
						}
						break;

					case 'CREATED':
						switch ($args['sendModeUsers']) {
							case 'ALL':
							case 'ACTIVE':
								$desc = sprintf('SiteWideMessages :: Send to active users on wikis by creation date:<br/>' .
									'Option: %s; Start date: %s; End date: %s<br />' .
									'Sender: %s [id: %d]',
									$args['wcOption'],
									$args['wcStartDate'],
									$args['wcEndDate'],
									$args['senderName'],
									$args['senderId']
								);
								break;
							case 'GROUP':
								$desc = sprintf('SiteWideMessages :: Send to a group on wikis by creation date:<br/>' .
									'Option: %s; Start date: %s; End date: %s<br />' .
									'Group: %s<br/>' .
									'Sender: %s [id: %d]',
									$args['wcOption'],
									$args['wcStartDate'],
									$args['wcEndDate'],
									$args['groupName'],
									$args['senderName'],
									$args['senderId']
								);
								break;

							case 'EDITCOUNT':
								$desc = sprintf('SiteWideMessages :: Send to users by editcount on wikis by creation date:<br/>' .
									'Option: %s; Start date: %s; End date: %s<br />' .
									'Option: %s, From: %s, TO: %s<br/>' .
									'Sender: %s [id: %d]',
									$args['wcOption'],
									$args['wcStartDate'],
									$args['wcEndDate'],
									$args['editCountOption'],
									$args['editCountStart'],
									( $args['editCountEnd'] === false ? '' : $args['editCountEnd'] ),
									$args['senderName'],
									$args['senderId']
								);
								break;

							case 'ANONS':
								$desc = sprintf('SiteWideMessages :: Send to all anonymous users on wikis by creation date:<br/>' .
									'Option: %s; Start date: %s; End date: %s<br />' .
									'Sender: %s [id: %d]',
									$args['wcOption'],
									$args['wcStartDate'],
									$args['wcEndDate'],
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
		global $wgExternalSharedDB;
		$result = true;

		$DB = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		//step 1 of 3: get list of all active wikis
		$this->log('Step 1 of 3: get list of all active wikis');
		$dbResult = $DB->Query (
			  'SELECT city_id, city_dbname'
			. ' FROM city_list'
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
	 * sendMessageToList
	 *
	 * sends a message to specified group of users
	 *
	 * @access private
	 * @author Daniel Grunwell (grunny)
	 *
	 * @param mixed $params - task arguments
	 *
	 * @return boolean: result of sending
	 */
	private function sendMessageToList( $params ) {
		$result = true;
		$sqlValues = array();

		$this->log("Step 1 of 2: make list of user ids from given " . count( $params['userNames'] ) ."users.");
		foreach ( $params['userNames'] as $userName ) {
			$userId = User::idFromName( trim( $userName ) );
			if ( !$userId ) {
				$this->log("Given user $userName does not exist.");
			} else {
				$sqlValues[] = "(0, $userId, {$params['messageId']}, " . MSG_STATUS_UNSEEN . ')';
			}
		}

		$this->log("Step 2 of 2: add records about new message to right users [number of users = " . count( $sqlValues ) . "]");
		$result = $this->sendMessageHelperToUsers( $sqlValues );

		unset( $sqlValues );

		return $result;
	}

	/**
	 * sendMessageToListOfWikis
	 *
	 * sends a message to specified group of users
	 *
	 * @access private
	 * @author Daniel Grunwell (grunny)
	 *
	 * @param mixed $params - task arguments
	 *
	 * @return boolean: result of sending
	 */
	private function sendMessageToListOfWikis( $params ) {
		global $wgExternalSharedDB;
		$result = true;
		$sqlValues = array();
		$wikisDB = array();

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

		$this->log( 'Get Wiki IDs for the supplied ' . count( $params['wikiNames'] ) . ' wikis' );
		foreach ( $params['wikiNames'] as $wikiName ) {
			$wikiID = null;
			$wikiDomains = array( '', '.wikia.com', '.sjc.wikia-inc.com' );
			foreach( $wikiDomains as $wikiDomain ) {
				if( !is_null( $wikiID = WikiFactory::DomainToID( $wikiName . $wikiDomain ) ) ) {
					break;
				}
			}
			if ( !is_null( $wikiID ) ) {
				$wikiDB = WikiFactory::IDtoDB( $wikiID );
				$wikisDB[$wikiID] = $wikiDB;
			}
		}

		switch ( $params['sendModeUsers'] ) {
			case 'ALL':
			case 'ACTIVE':
				$result = $this->sendMessageHelperToActive( $dbr, $wikisDB, $params );
				break;

			case 'GROUP':
				$result = $this->sendMessageHelperToGroup( $dbr, $wikisDB, $params );
				break;

			case 'ANONS':
				foreach ( $wikisDB as $mWikiId => $mWikiDB ) {
					$sqlValues[] = array(
						'msg_wiki_id' => $mWikiId,
						'msg_recipient_id' => 0,
						'msg_id' => $params['messageId'],
						'msg_status' => MSG_STATUS_UNSEEN
					);
				}
				$result = (boolean)$dbw->insert(
					MSG_STATUS_DB,
					$sqlValues
				);
				break;

			case 'EDITCOUNT':
				$result = $this->sendMessageByEditcountList( $wikisDB, $params );
				break;
		}

		return $result;
	}

	/**
	 * sendMessageToWikisByCreationDate
	 *
	 * sends a message to specified group of users
	 *
	 * @access private
	 * @author Daniel Grunwell (grunny)
	 *
	 * @param mixed $params - task arguments
	 *
	 * @return boolean: result of sending
	 */
	private function sendMessageToWikisByCreationDate( $params ) {
		global $wgExternalSharedDB;
		$result = true;
		$sqlValues = array();
		$where = array();
		$wikisDB = array();

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

		switch ( $params['wcOption'] ) {
			case 'after':
				$where[] = "city_created > {$dbr->addQuotes( $params['wcStartDate'] )}";
				break;

			case 'before':
				$where[] = "city_created < {$dbr->addQuotes( $params['wcStartDate'] )}";
				break;

			case 'between':
				$where[] = "city_created BETWEEN {$dbr->addQuotes( $params['wcStartDate'] )} AND {$dbr->addQuotes( $params['wcEndDate'] )}";
				break;
		}
		// Only get active wikis
		$where['city_public'] = 1;

		$this->log( "Get Wiki IDs based on the given creation date parameters (option: {$params['wcOption']}; start date: {$params['wcStartDate']}; end date: {$params['wcEndDate']}" );
		$res = $dbr->select(
			array( 'city_list' ),
			array( 'city_id', 'city_dbname' ),
			$where,
			__METHOD__
		);
		while ( $row = $dbr->fetchObject( $res ) ) {
			$wikisDB[$row->city_id] = $row->city_dbname;
		}
		$dbr->freeResult( $res );

		$this->log( 'Send message to the retrieved ' . count( $wikisDB ) . ' wikis' );
		switch ( $params['sendModeUsers'] ) {
			case 'ALL':
			case 'ACTIVE':
				$result = $this->sendMessageHelperToActive( $dbr, $wikisDB, $params );
				break;

			case 'GROUP':
				$result = $this->sendMessageHelperToGroup( $dbr, $wikisDB, $params );
				break;

			case 'ANONS':
				foreach ( $wikisDB as $mWikiId => $mWikiDB ) {
					$sqlValues[] = array(
						'msg_wiki_id' => $mWikiId,
						'msg_recipient_id' => 0,
						'msg_id' => $params['messageId'],
						'msg_status' => MSG_STATUS_UNSEEN
					);
				}
				$result = (boolean)$dbw->insert(
					MSG_STATUS_DB,
					$sqlValues
				);
				break;

			case 'EDITCOUNT':
				$result = $this->sendMessageByEditcountList( $wikisDB, $params );
				break;
		}

		return $result;
	}

	/**
	 * sendMessageToRegistered
	 *
	 * sends a message to specified group of users
	 *
	 * @access private
	 * @author Daniel Grunwell (grunny)
	 *
	 * @param mixed $params - task arguments
	 *
	 * @return boolean: result of sending
	 */
	private function sendMessageToRegistered( $params ) {
		global $wgExternalSharedDB;
		$result = true;
		$sqlValues = array();
		$where = array();

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		switch ( $params['regOption'] ) {
			case 'after':
				$where[] = "user_registration > {$dbr->addQuotes( $params['regStartDate'] )}";
				break;

			case 'before':
				$where[] = "user_registration < {$dbr->addQuotes( $params['regStartDate'] )}";
				break;

			case 'between':
				$where[] = "user_registration BETWEEN {$dbr->addQuotes( $params['regStartDate'] )} AND {$dbr->addQuotes( $params['regEndDate'] )}";
				break;
		}

		$this->log( "Step 1 of 2: make list of user ids from users who registered {$params['regOption']} start date {$params['regStartDate']} and {$params['regEndDate']}." );
		$res = $dbr->select(
			array( '`user`' ),
			array( 'user_id' ),
			$where,
			__METHOD__
		);
		while ( $row = $dbr->fetchObject( $res ) ) {
			$sqlValues[] = "(0, {$row->user_id}, {$params['messageId']}, " . MSG_STATUS_UNSEEN . ')';
		}
		$dbr->freeResult( $res );

		$this->log( 'Step 2 of 2: add records about new message to right users [number of users = ' . count( $sqlValues ) . ']' );
		$result = $this->sendMessageHelperToUsers( $sqlValues );

		unset( $sqlValues );

		return $result;
	}

	/**
	 * sendMessageByEditcountGlobal
	 *
	 * sends a message to specified group of users
	 *
	 * @access private
	 * @author Daniel Grunwell (grunny)
	 *
	 * @param mixed $params - task arguments
	 *
	 * @return boolean: result of sending
	 */
	private function sendMessageByEditcountGlobal( $params ) {
		global $wgStatsDB;
		$result = true;
		$sqlValues = array();
		$having = '';

		$dbr = wfGetDB( DB_SLAVE, array(), $wgStatsDB );

		switch ( $params['editCountOption'] ) {
			case 'more':
				$having = "editcnt > {$dbr->addQuotes( $params['editCountStart'] )}";
				break;

			case 'less':
				$having = "editcnt < {$dbr->addQuotes( $params['editCountStart'] )}";
				break;

			case 'between':
				$having = "editcnt BETWEEN {$dbr->addQuotes( $params['editCountStart'] )} AND {$dbr->addQuotes( $params['editCountEnd'] )}";
				break;
		}

		$this->log( "Step 1 of 2: make list of user ids from users who have a specific editcount. [operator = {$params['editCountOption']}, from = {$params['editCountStart']}, to = {$params['editCountEnd']}]." );
		$res = $dbr->select(
			array( 'events' ),
			array( 'user_id', 'count(*) as editcnt' ),
			array( ' ( event_type = 1 ) or ( event_type = 2 ) ' ),
			__METHOD__,
			array(
				'GROUP BY' => 'user_id',
				'HAVING' => $having
			)
		);
		while ( $row = $dbr->fetchObject( $res ) ) {
			$sqlValues[] = "(0, {$row->user_id}, {$params['messageId']}, " . MSG_STATUS_UNSEEN . ')';
		}
		$dbr->freeResult( $res );

		$this->log( 'Step 2 of 2: add records about new message to right users [number of users = ' . count( $sqlValues ) . ']' );
		$result = $this->sendMessageHelperToUsers( $sqlValues );

		unset( $sqlValues );

		return $result;
	}

	/**
	 * sendMessageByEditcountLocal
	 *
	 * sends a message to specified group of users
	 *
	 * @access private
	 * @author Daniel Grunwell (grunny)
	 *
	 * @param mixed $params - task arguments
	 *
	 * @return boolean: result of sending
	 */
	private function sendMessageByEditcountLocal( $params ) {
		global $wgExternalSharedDB;
		$result = true;
		$sqlValues = array();
		$having = '';

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		switch ( $params['editCountOption'] ) {
			case 'more':
				$having = "editcnt > {$dbr->addQuotes( $params['editCountStart'] )}";
				break;

			case 'less':
				$having = "editcnt < {$dbr->addQuotes( $params['editCountStart'] )}";
				break;

			case 'between':
				$having = "editcnt BETWEEN {$dbr->addQuotes( $params['editCountStart'] )} AND {$dbr->addQuotes( $params['editCountEnd'] )}";
				break;
		}

		$wikiID = null;
		$wikiDomains = array( '', '.wikia.com', '.sjc.wikia-inc.com' );
		foreach( $wikiDomains as $wikiDomain ) {
			if( !is_null( $wikiID = WikiFactory::DomainToID( $params['wikiName'] . $wikiDomain ) ) ) {
				break;
			}
		}
		if ( is_null( $wikiID ) ) {
			return false;
		}

		$dbResult = $dbr->select(
			array( 'city_list' ),
			array( 'city_useshared' ),
			array( 'city_id' => $wikiID ),
			__METHOD__
		);

		if( $row = $dbr->fetchObject( $dbResult ) ) {
			if ( $row->city_useshared != '1' ) {
				$this->log("Wiki [wiki_id = $wikiID] does not use shared database. Message was not sent.");
				return false;
			}
		}
		$dbr->freeResult( $dbResult );

		$wikiDB = WikiFactory::IDtoDB($wikiID);
		$this->log("Look into selected wiki for users that have a specific editcount [operator = {$params['editCountOption']}, from = {$params['editCountStart']}, to = {$params['editCountEnd']}, wiki_id = $wikiID, wiki_db = $wikiDB]");
		$db = wfGetDB( DB_SLAVE, array(), $wikiDB );
		$res = $db->select(
			array( 'revision' ),
			array( 'rev_user', 'count(*) as editcnt' ),
			'',
			__METHOD__,
			array(
				'GROUP BY' => 'rev_user',
				'HAVING' => $having
			)
		);

		while ( $row = $db->fetchObject( $res ) ) {
			$sqlValues[] = "($wikiID, {$row->rev_user}, {$params['messageId']}, " . MSG_STATUS_UNSEEN . ')';
		}
		$db->freeResult( $res );
		$this->log("Add records about new message to right users [wiki_id = $wikiID, wiki_db = $wikiDB, number of users = " . count( $sqlValues ) . "]");
		if ( count( $sqlValues ) ) {
			$result = $this->sendMessageHelperToUsers( $sqlValues );
		}
		unset( $sqlValues );
		return $result;
	}

	/**
	 * sendMessageByEditcountList
	 *
	 * sends a message to specified group of users
	 *
	 * @access private
	 * @author Daniel Grunwell (grunny)
	 *
	 * @param mixed $params - task arguments
	 *
	 * @return boolean: result of sending
	 */
	private function sendMessageByEditcountList( $wikisDB, $params ) {
		$result = true;
		$sqlValues = array();
		$having = '';
		$dbr = wfGetDB( DB_SLAVE );

		switch ( $params['editCountOption'] ) {
			case 'more':
				$having = "editcnt > {$dbr->addQuotes( $params['editCountStart'] )}";
				break;

			case 'less':
				$having = "editcnt < {$dbr->addQuotes( $params['editCountStart'] )}";
				break;

			case 'between':
				$having = "editcnt BETWEEN {$dbr->addQuotes( $params['editCountStart'] )} AND {$dbr->addQuotes( $params['editCountEnd'] )}";
				break;
		}

		foreach ( $wikisDB as $wikiID => $wikiDB ) {
			$this->log("Look into selected wiki for users that have a specific editcount [operator = {$params['editCountOption']}, from = {$params['editCountStart']}, to = {$params['editCountEnd']}, wiki_id = $wikiID, wiki_db = $wikiDB]");
			$db = wfGetDB( DB_SLAVE, array(), $wikiDB );
			$res = $db->select(
				array( 'revision' ),
				array( 'rev_user', 'count(*) as editcnt' ),
				'',
				__METHOD__,
				array(
					'GROUP BY' => 'rev_user',
					'HAVING' => $having
				)
			);

			while ( $row = $db->fetchObject( $res ) ) {
				$sqlValues[] = "($wikiID, {$row->rev_user}, {$params['messageId']}, " . MSG_STATUS_UNSEEN . ')';
			}
			$db->freeResult( $res );
			$this->log("Add records about new message to right users [wiki_id = $wikiID, wiki_db = $wikiDB, number of users = " . count( $sqlValues ) . "]");
		}
		$this->log( 'Add records about new message to right users [number of wikis = ' . count( $wikisDB ) . ', number of users = ' . count( $sqlValues ) . ']' );
		if ( count( $sqlValues ) ) {
			$result = $this->sendMessageHelperToUsers( $sqlValues );
		}
		unset( $sqlValues );
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
		global $wgExternalSharedDB;
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

		$DB = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$dbResult = $DB->Query (
			  'SELECT city_useshared'
			. ' FROM city_list'
			. " WHERE city_id = $wikiID"
			. ';'
			, __METHOD__
		);

		if($row = $DB->FetchObject($dbResult)) {
			if ($row->city_useshared != '1') {
				$this->log("Wiki [wiki_id = $wikiID] does not use shared database. Message was not sent.");
				return false;
			}
		}
		$DB->FreeResult($dbResult);

		$wikiDB = WikiFactory::IDtoDB($wikiID);
		$this->log("Look into selected wiki for users that belong to a specified group [wiki_id = $wikiID, wiki_db = $wikiDB]");
		$DB = wfGetDB( DB_SLAVE );
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
			$sqlValues[] = "($wikiID, {$row->ug_user}, {$params['messageId']}, " . MSG_STATUS_UNSEEN . ')';
		}
		$DB->FreeResult($dbResult);
		$this->log("Add records about new message to right users [wiki_id = $wikiID, wiki_db = $wikiDB, number of users = " . count($sqlValues) . "]");
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
		global $wgExternalSharedDB;
		$result = true;
		$sqlValues = array();

		$DB = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		//step 1 of 3: get list of all active wikis
		$this->log('Step 1 of 3: get list of all active wikis belonging to a specified hub');
		$dbResult = $DB->Query (
			  'SELECT city_id, city_dbname'
			. ' FROM city_list'
			. ' JOIN city_cat_mapping USING (city_id)'
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

		if ( $params['sendModeUsers'] === 'ANONS' ) {
			$this->log( 'Send message to anoymous users (on specified wikis) [number of wikis = ' . count( $wikisDB ) . ']' );
			$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
			foreach ( array_keys( $wikisDB ) as $mWikiId ) {
				$sqlValues[] = array(
					'msg_wiki_id' => $mWikiId,
					'msg_recipient_id' => 0,
					'msg_id' => $params['messageId'],
					'msg_status' => MSG_STATUS_UNSEEN
				);
			}
			$result = (boolean)$dbw->insert(
				MSG_STATUS_DB,
				$sqlValues
			);
		} else {
			$result = $this->sendMessageHelperToActive($DB, $wikisDB, $params);
		}

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
		global $wgExternalSharedDB;
		$result = true;

		$DB = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		//step 1 of 3: get list of all active wikis
		$this->log('Step 1 of 3: get list of all active wikis belonging to a specified hub');
		$dbResult = $DB->Query (
			  'SELECT city_id, city_dbname'
			. ' FROM city_list'
			. ' JOIN city_cat_mapping USING (city_id)'
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
	 * sendMessageToCluster
	 *
	 * sends a message to active users on wikis in specified cluster
	 *
	 * @access private
	 * @author Maciej Błaszkowski (Marooned) <marooned at wikia.com>
	 * @author Wladyslaw Bodzek
	 *
	 * @param mixed $params - task arguments
	 *
	 * @return boolean: result of sending
	 */
	private function sendMessageToCluster($params) {
		global $wgExternalSharedDB;
		$result = true;

		$DB = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		$clusterId = intval($params['clusterId']);
		$clusterQuery = $clusterId == 1 ? " AND (city_cluster IS NULL OR city_cluster = 'c1')"
			: " AND city_cluster = 'c{$clusterId}' ";

		//step 1 of 3: get list of all active wikis
		$this->log('Step 1 of 3: get list of all active wikis belonging to a specified cluster');
		$dbResult = $DB->Query (
			  'SELECT city_id, city_dbname'
			. ' FROM city_list'
			. ' JOIN city_cat_mapping USING (city_id)'
			. ' WHERE city_public = 1'
			. ' AND city_useshared = 1'
			. $clusterQuery
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
	 * sendMessageToGroupOnCluster
	 *
	 * sends a message to active users on wikis in specified cluster
	 *
	 * @access private
	 * @author Maciej Błaszkowski (Marooned) <marooned at wikia.com>
	 * @author Wladyslaw Bodzek
	 *
	 * @param mixed $params - task arguments
	 *
	 * @return boolean: result of sending
	 */
	private function sendMessageToGroupOnCluster($params) {
		global $wgExternalSharedDB;
		$result = true;

		$DB = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		$clusterId = intval($params['clusterId']);
		$clusterQuery = $clusterId == 1 ? " AND (city_cluster IS NULL OR city_cluster = 'c1')"
			: " AND city_cluster = 'c{$clusterId}' ";


		//step 1 of 3: get list of all active wikis
		$this->log('Step 1 of 3: get list of all active wikis belonging to a specified cluster');
		$dbResult = $DB->Query (
			  'SELECT city_id, city_dbname'
			. ' FROM city_list'
			. ' JOIN city_cat_mapping USING (city_id)'
			. ' WHERE city_public = 1'
			. ' AND city_useshared = 1'
			. $clusterQuery
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
		global $wgExternalSharedDB;
		$result = true;

		$DB = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		//step 1 of 3: get list of all active wikis
		$this->log('Step 1 of 3: get list of all active wikis');
		$dbResult = $DB->Query (
			  'SELECT city_id, city_dbname'
			. ' FROM city_list'
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
		global $wgExternalSharedDB;
		$DB = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
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
		global $IP, $wgWikiaLocalSettingsPath;
		$result = true;

		//step 2 of 3: get list of active users (on specified wikis)
		$this->log('Step 2 of 2: get list of active users (on specified wikis) [number of wikis = ' . count($wikisDB) . ']');

		foreach ( $wikisDB as $wikiId => $wikiDB ) {
			$this->log( "Sending to active users on $wikiDB ($wikiId)" );
			$sCommand = "SERVER_ID={$wikiId} php $IP/extensions/wikia/SiteWideMessages/maintenance/sendToActiveOnWiki.php ";
			$sCommand .= escapeshellarg( $params['messageId'] ) . " --conf {$wgWikiaLocalSettingsPath}";

			$retval = '';
			$responseMessage = wfShellExec( $sCommand, $retval );

			if ( $retval ) {
				$this->log( "Sending to active users on $wikiDB ($wikiId) failed. Error code returned: $retval. Error was: $responseMessage" );
			} else {
				$this->log( "Sending to active users on $wikiDB ($wikiId) succeeded. Message was: $responseMessage" );
			}
		}
		$this->log( 'Done!' );

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
		global $wgSpecialsDB;

		$result = true;

		//step 2 of 3: get list of users that belong to a specified group (on specified wikis)
		$this->log('Step 2 of 3: get list of users that belong to a specified group (on specified wikis) [number of wikis = ' . count($wikisDB) . ']');

		$sqlValues = array();
		$dbr = wfGetDB(DB_SLAVE, array(), $wgSpecialsDB);
		$groupName = $params['groupName'];
		$groupNameLike = $dbr->buildLike( $dbr->anyString(), $groupName, $dbr->anyString() );

		$dbResult = $dbr->select(
			array('events_local_users'),
			array('user_id', 'wiki_id'),
			array('wiki_id IN (' . implode(',', array_keys($wikisDB)) . ')', "(single_group = '$groupName' OR all_groups " . $groupNameLike .")"),
			__METHOD__,
			array('GROUP BY' => 'wiki_id, user_id')
		);

		//step 3 of 3: add records about new message to right users
		while ($row = $dbr->FetchObject($dbResult)) {
			$sqlValues[] = "({$row->wiki_id}, {$row->user_id}, {$params['messageId']}, " . MSG_STATUS_UNSEEN . ')';
		}
		$dbr->FreeResult($dbResult);

		if (count($sqlValues)) {
			$this->log("Step 3 of 3: add records about new message to right users [number of users = " . count($sqlValues) .	"]");
			$result = $this->sendMessageHelperToUsers($sqlValues);
		}
		unset($sqlValues);

		return $result;
	}
}
