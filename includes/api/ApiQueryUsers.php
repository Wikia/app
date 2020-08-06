<?php
/**
 *
 *
 * Created on July 30, 2007
 *
 * Copyright © 2007 Roan Kattouw <Firstname>.<Lastname>@gmail.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

/**
 * Query module to get information about a list of users
 *
 * @ingroup API
 */
class ApiQueryUsers extends ApiQueryBase {
	const INVALID_PARAMS_ERR = 'You must specify at least one valid user name or ID to query for';

	private $tokenFunctions, $prop;

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'us' );
	}

	/**
	 * Get an array mapping token names to their handler functions.
	 * The prototype for a token function is func($user)
	 * it should return a token or false (permission denied)
	 * @return Array tokenname => function
	 */
	protected function getTokenFunctions() {
		// Don't call the hooks twice
		if ( isset( $this->tokenFunctions ) ) {
			return $this->tokenFunctions;
		}

		// If we're in JSON callback mode, no tokens can be obtained
		if ( !is_null( $this->getMain()->getRequest()->getVal( 'callback' ) ) ) {
			return array();
		}

		$this->tokenFunctions = array(
			'userrights' => array( 'ApiQueryUsers', 'getUserrightsToken' ),
		);
		Hooks::run( 'APIQueryUsersTokens', array( &$this->tokenFunctions ) );
		return $this->tokenFunctions;
	}

	 /**
	  * @param $user User
	  * @return String
	  */
	public static function getUserrightsToken( $user ) {
		global $wgUser;
		// Since the permissions check for userrights is non-trivial,
		// don't bother with it here
		return $wgUser->getEditToken( $user->getName() );
	}

	public function execute() {
		$params = $this->extractRequestParams();

		if ( !is_null( $params['prop'] ) ) {
			$this->prop = array_flip( $params['prop'] );
		} else {
			$this->prop = array();
		}

		// Port of T34494: allow lookup by user ID
		$this->requireMaxOneParameter( [ 'users', 'ids' ] );

		$users = (array)$params['users'];
		$ids = (array)$params['ids'];

		$useNames = !empty( $users );

		$goodNames = $done = array();
		$result = $this->getResult();

		// Canonicalize user names
		foreach ( $users as $u ) {
			$n = User::getCanonicalName( $u );
			if ( $n === false || $n === '' ) {
				$vals = array( 'name' => $u, 'invalid' => '' );
				$fit = $result->addValue( array( 'query', $this->getModuleName() ),
						null, $vals );
				if ( !$fit ) {
					$this->setContinueEnumParameter( 'users',
							implode( '|', array_diff( $users, $done ) ) );
					$goodNames = array();
					break;
				}
				$done[] = $u;
			} else {
				$goodNames[] = $n;
			}
		}

		// SUS-3282: Do not query for user_id = 0
		$validUserIds = array_filter( $ids );
		if ( empty( $validUserIds ) && empty( $goodNames ) ) {
			$this->dieUsage( static::INVALID_PARAMS_ERR, 400 );
		}

		$result = $this->getResult();

		/* Wikia change begin - SUS-2989 */
		$res = $this->getUserRows( $goodNames, $ids );
		/* Wikia change end - SUS-2989 */

		foreach ( $res as $row ) {
			$user = User::newFromRow( $row );
			$data = [];

			$data['userid'] = $user->getId();
			$data['name'] = $user->getName();

			if ( isset( $this->prop['editcount'] ) ) {
				$data['editcount'] = intval( $user->getEditCount() );
			}

			if ( isset( $this->prop['registration'] ) ) {
				$data['registration'] = wfTimestampOrNull( TS_ISO_8601, $user->getRegistration() );
			}

			if ( isset( $this->prop['groups'] ) ) {
				$data['groups'] = $user->getEffectiveGroups();
				$result->setIndexedTagName( $data['groups'], 'g' );
			}

			if ( isset( $this->prop['implicitgroups'] ) && !isset( $data['implicitgroups'] ) ) {
				$data['implicitgroups'] = self::getAutoGroups( $user );
				$result->setIndexedTagName( $data['implicitgroups'], 'g' );
			}

			if ( isset( $this->prop['rights'] ) ) {
				$data['rights'] = $user->getRights();
				$result->setIndexedTagName( $data['rights'], 'r' );
			}
			if ( isset( $row->ipb_deleted ) /* Wikia change */ && $row->ipb_deleted ) {
				$data['hidden'] = '';
			}

			/* Wikia change begin - SUS-92 */
			if ( isset( $this->prop['blockinfo'] ) || isset( $this->prop['localblockinfo'] ) ) {
				$isGlobalBlockCheck = !isset( $this->prop['localblockinfo'] ) && $this->canViewGlobalBlockInfo();
				$blockInfo = $user->getBlock( true, false /* don't log in Phalanx stats */, $isGlobalBlockCheck );

				if ( $user->isBlockedGlobally() ) {
					// SUS-1456: We're performing a global block check, and request is authorized
					// (internal request from service, or user who can view phalanx)

					// For Phalanx blocks, use separate fields...
					$data['phalanxblockedby'] = $blockInfo->getByName();
					$data['phalanxblockreason'] = $blockInfo->mReason;
					$data['phalanxblockexpiry'] = $blockInfo->getExpiry();

					// reset fields so that we can load info for local block
					$user->clearBlockInfo();

					// load info for local block and display it in its own fields
					$localBlockInfo = $user->getBlock( true, false, false /* check only local blocks */ );
					if ( $localBlockInfo ) {
						$data['blockedby'] = $localBlockInfo->getByName();
						$data['blockreason'] = $localBlockInfo->mReason;
						$data['blockexpiry'] = $localBlockInfo->getExpiry();
					}
				} elseif ( $user->isBlocked() ) {
					// user is not blocked globally, but is blocked locally
					// or request is not authorized

					$data['blockedby'] = $blockInfo->getByName();
					$data['blockreason'] = $blockInfo->mReason;
					$data['blockexpiry'] = $blockInfo->getExpiry();
				}
			}
			/* Wikia change end */

			if ( isset( $this->prop['emailable'] ) && $user->canReceiveEmail() ) {
				$data['emailable'] = '';
			}

			if ( isset( $this->prop['gender'] ) ) {
				$gender = $user->getGlobalAttribute( 'gender' );
				if ( strval( $gender ) === '' ) {
					$gender = 'unknown';
				}
				$data['gender'] = $gender;
			}

			if ( !is_null( $params['token'] ) ) {
				$tokenFunctions = $this->getTokenFunctions();
				foreach ( $params['token'] as $t ) {
					$val = call_user_func( $tokenFunctions[$t], $user );
					if ( $val === false ) {
						$this->setWarning( "Action '$t' is not allowed for the current user" );
					} else {
						$data[$t . 'token'] = $val;
					}
				}
			}

			if ( !$result->addValue( [ 'query', $this->getModuleName() ], null, $data ) ) {
				if ( $useNames ) {
					$this->setContinueEnumParameter( 'users',
						implode( '|', array_diff( $users, $done ) ) );
				} else {
					$this->setContinueEnumParameter( 'ids',
						implode( '|', array_diff( $ids, $done ) ) );
				}
				break;
			}
		}

		return $result->setIndexedTagName_internal( [ 'query', $this->getModuleName() ], 'user' );
	}

	/**
	 * SUS-1472: Check if current request is authorized to view global block information
	 * (it is internal request or request by staff/SOAP/helper user)
	 * @return bool
	 */
	private function canViewGlobalBlockInfo() {
		return $this->getRequest()->isWikiaInternalRequest() || $this->getUser()->isAllowed( 'phalanx' );
	}

	/**
	* Gets all the groups that a user is automatically a member of (implicit groups)
	* @param $user User
	* @return array
	*/
	public static function getAutoGroups( $user ) {
		$groups = array();
		$groups[] = '*';

		if ( !$user->isAnon() ) {
			$groups[] = 'user';
		}

		return array_merge( $groups, Autopromote::getAutopromoteGroups( $user ) );
	}

	public function getCacheMode( $params ) {
		if ( isset( $params['token'] ) ) {
			return 'private';
		} else {
			return 'anon-public-user-private';
		}
	}

	public function getAllowedParams() {
		return [
			'prop' => [
				ApiBase::PARAM_DFLT => null,
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => [
					'blockinfo',
					'localblockinfo',
					'groups',
					'implicitgroups',
					'rights',
					'editcount',
					'registration',
					'emailable',
					'gender',
				],
			],
			'users' => [
				ApiBase::PARAM_ISMULTI => true,
			],
			'ids' => [
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => 'integer',
			],
			'token' => [
				ApiBase::PARAM_TYPE => array_keys( $this->getTokenFunctions() ),
				ApiBase::PARAM_ISMULTI => true,
			],
		];
	}

	private function getUserRows( $userNames, $userIds ) {
		global $wgExternalSharedDB;
		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		if ( !empty( $userIds ) ) {
			return $dbr->select('`user`', [ 'user_id', 'user_name' ], [ 'user_id' => $userIds ], __METHOD__);
		}

		if ( !empty( $userNames ) ) {
			return $dbr->select('`user`', [ 'user_id', 'user_name' ], [ 'user_name' => $userNames ], __METHOD__);
		}

		return [];
	}

	public function getParamDescription() {
		return array(
			'prop' => array(
				'What pieces of information to include',
				'  blockinfo      - Tags if the user is blocked, by whom, and for what reason',
				'  groups         - Lists all the groups the user(s) belongs to',
				'  implicitgroups - Lists all the groups a user is automatically a member of',
				'  rights         - Lists all the rights the user(s) has',
				'  editcount      - Adds the user\'s edit count',
				'  registration   - Adds the user\'s registration timestamp',
				'  emailable      - Tags if the user can and wants to receive e-mail through [[Special:Emailuser]]',
				'  gender         - Tags the gender of the user. Returns "male", "female", or "unknown"',
			),
			'users' => 'A list of user names to obtain the same information for',
			'ids' => 'A list of user IDs to obtain the same information for',
			'token' => 'Which tokens to obtain for each user',
		);
	}

	public function getDescription() {
		return 'Get information about a list of users';
	}

	public function getExamples() {
		return [
			'api.php?action=query&list=users&ususers=brion|TimStarling&usprop=groups|editcount|gender',
			'api.php?action=query&list=users&usids=1|2&usprop=groups|editcount|gender',
		];
	}

	public function getHelpUrls() {
		return 'https://www.mediawiki.org/wiki/API:Users';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
