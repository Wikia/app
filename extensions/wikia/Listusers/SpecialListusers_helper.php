<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com>
 * @version: $Id$
 */

use Wikia\Service\User\Permissions\PermissionsServiceAccessor;

class ListusersData {
	use PermissionsServiceAccessor;

	private $mCityId;
	private $mGroups;
	private $mFilterGroup;
	private $mUserId;
	private $mEditsThreshold;
	private $mLimit;
	private $mOffset;
	private $mOrder;
	private $mOrderOptions;
	private $mDBh;

	const TABLE = 'events_local_users';
	const CACHE_VERSION = 'v6';
	private const LOCAL_USER_GROUPS_TABLE = 'local_user_groups';

	function __construct( int $city_id ) {
		global $wgSpecialsDB;
		$this->mCityId = $city_id;
		$this->mDBh = $wgSpecialsDB;

		$this->mOrderOptions = array(
			'groups' 	=> array( 'all_groups %s', 'cnt_groups %s'),
			'revcnt' 	=> array( 'edits %s' ),
			'dtedit' 	=> array( 'editdate %s' )
		);
	}

	function load() {
		$this->setEditsThreshold();
		$this->setLimit();
		$this->setOffset();
		$this->setOrder();
		$this->loadGroups();
	}

	function setFilterGroup ( $group = array() ) { $this->mFilterGroup = $group; }
	function getFilterGroup () { return $this->mFilterGroup; }

	function setUserId	    ( int $user_id ) { $this->mUserId = $user_id; }
	function setEditsThreshold ( $edits = Listusers::DEF_EDITS ) { $this->mEditsThreshold = $edits; }
	function setLimit    	( $limit = Listusers::DEF_LIMIT ) { $this->mLimit = $limit; }
	function setOffset   	( $offset = 0 ) { $this->mOffset = $offset; }
	function setOrder    	( $orders = array() ) {
		if ( empty($orders) || !is_array($orders) ) {
			$orders = array( Listusers::DEF_ORDER );
		}

		$validSortDirections = [
			'asc',
			'desc',
		];

		# order by
		$this->mOrder = array();
		if ( !empty( $orders ) ) {
			foreach ( $orders as $order ) {
				list ( $orderName, $orderDesc ) = explode( ":", $order );
				if ( isset( $this->mOrderOptions[$orderName] ) && in_array( $orderDesc, $validSortDirections ) ) {
					foreach ( $this->mOrderOptions[$orderName] as $orderStr ) {
						$this->mOrder[] = sprintf( $orderStr, $orderDesc );
					}
				}
			}
		}

		// SUS-3207 - order by number of edits (descending) by default
		if ( empty( $this->mOrder ) ) {
			$this->mOrder[] = 'edits DESC';
		}
	}

	function getGroups   	() { return $this->mGroups; }

