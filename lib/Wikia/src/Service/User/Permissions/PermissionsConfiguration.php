<?php

namespace Wikia\Service\User\Permissions;

class PermissionsConfiguration {

	/** @var string[] - global explicit groups to which a user can be explicitly assigned */
	private $explicitGroups = [];

	/** @var string[string][] - key is the group and value array of groups addable by this group */
	private $groupsAddableByGroup = [];

	/** @var string[string][] - key is the group and value array of groups removable by this group */
	private $groupsRemovableByGroup = [];

	/** @var string[string][] - key is the group and value array of groups self addable */
	private $groupsSelfAddableByGroup = [];

	/** @var string[string][] - key is the group and value array of groups self removable */
	private $groupsSelfRemovableByGroup = [];

	/** @var string[] $restrictedAccessGroups */
	private $restrictedAccessGroups = [];

	/** @var string[] $restrictedAccessExemptGroups */
	private $restrictedAccessExemptGroups = [];

	private $globalGroups = [
		'authenticated',
		'beta',
		'bot-global',
		'content-reviewer',
		'content-volunteer',
		'council',
		'helper',
		'restricted-login',
		'restricted-login-exempt',
		'reviewer',
		'staff',
		'translator',
		'util',
		'vanguard',
		'voldev',
		'soap',
		'fandom-editor',
		'global-discussions-moderator',
		'request-to-be-forgotten-admin',
		'wiki-manager',
		'content-team-member',
	];

	private $implicitGroups = [
		'*',
		'user',
		'autoconfirmed',
		'restricted-login-auto',
	];

	private $permissions = [
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
		'editusercssjs', # deprecated
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
		'wikifactory',
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
		'commentcreate',
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
		'phalanxexempt',
		'phalanx',
		'phalanxemailblock',
		'piggyback',
		'places-enable-category-geolocation',
		'metadata',
		'quicktools',
		'quickadopt',
		'restrictsession',
		'performancestats',
		'messagetool',
		'forceview',
		'edithub',
		'InterwikiEdit',
		'multilookup',
		'newwikislist',
		'restricted_promote',
		'protectsite',
		'protectsite-exempt',
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
		'usermanagement',
		'removeavatar',
		'renameuser',
		'userrollback',
		'wdacreview',
		'WhereIsExtension',
		'smwallowaskpage',
		'council',
		'authenticated',
		'editinterfacetrusted',
		'deleteinterfacetrusted',
		'voldev',
		'wikianavglobal',
		'wikianavlocal',
		'videoupload',
		'mcachepurge',
		'editrestrictedfields',
		'viewedittab',
		'createclass',
		'first-edit-dialog-exempt',
		'hideblockername',
		'clearuserprofile',
		'smw-patternedit',
		'smw-admin',
		'fandom-admin',
		'exportuserdata'
	];

	public function __construct(
		array $wgGroupPermissions, array $wgAddGroupsLocal, array $wgRemoveGroupsLocal,
		array $wgGroupsAddToSelfLocal, array $wgGroupsRemoveFromSelfLocal, array $wgRestrictedAccessGroups,
		array $wgRestrictedAccessExemptGroups
	) {
		$this->explicitGroups = array_diff(
			array_keys( $wgGroupPermissions ),
			$this->implicitGroups
		);

		$this->loadGroupsChangeableByGroups(
			$wgAddGroupsLocal,
			$wgRemoveGroupsLocal,
			$wgGroupsAddToSelfLocal,
			$wgGroupsRemoveFromSelfLocal
		);

		$this->restrictedAccessGroups = $wgRestrictedAccessGroups;
		$this->restrictedAccessExemptGroups = $wgRestrictedAccessExemptGroups;
	}

	/**
	 * @return string[] List of global groups, that is groups to which one is added on all wikis or on none
	 */
	public function getGlobalGroups() {
		return $this->globalGroups;
	}

	/**
	 * Checks if the given group is among the global groups
	 * @param $group string Group name
	 * @return string True if is global group
	 */
	public function isGlobalGroup( $group ) {
		return in_array( $group, $this->getGlobalGroups() );
	}

