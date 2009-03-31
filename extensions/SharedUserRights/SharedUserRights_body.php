<?php
/**
 * Special page to allow managing user group membership
 *
 * @file
 * @ingroup Extensions
 */

/**
 * A class to manage user levels rights.
 * @ingroup Extensions
 */
class SharedUserRights extends SpecialPage {
	# The target of the local right-adjuster's interest.  Can be gotten from
	# either a GET parameter or a subpage-style parameter, so have a member
	# variable for it.
	protected $mTarget;
	protected $isself = false;

	public function __construct() {
		parent::__construct( 'SharedUserRights' );
	}

	public function isRestricted() {
		return true;
	}

	public function userCanExecute( $user ) {
		return $user->isAllowed( 'userrights-global' );
	}

	/**
	 * Manage forms to be shown according to posted data.
	 * Depending on the submit button used, call a form or a save function.
	 *
	 * @param $par Mixed: string if any subpage provided, else null
	 */
	function execute( $par ) {
		global $wgUser, $wgRequest;

		wfLoadExtensionMessages( 'SharedUserRights' );

		if ( $par ) {
			$this->mTarget = $par;
		} else {
			$this->mTarget = $wgRequest->getVal( 'user' );
		}
		
		# This might be redundant, but more security is always good. Right?
		if ( !$this->userCanExecute( $wgUser ) ) {
			global $wgOut;
			$wgOut->permissionRequired( 'userrights-global' );
			return;
		}

		if ( wfReadOnly() ) {
			global $wgOut;
			$wgOut->readOnlyPage();
			return;
		}

		$this->outputHeader();

		$this->setHeaders();

		# show user selection form
		$this->switchForm();

		if ( $wgRequest->wasPosted() ) {
			# save right changes
			if ( $wgRequest->getCheck( 'saveusergroups' ) ) {
				$reason = $wgRequest->getVal( 'user-reason' );
				if ( $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ), $this->mTarget ) ) {
					$this->saveUserGroups(
						$this->mTarget,
						$reason
					);
				}
			}
		}

		# show the rights edit, also
		if ( $this->mTarget ) {
			$this->editUserGroupsForm( $this->mTarget );
		}
	}

	/**
	 * Save user groups changes in the database.
	 * Data comes from the editUserGroupsForm() form function
	 *
	 * @param $username String: username to apply changes to.
	 * @param $reason String: reason for group change
	 * @return null
	 */
	function saveUserGroups( $username, $reason = '' ) {
		global $wgRequest, $wgUser;

		$user = $this->fetchUser( $username );
		if ( !$user ) {
			return;
		}

		$allgroups = $this->getAllGroups();
		$addgroup = array();
		$removegroup = array();
		
		foreach ( $allgroups as $group ) {
			// We'll tell it to remove all unchecked groups, and add all checked groups.
			// Later on, this gets filtered for what can actually be removed
			if ( $wgRequest->getCheck( "wpGroup-$group" ) ) {
				$addgroup[] = $group;
			} else {
				$removegroup[] = $group;
			}
		}
		
		$removegroup = array_unique(
			array_intersect( (array)$removegroup, $allgroups ) );
		$addgroup = array_unique(
			array_intersect( (array)$addgroup, $allgroups ) );

		$oldGroups = $this->listGroups( $username );
		$newGroups = $oldGroups;
		
		# remove groups
		if ( $removegroup ) {
			$newGroups = array_diff( $newGroups, $removegroup );
			foreach ( $removegroup as $group ) {
				$this->removeGroup( $username, $group );
			}
		}
		
		# add new groups
		if ( $addgroup ) {
			$newGroups = array_merge( $newGroups, $addgroup );
			foreach ( $addgroup as $group ) {
				$this->addGroup( $username, $group );
			}
		}
		
		$newGroups = array_unique( $newGroups );

		# Clear the caches
		$user->invalidateCache();

		wfDebug( 'oldGroups: ' . print_r( $oldGroups, true ) );
		wfDebug( 'newGroups: ' . print_r( $newGroups, true ) );

		if ( $newGroups != $oldGroups ) {
			$this->addLogEntry( $user, $oldGroups, $newGroups );
		}
	}

	/**
	 * Add a rights log entry for an action.
	 */
	function addLogEntry( $user, $oldGroups, $newGroups ) {
		global $wgRequest;
		$log = new LogPage( 'gblrights' );

		$log->addEntry( 'rights',
			$user->getUserPage(),
			$wgRequest->getText( 'user-reason' ),
			array(
				$this->makeGroupNameList( $oldGroups ),
				$this->makeGroupNameList( $newGroups )
			)
		);
	}

	/**
	 * Edit user groups membership
	 * @param $username String: name of the user.
	 */
	function editUserGroupsForm( $username ) {
		global $wgOut;

		$user = $this->fetchUser( $username );
		if ( !$user ) {
			return;
		}

		$groups = $this->listGroups( $username );

		$this->showEditUserGroupsForm( $user, $username, $groups );

		# Show recent SharedUserRights changes for this user
		$this->showLogFragment( $user, $wgOut );
	}

	function addGroup( $username, $groupname ) {
		$groups = $this->listGroups( $username );
		
		if( in_array( $groupname, $groups )) {
			return false;
		} else {
			$user = $this->fetchUser( $username );

			$dbw = wfGetDB( DB_MASTER );

			$dbw->insert( efSharedTable( 'shared_user_groups' ), array(
				'sug_user' => $user->getId(),
				'sug_group' => $groupname ),
				'SharedUserRights::addGroup',
				'IGNORE'
			);

			return true;
		}
	}

	function removeGroup( $username, $groupname ) {
		$user = $this->fetchUser( $username );
		
		$dbw = wfGetDB( DB_MASTER );

		$dbw->delete( efSharedTable( 'shared_user_groups' ), array(
			'sug_user' => $user->getId(),
			'sug_group' => $groupname ),
			'SharedUserRights::removeGroup'
		);

		return true;
	}

	function listGroups( $username ) {
		global $wgSharedDB;

		$user = $this->fetchUser( $username );

		$dbr = wfGetDB( DB_SLAVE, array(), $wgSharedDB );

		$groups = array();
		
		$res = $dbr->select(
			'shared_user_groups',
			'sug_group',
			array( 'sug_user' => $user->mId ) );

		while ( $row = $dbr->fetchObject( $res ) ) {
			$groups[] = $row->sug_group;
		}

		$dbr->freeResult( $res );

		return $groups;
	}

	/**
	 * Normalize the input username, which may be local or remote, and
	 * return a user (or proxy) object for manipulating it.
	 *
	 * Side effects: error output for invalid access
	 * @return mixed User
	 */
	function fetchUser( $username ) {
		global $wgOut, $wgUser;
		
		$name = trim( $username );

		if ( $name == '' ) {
			$wgOut->addWikiMsg( 'nouserspecified' );
			return false;
		}

		if ( $name[0] == '#' ) {
			// Numeric ID can be specified...
			// We'll do a lookup for the name internally.
			$id = intval( substr( $name, 1 ) );

			$name = User::whoIs( $id );

			if ( !$name ) {
				$wgOut->addWikiMsg( 'noname' );
				return null;
			}
		}

		$user = User::newFromName( $name );

		if ( !$user || $user->isAnon() ) {
			$wgOut->addWikiMsg( 'nosuchusershort', $username );
			return null;
		}

		return $user;
	}

	function makeGroupNameList( $ids ) {
		if ( empty( $ids ) ) {
			return wfMsgForContent( 'rightsnone' );
		} else {
			return implode( ', ', $ids );
		}
	}

	/**
	 * Output a form to allow searching for a user
	 */
	function switchForm() {
		global $wgOut, $wgScript;
		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript, 'name' => 'uluser', 'id' => 'mw-userrights-form1' ) ) .
			Xml::hidden( 'title',  $this->getTitle()->getPrefixedText() ) .
			Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', array(), wfMsg( 'userrights-lookup-user' ) ) .
			Xml::inputLabel( wfMsg( 'userrights-user-editname' ), 'user', 'username', 30, $this->mTarget ) . ' ' .
			Xml::submitButton( wfMsg( 'editusergroup' ) ) .
			Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' ) . "\n"
		);
	}

	/**
	 * Show the form to edit group memberships.
	 *
	 * @param $user      User or UserRightsProxy you're editing
	 * @param $groups    Array:  Array of groups the user is in
	 */
	protected function showEditUserGroupsForm( $user, $username, $groups ) {
		global $wgOut, $wgUser, $wgLang;

		$addable = $this->getAllGroups();
		$removable = $this->getAllGroups();

		$list = array();
		foreach ( $this->listGroups( $username ) as $group )
			$list[] = self::buildGroupLink( $group );

		$grouplist = '';
		if ( count( $list ) > 0 ) {
			$grouplist = wfMsgHtml( 'userrights-groupsmember' );
			$grouplist = '<p>' . $grouplist  . ' ' . $wgLang->listToText( $list ) . '</p>';
		}
		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->getTitle()->getLocalURL(), 'name' => 'editGroup', 'id' => 'mw-userrights-form2' ) ) .
			Xml::hidden( 'user', $this->mTarget ) .
			Xml::hidden( 'wpEditToken', $wgUser->editToken( $this->mTarget ) ) .
			Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', array(), wfMsg( 'userrights-editusergroup' ) ) .
			wfMsgExt( 'editinguser', array( 'parse' ), wfEscapeWikiText( $user->getName() ) ) .
			wfMsgExt( 'userrights-groups-help', array( 'parse' ) ) .
			$grouplist .
			Xml::tags( 'p', null, $this->groupCheckboxes( $groups ) ) .
			Xml::openElement( 'table', array( 'border' => '0', 'id' => 'mw-userrights-table-outer' ) ) .
				"<tr>
					<td class='mw-label'>" .
						Xml::label( wfMsg( 'userrights-reason' ), 'wpReason' ) .
					"</td>
					<td class='mw-input'>" .
						Xml::input( 'user-reason', 60, false, array( 'id' => 'wpReason', 'maxlength' => 255 ) ) .
					"</td>
				</tr>
				<tr>
					<td></td>
					<td class='mw-submit'>" .
						Xml::submitButton( wfMsg( 'saveusergroups' ), array( 'name' => 'saveusergroups', 'accesskey' => 's' ) ) .
					"</td>
				</tr>" .
			Xml::closeElement( 'table' ) . "\n" .
			Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' ) . "\n"
		);
	}

	/**
	 * Format a link to a group description page
	 *
	 * @param $group string
	 * @return string
	 */
	private static function buildGroupLink( $group ) {
		static $cache = array();
		if ( !isset( $cache[$group] ) )
			$cache[$group] = User::makeGroupLinkHtml( $group, User::getGroupName( $group ) );
		return $cache[$group];
	}

	/**
	 * Returns an array of all groups that may be edited
	 * @return array Array of groups that may be edited.
	 */
	 protected static function getAllGroups() {
		return User::getAllGroups();
	 }

	/**
	 * Adds a table with checkboxes where you can select what groups to add/remove
	 *
	 * @param $usergroups Array: groups the user belongs to
	 * @return string XHTML table element with checkboxes
	 */
	private function groupCheckboxes( $usergroups ) {
		$allgroups = $this->getAllGroups();
		$ret = '';

		$column = 1;
		$settable_col = '';
		$unsettable_col = '';

		foreach ( $allgroups as $group ) {
			$set = in_array( $group, $usergroups );
			
			$attr = array();
			$text = User::getGroupMember( $group );
			$checkbox = Xml::checkLabel( $text, "wpGroup-$group",
				"wpGroup-$group", $set, $attr );
			
			$settable_col .= "$checkbox<br />\n";
		}

		if ( $column ) {
			$ret .=	Xml::openElement( 'table', array( 'border' => '0', 'class' => 'mw-userrights-groups' ) ) .
				"<tr>";
			if ( $settable_col !== '' ) {
				$ret .= xml::element( 'th', null, wfMsg( 'userrights-changeable-col' ) );
			}
			if ( $unsettable_col !== '' ) {
				$ret .= xml::element( 'th', null, wfMsg( 'userrights-unchangeable-col' ) );
			}
			$ret .= "</tr>
				<tr>";
			if ( $settable_col !== '' ) {
				$ret .= "
					<td style='vertical-align:top;'>
						$settable_col
					</td>";
			}
			if ( $unsettable_col !== '' ) {
				$ret .= "
					<td style='vertical-align:top;'>
						$unsettable_col
					</td>";
			}
			$ret .= Xml::closeElement( 'tr' ) . Xml::closeElement( 'table' );
		}

		return $ret;
	}
	
	/**
	 * Show a rights log fragment for the specified user
	 *
	 * @param $user User to show log for
	 * @param $output OutputPage to use
	 */
	protected function showLogFragment( $user, $output ) {
		$output->addHTML( Xml::element( 'h2', null, LogPage::logName( 'gblrights' ) . "\n" ) );
		LogEventsList::showLogExtract( $output, 'gblrights', $user->getUserPage()->getPrefixedText() );
	}
}
