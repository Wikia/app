<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com>
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

class ListusersData {	
	var $mCityId;
	var $mGroups;
	var $mFilterGroup;	
	var $mUserName;
	var $mEdits;
	var $mLimit;
	var $mOffset;
	var $mOrder;
	var $mOrderOptions;
	
	var $mDBh;
	var $mTable;
	
	function __construct( $city_id, $load = 1 ) {
		global $wgStatsDB;
		wfLoadExtensionMessages("Listusers");
		$this->mCityId = $city_id;
		$this->mDBh = $wgStatsDB;
		$this->mTable = '`specials`.`events_local_users`';
			
		$this->mOrderOptions = array(
			'username'	=> array( 'user_name %s' ),
			'groups' 	=> array( 'all_groups %s', 'cnt_groups %s'),
			'revcnt' 	=> array( 'edits %s' ),
			'loggedin' 	=> array( 'ts %s' ),
			'dtedit' 	=> array( 'editdate %s' )
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
		
		# order by 
		$this->mOrder = array();
		if ( !empty($orders) ) {
			foreach ( $orders as $order ) {
				list ( $orderName, $orderDesc ) = explode( ":", $order );
				if ( isset( $this->mOrderOptions[$orderName] ) ) {
					foreach ( $this->mOrderOptions[$orderName] as $orderStr ) {
						$this->mOrder[] = sprintf( $orderStr, $orderDesc );
					}
				}			
			}
		}
		if ( empty($this->mOrder) ) {
			$this->mOrder[] = sprintf( $this->mOrderOptions[Listusers::DEF_ORDER], Listusers::DEF_ORDER_ASC );
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
		$cached = ""; #$wgMemc->get($memkey);
		
		if ( empty($cached) ) { 
			/* db handle */
			$dbs = wfGetDB( DB_SLAVE, array(), $this->mDBh );

			/* initial conditions for SQL query */
			$where = array( 'wiki_id' => $this->mCityId );
			
			/* filter: groups */
			if ( !empty( $this->mFilterGroup ) && is_array( $this->mFilterGroup ) ) {
				$whereGroup = array();
				foreach ( $this->mFilterGroup as $group ) {
					if ( !empty($group) ) {
						$whereGroup[] = 
							( $group == Listusers::DEF_GROUP_NAME ) 
							? " all_groups = '' " 
							: " all_groups like '%" . $dbs->escapeLike( $group ) . "%' ";
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
				$userIsBlocked = $wgUser->isBlocked();
				$sk = $wgUser->getSkin();
				/* select records */
				$oRes = $dbs->select(
					array( $this->mTable . ' as e1', 'user_login_history_summary as ul1' ),
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
					if ( !($oUser instanceof User) ) {
						$oUser = User::newFromId($oRow->user_id);
					}
					
					# hmmm ... if user not found
					if ( !($oUser instanceof User) ) continue;

					/* groups */
					$groups = explode(";", $oRow->all_groups);
					$group = "<i>" . wfMsg('listusers-nonegroup') . "</i>";
					if ( !empty( $groups ) ) {
						$group = implode(", ", $groups);
					}

					$links = array (
						0 => "",
						1 => $sk->makeLinkObj(
							Title::newFromText( 'Contributions', NS_SPECIAL ), 
							$wgLang->ucfirst( wfMsg('contribslink') ), 
							"target={$oUser->getName()}"
						),
						2 => $sk->makeLinkObj(
							Title::newFromText( 'Editcount', NS_SPECIAL ), 
							$wgLang->ucfirst( wfMsg('listusersedits') ), 
							"username={$oUser->getName()}"
						)
					);

					$oUTitle = Title::newFromText($oUser->getName(), NS_USER_TALK);
					if ( $oUTitle instanceof Title ) {
						$links[0] = $sk->makeLinkObj( $oUTitle, $wgLang->ucfirst(wfMsg('talkpagelinktext') ) );
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
							"user={$oUser->getName()}"
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
				$wgMemc->set( $memkey, $data, 60*60 );
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
						'user_is_closed' => 0
					); 
					if ( $key != Listusers::DEF_GROUP_NAME ) {
						$where[] = " all_groups like '%" . $dbs->escapeLike( $key ) . "%' ";
					} else {
						$where['cnt_groups'] = 0;
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
				$wgMemc->set( $memkey, $result, 60*60 );
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
		
		$dbr = wfGetDB(DB_SLAVE, array(), $this->mDBh);
		$where = array( 
			"user_id" 	=> $user->getID(),
			"wiki_id" 	=> $wgCityId
		);

		$oRow = $dbr->selectRow( 
			array( $this->mTable ), 
			array( "all_groups" ), 
			$where,
			__METHOD__ 
		);
		if ( $oRow !== false && !empty( $oRow->all_groups ) ) {
			$groups = explode( ";", $oRow->all_groups );
			if ( !empty($addgroup) ) {
				$groups = array_unique( array_merge($groups, $addgroup) );
			} 
			if ( !empty($removegroup) ) {
				$groups = array_unique( array_diff($groups, $removegroup) );
			}
			if ( !empty($groups) ) { 
				sort($groups);
				$elements = count($groups);
				$singlegroup = ( $elements > 0 ) ? $groups[$elements-1] : "";
				
				$dbw = wfGetDB( DB_MASTER, array(), $this->mDBh );
				$dbw->update(
					$this->mTable,
					array(
						"single_group"	=> $singlegroup,
						"all_groups"	=> @implode(";", $groups)
					),
					$where,
					__METHOD__
				);
			}
		}
		
		wfProfileOut( __METHOD__ );		
		return true;
	}
}
