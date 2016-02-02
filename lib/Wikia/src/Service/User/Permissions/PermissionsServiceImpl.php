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

	/** @var string[string] - key is the user id */
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

	/** @var string[string][] - key is the group and value array of groups addable by this group */
	private $groupsAddableByGroup = [];

	/** @var string[string][] - key is the group and value array of groups removable by this group */
	private $groupsRemovableByGroup = [];

	/** @var string[string][] - key is the group and value array of groups self addable */
	private $groupsSelfAddableByGroup = [];

	/** @var string[string][] - key is the group and value array of groups self removable */
	private $groupsSelfRemovableByGroup = [];

	public function __construct() {
		$this->loadGlobalGroups();
		$this->loadImplicitGroups();
		$this->loadExplicitGroups();
		$this->loadPermissions();
		$this->loadGroupsChangeableByGroups();
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

	private function loadGlobalGroups() {
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
	}

	private function loadImplicitGroups() {
		$this->implicitGroups[] = '*';
		$this->implicitGroups[] = 'user';
		$this->implicitGroups[] = 'autoconfirmed';
		$this->implicitGroups[] = 'poweruser';
	}

	private function loadExplicitGroups() {
		//TODO need to remove the $wgGroupPermissions and $wgRevokePermissions variables
		global $wgGroupPermissions, $wgRevokePermissions;
		$this->explicitGroups = array_diff(
			array_merge( array_keys( $wgGroupPermissions ), array_keys( $wgRevokePermissions ) ),
			$this->implicitGroups
		);
	}

	private function loadPermissions() {
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
	}

	private function loadGroupsChangeableByGroups() {
		$this->groupsAddableByGroup['bureaucrat'] = array('bureaucrat', 'rollback', 'sysop', 'content-moderator', 'threadmoderator');
		$this->groupsRemovableByGroup['bureaucrat'] = array('rollback', 'sysop', 'bot', 'content-moderator', 'threadmoderator');
		$this->groupsSelfRemovableByGroup['bureaucrat'] = array('rollback', 'sysop', 'bot', 'content-moderator');

		$this->groupsAddableByGroup['staff'] = array('rollback', 'bot', 'sysop', 'bureaucrat', 'content-moderator', 'chatmoderator', 'translator', 'threadmoderator');
		$this->groupsRemovableByGroup['staff'] = array('rollback', 'bot', 'sysop', 'bureaucrat', 'content-moderator', 'chatmoderator', 'translator', 'threadmoderator');

		$this->groupsAddableByGroup['helper'] = array('rollback', 'bot', 'sysop', 'bureaucrat', 'chatmoderator', 'threadmoderator');
		$this->groupsRemovableByGroup['helper'] = array('rollback', 'bot', 'sysop', 'bureaucrat', 'chatmoderator', 'threadmoderator');

		$this->groupsAddableByGroup['sysop'] = array('chatmoderator', 'threadmoderator');
		$this->groupsRemovableByGroup['sysop'] = array('chatmoderator', 'threadmoderator');

		$this->groupsAddableByGroup['content-reviewer'] = array('content-reviewer');
		$this->groupsRemovableByGroup['content-reviewer'] = array('content-reviewer');

		$this->groupsAddableByGroup['vstf'] = array('rollback', 'bot');
		$this->groupsRemovableByGroup['vstf'] = array('rollback', 'bot');
		$this->groupsSelfAddableByGroup['vstf'] = array('sysop');
		$this->groupsSelfRemovableByGroup['vstf'] = array('sysop', 'bureaucrat');

		//the $wgXXXLocal variables are loaded from wiki factory - we should use it as is
		if ( !empty( $wgAddGroupsLocal ) )
			$this->groupsAddableByGroup = array_merge( $this->groupsAddableByGroup, $wgAddGroupsLocal );
		if ( !empty( $wgRemoveGroupsLocal ) )
			$this->groupsRemovableByGroup = array_merge( $this->groupsRemovableByGroup, $wgRemoveGroupsLocal );
		if ( !empty( $wgGroupsAddToSelfLocal ) )
			$this->groupsSelfAddableByGroup = array_merge( $this->groupsSelfAddableByGroup, $wgGroupsAddToSelfLocal );
		if ( !empty( $wgGroupsRemoveFromSelfLocal ) )
			$this->groupsSelfRemovableByGroup = array_merge( $this->groupsSelfRemovableByGroup, $wgGroupsRemoveFromSelfLocal );

		$this->groupsAddableByGroup['util'] =
			array_diff( $this->getExplicitGroups(), array_merge( [ 'wikifactory' ], $this->getImplicitGroups() ) );
		$this->groupsRemovableByGroup['util'] =
			array_diff( $this->getExplicitGroups(), $this->getImplicitGroups() );

		global $wgDevelEnvironment;
		if ( !empty( $wgDevelEnvironment )) {
			$this->groupsAddableByGroup['staff'] = $this->getExplicitGroups();
			$this->groupsRemovableByGroup['staff'] = $this->getExplicitGroups();
			$this->groupsSelfAddableByGroup['staff'] = $this->getExplicitGroups();
			$this->groupsSelfRemovableByGroup['staff'] = $this->getExplicitGroups();
		}
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
		$this->loadGlobalUserGroups( $userId );
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

	private function loadGlobalUserGroups( $userId ) {
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

	/**
	 * Returns an array of the groups that a particular group can add/remove.
	 *
	 * @param $group String: the group to check for whether it can add/remove
	 * @return Array array( 'add' => array( addablegroups ),
	 *     'remove' => array( removablegroups ),
	 *     'add-self' => array( addablegroups to self),
	 *     'remove-self' => array( removable groups from self) )
	 */
	public function getGroupsChangeableByGroup( $group ) {
		$groups = array( 'add' => array(), 'remove' => array(), 'add-self' => array(), 'remove-self' => array() );

		if ( array_key_exists( $group, $this->groupsAddableByGroup ) ) {
			$groups['add'] = $this->groupsAddableByGroup[$group];
		}

		if ( array_key_exists( $group, $this->groupsRemovableByGroup ) ) {
			$groups['remove'] = $this->groupsRemovableByGroup[$group];
		}

		if ( array_key_exists( $group, $this->groupsSelfAddableByGroup ) ) {
			$groups['add-self'] = $this->groupsSelfAddableByGroup[$group];
		}

		if ( array_key_exists( $group, $this->groupsSelfRemovableByGroup ) ) {
			$groups['remove-self'] = $this->groupsSelfRemovableByGroup[$group];
		}

		return $groups;
	}

	private function isBlockedContentReviewGroupAddition( $group ) {
		global $wgUser;

		//TODO would be good to change this to not have such hard coded group specific checks
		//TODO also remove usage of wgUser
		if ( $group === 'content-reviewer' && ( !$wgUser->isAllowed( 'content-review' ) || !$wgUser->isStaff() ) ) {
			return true;
		}

		return false;
	}

	private function isCentralWiki() {
		global $wgWikiaIsCentralWiki;
		return (bool)$wgWikiaIsCentralWiki;
	}

	private function addUserToGlobalGroup( \User $user, $group ) {
		if ( !$this->isCentralWiki() ) {
			return false;
		}

		// Purge cache first so in case of DB failure we don't leave inconsistent data in cache
		\WikiaDataAccess::cachePurge( self::getMemcKey( $user->getId() ) );
		$this->invalidateUserGroupsAndPermissions( $user->getId() );

		$dbw = self::getSharedDB( DB_MASTER );
		if ( $user->getId() ) {
			$dbw->insert( 'user_groups',
				[
					'ug_user'  => $user->getID(),
					'ug_group' => $group,
				],
				__METHOD__
			);
		}

		//This calls ExactTarget updates
		wfRunHooks( 'AfterUserAddGlobalGroup', [ $user, $group ] );
		return true;
	}

	private function addUserToLocalGroup( \User $user, $group ) {
		$dbw = wfGetDB( DB_MASTER );
		if( $user->getId() ) {
			$dbw->insert( 'user_groups',
				array(
					'ug_user'  => $user->getId(),
					'ug_group' => $group,
				),
				__METHOD__,
				array( 'IGNORE' ) );
		}
		$this->invalidateUserGroupsAndPermissions( $user->getId() );

		return true;
	}

	public function addUserToGroup( \User $user, $group ) {
		if ( $this->isBlockedContentReviewGroupAddition( $group ) ) {
			return false;
		}

		//Is global group
		if ( in_array( $group, $this->getGlobalGroups() ) ) {
			return $this->addUserToGlobalGroup( $user, $group );
		} else {
			return $this->addUserToLocalGroup( $user, $group );
		}
	}

	private function removeUserFromGlobalGroup( \User $user, $group ) {
		if ( !$this->isCentralWiki() ) {
			return false;
		}

		// Purge cache first so in case of DB failure we don't leave inconsistent data in cache
		\WikiaDataAccess::cachePurge( self::getMemcKey( $user->getId() ) );
		$this->invalidateUserGroupsAndPermissions( $user->getId() );

		$dbw = self::getSharedDB( DB_MASTER );
		$dbw->delete( 'user_groups',
			[
				'ug_user'  => $user->getID(),
				'ug_group' => $group,
			],
			__METHOD__
		);

		//This calls ExactTarget updates
		wfRunHooks( 'AfterUserRemoveGlobalGroup', [ $user, $group ] );

		return true;
	}

	private function removeUserFromLocalGroup( \User $user, $group ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'user_groups',
			array(
				'ug_user'  => $user->getId(),
				'ug_group' => $group,
			), __METHOD__ );

		$this->invalidateUserGroupsAndPermissions( $user->getId() );

		return true;
	}

	public function removeUserFromGroup( \User $user, $group ) {
		if ( in_array( $group, $this->getGlobalGroups() ) ) {
			return $this->removeUserFromGlobalGroup( $user, $group );
		} else {
			return $this->removeUserFromLocalGroup( $user, $group );
		}
	}

	private function invalidateUserGroupsAndPermissions( $userId ) {
		foreach ( $this->userPermissions as &$userData ) {
			unset( $userData[$userId] );
		}
		foreach ( $this->localExplicitUserGroups as &$userData ) {
			unset( $userData[$userId] );
		}
		unset( $this->implicitUserGroups[$userId] );
		unset( $this->globalExplicitUserGroups[$userId] );
	}


	public function doesUserHavePermission( $cityId, \User $user, $permission ) {
		if ( $permission === '' ) {
			return true; // In the spirit of DWIM
		}
		# Patrolling may not be enabled
		if( $permission === 'patrol' || $permission === 'autopatrol' ) {
			global $wgUseRCPatrol, $wgUseNPPatrol;
			if( !$wgUseRCPatrol && !$wgUseNPPatrol )
				return false;
		}
		# Use strict parameter to avoid matching numeric 0 accidentally inserted
		# by misconfiguration: 0 == 'foo'
		return in_array( $permission, $this->getUserPermissions( $cityId, $user ), true );
	}

	public function doesUserHaveAllPermissions( $cityId, \User $user, $permissions ) {
		foreach( $permissions as $permission ){
			if( !$this->doesUserHavePermission( $cityId, $user, $permission ) ){
				return false;
			}
		}
		return true;
	}

	public function doesUserHaveAnyPermission( $cityId, \User $user, $permissions ) {
		foreach( $permissions as $permission ){
			if( $this->doesUserHavePermission( $cityId, $user, $permission ) ){
				return true;
			}
		}
		return false;
	}
}
