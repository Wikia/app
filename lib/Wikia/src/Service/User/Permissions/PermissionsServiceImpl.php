<?php

namespace Wikia\Service\User\Permissions;

use Wikia\Domain\User\Permissions\LocalGroup;
use Wikia\Domain\User\Permissions\GlobalGroup;
use Wikia\Util\WikiaProfiler;
use Wikia\Logger\Loggable;

class PermissionsServiceImpl implements PermissionsService {

	use Loggable;

	/** @var string[string][string] - key is the city id, then user id */
	private $localExplicitUserGroups = [];

	/** @var string[string] - key is the user id */
	private $globalExplicitUserGroups = [];

	/** @var string[string][string] - key is the user id */
	private $implicitUserGroups = [];

	/** @var string[] - global groups to which a user can be assigned */
	private $globalGroups = [];

	/** @var string[] - global groups to which a user can be assigned */
	private $implicitGroups = [];

	public function __construct() {
		$this->globalGroups[] = 'content-reviewer';
		$this->globalGroups[] = 'staff';
		$this->globalGroups[] = 'helper';
		$this->globalGroups[] = 'vstf'; //rt#27789
		$this->globalGroups[] = 'beta';
		$this->globalGroups[] = 'bot-global';
		$this->globalGroups[] = 'util';
		$this->globalGroups[] = 'reviewer';
		$this->globalGroups[] = 'poweruser';
		$this->globalGroups[] = 'translator';
		$this->globalGroups[] = 'wikifactory';
		$this->globalGroups[] = 'restricted-login';

		$this->implicitGroups[] = '*';
		$this->implicitGroups[] = 'user';
		$this->implicitGroups[] = 'autoconfirmed';
		$this->implicitGroups[] = 'poweruser';

	}

	private function getLocalUserGroups( $cityId, $userId ) {
		if ( !isset( $this->localExplicitUserGroups[$cityId] ) || !isset( $this->localExplicitUserGroups[$cityId][$userId] ) ) {
			return false;
		}
		return $this->localExplicitUserGroups[$cityId][$userId];
	}

	private function setLocalUserGroups( $cityId, $userId, $groups ) {
		if ( !isset( $this->localExplicitUserGroups[$cityId] ) ) {
			$this->localExplicitUserGroups[$cityId] = [];
		}
		$this->localExplicitUserGroups[$cityId][$userId] = $groups;
	}

	private function getImplicitUserGroups( $userId ) {
		if ( !isset( $this->implicitUserGroups[$userId] ) ) {
			return false;
		}
		return $this->implicitUserGroups[$userId];
	}

	private function setImplicitUserGroups( $userId, $groups ) {
		$this->implicitUserGroups[$userId] = $groups;
	}

	private function getGlobalUserGroups( $userId ) {
		if ( !isset( $this->globalExplicitUserGroups[$userId] ) ) {
			return false;
		}
		return $this->globalExplicitUserGroups[$userId];
	}

	private function setGlobalUserGroups( $userId, $groups ) {
		$this->globalExplicitUserGroups[$userId] = $groups;
	}

	public function getGlobalGroups() {
		return $this->globalGroups;
	}

	public function getImplicitGroups() {
		return $this->implicitGroups;
	}

	public function getExplicitUserGroups( $cityId, $userId ) {
		return array_unique( array_merge (
			$this->getExplicitLocalUserGroups( $cityId, $userId ),
			$this->getExplicitGlobalUserGroups( $userId )
		) );
	}

	public function getExplicitLocalUserGroups( $cityId, $userId ) {
		$this->loadLocalGroups( $cityId, $userId );
		return $this->getLocalUserGroups( $cityId, $userId );
	}

	public function getExplicitGlobalUserGroups( $userId ) {
		$this->loadGlobalGroups( $userId );
		return $this->getGlobalUserGroups( $userId );
	}

	/**
	 * Return memcache key used for storing groups for a given user
	 *
	 * @param \User $user
	 * @return string memcache key
	 */
	static public function getMemcKey( $userId ) {
		return wfSharedMemcKey( __CLASS__, 'permissions-groups', $userId );
	}

	/**
	 * Get the list of implicit group memberships this user has.
	 * This includes 'user' if logged in, '*' for all accounts,
	 * and autopromoted groups
	 * @return Array of String internal group names
	 */
	public function getAutomaticUserGroups( \User $user, $reCacheAutomaticGroups = false ) {
		if ( $reCacheAutomaticGroups || $this->getImplicitUserGroups( $user->getId() ) == false ) {
			$implicitGroups = array( '*' );
			if ( $user->getId() ) {
				$implicitGroups[] = 'user';

				$implicitGroups = array_unique( array_merge(
					$implicitGroups,
					\Autopromote::getAutopromoteGroups( $user )
				) );
			}
			$this->setImplicitUserGroups($user->getId(), $implicitGroups);
		}

		return $this->getImplicitUserGroups($user->getId());
	}

	/**
	 * Get the list of explicit and implicit group memberships this user has.
	 * This includes all explicit groups, plus 'user' if logged in,
	 * '*' for all accounts, and autopromoted groups
	 * @return Array of String internal group names
	 */
	public function getEffectiveUserGroups( $cityId, \User $user, $reCacheAutomaticGroups = false ) {

		return array_unique( array_merge(
			$this->getExplicitUserGroups( $cityId, $user->getId() ),
			$this->getAutomaticUserGroups( $user, $reCacheAutomaticGroups )
		) );
	}


	//These function will need to go to the external service eventually.

	private function loadLocalGroups( $cityId, $userId ) {
		$userLocalGroups = $this->getLocalUserGroups( $cityId, $userId );

		if ( $userLocalGroups == false ) {
			$dbr = wfGetDB( DB_MASTER );
			$res = $dbr->select( 'user_groups',
				array( 'ug_group' ),
				array( 'ug_user' => $userId ),
				__METHOD__ );
			$userLocalGroups = [];
			foreach ( $res as $row ) {
				$userLocalGroups[] = $row->ug_group;
			}
			$this->setLocalUserGroups( $cityId, $userId, $userLocalGroups);
		}
	}

	/**
	 * @param int $db DB_SLAVE or DB_MASTER
	 * @return DatabaseBase
	 */
	static private function getSharedDB( $db = DB_SLAVE ) {
		global $wgExternalSharedDB;
		return wfGetDB( $db, [], $wgExternalSharedDB );
	}

	private function loadGlobalGroups( $userId ) {
		if ( $this->getGlobalUserGroups( $userId ) == false ) {

			if ( empty( $userId ) ) {
				$this->setGlobalUserGroups( $userId, [] );
			} else {
				$fname = __METHOD__;
				$globalGroups = \WikiaDataAccess::cache(
					self::getMemcKey( $userId ),
					\WikiaResponse::CACHE_LONG,
					function() use ( $userId, $fname ) {
						$dbr = self::getSharedDB( DB_MASTER );
						return $dbr->selectFieldValues(
							'user_groups',
							'ug_group',
							[ 'ug_user' => $userId ],
							$fname
						);
					}
				);

				$globalGroups = array_intersect( $globalGroups, $this->globalGroups );
				$this->setGlobalUserGroups( $userId, $globalGroups );
			}
		}
	}
}
