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
 * Special page to allow managing invitations by users.
 *
 * @addtogroup Extensions
 */

class SpecialInvitations extends SpecialPage {
	function __construct() {
		parent::__construct('Invitations');
	}

	function execute( $subpage ) {
		wfLoadExtensionMessages('Invitations');
		global $wgRequest;

		if ($subpage != '' && $wgRequest->getBool('invite_submit')) {
			$this->doInviteSubmit($subpage);
		} else if ($subpage != '') {
			$this->buildFeatureView($subpage);
		} else {
			$this->buildMainView();
		}
	}

	function buildMainView() {
		global $wgOut,$wgUser,$wgInvitationTypes, $wgLang;
		$sk = $wgUser->getSkin();

		$wgOut->setPageTitle( wfMsg( 'invitations-pagetitle' ) );
		$wgOut->setRobotpolicy( "noindex,nofollow" );
		$wgOut->setArticleRelated( false );
		$wgOut->enableClientCache( false );

		$invitedfeatures = Invitations::getAllowedFeatures();

		if (count($invitedfeatures)) {
			$wgOut->addWikiMsg( 'invitations-invitedlist-description' );
			$wgOut->addHTML( '<ul>' );

			foreach ($invitedfeatures as $feature) {
				$link = $sk->makeKnownLinkObj( SpecialPage::getTitleFor( 'Invitations', $feature ), wfMsgHtml("invitation-type-$feature") );
				$num = $wgLang->formatNum( Invitations::getRemainingInvites( $feature ) );

				$text = "<b>$link</b>";
				$text = ' '. wfMsgExt( 'invitations-invitedlist-item-count', 'parseinline', $num );

				$wgOut->addHTML( "<li> $text </li>" );
			}
		} else {
			$wgOut->addWikiMsg( 'invitations-invitedlist-none' );
		}

		$uninvitedfeatures = array_diff( array_keys($wgInvitationTypes), $invitedfeatures );

		if (count($uninvitedfeatures)) {
			$wgOut->addWikiMsg( 'invitations-uninvitedlist-description' );
			$wgOut->addHTML( '<ul>' );

			foreach ($uninvitedfeatures as $feature) {
				$link = $sk->makeKnownLinkObj( SpecialPage::getTitleFor( 'Invitations', $feature ), wfMsgHtml("invitation-type-$feature") );

				$text = "<b>$link</b>";

				$wgOut->addHTML( "<li> $text </li>" );
			}
		} else {
			$wgOut->addWikiMsg( 'invitations-uninvitedlist-none' );
		}
	}

	function doInviteSubmit( $feature ) {
		global $wgRequest;

		$username = $wgRequest->getVal( 'user' );
		$invitee = User::newFromName($username);

		if ($invitee->getId() == 0) {
			$this->buildFeatureView( $feature, 'invitation-error-baduser' );
			return;
		}

		if ( ($res = Invitations::inviteUser( $feature, $invitee )) == INVITE_RESULT_OK  ) {
			$this->buildFeatureView( $feature, false, array( 'invitations-invite-success', $username ) );
		} else {
			$results = array( INVITE_RESULT_ALREADY_INVITED => array( 'invitations-error-alreadyinvited', $username ),
					INVITE_RESULT_NOT_ALLOWED => array( 'invitations-feature-notallowed', wfMsg("invitations-type-$feature") ),
					INVITE_RESULT_NONE_LEFT => array( 'invitations-feature-noneleft' ),
					INVITE_RESULT_NONE_YET => array( 'invitations-feature-noneyet' ) );

			$this->buildFeatureView( $feature, $results[$res] );
		}
	}

	function buildFeatureView( $feature, $error = false, $success = false ) {
		global $wgUser, $wgOut, $wgInvitationTypes, $wgLang;

		$friendlyname = wfMsg("invitation-type-$feature");

		$wgOut->setPageTitle( wfMsg( 'invitations-feature-pagetitle', $friendlyname ) );
		$wgOut->setRobotpolicy( "noindex,nofollow" );
		$wgOut->setArticleRelated( false );
		$wgOut->enableClientCache( false );

		if (Invitations::hasInvite($feature)) {
			$wgOut->addWikiMsg( 'invitations-feature-access', $friendlyname );
			$numleft = Invitations::getRemainingInvites($feature);
			$numLeftFmt = $wgLang->formatNum( $numleft );

			if ($numleft > 0) {
				$allocation = $wgLang->formatNum( $wgInvitationTypes[$feature]['reserve'] );

				$wgOut->addWikiMsg( 'invitations-feature-numleft', $numleftFmt, $allocation );
			} else if ($numleft == -1) {
				# Do nothing.
			} else if (!Invitations::checkDelay( $feature ) ) {
				$wgOut->addWikiMsg( 'invitations-feature-noneyet' );
			} else {
				$wgOut->addWikiMsg( 'invitations-feature-noneleft' );
			}

			// Successes and errors

			if ($error) {
				$wgOut->wrapWikiMsg( '<div class="error">$1</div>', $error );
			} else if ($success) {
				$wgOut->wrapWikiMsg( '<big>$1</big>', $success );
			}

			// Invitation form
			if ($numleft != 0)
				$wgOut->addHTML( $this->buildInvitationForm($feature, $error) );
		} else {
			$wgOut->addWikiMsg( 'invitations-feature-notallowed', $friendlyname );
		}
	}

	function buildInvitationForm( $feature, $error = false ) {
		$friendlyname = wfMsgHtml("invitation-type-$feature");

		$form = '<h2>'.wfMsgExt('invitations-inviteform-title', 'parseinline', $friendlyname).'</h2>';
		$form  = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $wgScript, 'name' => 'uluser' ) );
		$form .= Xml::hidden( 'title',  SpecialPage::getTitleFor('Invitations', $feature)->getPrefixedText() ); 
		$form .= Xml::hidden( 'invite_submit', 1 ); 
		$form .= '<fieldset><legend>' . wfMsgHtml( 'invitations-inviteform-title', $friendlyname ) . '</legend>';
		$form .= '<p>' . Xml::inputLabel( wfMsg( 'invitations-inviteform-username' ), 'user', 'username', 30, $this->mTarget ) . '</p>';
		$form .= '<p>' . Xml::submitButton( wfMsg( 'invitations-inviteform-submit' ) ) . '</p>';
		$form .= '</fieldset>';
		$form .= '</form>';

		return $form;
	}
}