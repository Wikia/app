<?php

namespace Wikia\Service\User\Permissions;

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

	/** @var string[string][string] - key is the city id, then user id */
	private $userPermissions = [];

	/** @var string[] - global groups to which a user can be assigned */
	private $globalGroups = [];

	/** @var string[] - global implicit groups to which a user can be automatically assigned*/
	private $implicitGroups = [];

	/** @var string[] - global explicit groups to which a user can be explicitly assigned */
	private $explicitGroups = [];

	/** @var string[] - right names - Each of these should have a corresponding message of the form "right-$right". */
	private $permissions = [];

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

		$this->permissions = array(
			'apihighlimits',
			'autoconfirmed',
			'autopatrol',
			'bigdelete',
			'block',
			'blockemail',
			'bot',
			'browsearchive',
			'createaccount',
			'createpage',
			'createtalk',
			'delete',
			'deletedhistory',
			'deletedtext',
			'deleterevision',
			'edit',
			'editinterface',
			'editmyoptions',
			'editusercssjs', #deprecated
			'editusercss',
			'edituserjs',
			'hideuser',
			'import',
			'importupload',
			'ipblock-exempt',
			'markbotedits',
			'mergehistory',
			'minoredit',
			'move',
			'movefile',
			'move-rootuserpages',
			'move-subpages',
			'nominornewtalk',
			'noratelimit',
			'override-export-depth',
			'patrol',
			'protect',
			'proxyunbannable',
			'purge',
			'read',
			'reupload',
			'reupload-shared',
			'rollback',
			'sendemail',
			'siteadmin',
			'suppressionlog',
			'suppressredirect',
			'suppressrevision',
			'unblockself',
			'undelete',
			'unwatchedpages',
			'upload',
			'upload_by_url',
			'userrights',
			'userrights-interwiki',
			'writeapi',
		);

		//Permissions from extensions
		$this->permissions[] = 'canremovemap';
		$this->permissions[] = 'wikiawidget';
		$this->permissions[] = 'wikifactory';
		$this->permissions[] = 'wikifactorymetrics';
		$this->permissions[] = 'dumpsondemand';
		$this->permissions[] = 'wikifeatures';
		$this->permissions[] = 'MultiFileUploader';
		$this->permissions[] = 'allowedtoblank';
		$this->permissions[] = 'batchmove';
		$this->permissions[] = 'linkstoredirects';
		$this->permissions[] = 'mobilesearches';
		$this->permissions[] = 'soapfailures';
		$this->permissions[] = 'moderatesotd';
		$this->permissions[] = 'hiderevision';
		$this->permissions[] = 'oversight';
		$this->permissions[] = 'abusefilter-modify';
		$this->permissions[] = 'abusefilter-log-detail';
		$this->permissions[] = 'abusefilter-view';
		$this->permissions[] = 'abusefilter-log';
		$this->permissions[] = 'abusefilter-private';
		$this->permissions[] = 'abusefilter-modify-restricted';
		$this->permissions[] = 'abusefilter-revert';
		$this->permissions[] = 'abusefilter-view-private';
		$this->permissions[] = 'abusefilter-hidden-log';
		$this->permissions[] = 'abusefilter-hide-log';
		$this->permissions[] = 'override-antispoof';
		$this->permissions[] = 'checkuser';
		$this->permissions[] = 'checkuser-log';
		$this->permissions[] = 'geocode';
		$this->permissions[] = 'nuke';
		$this->permissions[] = 'refreshspecial';
		$this->permissions[] = 'replacetext';
		$this->permissions[] = 'spamregex';
		$this->permissions[] = 'tboverride';	// Implies tboverride-account
		$this->permissions[] = 'tboverride-account';	// For account creation
		$this->permissions[] = 'torunblocked';
		$this->permissions[] = 'abusefilter-bypass';
		$this->permissions[] = 'platinum';
		$this->permissions[] = 'sponsored-achievements';
		$this->permissions[] = 'achievements-exempt';
		$this->permissions[] = 'achievements-explicit';
		$this->permissions[] = 'admindashboard';
		$this->permissions[] = 'commentmove';
		$this->permissions[] = 'commentedit';
		$this->permissions[] = 'commentdelete';
		$this->permissions[] = 'becp_user';
		$this->permissions[] = 'blog-comments-toggle';
		$this->permissions[] = 'blog-comments-delete';
		$this->permissions[] = 'blog-articles-edit';
		$this->permissions[] = 'blog-articles-move';
		$this->permissions[] = 'blog-articles-protect';
		$this->permissions[] = 'blog-auto-follow';
		$this->permissions[] = 'skipcaptcha';
		$this->permissions[] = 'chatmoderator';
		$this->permissions[] = 'chat';
		$this->permissions[] = 'commentcsv';
		$this->permissions[] = 'content-review';
		$this->permissions[] = 'content-review-test-mode';
		$this->permissions[] = 'coppatool';
		$this->permissions[] = 'createnewwiki';
		$this->permissions[] = 'createwikilimitsexempt'; // user not bound by creation throttle
		$this->permissions[] = 'finishcreate';
		$this->permissions[] = 'devboxpanel';
		$this->permissions[] = 'dmcarequestmanagement';
		$this->permissions[] = 'editaccount';
		$this->permissions[] = 'emailsstorage';
		$this->permissions[] = 'flags-administration';
		$this->permissions[] = 'forum';
		$this->permissions[] = 'boardedit';
		$this->permissions[] = 'forumadmin';
		$this->permissions[] = 'welcomeexempt';
		$this->permissions[] = 'coppaimagereview';
		$this->permissions[] = 'imagereview';
		$this->permissions[] = 'questionableimagereview';
		$this->permissions[] = 'rejectedimagereview';
		$this->permissions[] = 'imagereviewstats';
		$this->permissions[] = 'imagereviewcontrols';
		$this->permissions[] = 'promoteimagereview';
		$this->permissions[] = 'promoteimagereviewquestionableimagereview';
		$this->permissions[] = 'promoteimagereviewrejectedimagereview';
		$this->permissions[] = 'promoteimagereviewstats';
		$this->permissions[] = 'promoteimagereviewcontrols';
		$this->permissions[] = 'insights';
		$this->permissions[] = 'listusers';
		$this->permissions[] = 'lookupcontribs';
		$this->permissions[] = 'lookupuser';
		$this->permissions[] = 'minieditor-specialpage';
		$this->permissions[] = 'multidelete';
		$this->permissions[] = 'multiwikiedit';
		$this->permissions[] = 'multiwikifinder';
		$this->permissions[] = 'njordeditmode';
		$this->permissions[] = 'phalanxexempt';
		$this->permissions[] = 'phalanx';
		$this->permissions[] = 'phalanxemailblock';
		$this->permissions[] = 'piggyback';
		$this->permissions[] = 'places-enable-category-geolocation';
		$this->permissions[] = 'metadata';
		$this->permissions[] = 'powerdelete';
		$this->permissions[] = 'quicktools';
		$this->permissions[] = 'quickadopt';
		$this->permissions[] = 'regexblock';
		$this->permissions[] = 'restrictsession';
		$this->permissions[] = 'scribeevents';
		$this->permissions[] = 'performancestats';
		$this->permissions[] = 'messagetool';
		$this->permissions[] = 'forceview';
		$this->permissions[] = 'apigate_admin';
		$this->permissions[] = 'batchuserrights';
		$this->permissions[] = 'edithub';
		$this->permissions[] = 'InterwikiEdit';
		$this->permissions[] = 'multilookup';
		$this->permissions[] = 'newwikislist';
		$this->permissions[] = 'restricted_promote';
		$this->permissions[] = 'protectsite';
		$this->permissions[] = 'stafflog';
		$this->permissions[] = 'unblockable';
		$this->permissions[] = 'tagsreport';
		$this->permissions[] = 'taskmanager';
		$this->permissions[] = 'taskmanager-action';
		$this->permissions[] = 'tasks-user';
		$this->permissions[] = 'template-bulk-classification';
		$this->permissions[] = 'templatedraft';
		$this->permissions[] = 'textregex';
		$this->permissions[] = 'themedesigner';
		$this->permissions[] = 'toplists-create-edit-list';
		$this->permissions[] = 'toplists-create-item';
		$this->permissions[] = 'toplists-edit-item';
		$this->permissions[] = 'toplists-delete-item';
		$this->permissions[] = 'usermanagement';
		$this->permissions[] = 'removeavatar';
		$this->permissions[] = 'renameuser';
		$this->permissions[] = 'userrollback';
		$this->permissions[] = 'specialvideohandler';
		$this->permissions[] = 'uploadpremiumvideo';
		$this->permissions[] = 'wdacreview';
		$this->permissions[] = 'WhereIsExtension';

		//TODO need to remove the $wgGroupPermissions and $wgRevokePermissions variables
		global $wgGroupPermissions, $wgRevokePermissions;
		$this->explicitGroups = array_diff(
			array_merge( array_keys( $wgGroupPermissions ), array_keys( $wgRevokePermissions ) ),
			$this->implicitGroups
		);
	}

	private function getLocalUserGroupsArray( $cityId, $userId ) {
		if ( !isset( $this->localExplicitUserGroups[$cityId] ) || !isset( $this->localExplicitUserGroups[$cityId][$userId] ) ) {
			return false;
		}
		return $this->localExplicitUserGroups[$cityId][$userId];
	}

	private function setLocalUserGroupsArray( $cityId, $userId, $groups ) {
		if ( !isset( $this->localExplicitUserGroups[$cityId] ) ) {
			$this->localExplicitUserGroups[$cityId] = [];
		}
		$this->localExplicitUserGroups[$cityId][$userId] = $groups;
	}

	private function getUserPermissionsArray( $cityId, $userId ) {
		if ( !isset( $this->userPermissions[$cityId] ) || !isset( $this->userPermissions[$cityId][$userId] ) ) {
			return false;
		}
		return $this->userPermissions[$cityId][$userId];
	}

	private function setUserPermissionsArray( $cityId, $userId, $rights ) {
		if ( !isset( $this->userPermissions[$cityId] ) ) {
			$this->userPermissions[$cityId] = [];
		}
		$this->userPermissions[$cityId][$userId] = $rights;
	}

	private function getImplicitUserGroupsArray( $userId ) {
		if ( !isset( $this->implicitUserGroups[$userId] ) ) {
			return false;
		}
		return $this->implicitUserGroups[$userId];
	}

	private function setImplicitUserGroupsArray( $userId, $groups ) {
		$this->implicitUserGroups[$userId] = $groups;
	}

	private function getGlobalUserGroupsArray( $userId ) {
		if ( !isset( $this->globalExplicitUserGroups[$userId] ) ) {
			return false;
		}
		return $this->globalExplicitUserGroups[$userId];
	}

	private function setGlobalUserGroupsArray( $userId, $groups ) {
		$this->globalExplicitUserGroups[$userId] = $groups;
	}

	public function getGlobalGroups() {
		return $this->globalGroups;
	}

	public function getImplicitGroups() {
		return $this->implicitGroups;
	}

	public function getExplicitGroups() {
		return $this->explicitGroups;
	}

	public function getExplicitUserGroups( $cityId, $userId ) {
		return array_unique( array_merge (
			$this->getExplicitLocalUserGroups( $cityId, $userId ),
			$this->getExplicitGlobalUserGroups( $userId )
		) );
	}

	public function getExplicitLocalUserGroups( $cityId, $userId ) {
		$this->loadLocalGroups( $cityId, $userId );
		return $this->getLocalUserGroupsArray( $cityId, $userId );
	}

	public function getExplicitGlobalUserGroups( $userId ) {
		$this->loadGlobalGroups( $userId );
		return $this->getGlobalUserGroupsArray( $userId );
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
		if ( $reCacheAutomaticGroups || $this->getImplicitUserGroupsArray( $user->getId() ) == false ) {
			$implicitGroups = array( '*' );
			if ( $user->getId() ) {
				$implicitGroups[] = 'user';

				$implicitGroups = array_unique( array_merge(
					$implicitGroups,
					\Autopromote::getAutopromoteGroups( $user )
				) );
			}
			$this->setImplicitUserGroupsArray($user->getId(), $implicitGroups);
		}

		return $this->getImplicitUserGroupsArray($user->getId());
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

	/**
	 * Get the permissions associated with a given list of groups
	 *
	 * @param $groups Array of Strings List of internal group names
	 * @return Array of Strings List of permission key names for given groups combined
	 */
	public function getGroupPermissions( $groups ) {
		//TODO remove the global variables
		global $wgGroupPermissions, $wgRevokePermissions;
		$rights = array();
		// grant every granted permission first
		foreach( $groups as $group ) {
			if( isset( $wgGroupPermissions[$group] ) ) {
				$rights = array_merge( $rights,
					// array_filter removes empty items
					array_keys( array_filter( $wgGroupPermissions[$group] ) ) );
			}
		}
		// now revoke the revoked permissions
		foreach( $groups as $group ) {
			if( isset( $wgRevokePermissions[$group] ) ) {
				$rights = array_diff( $rights,
					array_keys( array_filter( $wgRevokePermissions[$group] ) ) );
			}
		}
		return array_unique( $rights );
	}

	/**
	 * Get all the groups who have a given permission
	 *
	 * @param $role String Role to check
	 * @return Array of Strings List of internal group names with the given permission
	 */
	public function getGroupsWithPermission( $role ) {
		//TODO remove the global variable
		global $wgGroupPermissions;
		$allowedGroups = array();
		foreach ( $wgGroupPermissions as $group => $rights ) {
			if ( isset( $rights[$role] ) && $rights[$role] ) {
				$allowedGroups[] = $group;
			}
		}
		return $allowedGroups;
	}

	/**
	 * Get the permissions this user has.
	 * @return Array of String permission names
	 */
	public function getUserPermissions( $cityId, \User $user ) {
		if ( $this->getUserPermissionsArray( $cityId, $user->getId() ) == false ) {
			$permissions = $this->getGroupPermissions( $this->getEffectiveUserGroups( $cityId, $user ) );
			wfRunHooks( 'UserGetRights', array( $this, &$permissions ) );
			$this->setUserPermissionsArray( $cityId, $user->getId(), array_values( $permissions ) );
		}
		return $this->getUserPermissionsArray( $cityId, $user->getId());
	}

	/**
	 * Get a list of all available permissions.
	 * @return Array of permission names
	 */
	public function getPermissions() {
		return $this->permissions;
	}

	private function loadLocalGroups( $cityId, $userId ) {
		$userLocalGroups = $this->getLocalUserGroupsArray( $cityId, $userId );

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
			$this->setLocalUserGroupsArray( $cityId, $userId, $userLocalGroups);
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
		if ( $this->getGlobalUserGroupsArray( $userId ) == false ) {

			if ( empty( $userId ) ) {
				$this->setGlobalUserGroupsArray( $userId, [] );
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
				$this->setGlobalUserGroupsArray( $userId, $globalGroups );
			}
		}
	}
}