	public function loadData() {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		/* initial values for result */
		$data = array(
			'cnt'	=> 0,
			'data' 	=> array()
		);

		$context = RequestContext::getMain();
		$user = $context->getUser();
		$lang = $context->getLanguage();

		$orderby = implode(",", $this->mOrder);
		$subMemkey = array(
			'G'  . implode(",", is_array($this->mFilterGroup) ? $this->mFilterGroup : array()),
			'U'  . $this->mUserId,
			'E'  . $this->mEditsThreshold,
			'O'  . $this->mOffset,
			'L'  . $this->mLimit,
			'O'  . $orderby,
			'L'  . $lang->getCode(), // localized messages are cached, vary by user language
		);

		$memkey = wfForeignMemcKey( $this->mCityId, __CLASS__, self::CACHE_VERSION, md5( implode(', ', $subMemkey) ) );
		$cached = $wgMemc->get($memkey);

		if ( empty($cached) ) {
			/* db handle */
			$dbs = wfGetDB( DB_SLAVE, array(), $this->mDBh );

			/* initial conditions for SQL query */
			$where = [
					self::TABLE . '.wiki_id' => $this->mCityId,
					self::TABLE . ".user_id > 0",
					'user_is_closed' => 0
			];

			/* filter: user ID  */
			if ( !empty( $this->mUserId ) ) {
				$where[] = self::TABLE . ".user_id = $this->mUserId";
			}

			/* filter: number of edits */
			if ( !empty( $this->mEditsThreshold ) ) {
				$where[] = "edits >= $this->mEditsThreshold";
			}

			/* filter: groups */
			if ( is_array( $this->mFilterGroup ) ) {
				$filteredGroups = array_filter( $this->mFilterGroup, function ( $group ): bool {
					return empty( $group ) || $group == Listusers::DEF_GROUP_NAME;
				} );

				if ( !empty( $filteredGroups ) ) {
					$where[self::LOCAL_USER_GROUPS_TABLE . '.group_name'] = $this->mFilterGroup;
				}
			}

			$result = $dbs->select(
				[ self::TABLE, self::LOCAL_USER_GROUPS_TABLE ],
				[ '1' ],
				$where,
				__METHOD__,
				[
					'GROUP BY' => [
						self::TABLE . '.wiki_id',
						self::TABLE . '.user_id',
					]
				],
				[
					self::LOCAL_USER_GROUPS_TABLE => [
						'LEFT JOIN',
						[
							self::TABLE . '.wiki_id = ' . self::LOCAL_USER_GROUPS_TABLE . '.wiki_id',
							self::TABLE . '.user_id = ' . self::LOCAL_USER_GROUPS_TABLE . '.user_id',
							self::LOCAL_USER_GROUPS_TABLE . '.expiry IS NULL OR ' . self::LOCAL_USER_GROUPS_TABLE . '.expiry > NOW()'
						]
					]
				]
			);
			// hacky, count returned groups as selectRowCount is not supported
			$data['cnt'] = count( iterator_to_array( $result ) );

			if ( $data['cnt'] > 0 ) {
				$userIsBlocked = $user->isBlocked( true, false );
				$sk = $context->getSkin();
				/* select records */
				$oRes = $dbs->select(
					[ self::TABLE, self::LOCAL_USER_GROUPS_TABLE, 'lug' => self::LOCAL_USER_GROUPS_TABLE ],
					[
						self::TABLE . '.user_id',
						'GROUP_CONCAT(DISTINCT lug.group_name) as groups',
						'edits',
						'last_revision',
						'editdate',
						'ifnull(last_revision, 0) as max_rev',
						'ifnull(unix_timestamp(editdate), 0) as ts_edit'
					],
					$where,
					__METHOD__,
					[
						'GROUP BY' => [
							self::TABLE . '.wiki_id',
							self::TABLE . '.user_id',
							// Group by sortable fields
							self::TABLE . '.edits',
							self::TABLE . '.editdate'
						],
						'ORDER BY' => $this->getOrderByString(),
						'LIMIT' => $this->mLimit,
						'OFFSET' => $this->mOffset,
					],
					[
						// First join for filtering by groups
						self::LOCAL_USER_GROUPS_TABLE => [
							'LEFT JOIN',
							[
								self::TABLE . '.wiki_id = ' . self::LOCAL_USER_GROUPS_TABLE . '.wiki_id',
								self::TABLE . '.user_id = ' . self::LOCAL_USER_GROUPS_TABLE . '.user_id',
								self::LOCAL_USER_GROUPS_TABLE . '.expiry IS NULL OR ' . self::LOCAL_USER_GROUPS_TABLE . '.expiry > NOW()'
							]
						],
						// Join again to fetch all groups for selected users
						'lug' => [
							'LEFT JOIN',
							[
								self::TABLE . '.wiki_id = lug.wiki_id',
								self::TABLE . '.user_id = lug.user_id',
								'lug.expiry IS NULL OR lug.expiry > NOW()'
							]
						],
					]
				);

				$data['data'] = array();
				while ( $oRow = $dbs->fetchObject( $oRes ) ) {
					$oUser = User::newFromId( $oRow->user_id );
					$oUser->load();
					if ( $oUser->isAnon() ) {
						continue;
					}

					/* groups */
					$groups = explode(",", $oRow->groups);
					$group = "<i>" . wfMsg('listusers-nonegroup') . "</i>";
					if ( !empty( $groups ) ) {
						$group = implode(", ", $groups);
					}

					$oEncUserName = urlencode( $oUser->getName() );

					$links = array (
						0 => "",
						1 => $sk->makeLinkObj(
							Title::newFromText( 'Contributions', NS_SPECIAL ),
							$lang->ucfirst( wfMsg('contribslink') ),
							"target={$oEncUserName}"
						),
						2 => $sk->makeLinkObj(
							Title::newFromText( 'Editcount', NS_SPECIAL ),
							$lang->ucfirst( wfMsg('listusersedits') ),
							"username={$oEncUserName}"
						)
					);

					global $wgEnableWallExt;
					if(!empty($wgEnableWallExt)) {
						$oUTitle = Title::newFromText($oUser->getName(), NS_USER_WALL);
						$msg = 'wall-message-wall-shorten';
					} else {
						$oUTitle = Title::newFromText($oUser->getName(), NS_USER_TALK);
						$msg = 'talkpagelinktext';
					}

					if ( $oUTitle instanceof Title ) {
						$links[0] = $sk->makeLinkObj( $oUTitle, $lang->ucfirst(wfMsg($msg) ) );
					}

					if ( $user->isAllowed( 'block' ) && ( !$userIsBlocked ) ) {
						$links[] = $sk->makeLinkObj(
							Title::newFromText( "BlockIP/{$oUser->getName()}", NS_SPECIAL ),
							$lang->ucfirst( wfMsg('blocklink') )
						);
					}
					if ( $user->isAllowed( 'userrights' ) && ( !$userIsBlocked ) ) {
						$links[] = $sk->makeLinkObj(
							Title::newFromText( 'UserRights', NS_SPECIAL ),
							$lang->ucfirst( wfMsg('listgrouprights-rights') ),
							"user={$oEncUserName}"
						);
					};

					$data['data'][$oRow->user_id] = array(
						'user_id' 			=> $oRow->user_id,
						'user_name' 		=> $oUser->getName(),
						'user_link'			=> $sk->makeLinkObj($oUser->getUserPage(), $oUser->getName()),
						'groups_nbr' 		=> count( $groups ),
						'groups' 			=> $group,
						'rev_cnt' 			=> $oRow->edits,
						'blcked'			=> $oUser->isBlocked( true, false ),
						'links'				=> "(" . implode( ") &#183; (", $links ) . ")",
						'last_edit_page' 	=> null,
						'last_edit_diff'	=> null,
						'last_edit_ts'		=> ( !empty($oRow->ts_edit) ) ? $lang->timeanddate( $oRow->ts_edit, true ) : ""
					);

					if ( !empty($oRow->max_rev) ) {
						$oRevision = Revision::newFromId($oRow->max_rev);
						if ( !is_null($oRevision) ) {
							$oTitle = $oRevision->getTitle();
							if ( !is_null($oTitle) ) {
								$data['data'][$oRow->user_id]['last_edit_page'] = $oTitle->getLocalUrl();
								$data['data'][$oRow->user_id]['last_edit_diff'] = $oTitle->getLocalUrl('diff=prev&oldid=' . $oRow->max_rev);
							}
						}
					}
				}
				$dbs->freeResult( $oRes );

				// BugId:12643 - We DO NOT want to cache empty arrays.
				if ( !empty( $data ) ) {
					$wgMemc->set( $memkey, $data, 60*60 );
				}
			}
		} else {
			$data = $cached;
		}

		wfProfileOut( __METHOD__ );
		return $data;
	}

