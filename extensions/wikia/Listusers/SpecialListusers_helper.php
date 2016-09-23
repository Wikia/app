<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com>
 * @version: $Id$
 */

use Wikia\DependencyInjection\Injector;
use Wikia\Service\User\Permissions\PermissionsService;
use Wikia\Service\User\Permissions\PermissionsServiceAccessor;

class ListusersData {
	use PermissionsServiceAccessor;
	var $mCityId;
	var $mGroups;
	var $mFilterGroup;
	var $mUserName;
	var $mEdits;
	var $mLimit;
	var $mOffset;
	var $mOrder;
	var $mOrderOptions;
	var $mUseKey;

	var $mDBh;
	var $mTable;

	function __construct( $city_id, $load = 1 ) {
		global $wgSpecialsDB;
		$this->mCityId = $city_id;
		$this->mDBh = $wgSpecialsDB;
		$this->mTable = 'events_local_users';

		$this->mOrderOptions = array(
			'username'	=> array( 'user_name %s' ),
			'groups' 	=> array( 'all_groups %s', 'cnt_groups %s'),
			'revcnt' 	=> array( 'edits %s' ),
			'loggedin' 	=> array( 'ts %s' ),
			'dtedit' 	=> array( 'editdate %s' )
		);

		$this->mUseKeyOptions = array(
			'username'	=> 'wiki_user_name_edits',
			'groups' 	=> '',
			'revcnt' 	=> 'wiki_edits_by_user',
			'loggedin' 	=> '',
			'dtedit' 	=> 'wiki_editdate_user_edits'
		);

		if ( $load == 1 ) {
			$this->load();
		}
	}

	function load() {
		$this->setEdits();
		$this->setLimit();
		$this->setOffset();
		$this->setOrder();
		$this->loadGroups();
	}

