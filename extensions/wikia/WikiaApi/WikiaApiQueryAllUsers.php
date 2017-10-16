<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	// Eclipse helper - will be ignored in production
	require_once ( 'ApiQueryBase.php' );
}

/**
 * A query action to return meta information about the wiki site.
 *
 * @addtogroup API
 */

class WikiaApiQueryAllUsers extends ApiQueryBase {

	private $params = [];

	private $mCityId, $mDB;

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'au' );
		$this->showError = true;
	}

	private function getUsersForGroup() {
		global $wgMemc, $wgSpecialsDB;

		if ( empty( $this->params['group'] ) ) {
			return [];
		}

		wfProfileIn( __METHOD__ );

		$memkey = wfSharedMemcKey( __METHOD__, implode( "-", (array) $this->params['group'] ), $this->mCityId );
		$data = $wgMemc->get( $memkey );

		if ( !is_array( $data ) ) {
			$db = wfGetDB( DB_SLAVE, array(), $wgSpecialsDB );

			// SUS-2038: build condition for all groups mentioned in the URL
			$groupsCondition = array_map(
				function( $group ) use ( $db ) {
					return "all_groups" . $db->buildLike( $db->anyString(), $group, $db->anyString() );
				},
				$this->params['group']
			);

			$this->profileDBIn();

			// e.g. SELECT  user_id,all_groups FROM `events_local_users`  WHERE wiki_id = '177' AND ((all_groups LIKE '%staff%'  OR all_groups LIKE '%sysop%' ))
			$oRes = $db->select(
				'events_local_users',
				[
					'user_id',
					'all_groups'
				],
				[
					'wiki_id' => $this->mCityId,
					join( ' OR ', $groupsCondition )
				],
				__METHOD__
			);

			$data = [];
			while ( $row = $db->fetchObject( $oRes ) ) {
				$data[$row->user_id] = $row->all_groups;
			}
			$db->freeResult( $oRes );
			$wgMemc->set( $memkey , $data, 300 );
			$this->profileDBOut();
		}

		wfProfileOut( __METHOD__ );
		return $data;
	}

	private function getUserRegistration( $user_id ) {
		global $wgMemc, $wgExternalSharedDB;
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE, 'stats', $wgExternalSharedDB );
		$condition = array(
			"user_id" 	=> $user_id,
		);

		$row = $dbr->selectRow(
			"`user`",
			array( "user_registration" ),
			$condition,
			__METHOD__
		);

		wfProfileOut( __METHOD__ );
		return ( is_object( $row ) ) ? $row->user_registration : null;
	}

	protected function getDB() {
		return $this->mDB;
	}

	protected function getSharedDB() {
		global $wgExternalSharedDB;
		$this->mDB = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		return $this->mDB;
	}

	protected function getSpecialsDB() {
		global $wgSpecialsDB;
		$this->mDB = wfGetDB( DB_SLAVE, array(), $wgSpecialsDB );
		return $this->mDB;
	}

	public function execute() {
		global $wgCityId;

		$this->params = $this->extractRequestParams();
		$this->mCityId = (int) $wgCityId;

		# prop
		$prop = $this->params['prop'];
		if ( !is_null( $prop ) ) {
			$prop = array_flip( $prop );
		}
		$this->fld_blockinfo 		= isset( $prop['blockinfo'] );
		$this->fld_editcount 		= isset( $prop['editcount'] );
		$this->fld_groups 			= isset( $prop['groups'] );
		$this->fld_registration 	= isset( $prop['registration'] );

		if ( $this->params['local'] ) {
			$this->local_users();
		} else {
			$this->global_users();
		}
	}

	private function global_users() {
		$db = $this->getSharedDB();

		$limit = $this->params['limit'];
		$this->addTables( '`user`', 'u1' );

		if ( !is_null( $this->params['group'] ) ) {
			$users = $this->getUsersForGroup();
			if ( empty( $users ) )
				$users = array( 0 );
			$this->addWhere( 'u1.user_id IN (' . $db->makeList( array_keys( $users ) ) . ') ' );
		}

		if ( !is_null( $this->params['from'] ) ) {
			$this->addWhere( 'u1.user_name >= ' . $db->addQuotes( $this->keyToTitle( $this->params['from'] ) ) );
		}

		if ( !is_null( $this->params['prefix'] ) ) {
			$this->addWhere( 'u1.user_name' . $db->buildLike( $this->keyToTitle( $this->params['prefix'] ), $db->anyString() ) );
		}

		if ( $this->params['witheditsonly'] ) {
			$this->addWhere( 'u1.user_editcount > 0' );
		}

		if ( $this->fld_blockinfo ) {
			$this->addTables( 'ipblocks' );
			$this->addTables( '`user`', 'u2' );
			$u2 = sprintf( "%s %s", '`user`', 'u2' );
			$this->addJoinConds(
				array(
					'ipblocks' => array( 'LEFT JOIN', 'ipb_user=u1.user_id' ),
					$u2 => array( 'LEFT JOIN', 'ipb_by=u2.user_id' )
				)
			);
			$this->addFields( array( 'ipb_reason', 'u2.user_name blocker_name' ) );
		}

		$this->addOption( 'LIMIT', $limit + 1 );

		$this->addFields  ( 'u1.user_name, u1.user_id' );
		$this->addFieldsIf( 'u1.user_editcount', $this->fld_editcount );
		$this->addFieldsIf( 'u1.user_registration', $this->fld_registration );

		$this->addOption  ( 'ORDER BY', 'u1.user_name' );

		$res = $this->select( __METHOD__ );

		$data = array ();
		$count = 0;
		$lastUserData = false;
		$lastUser = false;
		$result = $this->getResult();

		while ( true ) {

			$row = $db->fetchObject( $res );
			$count++;

			if ( !$row || $lastUser !== $row->user_name ) {
				// Save the last pass's user data
				if ( is_array( $lastUserData ) ) {
					$fit = $result->addValue( array( 'query', $this->getModuleName() ), null, $lastUserData );
					if ( !$fit ) {
						$this->setContinueEnumParameter( 'from', $this->keyToTitle( $lastUserData['name'] ) );
						break;
					}
				}

				// No more rows left
				if ( !$row ) {
					break;
				}

				if ( $count > $limit ) {
					// We've reached the one extra which shows that there are additional pages to be had. Stop here...
					$this->setContinueEnumParameter( 'from', $this->keyToTitle( $row->user_name ) );
					break;
				}

				// Record new user's data
				$lastUser = $row->user_name;
				$lastUserData = array( 'name' => $lastUser, 'id' => $row->user_id );
				if ( $this->fld_blockinfo ) {
					$lastUserData['blockedby'] = $row->blocker_name;
					$lastUserData['blockreason'] = $row->ipb_reason;
				}
				if ( $this->fld_editcount ) {
					$lastUserData['editcount'] = intval( $row->user_editcount );
				}
				if ( $this->fld_registration ) {
					$lastUserData['registration'] = wfTimestamp( TS_ISO_8601, $row->user_registration );
				}

				// Add user's group info
				if ( $this->fld_groups ) {
					$lastUserData['groups'] = ( !empty( $users ) && array_key_exists( $row->user_id, $users ) )
						? explode( ';', $users[$row->user_id] )
						: array();
					$result->setIndexedTagName( $lastUserData['groups'], 'g' );
				}
			}

		}

		$db->freeResult( $res );

		$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'u' );
	}

	private function local_users() {
		global $wgCityId;

		$db = $this->getSpecialsDB();
		$params = $this->extractRequestParams();

		# prop
		$prop = $params['prop'];
		if ( !is_null( $prop ) ) {
			$prop = array_flip( $prop );
		}

		# table
		$this->addTables( 'events_local_users' );
		$this->addWhere( 'wiki_id = ' . intval( $wgCityId ) );
		$this->addWhere( 'user_is_closed = 0' );

		# limit
		$limit = $params['limit'];
		$this->addOption( 'LIMIT', $limit );

		# params
		$fld_blockinfo 		= isset( $prop['blockinfo'] );
		$fld_editcount 		= isset( $prop['editcount'] );
		$fld_groups 		= isset( $prop['groups'] );
		$fld_registration 	= isset( $prop['registration'] );

		if ( !is_null( $params['from'] ) )
			$this->addWhere( 'user_name >= ' . $db->addQuotes( $this->keyToTitle( $params['from'] ) ) );

		if ( !is_null( $params['prefix'] ) )
			$this->addWhere( 'user_name' . $db->buildLike( $this->keyToTitle( $params['prefix'] ), $db->anyString() ) );

		if ( !is_null( $params['group'] ) ) {
			$this->addWhere( 'all_groups' . $db->buildLike( $db->anyString(), $params['group'], $db->anyString() ) );
		}

		if ( $params['witheditsonly'] )
			$this->addWhere( 'edits > 0' );

		$this->addFields( 'user_id, user_name, cnt_groups, edits as user_editcount, all_groups, user_is_blocked' );
		$this->addOption( 'ORDER BY', 'user_name' );

		$res = $this->select( __METHOD__ );

		$data = array ();
		$count = 0;
		$lastUserData = false;
		$lastUser = false;
		$result = $this->getResult();

		while ( true ) {
			$row = $db->fetchObject( $res );
			$count++;

			if ( !$row || $lastUser !== $row->user_name ) {
				if ( is_array( $lastUserData ) ) {
					$fit = $result->addValue( array( 'query', $this->getModuleName() ), null, $lastUserData );
					if ( !$fit ) {
						$this->setContinueEnumParameter( 'from', $this->keyToTitle( $lastUserData['name'] ) );
						break;
					}
				}

				// No more rows left
				if ( !$row ) break;

				if ( $count > $limit ) {
					$this->setContinueEnumParameter( 'from', $this->keyToTitle( $row->user_name ) );
					break;
				}

				// Record new user's data
				$lastUser = $row->user_name;
				$lastUserData = array( 'name' => $lastUser );

				# is blocked
				if ( $this->fld_blockinfo ) {
					$blocker_name = $block_reason = '';
					if ( $row->user_is_blocked ) {
						$oBlock = Block::newFromTarget( User::whoIs( $row->user_id ), 0 );
						if ( is_object( $oBlock ) ) {
							$blocker_name = $oBlock->getByName();
							$block_reason = $oBlock->mReason;
						}
					}
					$lastUserData['blockedby'] = $blocker_name;
					$lastUserData['blockreason'] = $block_reason;
				}
				# edit count
				if ( $this->fld_editcount ) {
					$lastUserData['editcount'] = intval( $row->user_editcount );
				}
				if ( $this->fld_registration ) {
					$user_registration = $this->getUserRegistration( $row->user_id );
					$lastUserData['registration'] = wfTimestamp( TS_ISO_8601, $user_registration );
				}
			}

			// Add user's group info
			if ( $this->fld_groups && $row->cnt_groups > 0 ) {
				$use_group = array();
				$groups = explode( ";", $row->all_groups );
				if ( !empty( $groups ) ) {
					foreach ( $groups as $group ) {
						if ( !in_array( $group, $use_group ) ) {
							$lastUserData['groups'][] = $group;
						}
						$use_group[] = $group;
					}
				}

				if ( isset( $lastUserData['groups'] ) )
					$result->setIndexedTagName( $lastUserData['groups'], 'g' );
			}
		}

		$db->freeResult( $res );

		$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'u' );
	}

	private function getBaseAllowedParams() {
		$userGroups = User::getAllGroups();
		return array(
			'from' => null,
			'to' => null,
			'prefix' => null,
			'dir' => array(
				ApiBase::PARAM_DFLT => 'ascending',
				ApiBase::PARAM_TYPE => array(
					'ascending',
					'descending'
				),
			),
			'group' => array(
				ApiBase::PARAM_TYPE => $userGroups,
				ApiBase::PARAM_ISMULTI => true,
			),
			'prop' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => array(
					'blockinfo',
					'groups',
					'implicitgroups',
					'rights',
					'editcount',
					'registration'
				)
			),
			'limit' => array(
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			),
			'witheditsonly' => false,
			'activeusers' => false,
		);
	}

	public function getAllowedParams() {
		$params = $this->getBaseAllowedParams();
		$params['local'] = array (
			ApiBase :: PARAM_ISMULTI => 0,
			ApiBase :: PARAM_TYPE => 'integer',
			ApiBase :: PARAM_DFLT => 0,
		);
		return $params;
	}

	private function getBaseParamDescription() {
		global $wgActiveUserDays;
		return array(
			'from' => 'The user name to start enumerating from',
			'to' => 'The user name to stop enumerating at',
			'prefix' => 'Search for all users that begin with this value',
			'dir' => 'Direction to sort in',
			'group' => 'Limit users to given group name(s)',
			'prop' => array(
				'What pieces of information to include.',
				' blockinfo      - Adds the information about a current block on the user',
				' groups         - Lists groups that the user is in. This uses more server resources and may return fewer results than the limit',
				' implicitgroups - Lists all the groups the user is automatically in',
				' rights         - Lists rights that the user has',
				' editcount      - Adds the edit count of the user',
				' registration   - Adds the timestamp of when the user registered if available (may be blank)',
			),
			'limit' => 'How many total user names to return',
			'witheditsonly' => 'Only list users who have made edits',
			'activeusers' => "Only list users active in the last {$wgActiveUserDays} days(s)"
		);
	}

	public function getParamDescription() {
		$params = $this->getBaseParamDescription();
		$params['local'] = array(
			'Show users active on Wikia'
		);
		return $params;
	}

	public function getCacheMode( $params ) {
		return 'anon-public-user-private';
	}

	public function getDescription() {
		return 'Enumerate all registered users';
	}

	public function getExamples() {
		return array(
			'api.php?action=query&list=allusers&aufrom=Y',
		);
	}

	public function getHelpUrls() {
		return 'https://www.mediawiki.org/wiki/API:Allusers';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
