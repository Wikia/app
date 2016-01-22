<?php

namespace Wikia\Service\User\Permissions;

use Wikia\Domain\User\Permissions\LocalGroup;
use Wikia\Domain\User\Permissions\GlobalGroup;
use Wikia\Util\WikiaProfiler;
use Wikia\Logger\Loggable;

class PermissionsServiceImpl implements PermissionsService {

	use Loggable;

	/** @var LocalGroup[string][string] - key is the city id, then user id */
	private $localExplicitGroups = [];

	/** @var GlobalGroup[string] - key is the user id */
	private $globalExplicitGroups = [];

	/** @var LocalGroup[string][string] - key is the user id */
	private $implicitGroups = [];

	/** @var string[] - global groups to which a user can be assigned */
	private $availableGlobalGroups = [];

	public function __construct() {
		$this->availableGlobalGroups[] = 'content-reviewer';
		$this->availableGlobalGroups[] = 'staff';
		$this->availableGlobalGroups[] = 'helper';
		$this->availableGlobalGroups[] = 'vstf'; //rt#27789
		$this->availableGlobalGroups[] = 'beta';
		$this->availableGlobalGroups[] = 'bot-global';
		$this->availableGlobalGroups[] = 'util';
		$this->availableGlobalGroups[] = 'reviewer';
		$this->availableGlobalGroups[] = 'poweruser';
		$this->availableGlobalGroups[] = 'translator';
		$this->availableGlobalGroups[] = 'wikifactory';
		$this->availableGlobalGroups[] = 'restricted-login';
	}

	private function getLocalUserGroups( $cityId, $userId ) {
		if ( !isset( $this->localExplicitGroups[$cityId] ) || !isset( $this->localExplicitGroups[$cityId][$userId] ) ) {
			return false;
		}
		return $this->localExplicitGroups[$cityId][$userId];
	}

	private function setLocalUserGroups( $cityId, $userId, $groups ) {
		if ( !isset( $this->localExplicitGroups[$cityId] ) ) {
			$this->localExplicitGroups[$cityId] = [];
		}
		$this->localExplicitGroups[$cityId][$userId] = $groups;
	}

	private function getImplicitUserGroups( $userId ) {
		if ( !isset( $this->implicitGroups[$userId] ) ) {
			return false;
		}
		return $this->implicitGroups[$userId];
	}

	private function setImplicitUserGroups( $userId, $groups ) {
		$this->implicitGroups[$userId] = $groups;
	}

	private function getGlobalUserGroups( $userId ) {
		if ( !isset( $this->globalExplicitGroups[$userId] ) ) {
			return false;
		}
		return $this->globalExplicitGroups[$userId];
	}

	private function setGlobalUserGroups( $userId, $groups ) {
		$this->globalExplicitGroups[$userId] = $groups;
	}

	public function getExplicitUserGroups( $cityId, \User $user ) {
		$this->loadLocalGroups( $cityId, $user->getId() );
		$this->loadGlobalGroups( $user->getId() );

		$groupNames = [];
		$localGroups = $this->getLocalUserGroups( $cityId, $user->getId() );
		$globalGroups = $this->getGlobalUserGroups( $user->getId() );

		if ( $localGroups != false) {
			foreach ( $localGroups as $localGroup ) {
				$groupNames[] = $localGroup->getName();
			}
		}

		if ( $globalGroups != false) {
			foreach ( $globalGroups as $globalGroup ) {
				$groupNames[] = $globalGroup->getName();
			}
		}

		return array_unique( $groupNames );
	}

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
				$userLocalGroups[] = new LocalGroup($row->ug_group, $cityId);
			}
		}

		$this->setLocalUserGroups( $cityId, $userId, $userLocalGroups);
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
	 * @param int $db DB_SLAVE or DB_MASTER
	 * @return DatabaseBase
	 */
	static private function getSharedDB( $db = DB_SLAVE ) {
		global $wgExternalSharedDB;
		return wfGetDB( $db, [], $wgExternalSharedDB );
	}

	private function loadGlobalGroups( $userId ) {
		if ( !empty( $userId ) && $this->getGlobalUserGroups( $userId ) == false ) {

			$fname = __METHOD__;
			$globalGroupNames = \WikiaDataAccess::cache(
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

			$globalGroupNames = array_intersect( $globalGroupNames, $this->availableGlobalGroups );
			$globalGroups = [];
			foreach ( $globalGroupNames as $groupName ) {
				$globalGroups[] = new GlobalGroup($groupName);
			}
			$this->setGlobalUserGroups( $userId, $globalGroups );
		}
	}

	/**
	 * Get the list of implicit group memberships this user has.
	 * This includes 'user' if logged in, '*' for all accounts,
	 * and autopromoted groups
	 * @return Array of String internal group names
	 */
	public function getAutomaticUserGroups( \User $user, $reCacheGroups = false ) {
		if ( $reCacheGroups || $this->getImplicitUserGroups( $user->getId() ) == false ) {
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
			$this->getExplicitUserGroups( $cityId, $user ),
			$this->getAutomaticUserGroups( $user, $reCacheAutomaticGroups )
		) );
	}
}