	private function getOrderByString(): string {
		$orderBy = array_map( function ( $order ) {
			[ $order, $direction ] = explode( ' ', $order );
			if ( $order == 'all_groups' ) { // Change legacy 'all_groups' to group list
				return implode( ' ', [ 'GROUP_CONCAT(DISTINCT lug.group_name)', $direction ] );
			}
			if ( $order == 'cnt_groups' ) { // Change legacy 'cnt_groups' to group count
				return implode( ' ', [ 'COUNT(DISTINCT lug.group_name)', $direction ] );
			}
			return $order;
		}, $this->mOrder );
		return implode( ',', $orderBy );
	}

	/*
	 * load all groups for selected Wikis
	 *
	 * @access public
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 * @param
	 */
	private function loadGroups() {
		global $wgContLang, $wgMemc;
		wfProfileIn( __METHOD__ );

		$memkey = wfForeignMemcKey( $this->mCityId, null, Listusers::TITLE, "groups", $wgContLang->getCode() );
		$cached = $wgMemc->get($memkey);

		if ( empty ( $cached ) ) {
			$this->mGroups[Listusers::DEF_GROUP_NAME] = array(
				'name' 	=> wfMsg('listusersnogroup'),
				'count' => 0
			);

			global $wgExternalSharedDB;
			$config = $this->permissionsService()->getConfiguration();
			$globalGroups = $config->getGlobalGroups();
			$localGroups = array_diff( $config->getExplicitGroups(), $globalGroups );

			$dbr = wfGetDB( DB_SLAVE );
			$centralDbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

			$this->loadCountOfUsersInGroups( $dbr, $localGroups );
			$this->loadCountOfUsersInGroups( $centralDbr, $globalGroups );
		} else {
			$this->mGroups = $cached;
		}

		wfProfileOut( __METHOD__ );
		return $this->mGroups;
	}

