<?php

namespace Wikia\Service\User\Permissions;

use Wikia\Util\WikiaProfiler;
use Wikia\Logger\Loggable;

class PermissionsServiceImpl implements PermissionsService {

	use Loggable;

	/** @var string[string] - key is user id */
	private $localExplicitUserGroups = [];

	/** @var string[string] - key is the user id */
	private $globalExplicitUserGroups = [];

	/** @var string[string] - key is the user id */
	private $implicitUserGroups = [];

	/** @var string[string] - key is user id */
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

	private function getLocalUserGroupsArray( $userId ) {
		if ( !isset( $this->localExplicitUserGroups[$userId] ) ) {
			return false;
		}
		return $this->localExplicitUserGroups[$userId];
	}

	private function setLocalUserGroupsArray( $userId, $groups ) {
		$this->localExplicitUserGroups[$userId] = $groups;
	}

	private function getUserPermissionsArray( $userId ) {
		if ( !isset( $this->userPermissions[$userId] ) ) {
			return false;
		}
		return $this->userPermissions[$userId];
	}

	private function setUserPermissionsArray( $userId, $rights ) {
		$this->userPermissions[$userId] = $rights;
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
		$this->globalGroups[] = 'council';
		$this->globalGroups[] = 'authenticated';
		$this->globalGroups[] = 'wikiastars';
		$this->globalGroups[] = 'restricted-login';
		$this->globalGroups[] = 'voldev';
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
			'canremovemap',
			'wikiawidget',
			'wikifactory',
			'wikifactorymetrics',
			'dumpsondemand',
			'wikifeatures',
			'MultiFileUploader',
			'allowedtoblank',
			'batchmove',
			'linkstoredirects',
			'mobilesearches',
			'soapfailures',
			'moderatesotd',
			'hiderevision',
			'oversight',
			'abusefilter-modify',
			'abusefilter-log-detail',
			'abusefilter-view',
			'abusefilter-log',
			'abusefilter-private',
			'abusefilter-modify-restricted',
			'abusefilter-revert',
			'abusefilter-view-private',
			'abusefilter-hidden-log',
			'abusefilter-hide-log',
			'override-antispoof',
			'checkuser',
			'checkuser-log',
			'geocode',
			'nuke',
			'refreshspecial',
			'replacetext',
			'spamregex',
			'tboverride', 	// Implies tboverride-account
			'tboverride-account', 	// For account creation
			'torunblocked',
			'abusefilter-bypass',
			'platinum',
			'sponsored-achievements',
			'achievements-exempt',
			'achievements-explicit',
			'admindashboard',
			'commentmove',
			'commentedit',
			'commentdelete',
			'becp_user',
			'blog-comments-toggle',
			'blog-comments-delete',
			'blog-articles-edit',
			'blog-articles-move',
			'blog-articles-protect',
			'blog-auto-follow',
			'skipcaptcha',
			'chatmoderator',
			'chat',
			'commentcsv',
			'content-review',
			'content-review-test-mode',
			'coppatool',
			'createnewwiki',
			'createwikilimitsexempt',  // user not bound by creation throttle
			'finishcreate',
			'devboxpanel',
			'dmcarequestmanagement',
			'editaccount',
			'emailsstorage',
			'flags-administration',
			'forum',
			'boardedit',
			'forumadmin',
			'welcomeexempt',
			'coppaimagereview',
			'imagereview',
			'questionableimagereview',
			'rejectedimagereview',
			'imagereviewstats',
			'imagereviewcontrols',
			'promoteimagereview',
			'promoteimagereviewquestionableimagereview',
			'promoteimagereviewrejectedimagereview',
			'promoteimagereviewstats',
			'promoteimagereviewcontrols',
			'insights',
			'listusers',
			'lookupcontribs',
			'lookupuser',
			'minieditor-specialpage',
			'multidelete',
			'multiwikiedit',
			'multiwikifinder',
			'njordeditmode',
			'phalanxexempt',
			'phalanx',
			'phalanxemailblock',
			'piggyback',
			'places-enable-category-geolocation',
			'metadata',
			'powerdelete',
			'quicktools',
			'quickadopt',
			'regexblock',
			'restrictsession',
			'scribeevents',
			'performancestats',
			'messagetool',
			'forceview',
			'apigate_admin',
			'batchuserrights',
			'edithub',
			'InterwikiEdit',
			'multilookup',
			'newwikislist',
			'restricted_promote',
			'protectsite',
			'stafflog',
			'unblockable',
			'tagsreport',
			'taskmanager',
			'taskmanager-action',
			'tasks-user',
			'template-bulk-classification',
			'templatedraft',
			'textregex',
			'themedesigner',
			'toplists-create-edit-list',
			'toplists-create-item',
			'toplists-edit-item',
			'toplists-delete-item',
			'usermanagement',
			'removeavatar',
			'renameuser',
			'userrollback',
			'specialvideohandler',
			'uploadpremiumvideo',
			'wdacreview',
			'WhereIsExtension',
			'smwallowaskpage',
			'council',
			'authenticated',
			'displaywikiastarslabel',
			'editinterfacetrusted',
			'deleteinterfacetrusted',
			'voldev',
			'wikianavglobal',
			'wikianavlocal',
			'videoupload',
			'mcachepurge',
			'editrestrictedfields',
			'viewedittab',
			'createclass'
		);
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
		$this->groupsSelfRemovableByGroup['sysop'] = array('sysop');

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

		$this->groupsAddableByGroup['util'] = array_diff( $this->getExplicitGroups(),
			array_merge( [ 'wikifactory', 'content-reviewer' ], $this->getImplicitGroups() ) );
		$this->groupsRemovableByGroup['util'] = array_diff( $this->getExplicitGroups(), $this->getImplicitGroups() );

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

