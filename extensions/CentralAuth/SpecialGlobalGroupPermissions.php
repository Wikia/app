<?php

#This file is part of MediaWiki.

#MediaWiki is free software: you can redistribute it and/or modify
#it under the terms of version 2 of the GNU General Public License
#as published by the Free Software Foundation.

#MediaWiki is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.

/**
 * Special page to allow managing global groups
 * Prototype for a similar system in core.
 *
 * @addtogroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "CentralAuth extension\n";
	exit( 1 );
}


class SpecialGlobalGroupPermissions extends SpecialPage
{
	function __construct() {
		parent::__construct('GlobalGroupPermissions', 'globalgrouppermissions');
		wfLoadExtensionMessages('SpecialCentralAuth');
	}
	
	function userCanExecute($user) {		
		$globalUser = CentralAuthUser::getInstance( $user );
		
		## Should be a global user
		if (!$globalUser->exists() || !$globalUser->isAttached()) {
			return false;
		}
		
		## Permission MUST be gained from global rights.
		return $globalUser->hasGlobalPermission( 'globalgrouppermissions' );
	}

	function execute( $subpage ) {
		global $wgRequest,$wgOut,$wgUser;
		
		if (!$this->userCanExecute($wgUser)) {
			$this->displayRestrictionError();
			return;
		}
		
		$wgOut->setPageTitle( wfMsg( 'globalgrouppermissions' ) );
		$wgOut->setRobotPolicy( "noindex,nofollow" );
		$wgOut->setArticleRelated( false );
		$wgOut->enableClientCache( false );
		
		if ($subpage == '' ) {
			$subpage = $wgRequest->getVal( 'wpGroup' );
		}

		if ($subpage != '' && $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) )) {
			$this->doSubmit($subpage);
		} else if ($subpage != '') {
			$this->buildGroupView($subpage);
		} else {
			$this->buildMainView();
		}
	}

	function buildMainView() {
		global $wgOut,$wgUser,$wgScript;
		$sk = $wgUser->getSkin();

		$groups = CentralAuthUser::availableGlobalGroups();
		
		// Existing groups
		$html = Xml::openElement( 'fieldset' );
		$html .= Xml::element( 'legend', null, wfMsg( 'centralauth-existinggroup-legend' ) );
		
		$wgOut->addHTML( $html );

		if (count($groups)) {
			$wgOut->addWikiMsg( 'centralauth-globalgroupperms-grouplist' );
			$wgOut->addHTML( '<ul>' );

			foreach ($groups as $group) {
				$text = wfMsgExt( 'centralauth-globalgroupperms-grouplistitem', array( 'parseinline' ), User::getGroupName($group), $group );

				$wgOut->addHTML( "<li> $text </li>" );
			}
		} else {
			$wgOut->addWikiMsg( 'centralauth-globalgroupperms-nogroups' );
		}

		$wgOut->addHTML( Xml::closeElement( 'ul' ) . Xml::closeElement( 'fieldset' ) );

		// "Create a group" prompt
		$html = Xml::openElement( 'fieldset' ) . Xml::element( 'legend', null, wfMsg( 'centralauth-newgroup-legend' ) );
		$html .= wfMsgExt( 'centralauth-newgroup-intro', array( 'parse' ) );
		$html .= Xml::openElement( 'form', array( 'method' => 'post', 'action' => $wgScript, 'name' => 'centralauth-globalgroups-newgroup' ) );
		$html .= Xml::hidden( 'title',  SpecialPage::getTitleFor('GlobalGroupPermissions')->getPrefixedText() );
		
		$fields = array( 'centralauth-globalgroupperms-newgroupname' => Xml::input( 'wpGroup' ) );
		
		$html .= Xml::buildForm( $fields, 'centralauth-globalgroupperms-creategroup-submit' );
		$html .= Xml::closeElement( 'form' );
		$html .= Xml::closeElement( 'fieldset' );
		
		$wgOut->addHTML( $html );
	}
	
	function buildGroupView( $group ) {
		global $wgOut, $wgUser, $wgScript;
		
		$wgOut->setSubtitle( wfMsg( 'centralauth-editgroup-subtitle', $group ) );
		
		$html = Xml::openElement( 'fieldset' ) . Xml::element( 'legend', null, wfMsg( 'centralauth-editgroup-fieldset', $group ) );
		$html .= Xml::openElement( 'form', array( 'method' => 'post', 'action' => SpecialPage::getTitleFor('GlobalGroupPermissions', $group)->getLocalUrl(), 'name' => 'centralauth-globalgroups-newgroup' ) );
		$html .= Xml::hidden( 'wpGroup', $group );
		$html .= Xml::hidden( 'wpEditToken', $wgUser->editToken() );
		
		$fields = array();
		
		$fields['centralauth-editgroup-name'] = $group;
		$fields['centralauth-editgroup-display'] = wfMsgExt( 'centralauth-editgroup-display-edit', array( 'parseinline' ), $group, User::getGroupName( $group ) );
		$fields['centralauth-editgroup-member'] = wfMsgExt( 'centralauth-editgroup-member-edit', array( 'parseinline' ), $group, User::getGroupMember( $group ) );
		$fields['centralauth-editgroup-members'] = wfMsgExt( 'centralauth-editgroup-members-link', array( 'parseinline' ), $group, User::getGroupMember( $group ) );
		$fields['centralauth-editgroup-restrictions'] = $this->buildWikiSetSelector($group);
		$fields['centralauth-editgroup-perms'] = $this->buildCheckboxes($group);
		$fields['centralauth-editgroup-reason'] = Xml::input( 'wpReason' );
		
		$html .= Xml::buildForm( $fields, 'centralauth-editgroup-submit' );
		
		$html .= Xml::closeElement( 'form' );
		$html .= Xml::closeElement( 'fieldset' );
		
		$wgOut->addHTML( $html );
		
		$this->showLogFragment( $group, $wgOut );
	}

	function buildWikiSetSelector( $group ) {
		$sets = WikiSet::getAllWikiSets();
		$default = WikiSet::getWikiSetForGroup( $group );

		$select = new XmlSelect( 'set', 'wikiset', $default );
		$select->addOption( wfMsg( 'centralauth-editgroup-noset' ), '0' );
		foreach( $sets as $set ) {
			$select->addOption( $set->getName(), $set->getID() );
		}

		$editlink = wfMsgExt( "centralauth-editgroup-editsets", array( "parseinline" ) );
		return $select->getHTML() . "&nbsp;{$editlink}";
	}

	function buildCheckboxes( $group ) {
		
		$rights = User::getAllRights();
		$assignedRights = $this->getAssignedRights( $group );
		
		sort($rights);
		
		$checkboxes = array();
		
		foreach( $rights as $right ) {
			# Build a checkbox.
			$checked = in_array( $right, $assignedRights );
			
			$checkbox = Xml::checkLabel( User::getRightDescription( $right ), 
				"wpRightAssigned-$right", "wpRightAssigned-$right", $checked );
			
			$checkboxes[] = "<li>$checkbox</li>";
		}
		
		$count = count($checkboxes);
		
		$firstCol = round($count/2);
		
		$checkboxes1 = array_slice($checkboxes, 0, $firstCol);
		$checkboxes2 = array_slice($checkboxes, $firstCol );
		
		$html = '<table><tbody><tr><td><ul>';
		
		foreach( $checkboxes1 as $cb ) {
			$html .= $cb;
		}
		
		$html .= '</ul></td><td><ul>';
		
		foreach( $checkboxes2 as $cb ) {
			$html .= $cb;
		}
		
		$html .= '</ul></td></tr></tbody></table>';
		
		return $html;
	}
	
	function getAssignedRights( $group ) {
		return CentralAuthUser::globalGroupPermissions( $group );
	}
	
	function doSubmit( $group ) {
		global $wgRequest,$wgOut,$wgScript;
		
		$newRights = array();
		$addRights = array();
		$removeRights = array();
		$oldRights = $this->getAssignedRights( $group );
		$allRights = User::getAllRights();
		
		$reason = $wgRequest->getVal( 'wpReason', '' );
		
		foreach ($allRights as $right) {
			$alreadyAssigned = in_array( $right, $oldRights );
			
			if ($wgRequest->getCheck( "wpRightAssigned-$right" )) {
				$newRights[] = $right;
			}
			
			if (!$alreadyAssigned && $wgRequest->getCheck( "wpRightAssigned-$right" )) {
				$addRights[] = $right;
			} else if ($alreadyAssigned && !$wgRequest->getCheck( "wpRightAssigned-$right" ) ) {
				$removeRights[] = $right;
			} # Otherwise, do nothing.
		}
		
		// Assign the rights.
		if (count($addRights)>0)
			$this->grantRightsToGroup( $group, $addRights );
		if (count($removeRights)>0)
			$this->revokeRightsFromGroup( $group, $removeRights );
		
		// Log it
		if (!(count($addRights)==0 && count($removeRights)==0))
			$this->addLogEntry( $group, $addRights, $removeRights, $reason );

		// Change set
		$current = WikiSet::getWikiSetForGroup( $group );
		$new = $wgRequest->getVal( 'set' );
		if( $current != $new ) {
			$this->setRestrictions( $group, $new );
			$this->addLogEntry2( $group, $current, $new, $reason );
		}

		$this->invalidateRightsCache( $group );
		
		// Display success
		$wgOut->setSubTitle( wfMsg( 'centralauth-editgroup-success' ) );
		$wgOut->addWikiMsg( 'centralauth-editgroup-success-text', $group );
	}
	
	function revokeRightsFromGroup( $group, $rights ) {
		$dbw = CentralAuthUser::getCentralDB();
		
		# Delete from the DB
		$dbw->delete( 'global_group_permissions', array( 'ggp_group' => $group, 'ggp_permission' => $rights), __METHOD__ );
	}
	
	function grantRightsToGroup( $group, $rights ) {
		$dbw = CentralAuthUser::getCentralDB();
		
		if (!is_array($rights)) {
			$rights = array($rights);
		}
		
		$insertRows = array();
		foreach( $rights as $right ) {
			$insertRows[] = array( 'ggp_group' => $group, 'ggp_permission' => $right );
		}
		
		# Replace into the DB
		$dbw->replace( 'global_group_permissions', array( 'ggp_group', 'ggp_permission' ), $insertRows, __METHOD__ );
	}
	
	protected function showLogFragment( $group, $output ) {
		$title = SpecialPage::getTitleFor( 'GlobalUsers', $group );
		$output->addHTML( Xml::element( 'h2', null, LogPage::logName( 'gblrights' ) . "\n" ) );
		LogEventsList::showLogExtract( $output, 'gblrights', $title->getPrefixedText() );
	}
	
	function addLogEntry( $group, $addRights, $removeRights, $reason ) {
		global $wgRequest;
		
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
	
	function makeRightsList( $ids ) {
		return (bool)count($ids) ? implode( ', ', $ids ) : wfMsgForContent( 'rightsnone' );
	}

	function setRestrictions( $group, $set ) {
		$dbw = CentralAuthUser::getCentralDB();
		if( $set == 0 ) {
			$dbw->delete( 'global_group_restrictions', array( 'ggr_group' => $group ), __METHOD__ );
		} else {
			$dbw->replace( 'global_group_restrictions', array( 'ggr_group' ),
				array( 'ggr_group' => $group, 'ggr_set' => $set, ), __METHOD__ );
		}
		return (bool)$dbw->affectedRows();
	}

	function addLogEntry2( $group, $old, $new, $reason ) {
		global $wgRequest;
		
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
		if( $id )
			return WikiSet::newFromID( $id )->getName();
		else
			return wfMsgForContent( 'centralauth-editgroup-noset' );
	}

	function invalidateRightsCache( $group ) {
		global $wgMemc;
		
		// Figure out all the users in this group.
		$dbr = CentralAuthUser::getCentralDB();
		
		$res = $dbr->select( array('global_user_groups','globaluser'), 'gu_name', array( 'gug_group' => $group, 'gu_id=gug_user' ), __METHOD__ );
		
		// Invalidate their rights cache.
		while ($row = $res->fetchObject() ) {
			$cu = new CentralAuthUser( $row->gu_name );
			$cu->quickInvalidateCache();
		}
	}
}