	/**
	 * Load count of users in the given groups
	 *
	 * @param DatabaseBase $db DB connection to use
	 * @param array $groups groups whose user count we need
	 */
	private function loadCountOfUsersInGroups( DatabaseBase $db, array $groups ) {
		$res = $db->select(
			'user_groups',
			[ 'ug_group', 'COUNT(*) AS users_count' ],
			[ 'ug_group' => $groups ],
			__METHOD__,
			[ 'GROUP BY' => 'ug_group' ]
		);

		/** @var object $row */
		foreach ( $res as $row ) {
			$this->mGroups[$row->ug_group] = [
				'name' => User::getGroupName( $row->ug_group ),
				'count' => $row->users_count
			];
		}
	}

	/**
	 * update user groups (hook)
	 *
	 * @access public
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 * @param       User    $user object
	 * @param		array   $addgroup - add group(s)
	 * @param		array   $removegroup - remove group(s)
	 * @return void
	 */
	public function updateUserGroups( User $user, $addgroup = array(), $removegroup = array() ) {
		wfProfileIn( __METHOD__ );

		$user_id = $user->getID();
		$dbr = wfGetDB(DB_SLAVE, array(), $this->mDBh);
		$groups = $dbr->selectFieldValues(
			'local_user_groups',
			'group_name',
			[
				'user_id' => $user_id,
				'wiki_id' => $this->mCityId,
				'expiry IS NULL OR expiry > NOW()'
			]
		);

		$central_groups = array();
		global $wgWikiaIsCentralWiki;
		if ( $wgWikiaIsCentralWiki === false  ) {
			$central_groups = $this->permissionsService()->getExplicitGlobalGroups( $user );
		}

		# add groups
		if ( !empty($addgroup) ) {
			$groups = array_unique( array_merge($groups, $addgroup) );
		}
		# remove groups
		if ( !empty($removegroup) ) {
			$groups = array_unique( array_diff($groups, $removegroup) );
		}
		#central groups
		if ( !empty($central_groups) ) {
			$groups = array_unique( array_merge($groups, $central_groups) );
		}

		$edits = $user->getEditCount();
		list( $editdate, $lastrev ) = self::getEditDateAndLastRevision( $user_id );

		$dbw = wfGetDB( DB_MASTER, array(), $this->mDBh );
		$this->updateUserGroupsTable( $dbw, $this->mCityId, $user_id, $groups );
		$dbw->replace(
			self::TABLE,
			[ 'wiki_id', 'user_id' ],
			[
				'wiki_id' => $this->mCityId,
				'user_id' => $user_id,
				'edits' => $edits,
				'editdate' => $editdate,
				'last_revision' => $lastrev,
			],
			__METHOD__
		);
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Fills specials.events_local_users table with entries for a given wiki.
	 * Used by CreateNewWikiTask class
	 *
	 * Get the list of all users that made an edit or a members of local groups
	 *
	 * @see SUS-3264
	 * @see SUS-4493
	 * @param int $cityId
	 */
	public static function populateEventsLocalUsers( int $cityId ) {
		$ids = [];

		// all users that made an edit
		$res = wfGetDB(DB_SLAVE)->select(
			'revision',
			'DISTINCT(rev_user) as user_id',
			[],
			__METHOD__
		);

		foreach( $res as $row ) {
			$ids[] = $row->user_id;
		}

		// all members of local groups
		$res = wfGetDB(DB_SLAVE)->select(
			'user_groups',
			'DISTINCT(ug_user) as user_id',
			[],
			__METHOD__
		);

		foreach( $res as $row ) {
			$ids[] = $row->user_id;
		}

		// process all accounts
		$listUsers = new \ListusersData( $cityId );

		foreach( array_unique( $ids ) as $id ) {
			$user = \User::newFromId( $id );
			$user->load();
			if ( $user->isAnon() ) {
				continue;
			}
			$listUsers->updateUserGroups( $user, $user->getGroups() );
		}
	}

	/**
	 * Updates edits count, last edit data and last revision ID for every entry in
	 * events_local_users table for a given wiki.
	 *
	 * @see SUS-4625
	 *
	 * @param int $cityId
	 */
	public static function populateEditDates( int $cityId ) {
		global $wgSpecialsDB;

		// get all users for a given wiki from The Table
		$dbr = wfGetDB(DB_SLAVE, array(), $wgSpecialsDB);
		$res = $dbr->select(
			self::TABLE,
			'user_id',
			[ 'wiki_id' => $cityId ],
			__METHOD__
		);

		$dbw = wfGetDB( DB_MASTER, array(), $wgSpecialsDB );

		foreach($res as $row) {
			$userId = $row->user_id;

			$edits = User::newFromId($userId)->getEditCount();
			list( $editdate, $lastrev ) = self::getEditDateAndLastRevision( $userId );

			$dbw->update(
				self::TABLE,
				[
					"edits"			 => $edits,
					"editdate"		 => $editdate,
					"last_revision"  => $lastrev,
				],
				[
					'wiki_id' => $cityId,
					'user_id' => $userId,
				],
				__METHOD__ . '::update'
			);
		}
	}

	private function updateUserGroupsTable( DatabaseBase $dbw, int $wikiId, int $userId, array $groups ): void {
		$dbw->delete( 'local_user_groups', [ 'user_id' => $userId, 'wiki_id' => $wikiId ] );

		$groupRows = array_map( function ( $group ) use ( $wikiId, $userId ) {
			return [
				'user_id' => $userId,
				'wiki_id' => $wikiId,
				'group_name' => $group,
			];
		}, $groups );
		$dbw->insert( 'local_user_groups', $groupRows );
	}

	/**
	 * @param int $user_id
	 * @return array
	 */
	private static function getEditDateAndLastRevision( int $user_id ): array {
		$dbr = wfGetDB( DB_SLAVE );
		$revRow = $dbr->selectRow( 'revision',
			array( 'rev_id', 'rev_timestamp' ),
			array( 'rev_user' => $user_id ),
			__METHOD__,
			array( 'ORDER BY' => 'rev_timestamp DESC' ) );

		if ( empty( $revRow ) ) {
			$editdate = '0000-00-00 00:00:00';
			$lastrev = 0;
		} else {
			$editdate = wfTimestamp( TS_DB, $revRow->rev_timestamp );
			$lastrev = (int) $revRow->rev_id;
		}

		return array( $editdate, $lastrev );
	}
}