	public function getExplicitUserGroups( $userId ) {
		return array_unique( array_merge (
			$this->getExplicitLocalUserGroups( $userId ),
			$this->getExplicitGlobalUserGroups( $userId )
		) );
	}

	public function getExplicitLocalUserGroups( $userId ) {
		$this->loadLocalGroups( $userId );
		return $this->getLocalUserGroupsArray( $userId );
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
	public function getEffectiveUserGroups( \User $user, $reCacheAutomaticGroups = false ) {

		return array_unique( array_merge(
			$this->getExplicitUserGroups( $user->getId() ),
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
	public function getUserPermissions( \User $user ) {
		if ( $this->getUserPermissionsArray( $user->getId() ) == false ) {
			$permissions = $this->getGroupPermissions( $this->getEffectiveUserGroups( $user ) );
			wfRunHooks( 'UserGetRights', array( $user, &$permissions ) );
			$this->setUserPermissionsArray( $user->getId(), array_values( $permissions ) );
		}
		return $this->getUserPermissionsArray( $user->getId());
	}

	/**
	 * Get a list of all available permissions.
	 * @return Array of permission names
	 */
	public function getPermissions() {
		return $this->permissions;
	}

	private function loadLocalGroups( $userId ) {
		$userLocalGroups = $this->getLocalUserGroupsArray( $userId );

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
			$this->setLocalUserGroupsArray( $userId, $userLocalGroups);
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

	private function canGroupBeAdded( \User $userPerformingChange, \User $userToChange, $group ) {
		$groups = $this->getGroupsChangeableByUser( $userPerformingChange );
		if ( in_array($group, $groups['add']) ) {
			return true;
		}
		if ( $userPerformingChange->getId() == $userToChange->getId() && in_array($group, $groups['add-self'] ) ) {
			return true;
		}

		return false;
	}

	private function canGroupBeRemoved( \User $userPerformingChange, \User $userToChange, $group ) {
		$groups = $this->getGroupsChangeableByUser( $userPerformingChange );
		if ( in_array($group, $groups['remove']) ) {
			return true;
		}
		if ( $userPerformingChange->getId() == $userToChange->getId() && in_array($group, $groups['remove-self'] ) ) {
			return true;
		}

		return false;
	}

	public function addUserToGroup( \User $userPerformingChange, \User $userToChange, $group ) {
		if ( !$this->canGroupBeAdded( $userPerformingChange, $userToChange, $group ) ) {
			return false;
		}

		//Is global group
		if ( in_array( $group, $this->getGlobalGroups() ) ) {
			return $this->addUserToGlobalGroup( $userToChange, $group );
		} else {
			return $this->addUserToLocalGroup( $userToChange, $group );
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

	public function removeUserFromGroup( \User $userPerformingChange, \User $userToChange, $group ) {
		if ( !$this->canGroupBeRemoved( $userPerformingChange, $userToChange, $group ) ) {
			return false;
		}

		if ( in_array( $group, $this->getGlobalGroups() ) ) {
			return $this->removeUserFromGlobalGroup( $userToChange, $group );
		} else {
			return $this->removeUserFromLocalGroup( $userToChange, $group );
		}
	}

	private function invalidateUserGroupsAndPermissions( $userId ) {
		unset( $this->userPermissions[$userId] );
		unset( $this->localExplicitUserGroups[$userId] );
		unset( $this->implicitUserGroups[$userId] );
		unset( $this->globalExplicitUserGroups[$userId] );
	}


	public function doesUserHavePermission( \User $user, $permission ) {
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
		return in_array( $permission, $this->getUserPermissions( $user ), true );
	}

	public function doesUserHaveAllPermissions( \User $user, $permissions ) {
		foreach( $permissions as $permission ){
			if( !$this->doesUserHavePermission( $user, $permission ) ){
				return false;
			}
		}
		return true;
	}

	public function doesUserHaveAnyPermission( \User $user, $permissions ) {
		foreach( $permissions as $permission ){
			if( $this->doesUserHavePermission( $user, $permission ) ){
				return true;
			}
		}
		return false;
	}

	/**
	 * Returns an array of groups that this user can add and remove
	 * @return Array array( 'add' => array( addablegroups ),
	 *  'remove' => array( removablegroups ),
	 *  'add-self' => array( addablegroups to self),
	 *  'remove-self' => array( removable groups from self) )
	 */
	public function getGroupsChangeableByUser( \User $user ) {
		if( $this->doesUserHavePermission( $user, 'userrights' ) ) {
			// This group gives the right to modify everything (reverse-
			// compatibility with old "userrights lets you change
			// everything")
			// Using array_merge to make the groups reindexed
			$all = array_merge( $this->getExplicitGroups() );
			return array(
				'add' => $all,
				'remove' => $all,
				'add-self' => array(),
				'remove-self' => array()
			);
		}

		// Okay, it's not so simple, we will have to go through the arrays
		$groups = array(
			'add' => array(),
			'remove' => array(),
			'add-self' => array(),
			'remove-self' => array()
		);
		$addergroups = $this->getEffectiveUserGroups( $user );

		foreach( $addergroups as $addergroup ) {
			$groups = array_merge_recursive(
				$groups, $this->getGroupsChangeableByGroup( $addergroup )
			);
			$groups['add']    = array_unique( $groups['add'] );
			$groups['remove'] = array_unique( $groups['remove'] );
			$groups['add-self'] = array_unique( $groups['add-self'] );
			$groups['remove-self'] = array_unique( $groups['remove-self'] );
		}
		return $groups;
	}
}
