<?php
/**
 * SiteWideMessagesTask
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Tasks;


class SiteWideMessagesTask extends BaseTask {
	public function getAdminExecuteableMethods() {
		return [];
	}

	public function send($args) {
		$this->info("begin process of sending messages", [
			'wiki_mode' => $args['sendModeWikis'],
			'user_mode' => $args['sendModeUsers'],
		]);

		$result = false;
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

		return $result;
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

		$DB = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$this->info('Step 1 of 3: get list of all active wikis');

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

		$result = $this->sendMessageHelperToGroup($wikisDB, $params);

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
		$sqlValues = array();

		$this->info('make list of user ids from given', [
			'num_users' => count( $params['userNames'] )
		]);

		foreach ( $params['userNames'] as $userName ) {
			$userId = \User::idFromName( trim( $userName ) );
			if ( !$userId ) {
				$this->warning('Given user does not exist', [
					'user_name' => $userName,
				]);
			} else {
				$sqlValues[] = "(0, $userId, {$params['messageId']}, " . MSG_STATUS_UNSEEN . ')';
			}
		}

		$this->info('add records about new message to users', [
			'num_users' => count( $sqlValues )
		]);

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

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

		$this->info( 'Get Wiki IDs for the supplied wikis', [
			'wikis' => count( $params['wikiNames'] ),
		]);

		foreach ( $params['wikiNames'] as $wikiName ) {
			$wikiID = null;
			$wikiDomains = array( '', '.wikia.com', '.sjc.wikia-inc.com' );
			foreach( $wikiDomains as $wikiDomain ) {
				if( !is_null( $wikiID = \WikiFactory::DomainToID( $wikiName . $wikiDomain ) ) ) {
					break;
				}
			}
			if ( !is_null( $wikiID ) ) {
				$wikiDB = \WikiFactory::IDtoDB( $wikiID );
				$wikisDB[$wikiID] = $wikiDB;
			}
		}

		switch ( $params['sendModeUsers'] ) {
			case 'ALL':
			case 'ACTIVE':
				$result = $this->sendMessageHelperToActive( $wikisDB, $params );
				break;

			case 'GROUP':
				$result = $this->sendMessageHelperToGroup( $wikisDB, $params );
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

		$this->info('get wiki ids based on creation date params', [
			'option' => $params['wcOption'],
			'start_date' => $params['wcStartDate'],
			'end_date' => $params['wcEndDate'],
		]);

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

		$this->info('send message to the retrieved', ['wikis' => count($wikisDB)]);
		switch ( $params['sendModeUsers'] ) {
			case 'ALL':
			case 'ACTIVE':
				$result = $this->sendMessageHelperToActive( $wikisDB, $params );
				break;

			case 'GROUP':
				$result = $this->sendMessageHelperToGroup( $wikisDB, $params );
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

		$this->info('make list of user ids from users who registered', [
			'option' => $params['regOption'],
			'start_date' => $params['regStartDate'],
			'end_date' => $params['regEndDate'],
		]);

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

		$this->info('add records about new message to right users', [
			'users' => count($sqlValues),
		]);

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

		$this->info('make list of user ids from users who have a specific edit count', [
			'operator' => $params['editCountOption'],
			'edits_min' => $params['editCountStart'],
			'edits_max' => $params['editCountEnd'],
		]);

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
		$this->info('add records about new message to correct users', [
			'users' => count($sqlValues),
		]);
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
			if( !is_null( $wikiID = \WikiFactory::DomainToID( $params['wikiName'] . $wikiDomain ) ) ) {
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
				$this->warning('wiki does not use a shared database, message was not sent', [
					'wiki_id' => $wikiID,
				]);

				return false;
			}
		}
		$dbr->freeResult( $dbResult );

		$wikiDB = \WikiFactory::IDtoDB($wikiID);
		$this->info('look into selected wiki for users that have a specific edit count', [
			'operator' => $params['editCountOption'],
			'edits_min' => $params['editCountStart'],
			'edits_max' => $params['editCountEnd'],
			'wiki_id' => $wikiID,
			'wiki_db' => $wikiDB,
		]);

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

		$this->info('add records about new messages to users', [
			'users' => count($sqlValues),
		]);

		if ( count( $sqlValues ) ) {
			$result = $this->sendMessageHelperToUsers( $sqlValues );
		}

		unset( $sqlValues );
		return $result;
	}

	/**
	 * @param $wikisDB
	 * @param $params
	 * @return bool
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
			$this->info('look at wiki for users that have edit count in range', [
				'operator' => $params['editCountOption'],
				'edits_min' => $params['editCountStart'],
				'edits_max' => $params['editCountEnd'],
				'wiki_id' => $wikiID,
				'wiki_db' => $wikiDB,
			]);

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
		}

		$this->info('add records about new message to users', [
			'wikis' => count($wikisDB),
			'users' => count($sqlValues),
		]);

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
			if(!is_null($wikiID = \WikiFactory::DomainToID($params['wikiName'] . $wikiDomain))) {
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
				$this->warning('wiki does not use shared database, message not sent', [
					'wiki_id' => $wikiID
				]);
				return false;
			}
		}
		$DB->FreeResult($dbResult);

		$wikiDB = \WikiFactory::IDtoDB($wikiID);
		$this->info('look into wiki for users that belong to a specific group', [
			'wiki_id' => $wikiID,
			'wiki_db' => $wikiDB,
			'group_name' => $params['groupName'],
		]);

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
		$this->info('add records about new message to users', [
			'wiki_id' => $wikiID,
			'wiki_db' => $wikiDB,
			'users' => count($sqlValues),
		]);

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

		$sqlValues = array();
		$DB = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$this->info('get list of all active wikis belonging to a specific hub', [
			'cat_id' => $params['hubId'],
		]);

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
			$this->info('send message to anon users on specified wikis', [
				'wikis' => count($wikisDB),
			]);

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
			$result = $this->sendMessageHelperToActive($wikisDB, $params);
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

		$DB = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$this->info('get list of all active wikis in specific hub', [
			'cat_id' => $params['hubId'],
		]);;

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

		$result = $this->sendMessageHelperToGroup($wikisDB, $params);

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

		$DB = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$clusterId = intval($params['clusterId']);
		$this->info('get list of all active wikis belonging to cluster', [
			'cluster_id' => $clusterId,
		]);

		$clusterQuery = $clusterId == 1 ? " AND (city_cluster IS NULL OR city_cluster = 'c1')"
			: " AND city_cluster = 'c{$clusterId}' ";

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
		$result = $this->sendMessageHelperToActive($wikisDB, $params);

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

		$DB = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		$clusterId = intval($params['clusterId']);
		$this->info('get list of all active wikis in specified cluster', [
			'cluster_id' => $clusterId,
		]);

		$clusterQuery = $clusterId == 1 ? " AND (city_cluster IS NULL OR city_cluster = 'c1')"
			: " AND city_cluster = 'c{$clusterId}' ";
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

		$result = $this->sendMessageHelperToGroup($wikisDB, $params);

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

		$DB = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$this->info('get list of all active wikis');

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

		$result = $this->sendMessageHelperToActive($wikisDB, $params);

		return $result;
	}

	/**
	 * add record about new message for specified users
	 *
	 * @param $sqlValues
	 * @return bool
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
	 * send message to active users on provided wikis
	 *
	 * @param $wikisDB
	 * @param $params
	 * @return bool
	 */
	private function sendMessageHelperToActive(&$wikisDB, &$params) {
		global $IP, $wgWikiaLocalSettingsPath;

		$result = true;
		$this->info('get list of active users on specific wikis', [
			'wikis' => count($wikisDB),
		]);

		foreach ( $wikisDB as $wikiId => $wikiDB ) {
			$this->info('sending to active users on wiki', [
				'wiki_id' => $wikiId,
				'wiki_db' => $wikiDB,
			]);

			$sCommand = "SERVER_ID={$wikiId} php $IP/extensions/wikia/SiteWideMessages/maintenance/sendToActiveOnWiki.php ";
			$sCommand .= escapeshellarg( $params['messageId'] ) . " --conf {$wgWikiaLocalSettingsPath}";

			$retval = '';
			$responseMessage = wfShellExec( $sCommand, $retval );

			if ( $retval ) {
				$this->error('sending to active users failed', [
					'wiki_id' => $wikiId,
					'error_code' => $retval,
					'error_message' => $responseMessage,
				]);
			}
		}

		$this->info('done!');

		return $result;
	}

	/**
	 * send message to active users on provided wikis
	 *
	 * @param $wikisDB
	 * @param $params
	 * @return bool
	 */
	private function sendMessageHelperToGroup(&$wikisDB, &$params) {
		global $wgStatsDB, $wgStatsDBEnabled;

		$result = true;
		$this->info('get list of users that belong to specific group on specific wikis', [
			'wikis' => count($wikisDB),
			'group' => $params['groupName'],
		]);

		$sqlValues = array();
		if ( !empty( $wgStatsDBEnabled ) ) {
			$dbr = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			$groupName = $params['groupName'];
			$groupNameLike = $dbr->buildLike( $dbr->anyString(), $groupName, $dbr->anyString() );

			$dbResult = $dbr->select(
				array('`specials`.`events_local_users`'),
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
		}

		if (count($sqlValues)) {
			$this->info('add records about new message to users', [
				'users' => count($sqlValues),
			]);
			$result = $this->sendMessageHelperToUsers($sqlValues);
		}

		unset($sqlValues);
		return $result;
	}
}
