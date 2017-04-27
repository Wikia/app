<?php
/**
 * SiteWideMessagesTask
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Tasks;


use FluentSql\StaticSQL;
use Wikia\DependencyInjection\Injector;
use Wikia\UserGroups\UserGroupStorage;

class SiteWideMessagesTask extends BaseTask {

	/** @var UserGroupStorage */
	private $userGroupStorage;

	public function getAdminExecuteableMethods() {
		return [];
	}

	public function init() {
		parent::init();

		if (!defined('MSG_STATUS_DB')) {
			define('MSG_STATUS_DB', 'messages_status');
		}

		if (!defined('MSG_STATUS_UNSEEN')) {
			define('MSG_STATUS_UNSEEN', '0');
		}

		$this->userGroupStorage = Injector::getInjector()->get(UserGroupStorage::class);
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

					case 'POWERUSER':
						$result = $this->sendMessageToPowerUsers( $args );
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
	 * sends a message to all users in a group across all wikis
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
		$this->info(
				'getting list of users that belong to a specific group on all wikis',
				[
					'group' => $params['groupName'],
				]);

		$userList = $this->userGroupStorage->findUsersWithGroup($params['groupName']);
		$sqlValues = $this->toSqlValues($userList, $params['messageId']);

		if (count($sqlValues)) {
			$this->info('add records about new message to users', [
					'users' => count($sqlValues),
			]);
			$result = $this->sendMessageHelperToUsers($sqlValues);
		}

		return $result;
	}

	/**
	 * Sends a message to Power Users (the ones that
	 * have one of the selected properties set to 1)
	 * @param $params An array of task args
	 * @return bool A result of the adding records to messages_status
	 */
	private function sendMessageToPowerUsers( $params ) {
		global $wgExternalSharedDB;

		$DB = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		/**
		 * Select all power users by default
		 */
		if ( !empty( $params[ 'powerUserType' ] ) )
			$powerUsersTypesArr = explode( ',', $params[ 'powerUserType' ] );
		else {
			$powerUsersTypesArr = \Wikia\PowerUser\PowerUser::$aPowerUserProperties;
		}

		/**
		 * Get IDs of users with the specified properties
		 */
		$userIds = ( new \WikiaSQL() )
			->SELECT()->DISTINCT( 'up_user' )
			->FROM( 'user_properties' )
			->WHERE( 'up_property' )->IN( $powerUsersTypesArr )
			->AND_( 'up_value' )->EQUAL_TO( 1 )
			->runLoop( $DB, function( &$userIds, $row ) {
				$userIds[] = $row->up_user;
			} );

		/**
		 * Create a messages_status record for each ID
		 */
		foreach ( $userIds as $userId ) {
			$sqlValues[] = [ 0, $userId, $params[ 'messageId' ], MSG_STATUS_UNSEEN ];
		}

		$this->info('add records about new message to users', [
			'num_users' => count( $sqlValues )
		] );

		/**
		 * Insert records into messages_status
		 */
		$result = $this->sendMessageHelperToUsers( $sqlValues );

		unset( $sqlValues );
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
				$sqlValues[] = [0, $userId, $params['messageId'], MSG_STATUS_UNSEEN];
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
		$result = true;
		$sqlValues = array();
		$wikisDB = array();

		$this->info( 'Get Wiki IDs for the supplied wikis', [
			'wikis' => count( $params['wikiNames'] ),
		]);

		foreach ( $params['wikiNames'] as $wikiName ) {
			$wikiID = null;
			$wikiDomains = [ '', '.wikia.com', '.sjc.wikia-inc.com' ];

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
					$sqlValues[] = [$mWikiId, 0, $params['messageId'], MSG_STATUS_UNSEEN];
				}

				$result = $this->sendMessageHelperToUsers($sqlValues);
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

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$sql = (new \WikiaSQL())
			->SELECT('city_id', 'city_dbname')
			->FROM('city_list')
			->WHERE('city_public')->EQUAL_TO(1);

		switch ( $params['wcOption'] ) {
			case 'after':
				$sql->AND_('city_created')->GREATER_THAN($params['wcStartDate']);
				break;
			case 'before':
				$sql->AND_('city_created')->LESS_THAN($params['wcStartDate']);
				break;
			case 'between':
				$sql->AND_('city_created')->BETWEEN($params['wcStartDate'], $params['wcEndDate']);
				break;
		}

		$this->info('get wiki ids based on creation date params', [
			'option' => $params['wcOption'],
			'start_date' => $params['wcStartDate'],
			'end_date' => $params['wcEndDate'],
		]);

		$wikisDB = $sql->runLoop($dbr, function(&$result, $row) {
			$result[$row->city_id] = $row->city_dbname;
		});

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
					$sqlValues[] = [$mWikiId, 0, $params['messageId'], MSG_STATUS_UNSEEN];
				}

				$result = $this->sendMessageHelperToUsers($sqlValues);
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

		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
		$sql = (new \WikiaSQL())
			->SELECT('user_id')
			->FROM('user');

		switch ( $params['regOption'] ) {
			case 'after':
				$sql->WHERE('user_registration')->GREATER_THAN($params['regStartDate']);
				break;

			case 'before':
				$sql->WHERE('user_registration')->LESS_THAN($params['regStartDate']);
				break;

			case 'between':
				$sql->WHERE('user_registration')->BETWEEN($params['regStartDate'], $params['regEndDate']);
				break;
		}

		$this->info('make list of user ids from users who registered', [
			'option' => $params['regOption'],
			'start_date' => $params['regStartDate'],
			'end_date' => $params['regEndDate'],
		]);

		$sqlValues = $sql->runLoop($dbr, function(&$results, $row) use ($params) {
			$results []= [0, $row->user_id, $params['messageId'], MSG_STATUS_UNSEEN];
		});

		$this->info('add records about new message to right users', [
			'users' => count($sqlValues),
		]);

		return $this->sendMessageHelperToUsers( $sqlValues );
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

		$sql = (new \WikiaSQL())
			->SELECT('user_id', 'count(*) as editcnt')
			->FROM('events')
			->WHERE('event_type')->EQUAL_TO(1)
				->OR_('event_type')->EQUAL_TO(2)
			->GROUP_BY('user_id');

		switch ( $params['editCountOption'] ) {
			case 'more':
				$sql->HAVING('editcnt')->GREATER_THAN($params['editCountStart']);
				break;
			case 'less':
				$sql->HAVING('editcnt')->LESS_THAN($params['editCountStart']);
				break;
			case 'between':
				$sql->HAVING('editcnt')->BETWEEN($params['editCountStart'], $params['editCountEnd']);
				break;
		}

		$this->info('make list of user ids from users who have a specific edit count', [
			'operator' => $params['editCountOption'],
			'edits_min' => $params['editCountStart'],
			'edits_max' => $params['editCountEnd'],
		]);

		$sqlValues = $sql->runLoop(wfGetDB( DB_SLAVE, [], $wgStatsDB ), function(&$results, $row) use ($params) {
			$results []= [0, $row->user_id, $params['messageId'], MSG_STATUS_UNSEEN];
		});

		$this->info('add records about new message to correct users', [
			'users' => count($sqlValues),
		]);

		return $this->sendMessageHelperToUsers( $sqlValues );
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
		$result = true;

		list($isShared, $wikiID) = $this->isWikiShared($params['wikiName']);
		if (!$isShared) {
			return false;
		}

		$wikiDB = \WikiFactory::IDtoDB($wikiID);
		$this->info('look into selected wiki for users that have a specific edit count', [
			'operator' => $params['editCountOption'],
			'edits_min' => $params['editCountStart'],
			'edits_max' => $params['editCountEnd'],
			'wiki_id' => $wikiID,
			'wiki_db' => $wikiDB,
		]);

		$db = wfGetDB( DB_SLAVE, array(), $wikiDB );
		$sql = (new \WikiaSQL())
			->SELECT('rev_user', 'count(*) as editcnt')
			->FROM('revision')
			->GROUP_BY('rev_user');

		switch ( $params['editCountOption'] ) {
			case 'more':
				$sql->HAVING('editcnt')->GREATER_THAN($params['editCountStart']);
				break;
			case 'less':
				$sql->HAVING('editcnt')->LESS_THAN($params['editCountStart']);
				break;
			case 'between':
				$sql->HAVING('editcnt')->BETWEEN($params['editCountStart'], $params['editCountEnd']);
				break;
		}

		$sqlValues = $sql->runLoop($db, function(&$results, $row) use ($wikiID, $params) {
			$results []= [$wikiID, $row->rev_user, $params['messageId'], MSG_STATUS_UNSEEN];
		});

		$this->info('add records about new messages to users', [
			'users' => count($sqlValues),
		]);

		if ( count( $sqlValues ) ) {
			$result = $this->sendMessageHelperToUsers( $sqlValues );
		}

		return $result;
	}

	/**
	 * @param $wikisDB
	 * @param $params
	 * @return bool
	 */
	private function sendMessageByEditcountList( $wikisDB, $params ) {
		$result = true;
		$sqlValues = [];

		$sql = (new \WikiaSQL())
			->SELECT('rev_user', 'count(*) as editcnt')
			->FROM('revision')
			->GROUP_BY('rev_user');

		switch ( $params['editCountOption'] ) {
			case 'more':
				$sql->HAVING('editcnt')->GREATER_THAN($params['editCountStart']);
				break;
			case 'less':
				$sql->HAVING('editcnt')->LESS_THAN($params['editCountStart']);
				break;
			case 'between':
				$sql->HAVING('editcnt')->BETWEEN($params['editCountStart'], $params['editCountEnd']);
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
			$sql->runLoop($db, function($_, $row) use ($wikiID, $params, &$sqlValues) {
				$sqlValues []= [$wikiID, $row->rev_user, $params['messageId'], MSG_STATUS_UNSEEN];
			});
		}

		$this->info('add records about new message to users', [
			'wikis' => count($wikisDB),
			'users' => count($sqlValues),
		]);

		if ( count( $sqlValues ) ) {
			$result = $this->sendMessageHelperToUsers( $sqlValues );
		}

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

		list($isShared, $wikiID) = $this->isWikiShared($params['wikiName']);
		if (!$isShared) {
			return false;
		}

		$wikiDB = \WikiFactory::IDtoDB($wikiID);
		$this->info('look into wiki for users that belong to a specific group', [
			'wiki_id' => $wikiID,
			'wiki_db' => $wikiDB,
			'group_name' => $params['groupName'],
		]);

		$sqlValues = (new \WikiaSQL())
			->SELECT('ug_user')
			->FROM('user_groups')
			->WHERE('ug_group')->EQUAL_TO($params['groupName'])
			->runLoop(wfGetDB( DB_SLAVE ), function(&$results, $row) use ($wikiID, $params) {
				$results []= [$wikiID, $row->ug_user, $params['messageId'], MSG_STATUS_UNSEEN];
			});

		$this->info('add records about new message to users', [
			'wiki_id' => $wikiID,
			'wiki_db' => $wikiDB,
			'users' => count($sqlValues),
		]);

		if (count($sqlValues)) {
			$result = $this->sendMessageHelperToUsers($sqlValues);
		}

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
		$wikisDB = $this->getWikisByHub($params['hubId']);

		if ( $params['sendModeUsers'] === 'ANONS' ) {
			$this->info('send message to anon users on specified wikis', [
				'wikis' => count($wikisDB),
			]);

			$sqlValues = [];
			foreach ( array_keys( $wikisDB ) as $mWikiId ) {
				$sqlValues []= [$mWikiId, 0, $params['messageId'], MSG_STATUS_UNSEEN];
			}

			$result = $this->sendMessageHelperToUsers($sqlValues);
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
		$wikisDB = $this->getWikisByHub($params['hubId']);
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
		$wikisDB = $this->getWikisByCluster($params['clusterId']);
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
		$wikisDB = $this->getWikisByCluster($params['clusterId']);
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

		$this->info('get list of all active wikis');
		$db = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		$wikisDB = (new \WikiaSQL())
			->SELECT('city_id', 'city_dbname')
			->FROM('city_list')
			->WHERE('city_public')->EQUAL_TO(1)
				->AND_('city_useshared')->EQUAL_TO(1)
			->runLoop($db, function(&$results, $row) {
				$results[$row->city_id] = $row->city_dbname;
			});

		return $this->sendMessageHelperToActive($wikisDB, $params);
	}

	/**
	 * add record about new message for specified users
	 *
	 * @param $sqlValues
	 * @return bool
	 */
	private function sendMessageHelperToUsers(&$sqlValues) {
		global $wgExternalSharedDB;

		$db = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
		return (new \WikiaSQL())
			->INSERT()->INTO(MSG_STATUS_DB, ['msg_wiki_id', 'msg_recipient_id', 'msg_id', 'msg_status'])
			->VALUES($sqlValues)
			->run($db);
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
		$result = true;
		$this->info('get list of users that belong to specific group on specific wikis', [
			'wikis' => count($wikisDB),
			'group' => $params['groupName'],
		]);

		$userList = $this->userGroupStorage->findUsersWithLocalGroup($params['groupName'], $wikisDB);
		$sqlValues = $this->toSqlValues($userList, $params['messageId']);

		if (count($sqlValues)) {
			$this->info('add records about new message to users', [
				'users' => count($sqlValues),
			]);
			$result = $this->sendMessageHelperToUsers($sqlValues);
		}

		return $result;
	}

	private function isWikiShared($wikiName) {
		global $wgExternalSharedDB;

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$wikiID = null;
		$wikiDomains = [ '', '.wikia.com', '.sjc.wikia-inc.com' ];

		foreach( $wikiDomains as $wikiDomain ) {
			if ( !is_null( $wikiID = \WikiFactory::DomainToID( $wikiName . $wikiDomain ) ) ) {
				break;
			}
		}

		if ( is_null( $wikiID ) ) {
			return [false, null];
		}

		$isShared = (new \WikiaSQL())
			->SELECT('city_useshared')
			->FROM('city_list')
			->WHERE('city_id')->EQUAL_TO($wikiID)
			->run($dbr, function($res) use ($wikiID) {
				/** @var \ResultWrapper $res */
				if ($row = $res->fetchObject()) {
					if ($row->city_useshared != '1') {
						$this->warning('wiki does not use a shared database, message was not sent', [
							'wiki_id' => $wikiID,
						]);

						return false;
					}
				}

				return true;
			});

		return [$isShared, $wikiID];
	}

	private function getWikisByHub($hubId) {
		return $this->getWikisByHubOrCluster($hubId);
	}

	private function getWikisByCluster($clusterId) {
		return $this->getWikisByHubOrCluster(null, $clusterId);
	}

	private function getWikisByHubOrCluster($hubId=null, $clusterId=null) {
		global $wgExternalSharedDB;

		$db = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$sql = (new \WikiaSQL())
			->SELECT('city_id', 'city_dbname')
			->FROM('city_list')
			->WHERE('city_public')->EQUAL_TO(1)
				->AND_('city_useshared')->EQUAL_TO(1);

		if ($hubId) {
			$this->info('get list of all active wikis belonging to a specific hub', [
				'city_vertical' => $hubId,
			]);

			$sql->AND_('city_vertical')->EQUAL_TO($hubId);
		}

		if ($clusterId) {
			$clusterId = intval($clusterId);
			$this->info('get list of all active wikis belonging to cluster', [
				'cluster_id' => $clusterId,
			]);

			if ($clusterId == 1) {
				$sql->AND_(StaticSQL::RAW(
					'(city_cluster IS NULL OR city_cluster = ?)', ['c1']
				));
			} else {
				$sql->AND_('city_cluster')->EQUAL_TO("c{$clusterId}");
			}
		}

		return $sql->runLoop($db, function(&$results, $row) {
			$results[$row->city_id] = $row->city_dbname;
		});
	}

	private function toSqlValues($userList, $messageId) {
		$sqlValues = [];

		foreach ($userList as list($userId, $wikiId)) {
			$sqlValues[] = [$wikiId, $userId, $messageId, MSG_STATUS_UNSEEN];
		}

		return $sqlValues;
	}
}
