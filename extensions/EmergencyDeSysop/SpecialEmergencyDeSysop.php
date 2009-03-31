<?php

if ( ! defined( 'MEDIAWIKI' ) )
	die();

class SpecialEmergencyDeSysop extends SpecialPage {

	function __construct() {
		wfLoadExtensionMessages( 'EmergencyDeSysop' );
		parent::__construct( 'EmergencyDeSysop' );
		parent::__construct( "EmergencyDeSysop", "emergencydesysop" );
	}
	
	/**
	* @brief takeGroups function
	*
	* This function decides which groups to take the user out of, and does so.
	* @param object reqUser A MW User object, for the user making the request
	* @param object targetUser A MW User object, for the user targeted by the request
	*/
	function takeGroups( $reqUser, $targetUser ) {
		global $wgEmDesysop;

		//Get groups for instigating user
		$reqGroups = $reqUser->getGroups();

		//Get groups for target user
		$targetGroups = $targetUser->getGroups();

		//Take them all from the requesting user?
		if( $wgEmDesysop['Requestor'] == "All" ) {
			foreach( $reqGroups as $reqGroup ) { $reqUser->removeGroup( $reqGroup ); }

		//Take sysop AND crat?
		} elseif( array_search( 'bureaucrat', $reqGroups ) !== FALSE && $wgEmDesysop['Requestor'] == "Crat" ) {
			$reqUser->removeGroup( 'sysop' );
			$reqUser->removeGroup( 'bureaucrat' );

		//Fall back on just taking sysop
		} else {
			$reqUser->removeGroup( 'sysop' );
		}

		//Take all groups away from target user?
		if( $wgEmDesysop['Target'] == "All" ) {
			foreach( $targetGroups as $targetGroup ) { $targetUser->removeGroup( $targetGroup ); }

		//Crat AND sysop?
		} elseif( array_search( 'bureaucrat', $targetGroups ) !== FALSE && $wgEmDesysop['Target'] == "Crat" ) {
			$targetUser->removeGroup( 'bureaucrat' );
			$targetUser->removeGroup( 'sysop' );

		//Default, just sysop
		} else {
			$targetUser->removeGroup( 'sysop' );
		}

	}

	/**
	* @brief validateTarget function
	*
	* This function checks that the user exists, and, is a member of the sysop usergroup
	* @param object targetUser A MW User object, for the user to be checked.
	*/
	function validateTarget( $targetUser ) {
		global $wgOut;

		//Is it a valid user?
		if( $targetUser->getid() == 0 ) { 
			$wgOut->addWikiText( wfMsg( 'emergencydesysop-invalidtarget' ) );
			$this->showForm();
			return False;
		}

		$targetGroups = $targetUser->getGroups();

		//Is the target a sysop?
		if( !is_array( $targetGroups ) && $targetGroups != 'sysop' ) {
			$wgOut->addWikiText( wfMsg( 'emergencydesysop-notasysop' ) );
			$this->showForm();
			return False;
		} elseif ( !array_search( 'sysop', $targetGroups ) ) {
			$wgOut->addWikiText( wfMsg( 'emergencydesysop-notasysop' ) );
			$this->showForm();
			return False;
		}

		return True;
	}

	/**
	* @brief formatGroups function
	*
	* This function formats an array of groups for logging
	* @param array groups an array of user groups
	*/
	function formatGroups ( $groups ) {
		if( empty( $groups ) ) { 
			$groups = wfMsg( 'emergencydesysop-nogroups' );
		} else {
			$groups = implode( ', ', $groups );
		}
		return $groups;
	}

	/**
	* @brief showForm function
	*
	* This function shows the request form
	*/
	function showForm() {
		global $wgRequest, $wgOut, $wgUser, $wgTitle;

		$action = $wgTitle->escapeLocalUrl();
		$f = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $action, 'name' => 'request' ) );


		$f .=  Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', array(), wfMsg( 'emergencydesysop-title' ) ) .
			Xml::tags( 'label', array( 'for' => 'otheradmin' ), wfMsgExt( 'emergencydesysop-otheradmin', 'parseinline' ) ) . ' ' .
			Xml::input( 'otheradmin', 20) . ' '.
			Xml::label( wfMsg( 'emergencydesysop-reason' ), 'reason' ) . ' ' .
			Xml::input( 'reason', 45) . ' '.
			Xml::submitButton( wfMsg( 'emergencydesysop-submit' ) ) .
			Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' );
			
		$wgOut->addHTML( $f );
	}

	/**
	* @brief function executed when the special page is opened.
	*/
	function execute( $subpage ) {
		global $wgRequest, $wgOut, $wgUser, $wgTitle;
		$this->setHeaders();
		
		//if the user is blocked, deny access.
		if ( $wgUser->IsBlocked() ) {
			//show the blocked message.
			$wgOut->addWikiText( wfMsg( 'emergencydesysop-blocked' ) ); 
			return;
		} else if ( $wgUser->isAnon() || !$wgUser->isAllowed( 'emergencydesysop' ) ) {
			//You've got to have the right
			$wgOut->addWikiText( wfMsg( 'emergencydesysop-noright' ) ); 
			return;
		} else if ( wfReadOnly() ) {
			//if the database is read-only, prevent access.
			$wgOut->readOnlyPage();
			return;
		}

		//if page was posted, then data has been sent
		if ( $wgRequest->wasPosted()  ) {
			if( !$wgRequest->getText( 'otheradmin' ) or !$wgRequest->getText( 'reason' ) ) {
				$wgOut->addWikiText( wfMsg( 'emergencydesysop-incomplete' ) ); 
				$this->showForm();
				return;
			}
			//Start new user object, for the target user
			$targetUser = User::newFromName( $wgRequest->getText( "otheradmin" ) );
			
			//Is the target user BOTH a sysop, and a valid user?
			if( !$this->validateTarget( $targetUser ) ) { return; }

			$targetUserGroupsOld = $targetUser->getGroups( );
			$doerUserGroupsOld = $wgUser->getGroups( );

			//Do the desysop
			$this->takeGroups( $wgUser, $targetUser );

			$targetUserGroupsNew = $targetUser->getGroups( );
			$doerUserGroupsNew = $wgUser->getGroups( );

			//Log it
			$log = new LogPage( "rights" );
			$log->addEntry( 
				"rights", 
				$targetUser->getUserPage( ), 
				'Emergency Desysop: ' . $wgRequest->getText( 'reason' ), 
				array( $this->formatGroups( $targetUserGroupsOld ), $this->formatGroups( $targetUserGroupsNew ) ) );

			$log->addEntry( 
				"rights", 
				$wgUser->getUserPage( ), 
				'Emergency Desysoped [[' . $targetUser->getUserPage( ) . ']]: ' . $wgRequest->getText( 'reason' ), 
				array( $this->formatGroups( $doerUserGroupsOld ), $this->formatGroups( $doerUserGroupsNew ) ) );
			$wgOut->addWikiText( wfMsg( 'emergencydesysop-done', $targetUser->getUserPage( ) ) );

		} else {	
			//show form
			$this->showForm();
		}
		
		return;
	}
}
