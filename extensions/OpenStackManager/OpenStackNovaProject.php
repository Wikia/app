<?php

class OpenStackNovaProject {

	var $projectname;
	var $projectDN;
	var $projectInfo;
	var $roles;

	static $rolenames = array( 'sysadmin', 'netadmin' );

	/**
	 * @param  $projectname
	 */
	function __construct( $projectname ) {
		$this->projectname = $projectname;
		OpenStackNovaLdapConnection::connect();
		$this->fetchProjectInfo();
	}

	/**
	 * Fetch the project from LDAP and initialize the object
	 * @return void
	 */
	function fetchProjectInfo() {
		global $wgAuth;
		global $wgOpenStackManagerLDAPProjectBaseDN;

		$result = LdapAuthenticationPlugin::ldap_search( $wgAuth->ldapconn, $wgOpenStackManagerLDAPProjectBaseDN,
								'(&(cn=' . $this->projectname . ')(owner=*))' );
		$this->projectInfo = LdapAuthenticationPlugin::ldap_get_entries( $wgAuth->ldapconn, $result );
		$this->projectDN = $this->projectInfo[0]['dn'];
		$this->roles = array();
		foreach ( self::$rolenames as $rolename ) {
			$this->roles[] = OpenStackNovaRole::getProjectRoleByName( $rolename, $this );
		}
	}

	/**
	 * @return  string
	 */
	function getProjectName() {
		return $this->projectname;
	}

	/**
	 * Return all roles for this project
	 * @return array
	 */
	function getRoles() {
		return $this->roles;
	}

	/**
	 * Return all users who are a member of this project
	 *
	 * @return array
	 */
	function getMembers() {
		global $wgAuth;

		$members = array();
		if ( isset( $this->projectInfo[0]['member'] ) ) {
			$memberdns = $this->projectInfo[0]['member'];
			array_shift( $memberdns );
			foreach ( $memberdns as $memberdn ) {
				$searchattr = $wgAuth->getConf( 'SearchAttribute' );
				if ( $searchattr ) {
					// We need to look up the search attr from the user entry
					// this is expensive, but must be done.
					// TODO: memcache this
					$userInfo = $wgAuth->getUserInfoStateless( $memberdn );
					$members[] = $userInfo[0][$searchattr][0];
				} else {
					$member = explode( '=', $memberdn );
					$member = explode( ',', $member[1] );
					$member = $member[0];
					$members[] = $member;
				}
			}
		}

		return $members;
	}