	/**
	 * @return string[] List of implicit groups,
	 * that is groups to which one is added automatically and not through manual assignment
	 */
	public function getImplicitGroups() {
		return $this->implicitGroups;
	}

	/**
	 * Checks if the given group is among the implicit groups
	 * @param $group string Group name
	 * @return string True if is implicit group
	 */
	public function isImplicitGroup( $group ) {
		return in_array( $group, $this->getImplicitGroups() );
	}

	/**
	 * @return string[] List of explicit groups, that is groups to which one can be manually assigned.
	 * Both global and local.
	 */
	public function getExplicitGroups() {
		return $this->explicitGroups;
	}

	/**
	 * Checks if the given group is among the explicit groups
	 * @param $group string Group name
	 * @return string True if is explicit group
	 */
	public function isExplicitGroup( $group ) {
		return in_array( $group, $this->getExplicitGroups() );
	}

	/**
	 * @return string[] List of all defined permissions
	 */
	public function getPermissions() {
		return $this->permissions;
	}

	/**
	 * Get the permissions associated with a given list of groups
	 *
	 * @param $groups string[] List of internal group names
	 * @return string[] List of permission key names for given groups combined
	 */
	public function getGroupPermissions( $groups ) {
		global $wgGroupPermissions;
		$rights = array();
		// grant every granted permission first
		foreach ( $groups as $group ) {
			if ( isset( $wgGroupPermissions[$group] ) ) {
				$rights = array_merge( $rights,
					// array_filter removes empty items
					array_keys( array_filter( $wgGroupPermissions[$group] ) ) );
			}
		}
		return array_values( array_unique( $rights ) );
	}

	/**
	 * Get all the groups who have a given permission
	 *
	 * @param $permission String Permissions to check
	 * @return string[] List of internal group names with the given permission
	 */
	public function getGroupsWithPermission( $permission ) {
		global $wgGroupPermissions;
		$allowedGroups = array();
		foreach ( $wgGroupPermissions as $group => $rights ) {
			if ( isset( $rights[$permission] ) && $rights[$permission] ) {
				$allowedGroups[] = $group;
			}
		}
		return $allowedGroups;
	}

