<?php

class ResignPage extends SpecialPage {
	private $mGroups, $mReason, $mConfirm, $mSubmit;

	public function __construct() {
		parent::__construct( 'Resign', 'resign' );

		global $wgUser, $wgRequest;
		$this->mGroups = array();
		foreach( $wgUser->getGroups() as $group ) {
			if ( $wgRequest->getBool( "wpGroup-$group" ) ) {
				$this->mGroups[] = $group;
			}
		}
		$this->mReason = $wgRequest->getText( 'wpReason' );
		$this->mConfirm = $wgRequest->getBool( 'wpConfirm' );
		$this->mSubmit = $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal( 'wpToken' ) );
	}

	public function execute( $par ) {
		global $wgOut, $wgUser, $wgRequest;

		wfLoadExtensionMessages( 'ResignPage' );

		$this->setHeaders();

		if ( !$wgUser->isAllowed( 'resign' ) ) {
			$wgOut->permissionRequired( 'resign' );
			return;
		}

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		if ( $this->mSubmit ) {
			$this->doSubmit();
		}

		$this->showForm();
	}

	function showForm() {
		global $wgOut, $wgUser;
		$self = SpecialPage::getTitleFor( 'Resign' );
		$wgOut->addHTML(
			Xml::openElement( 'form' , array( 'method' => 'post', 'action' => $self->getLocalUrl() ) ) .
			wfMsgExt( 'resign-text', array( 'parse' ) ) .
			Xml::openElement( 'ul' )
		);
		foreach( $wgUser->getGroups() as $group ) {
			$wgOut->addHTML(
				Xml::tags( 'li', null, Xml::check( "wpGroup-$group", in_array( $group, $this->mGroups ) ) . ' ' .
				User::makeGroupLinkHTML( $group, User::getGroupMember( $group ) ) )
			);
		}
		$wgOut->addHTML(
			Xml::closeElement( 'ul' ) .
			Xml::tags( 'p', null, Xml::inputLabel( wfMsg( 'resign-reason' ), 'wpReason', 'wpReason', 60, $this->mReason ) ) .
			Xml::tags( 'p', null, Xml::checkLabel( wfMsgExt( 'resign-confirm', array( 'parseinline' ) ), 'wpConfirm', 'wpConfirm', $this->mConfirm ) ) .
			Xml::tags( 'p', null, Xml::submitButton( wfMsg( 'confirm' ) ) ) .
			Xml::hidden( 'wpToken', $wgUser->editToken() ) .
			Xml::closeElement( 'form' )
		);
	}

	function doSubmit() {
		global $wgOut, $wgUser;

		if ( !$this->mConfirm ) {
			$wgOut->addHTML( Xml::tags( 'p', array( 'class' => 'error' ), wfMsgExt( 'resign-noconfirm', array( 'parseinline' ) ) ) );
			return;
		}

		if ( count( $this->mGroups ) == 0 ) {
			$wgOut->addHTML( Xml::tags( 'p', array( 'class' => 'error' ), wfMsgExt( 'resign-nogroups', array( 'parseinline' ) ) ) );
			return;
		}

		foreach( $this->mGroups as $group ) {
			$wgUser->removeGroup( $group );
		}

		$log = new LogPage( 'rights' );
		$log->addEntry( 'resign', Title::makeTitle( NS_USER, $wgUser->getName() ), $this->mReason, array( $this->makeGroupNameList( $this->mGroups ) ) );

		$wgOut->addHTML( Xml::tags( 'p', null, wfMsgExt( 'resign-success', array( 'parseinline' ) ) ) );
	}

	function makeGroupNameList( $ids ) {
		return implode( ', ', $ids );
	}
}