	function setFilterGroup ( $group = array() ) { $this->mFilterGroup = $group; }
	function setGroups   	( $groups = array() ) { /* not used */ }
	function setUserName	( $username = '' ) { $this->mUserName = $username; }
	function setEdits    	( $edits = Listusers::DEF_EDITS ) { $this->mEdits = $edits; }
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
					// disable mUseKey temporarily due to PLATFORM-1174 MAIN-4386
					// $this->mUseKey = $this->mUseKeyOptions[$orderName];
				}
			}
		}
		if ( empty( $this->mOrder ) ) {
			$this->mOrder[] = 'user_name ASC';
		}
	}

	function getFilterGroup () { return $this->mFilterGroup; }
	function getGroups   	() { return $this->mGroups; }
	function getUserName	() { return $this->mUserName; }
	function getEdits    	() { return $this->mEdits; }
	function getLimit    	() { return $this->mLimit; }
	function getOffset   	() { return $this->mOffset; }
	function getOrder    	() { return $this->mOrder; }

	public function loadData() {
		global $wgMemc, $wgLang, $wgUser, $wgDBname;
		wfProfileIn( __METHOD__ );

		/* initial values for result */
		$data = array(
			'cnt'	=> 0,
			'sColumns' => implode(",", array_keys($this->mOrderOptions)),
			'data' 	=> array()
		);

		$orderby = implode(",", $this->mOrder);
		$subMemkey = array(
			'G'  . implode(",", is_array($this->mFilterGroup) ? $this->mFilterGroup : array()),
			'U'  . $this->mUserName,
			'C'  . $this->mEdits,
			'O'  . $this->mOffset,
			'L'  . $this->mLimit,
			'O'  . $orderby
		);

		$memkey = wfForeignMemcKey( $this->mCityId, null, "ludata", md5( implode(', ', $subMemkey) ) );
		$cached = $wgMemc->get($memkey);

		if ( empty($cached) ) {
			/* db handle */
			$dbs = wfGetDB( DB_SLAVE, array(), $this->mDBh );

			/* initial conditions for SQL query */
			$where = [
					'wiki_id' => $this->mCityId,
					"user_name != ''",
					'user_is_closed' => 0
			];

			/* filter: groups */
			if ( !empty( $this->mFilterGroup ) && is_array( $this->mFilterGroup ) ) {
				$whereGroup = array();
				foreach ( $this->mFilterGroup as $group ) {
					if ( !empty($group) ) {
						if ( $group == Listusers::DEF_GROUP_NAME ) {
							/**
							 * @see CE-1487
							 * Until poweruser group is still being evaluated
							 * and developed - we consider it as 'invisible'
							 * and include it in the No group checkbox
							 */
							$powerUserGroupName = \Wikia\PowerUser\PowerUser::GROUP_NAME;
							$whereGroup[] = ' single_group = ' . $dbs->addQuotes( $powerUserGroupName );

							$whereGroup[] = " all_groups = '' ";
						} else {
							$whereGroup[] = " all_groups " . $dbs->buildLike( $dbs->anyString(), $group );
							$whereGroup[] = " all_groups " . $dbs->buildLike( $dbs->anyString(), sprintf("%s;", $group), $dbs->anyString() );
						}
					}
				}

				if ( !empty( $whereGroup ) ) {
					$where[] = implode( " or ", $whereGroup );
				}
			}

			/* filter: user name */
			if ( !empty( $this->mUserName ) ) {
				$where[] = " user_name >= ". $dbs->addQuotes( $this->mUserName );
			}

			/* filter: number of edits */
			if ( !empty( $this->mEdits ) ) {
				$where[] = " edits >= ". intval( $this->mEdits );
			}

			/* number of records */
			$oRow = $dbs->selectRow(
				$this->mTable,
				array( 'count(0) as cnt' ),
				$where,
				__METHOD__
			);
			if ( is_object($oRow) ) {
				$data['cnt'] = $oRow->cnt;
			}

			if ( $data['cnt'] > 0 ) {
				$userIsBlocked = $wgUser->isBlocked( true, false );
				$sk = RequestContext::getMain()->getSkin();
				/* select records */
				$oRes = $dbs->select(
					array( $this->mTable . ' as e1 ' . ( ($this->mUseKey) ? 'use key('.$this->mUseKey.')' : '' ) , 'user_login_history_summary as ul1' ),
					array(
						'e1.user_id',
						'user_name',
						'cnt_groups',
						'all_groups',
						'edits',
						'user_is_blocked',
						'last_revision',
						'editdate',
						'ul1.ulh_timestamp as ts',
						'ifnull(unix_timestamp(ul1.ulh_timestamp), 0) as ts',
						'ifnull(e1.last_revision, 0) as max_rev',
						'ifnull(unix_timestamp(e1.editdate), 0) as ts_edit'
					),
					$where,
					__METHOD__,
					array(
						'ORDER BY'	=> $orderby,
						'LIMIT'		=> $this->mLimit,
						'OFFSET'	=> intval($this->mOffset)
					),
					array(
						'user_login_history_summary as ul1' => array(
							'LEFT JOIN',
							'ul1.user_id = e1.user_id'
						)
					)
				);

				$data['data'] = array();
				while ( $oRow = $dbs->fetchObject( $oRes ) ) {
					/* user exists */
					$oUser = User::newFromName($oRow->user_name);

					# check by ID id, if user not found
					if ( !( $oUser instanceof User ) || $oUser->getId() === 0 ) {
						$oUser = User::newFromId( $oRow->user_id );

						if ( !$oUser->loadFromId() ) {
							// User doesn't exist
							continue;
						}
					}

					/* groups */
					$groups = explode(";", $oRow->all_groups);
					$group = "<i>" . wfMsg('listusers-nonegroup') . "</i>";
					if ( !empty( $groups ) ) {
						$group = implode(", ", $groups);
					}

					$oEncUserName = urlencode( $oUser->getName() );

					$links = array (
						0 => "",
						1 => $sk->makeLinkObj(
							Title::newFromText( 'Contributions', NS_SPECIAL ),
							$wgLang->ucfirst( wfMsg('contribslink') ),
							"target={$oEncUserName}"
						),
						2 => $sk->makeLinkObj(
							Title::newFromText( 'Editcount', NS_SPECIAL ),
							$wgLang->ucfirst( wfMsg('listusersedits') ),
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
						$links[0] = $sk->makeLinkObj( $oUTitle, $wgLang->ucfirst(wfMsg($msg) ) );
					}

					if ( $wgUser->isAllowed( 'block' ) && ( !$userIsBlocked ) ) {
						$links[] = $sk->makeLinkObj(
							Title::newFromText( "BlockIP/{$oUser->getName()}", NS_SPECIAL ),
							$wgLang->ucfirst( wfMsg('blocklink') )
						);
					}
					if ( $wgUser->isAllowed( 'userrights' ) && ( !$userIsBlocked ) ) {
						$links[] = $sk->makeLinkObj(
							Title::newFromText( 'UserRights', NS_SPECIAL ),
							$wgLang->ucfirst( wfMsg('listgrouprights-rights') ),
							"user={$oEncUserName}"
						);
					};

					$data['data'][$oRow->user_id] = array(
						'user_id' 			=> $oRow->user_id,
						'user_name' 		=> $oUser->getName(),
						'user_link'			=> $sk->makeLinkObj($oUser->getUserPage(), $oUser->getName()),
						'groups_nbr' 		=> $oRow->cnt_groups,
						'groups' 			=> $group,
						'rev_cnt' 			=> $oRow->edits,
						'blcked'			=> $oRow->user_is_blocked,
						'links'				=> "(" . implode( ") &#183; (", $links ) . ")",
						'last_edit_page' 	=> null,
						'last_edit_diff'	=> null,
						'last_login'		=> ( !empty($oRow->ts) ) ? $wgLang->timeanddate( $oRow->ts, true ) : "",
						'last_edit_ts'		=> ( !empty($oRow->ts_edit) ) ? $wgLang->timeanddate( $oRow->ts_edit, true ) : ""
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

			$groups = User::getAllGroups();
			if ( is_array ( $groups ) && !empty( $groups ) ) {
				foreach( $groups as $group ) {
					$this->mGroups[$group] = array(
						'name' 	=> User::getGroupName($group),
						'count' => 0
					);
				}
			}

			if ( !empty( $this->mGroups ) ) {
				$records = $this->groupRecords();
				if ( !empty($records) ) {
					foreach ( $records as $key => $count ) {
						$this->mGroups[$key]['count'] = $count;
					}
				}
			}
		} else {
			$this->mGroups = $cached;
		}

		wfProfileOut( __METHOD__ );
		return $this->mGroups;
	}

	/*
	 * number of users in groups
	 *
	 * @access public
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 * @param
	 */
	private function groupRecords() {
		global $wgMemc;

		wfProfileIn( __METHOD__ );

		$result = array();
		$memkey = wfForeignMemcKey( $this->mCityId, null, Listusers::TITLE, "records" );
		$cached = $wgMemc->get($memkey);
		if ( empty($cached) ) {
			/* build SQL query */
			$dbs = wfGetDB(DB_SLAVE, array(), $this->mDBh);

			/* sql unions */
			$unions = array();
			if ( !empty( $this->mGroups ) ) {
				foreach ( $this->mGroups as $key => $name ) {
					# group name or all groups
					$where = array(
						'wiki_id' => $this->mCityId,
						'user_is_closed' => 0,
						"user_name != ''",
					);
					if ( $key != Listusers::DEF_GROUP_NAME ) {
						$where[] = " all_groups " . $dbs->buildLike( $dbs->anyString(), $key ) . " OR all_groups " . $dbs->buildLike( $dbs->anyString(), sprintf("%s;", $key), $dbs->anyString() );
					} else {
						$where[] = " all_groups = '' ";
					}

					$unions[] = $dbs->selectSQLText(
						array( $this->mTable ),
						array( $dbs->addQuotes($key) . ' as gName', 'count(0) as cnt' ),
						$where,
						__METHOD__
					);
				}

				if ( !empty( $unions ) ) {
					$sql = implode(' UNION ', $unions);
					$res = $dbs->query($sql, __METHOD__ );
					while ($row = $dbs->fetchObject($res)) {
						$result[$row->gName] = $row->cnt;
					}
					$dbs->freeResult($res);
				}

				// BugId:12643 - We DO NOT want to cache empty arrays.
				if ( !empty( $result ) ) {
					$wgMemc->set( $memkey, $result, 60*60 );
				}
			}
		} else {
			$result = $cached;
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/*
	 * update user groups (hook)
	 *
	 * @access public
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 * @param       User    $user object
	 * @param		Array   $addgroups - add group(s)
	 * @param		Array   $removegroup - remove group(s)
	 */
	public function updateUserGroups( $user, $addgroup = array(), $removegroup = array() ) {
		wfProfileIn( __METHOD__ );

		if ( !$user instanceof User ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$user_id = $user->getID();
		$dbr = wfGetDB(DB_SLAVE, array(), $this->mDBh);
		$where = array(
			"user_id" 	=> $user_id,
			"wiki_id" 	=> $this->mCityId
		);

		$oRow = $dbr->selectRow(
			array( $this->mTable ),
			array( "all_groups" ),
			$where,
			__METHOD__
		);
		$groups = array();
		if ( $oRow !== false ) {
			$tmp = explode( ";", $oRow->all_groups );
			if ( !empty($tmp) ) {
				foreach ( $tmp as $g ) {
					if ( !empty($g) ) {
						$groups[] = $g;
					}
				}
			}
		}

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

		if ( !empty($groups) ) {
			sort( $groups );
		}
		$elements = count($groups);
		$singlegroup = ( $elements > 0 ) ? $groups[$elements-1] : "";
		$allgroups = ( $elements > 0 ) ? implode(";", $groups) : "";

		$dbw = wfGetDB( DB_MASTER, array(), $this->mDBh );
		if ( empty($oRow) ) {
			$edits = User::edits($user_id);

			$dbr = wfGetDB( DB_SLAVE );
			$revRow = $dbr->selectRow(
				'revision',
				array( 'rev_id', 'rev_timestamp' ),
				array( 'rev_user' => $user_id ),
				__METHOD__,
				array( 'ORDER BY' => 'rev_timestamp DESC' )
			);
			if ( empty($revRow) ) {
				$editdate = '0000-00-00 00:00:00';
				$lastrev = 0;
			} else {
				$editdate = wfTimestamp( TS_DB, $revRow->rev_timestamp );
				$lastrev = $revRow->rev_id;
			}

			$dbw->replace(
				$this->mTable,
				array( 'wiki_id', 'user_id', 'user_name' ),
				array(
					"wiki_id"        => $this->mCityId,
					"user_id"        => $user_id,
					"user_name"  	 => $user->getName(),
					"last_ip"		 => 0,
					"edits"			 => $edits,
					"editdate"		 => $editdate,
					"last_revision"  => intval($lastrev),
					"cnt_groups"	 => $elements,
					"single_group"   => $singlegroup,
					"all_groups"	 => $allgroups
				),
				__METHOD__
			);
		} else {
			$dbw->update(
				$this->mTable,
				array(
					"cnt_groups"	=> $elements,
					"single_group"	=> $singlegroup,
					"all_groups"	=> $allgroups
				),
				$where,
				__METHOD__
			);
		}
		wfProfileOut( __METHOD__ );
		return true;
	}
}