	/**
	 * Remove a member from the project based on username
	 *
	 * @param  $username string
	 * @return bool
	 */
	function deleteMember( $username ) {
		global $wgAuth;

		if ( isset( $this->projectInfo[0]['member'] ) ) {
			$members = $this->projectInfo[0]['member'];
			array_shift( $members );
			$user = new OpenStackNovaUser( $username );
			if ( ! $user->userDN ) {
				$wgAuth->printDebug( "Failed to find userDN in deleteMember", NONSENSITIVE );
				return false;
			}
			$index = array_search( $user->userDN, $members );
			if ( $index === false ) {
				$wgAuth->printDebug( "Failed to find userDN in member list", NONSENSITIVE );
				return false;
			}
			unset( $members[$index] );
			$values = array();
			$values['member'] = array();
			foreach ( $members as $member ) {
				$values['member'][] = $member;
			}
			$success = LdapAuthenticationPlugin::ldap_modify( $wgAuth->ldapconn, $this->projectDN, $values );
			if ( $success ) {
				foreach ( $this->roles as $role ) {
					$success = $role->deleteMember( $username );
					#TODO: Find a way to fail gracefully if role member
					# deletion fails
				}
				$this->fetchProjectInfo();
				$wgAuth->printDebug( "Successfully removed $user->userDN from $this->projectDN", NONSENSITIVE );
				return true;
			} else {
				$wgAuth->printDebug( "Failed to remove $user->userDN from $this->projectDN", NONSENSITIVE );
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * Add a member to this project based on username
	 *
	 * @param $username string
	 * @return bool
	 */
	function addMember( $username ) {
		global $wgAuth;

		$members = array();
		if ( isset( $this->projectInfo[0]['member'] ) ) {
			$members = $this->projectInfo[0]['member'];
			array_shift( $members );
		}
		$user = new OpenStackNovaUser( $username );
		if ( ! $user->userDN ) {
			$wgAuth->printDebug( "Failed to find userDN in addMember", NONSENSITIVE );
			return false;
		}
		$members[] = $user->userDN;
		$values = array();
		$values['member'] = $members;
		$success = LdapAuthenticationPlugin::ldap_modify( $wgAuth->ldapconn, $this->projectDN, $values );
		if ( $success ) {
			$this->fetchProjectInfo();
			$wgAuth->printDebug( "Successfully added $user->userDN to $this->projectDN", NONSENSITIVE );
			return true;
		} else {
			$wgAuth->printDebug( "Failed to add $user->userDN to $this->projectDN", NONSENSITIVE );
			return false;
		}
	}

	/**
	 * Return a project by its project name. Returns null if the project does not exist.
	 *
	 * @static
	 * @param  $projectname
	 * @return null|OpenStackNovaProject
	 */
	static function getProjectByName( $projectname ) {
		$project = new OpenStackNovaProject( $projectname );
		if ( $project->projectInfo ) {
			return $project;
		} else {
			return null;
		}
	}

	/**
	 * Return all existing projects. Returns an empty array if no projects exist.
	 *
	 * @static
	 * @return array
	 */
	static function getAllProjects() {
		global $wgAuth;
		global $wgOpenStackManagerLDAPProjectBaseDN;

		OpenStackNovaLdapConnection::connect();

		$projects = array();
		$result = LdapAuthenticationPlugin::ldap_search( $wgAuth->ldapconn, $wgOpenStackManagerLDAPProjectBaseDN, '(owner=*)' );
		if ( $result ) {
			$entries = LdapAuthenticationPlugin::ldap_get_entries( $wgAuth->ldapconn, $result );
			if ( $entries ) {
				# First entry is always a count
				array_shift( $entries );
				foreach ( $entries as $entry ) {
					$project = new OpenStackNovaProject( $entry['cn'][0] );
					array_push( $projects, $project );
				}
			}
		}

		return $projects;
	}

	/**
	 * Create a new project based on project name. This function will also create
	 * all roles needed by the project.
	 *
	 * @static
	 * @param  $projectname
	 * @return bool
	 */
	static function createProject( $projectname ) {
		global $wgAuth;
		global $wgOpenStackManagerLDAPUser;
		global $wgOpenStackManagerLDAPProjectBaseDN;

		OpenStackNovaLdapConnection::connect();

		$project = array();
		$project['objectclass'][] = 'groupofnames';
		$project['objectclass'][] = 'posixgroup';
		$project['cn'] = $projectname;
		$project['owner'] = $wgOpenStackManagerLDAPUser;
		$project['gidnumber'] = OpenStackNovaUser::getNextIdNumber( $wgAuth, 'gidnumber' );
		$projectdn = 'cn=' . $projectname . ',' . $wgOpenStackManagerLDAPProjectBaseDN;

		$success = LdapAuthenticationPlugin::ldap_add( $wgAuth->ldapconn, $projectdn, $project );
		$project = new OpenStackNovaProject( $projectname );
		if ( $success ) {
			foreach ( self::$rolenames as $rolename ) {
				$role = OpenStackNovaRole::createRole( $rolename, $project );
				# TODO: If role addition fails, find a way to fail gracefully
				# Though, if the project was added successfully, it is unlikely
				# that role addition will fail.
			}
			$wgAuth->printDebug( "Successfully added project $projectname", NONSENSITIVE );
			return true;
		} else {
			$wgAuth->printDebug( "Failed to add project $projectname", NONSENSITIVE );
			return false;
		}
	}

	/**
	 * Deletes a project based on project name. This function will also delete all roles
	 * associated with the project.
	 *
	 * @param  $projectname String
	 * @return bool
	 */
	static function deleteProject( $projectname ) {
		global $wgAuth;

		OpenStackNovaLdapConnection::connect();

		$project = new OpenStackNovaProject( $projectname );
		if ( ! $project ) {
			return false;
		}
		$dn = $project->projectDN;

		# Projects can have roles as sub-entries, we need to delete them first
		$result = LdapAuthenticationPlugin::ldap_list( $wgAuth->ldapconn, $dn, 'objectclass=*' );
		$roles = LdapAuthenticationPlugin::ldap_get_entries( $wgAuth->ldapconn, $result );
		array_shift( $roles );
		foreach ( $roles as $role ) {
			$roledn = $role['dn'];
			$success = LdapAuthenticationPlugin::ldap_delete( $wgAuth->ldapconn, $roledn );
			if ( $success ){
				$wgAuth->printDebug( "Successfully deleted role $roledn", NONSENSITIVE );
			} else {
				$wgAuth->printDebug( "Failed to delete role $roledn", NONSENSITIVE );
			}
		}
		$success = LdapAuthenticationPlugin::ldap_delete( $wgAuth->ldapconn, $dn );
		if ( $success ) {
			$wgAuth->printDebug( "Successfully deleted project $projectname", NONSENSITIVE );
			return true;
		} else {
			$wgAuth->printDebug( "Failed to delete project $projectname", NONSENSITIVE );
			return false;
		}
	}

	/**
	 * Pulls all projects from LDAP and adds them as MediaWiki namespaces. Also adds
	 * associated talk namespaces. This function must be called from LocalSettings.
	 *
	 * @static
	 * @return void
	 */
	static function addNamespaces() {
		global $wgAuth;
		global $wgOpenStackManagerLDAPProjectBaseDN;
		global $wgExtraNamespaces;

		OpenStackNovaLdapConnection::connect();

		$result = LdapAuthenticationPlugin::ldap_search( $wgAuth->ldapconn, $wgOpenStackManagerLDAPProjectBaseDN, 'owner=*' );
		$entries = LdapAuthenticationPlugin::ldap_get_entries( $wgAuth->ldapconn, $result );
		if ( $entries ) {
			array_shift( $entries );
			foreach ( $entries as $entry ) {
				$id = (int)$entry['gidnumber'][0];
				$talkid = $id + 1;
				$name = ucwords( $entry['cn'][0] );
				$wgAuth->printDebug( "Adding namespace $name", NONSENSITIVE );
				$wgExtraNamespaces[$id] = $name;
				$wgExtraNamespaces[$talkid] = $name . '_talk';
			}
		} else {
			$wgAuth->printDebug( "Failed to find projects", NONSENSITIVE );
		}
	}

	function editArticle() {
		global $wgOpenStackManagerCreateProjectSALPages;

		if ( ! OpenStackNovaArticle::canCreatePages() ) {
			return;
		}

		$format = <<<RESOURCEINFO
{{Nova Resource
|Resource Type=project
|Project Name=%s
|Members=%s}}
__NOEDITSECTION__
RESOURCEINFO;
		$rawmembers = $this->getMembers();
		$members = array();
		foreach ( $rawmembers as $member ) {
			array_push( $members, 'User:' . $member );
		}
		$text = sprintf( $format,
			$this->getProjectName(),
			implode( ',', $members )
		);
		OpenStackNovaArticle::editArticle( $this->getProjectName(), $text );
		if ( $wgOpenStackManagerCreateProjectSALPages ) {
			$pagename = $this->getProjectName() . "/SAL";
			$id = Title::newFromText( $pagename, NS_NOVA_RESOURCE )->getArticleId();
			$article = Article::newFromId( $id );
			$content = '';
			if ( $article ) {
				$content = $article->getRawText();
			}
			$text = "{{SAL|Project Name=" . $this->getProjectName() . "}}";
			if ( !strstr( $content, $text ) ) {
				OpenStackNovaArticle::editArticle( $pagename, $text );
			}
		}
	}

	function deleteArticle() {
		OpenStackNovaArticle::deleteArticle( $this->getProjectName() );
	}

}