	/**
	 * Returns an array of the groups that a particular group can add/remove.
	 *
	 * @param $group String: the group to check for whether it can add/remove
	 * @return array array( 'add' => array( addablegroups ),
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

	private function loadGroupsChangeableByGroups(
		array $wgAddGroupsLocal, array $wgRemoveGroupsLocal, array $wgGroupsAddToSelfLocal, array $wgGroupsRemoveFromSelfLocal
	) {
		$this->groupsAddableByGroup['bureaucrat'] = [ 'bureaucrat', 'rollback', 'sysop', 'content-moderator' ];
		$this->groupsRemovableByGroup['bureaucrat'] = [ 'rollback', 'sysop', 'bot', 'content-moderator' ];
		$this->groupsSelfRemovableByGroup['bureaucrat'] = [ 'bureaucrat' ];

		$this->groupsAddableByGroup['staff'] = [ 'rollback', 'bot', 'sysop', 'bureaucrat', 'content-moderator', 'chatmoderator', 'threadmoderator', 'fandom-editor', 'global-discussions-moderator', 'content-volunteer' ];
		$this->groupsRemovableByGroup['staff'] = [ 'rollback', 'bot', 'sysop', 'bureaucrat', 'content-moderator', 'chatmoderator', 'threadmoderator', 'fandom-editor', 'global-discussions-moderator', 'content-volunteer' ];

		$this->groupsAddableByGroup['wiki-manager'] = [ 'rollback', 'bot', 'sysop', 'bureaucrat', 'content-moderator', 'chatmoderator', 'threadmoderator' ];
		$this->groupsRemovableByGroup['wiki-manager'] = [ 'rollback', 'bot', 'sysop', 'bureaucrat', 'content-moderator', 'chatmoderator', 'threadmoderator' ];

		$this->groupsAddableByGroup['helper'] = [ 'rollback', 'bot', 'sysop', 'bureaucrat', 'content-moderator', 'chatmoderator', 'threadmoderator' ];
		$this->groupsRemovableByGroup['helper'] = [ 'rollback', 'bot', 'sysop', 'bureaucrat', 'content-moderator', 'chatmoderator', 'threadmoderator' ];

		$this->groupsAddableByGroup['sysop'] = [ 'chatmoderator', 'threadmoderator' ];
		$this->groupsRemovableByGroup['sysop'] = [ 'chatmoderator', 'threadmoderator' ];
		$this->groupsSelfRemovableByGroup['sysop'] = [ 'sysop' ];

		$this->groupsAddableByGroup['content-reviewer'] = [ 'content-reviewer' ];
		$this->groupsRemovableByGroup['content-reviewer'] = [ 'content-reviewer' ];

		$this->groupsSelfAddableByGroup['soap'] = [ 'rollback', 'bot', 'sysop' ];
		$this->groupsSelfRemovableByGroup['soap'] = [ 'rollback', 'bot', 'sysop', 'bureaucrat' ];

		$this->groupsSelfRemovableByGroup['chatmoderator'] = [ 'chatmoderator' ];
		$this->groupsSelfRemovableByGroup['threadmoderator'] = [ 'threadmoderator' ];
		$this->groupsSelfRemovableByGroup['content-moderator'] = [ 'content-moderator' ];
		$this->groupsSelfRemovableByGroup['bot'] = [ 'bot' ];
		$this->groupsSelfRemovableByGroup['rollback'] = [ 'rollback' ];
		$this->groupsSelfRemovableByGroup['vanguard'] = [ 'vanguard' ];
		$this->groupsSelfRemovableByGroup['global-discussions-moderator'] = [ 'global-discussions-moderator' ];

		// the $wgXXXLocal variables are loaded from wiki factory - we should use it as is
		$this->groupsAddableByGroup = array_merge( $this->groupsAddableByGroup, $wgAddGroupsLocal );
		$this->groupsRemovableByGroup = array_merge( $this->groupsRemovableByGroup, $wgRemoveGroupsLocal );
		$this->groupsSelfAddableByGroup = array_merge( $this->groupsSelfAddableByGroup, $wgGroupsAddToSelfLocal );
		$this->groupsSelfRemovableByGroup = array_merge( $this->groupsSelfRemovableByGroup, $wgGroupsRemoveFromSelfLocal );

		//This group management control should be always possible, independently of any local customization that might
		//override default group control
		$this->groupsAddableByGroup['bureaucrat'] = array_unique( array_merge( $this->groupsAddableByGroup['bureaucrat'],
			[ 'content-moderator' ] ) );
		$this->groupsRemovableByGroup['bureaucrat'] = array_unique( array_merge( $this->groupsRemovableByGroup['bureaucrat'],
			[ 'content-moderator' ] ) );
		$this->groupsAddableByGroup['sysop'] = array_unique( array_merge( $this->groupsAddableByGroup['sysop'],
			[ 'chatmoderator', 'threadmoderator' ] ) );
		$this->groupsRemovableByGroup['sysop'] = array_unique( array_merge( $this->groupsRemovableByGroup['sysop'],
			[ 'chatmoderator', 'threadmoderator' ] ) );

		$this->groupsAddableByGroup['util'] = array_diff( $this->getExplicitGroups(),
			array_merge( [ 'content-reviewer', 'staff', 'util', 'restricted-login-exempt' ], $this->getImplicitGroups() ) );
		$this->groupsRemovableByGroup['util'] = array_diff( $this->getExplicitGroups(),
			array_merge( [ 'restricted-login', 'restricted-login-exempt' ], $this->getImplicitGroups() ) );
	}

	public function getRestrictedAccessGroups() {
		return $this->restrictedAccessGroups;
	}

	public function getRestrictedAccessExemptGroups() {
		return $this->restrictedAccessExemptGroups;
	}
}
