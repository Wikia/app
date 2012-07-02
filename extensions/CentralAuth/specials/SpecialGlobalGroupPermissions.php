<?php
# This file is part of MediaWiki.

# MediaWiki is free software: you can redistribute it and/or modify
# it under the terms of version 2 of the GNU General Public License
# as published by the Free Software Foundation.

# MediaWiki is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

/**
 * Special page to allow managing global groups
 * Prototype for a similar system in core.
 *
 * @file
 * @ingroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "CentralAuth extension\n";
	exit( 1 );
}

class SpecialGlobalGroupPermissions extends SpecialPage {
	function __construct() {
		parent::__construct( 'GlobalGroupPermissions' );
	}

	/**
	 * @param $user
	 * @return bool
	 */
	function userCanEdit( $user ) {
		$globalUser = CentralAuthUser::getInstance( $user );

		# # Should be a global user
		if ( !$globalUser->exists() || !$globalUser->isAttached() ) {
			return false;
		}

		# # Permission MUST be gained from global rights.
		return $globalUser->hasGlobalPermission( 'globalgrouppermissions' );
	}

	function execute( $subpage ) {
		if ( !$this->userCanExecute( $this->getUser() ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->getOutput()->setPageTitle( wfMsg( 'globalgrouppermissions' ) );
		$this->getOutput()->setRobotPolicy( "noindex,nofollow" );
		$this->getOutput()->setArticleRelated( false );
		$this->getOutput()->enableClientCache( false );

		if ( $subpage == '' ) {
			$subpage = $this->getRequest()->getVal( 'wpGroup' );
		}

		if ( $subpage != '' && $this->getUser()->matchEditToken( $this->getRequest()->getVal( 'wpEditToken' ) ) ) {
			$this->doSubmit( $subpage );
		} elseif ( $subpage != '' ) {
			$this->buildGroupView( $subpage );
		} else {
			$this->buildMainView();
		}
	}

	function buildMainView() {
		global $wgScript;

		$groups = CentralAuthUser::availableGlobalGroups();

		// Existing groups
		$html = Xml::fieldset( wfMsg( 'centralauth-existinggroup-legend' ) );

		$this->getOutput()->addHTML( $html );

		if ( count( $groups ) ) {
			$this->getOutput()->addWikiMsg( 'centralauth-globalgroupperms-grouplist' );
			$this->getOutput()->addHTML( '<ul>' );

			foreach ( $groups as $group ) {
				$text = wfMsgExt( 'centralauth-globalgroupperms-grouplistitem', array( 'parseinline' ), User::getGroupName( $group ), $group, '<span class="centralauth-globalgroupperms-groupname">' . $group . '</span>' );

				$this->getOutput()->addHTML( "<li> $text </li>" );
			}
		} else {
			$this->getOutput()->addWikiMsg( 'centralauth-globalgroupperms-nogroups' );
		}

		$this->getOutput()->addHTML( Xml::closeElement( 'ul' ) . Xml::closeElement( 'fieldset' ) );

		if ( $this->userCanEdit( $this->getUser() ) ) {
			// "Create a group" prompt
			$html = Xml::fieldset( wfMsg( 'centralauth-newgroup-legend' ) );
			$html .= wfMsgExt( 'centralauth-newgroup-intro', array( 'parse' ) );
			$html .= Xml::openElement( 'form', array( 'method' => 'post', 'action' => $wgScript, 'name' => 'centralauth-globalgroups-newgroup' ) );
			$html .= Html::hidden( 'title',  SpecialPage::getTitleFor( 'GlobalGroupPermissions' )->getPrefixedText() );

			$fields = array( 'centralauth-globalgroupperms-newgroupname' => Xml::input( 'wpGroup' ) );

			$html .= Xml::buildForm( $fields, 'centralauth-globalgroupperms-creategroup-submit' );
			$html .= Xml::closeElement( 'form' );
			$html .= Xml::closeElement( 'fieldset' );

			$this->getOutput()->addHTML( $html );
		}
	}

	/**
	 * @param $group
	 */
	function buildGroupView( $group ) {
		$editable = $this->userCanEdit( $this->getUser() );

		$this->getOutput()->setSubtitle( wfMsg( 'centralauth-editgroup-subtitle', $group ) );

		$html = Xml::fieldset( wfMsg( 'centralauth-editgroup-fieldset', $group ) );

		if ( $editable ) {
			$html .= Xml::openElement( 'form', array( 'method' => 'post', 'action' => SpecialPage::getTitleFor( 'GlobalGroupPermissions', $group )->getLocalUrl(), 'name' => 'centralauth-globalgroups-newgroup' ) );
			$html .= Html::hidden( 'wpGroup', $group );
			$html .= Html::hidden( 'wpEditToken', $this->getUser()->getEditToken() );
		}

		$fields = array();

		$fields['centralauth-editgroup-name'] = $group;
		$fields['centralauth-editgroup-display'] = wfMsgExt( 'centralauth-editgroup-display-edit', array( 'parseinline' ), $group, User::getGroupName( $group ) );
		$fields['centralauth-editgroup-member'] = wfMsgExt( 'centralauth-editgroup-member-edit', array( 'parseinline' ), $group, User::getGroupMember( $group ) );
		$fields['centralauth-editgroup-members'] = wfMsgExt( 'centralauth-editgroup-members-link', array( 'parseinline' ), $group, User::getGroupMember( $group ) );
		$fields['centralauth-editgroup-restrictions'] = $this->buildWikiSetSelector( $group );
		$fields['centralauth-editgroup-perms'] = $this->buildCheckboxes( $group );

		if ( $editable ) {
			$fields['centralauth-editgroup-reason'] = Xml::input( 'wpReason', 60 );
		}

		$html .= Xml::buildForm( $fields,  $editable ? 'centralauth-editgroup-submit' : null );

		if ( $editable )
			$html .= Xml::closeElement( 'form' );

		$html .= Xml::closeElement( 'fieldset' );

		$this->getOutput()->addHTML( $html );

		$this->showLogFragment( $group, $this->getOutput() );
	}

	/**
	 * @param $group
	 * @return string
	 */
	function buildWikiSetSelector( $group ) {
		$sets = WikiSet::getAllWikiSets();
		$default = WikiSet::getWikiSetForGroup( $group );

		if ( !$this->userCanEdit( $this->getUser() ) )
			return htmlspecialchars( $default );

		$select = new XmlSelect( 'set', 'wikiset', $default );
		$select->addOption( wfMsg( 'centralauth-editgroup-noset' ), '0' );
		foreach ( $sets as $set ) {
			$select->addOption( $set->getName(), $set->getID() );
		}

		$editlink = wfMsgExt( "centralauth-editgroup-editsets", array( "parseinline" ) );
		return $select->getHTML() . "&#160;{$editlink}";
	}

	/**
	 * @param $group
	 * @return string
	 */
	function buildCheckboxes( $group ) {
		$editable = $this->userCanEdit( $this->getUser() );

		$rights = User::getAllRights();
		$assignedRights = $this->getAssignedRights( $group );

		sort( $rights );

		$checkboxes = array();
		$attribs = array();

		if ( !$editable ) {
			$attribs['disabled'] = 'disabled';
		}

		foreach ( $rights as $right ) {
			# Build a checkbox.
			$checked = in_array( $right, $assignedRights );

			$desc = $this->getOutput()->parseInline( User::getRightDescription( $right ) ) . ' ' .
						Xml::element( 'tt', null, wfMsg( 'parentheses', $right ) );

			$checkbox = Xml::check( "wpRightAssigned-$right", $checked,
				array_merge( $attribs, array( 'id' => "wpRightAssigned-$right" ) ) );
			$label = Xml::tags( 'label', array( 'for' => "wpRightAssigned-$right" ),
					$desc );

			$checkboxes[] = "<li>$checkbox&#160;$label</li>";
		}

		$count = count( $checkboxes );

		$firstCol = round( $count / 2 );

		$checkboxes1 = array_slice( $checkboxes, 0, $firstCol );
		$checkboxes2 = array_slice( $checkboxes, $firstCol );

		$html = '<table><tbody><tr><td><ul>';

		foreach ( $checkboxes1 as $cb ) {
			$html .= $cb;
		}

		$html .= '</ul></td><td><ul>';

		foreach ( $checkboxes2 as $cb ) {
			$html .= $cb;
		}

		$html .= '</ul></td></tr></tbody></table>';

		return $html;
	}

	/**
	 * @param $group
	 * @return array
	 */
	function getAssignedRights( $group ) {
		return CentralAuthUser::globalGroupPermissions( $group );
	}

	function doSubmit( $group ) {
		// Paranoia -- the edit token shouldn't match anyway
		if ( !$this->userCanEdit( $this->getUser() ) )
			return;

		$newRights = array();
		$addRights = array();
		$removeRights = array();
		$oldRights = $this->getAssignedRights( $group );
		$allRights = User::getAllRights();

		$reason = $this->getRequest()->getVal( 'wpReason', '' );

		foreach ( $allRights as $right ) {
			$alreadyAssigned = in_array( $right, $oldRights );

			if ( $this->getRequest()->getCheck( "wpRightAssigned-$right" ) ) {
				$newRights[] = $right;
			}

			if ( !$alreadyAssigned && $this->getRequest()->getCheck( "wpRightAssigned-$right" ) ) {
				$addRights[] = $right;
			} elseif ( $alreadyAssigned && !$this->getRequest()->getCheck( "wpRightAssigned-$right" ) ) {
				$removeRights[] = $right;
			} # Otherwise, do nothing.
		}

		// Assign the rights.
		if ( count( $addRights ) > 0 )
			$this->grantRightsToGroup( $group, $addRights );
		if ( count( $removeRights ) > 0 )
			$this->revokeRightsFromGroup( $group, $removeRights );

		// Log it
		if ( !( count( $addRights ) == 0 && count( $removeRights ) == 0 ) )
			$this->addLogEntry( $group, $addRights, $removeRights, $reason );

		// Change set
		$current = WikiSet::getWikiSetForGroup( $group );
		$new = $this->getRequest()->getVal( 'set' );
		if ( $current != $new ) {
			$this->setRestrictions( $group, $new );
			$this->addLogEntry2( $group, $current, $new, $reason );
		}

		$this->invalidateRightsCache( $group );

		// Display success
		$this->getOutput()->setSubTitle( wfMsg( 'centralauth-editgroup-success' ) );
		$this->getOutput()->addWikiMsg( 'centralauth-editgroup-success-text', $group );
	}

	/**
	 * @param $group
	 * @param $rights
	 */
	function revokeRightsFromGroup( $group, $rights ) {
		$dbw = CentralAuthUser::getCentralDB();

		# Delete from the DB
		$dbw->delete( 'global_group_permissions', array( 'ggp_group' => $group, 'ggp_permission' => $rights ), __METHOD__ );
	}

	/**
	 * @param $group
	 * @param $rights
	 */
	function grantRightsToGroup( $group, $rights ) {
		$dbw = CentralAuthUser::getCentralDB();

		if ( !is_array( $rights ) ) {
			$rights = array( $rights );
		}

		$insertRows = array();
		foreach ( $rights as $right ) {
			$insertRows[] = array( 'ggp_group' => $group, 'ggp_permission' => $right );
		}

		# Replace into the DB
		$dbw->replace( 'global_group_permissions', array( 'ggp_group', 'ggp_permission' ), $insertRows, __METHOD__ );
	}

	/**
	 * @param $group
	 * @param $output OutputPage
	 */
	protected function showLogFragment( $group, $output ) {
		$title = SpecialPage::getTitleFor( 'GlobalUsers', $group );
		$output->addHTML( Xml::element( 'h2', null, LogPage::logName( 'gblrights' ) . "\n" ) );
		LogEventsList::showLogExtract( $output, 'gblrights', $title->getPrefixedText() );
	}

	/**
	 * @param $group
	 * @param $addRights
	 * @param $removeRights
	 * @param $reason
	 */
	function addLogEntry( $group, $addRights, $removeRights, $reason ) {
		$log = new LogPage( 'gblrights' );

		$log->addEntry( 'groupprms2',
			SpecialPage::getTitleFor( 'GlobalUsers', $group ),
			$reason,
			array(
				$this->makeRightsList( $addRights ),
				$this->makeRightsList( $removeRights )
			)
		);
	}

	/**
	 * @param $ids
	 * @return string
	 */
	function makeRightsList( $ids ) {
		return (bool)count( $ids ) ? implode( ', ', $ids ) : wfMsgForContent( 'rightsnone' );
	}

	/**
	 * @param $group
	 * @param $set
	 * @return bool
	 */
	function setRestrictions( $group, $set ) {
		$dbw = CentralAuthUser::getCentralDB();
		if ( $set == 0 ) {
			$dbw->delete( 'global_group_restrictions', array( 'ggr_group' => $group ), __METHOD__ );
		} else {
			$dbw->replace( 'global_group_restrictions', array( 'ggr_group' ),
				array( 'ggr_group' => $group, 'ggr_set' => $set, ), __METHOD__ );
		}
		return (bool)$dbw->affectedRows();
	}

	/**
	 * @param $group
	 * @param $old
	 * @param $new
	 * @param $reason
	 */
	function addLogEntry2( $group, $old, $new, $reason ) {
		$log = new LogPage( 'gblrights' );

		$log->addEntry( 'groupprms3',
			SpecialPage::getTitleFor( 'GlobalUsers', $group ),
			$reason,
			array(
				$this->getWikiSetName( $old ),
				$this->getWikiSetName( $new ),
			)
		);
	}

	function getWikiSetName( $id ) {
		if ( $id ) {
			return WikiSet::newFromID( $id )->getName();
		} else {
			return wfMsgForContent( 'centralauth-editgroup-noset' );
		}
	}

	/**
	 * @param $group
	 */
	function invalidateRightsCache( $group ) {
		// Figure out all the users in this group.
		$dbr = CentralAuthUser::getCentralDB();

		$res = $dbr->select( array( 'global_user_groups', 'globaluser' ), 'gu_name', array( 'gug_group' => $group, 'gu_id=gug_user' ), __METHOD__ );

		// Invalidate their rights cache.
		foreach ( $res as $row ) {
			$cu = new CentralAuthUser( $row->gu_name );
			$cu->quickInvalidateCache();
		}
	}
}
