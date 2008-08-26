<?php

/**
 * Special page class for the Vote extension
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 *
 * Please see the LICENCE file for terms of use and redistribution
 */

class SpecialVote extends SpecialPage {

	private $user;

	public function __construct() {
		parent::__construct( 'Vote', 'vote' );
	}

	public function execute( $mode ) {
		global $wgOut, $wgUser;
		wfLoadExtensionMessages( 'SpecialVote' );
		$this->setHeaders();
		$this->user = $wgUser;
		if( strtolower( $mode ) == 'results' ) {
			if( $wgUser->isAllowed( 'voteadmin' ) )
				$this->showResults();
		} else {
			if( $wgUser->isAnon() ) {
				$skin = $wgUser->getSkin();
				$self = SpecialPage::getTitleFor( 'Vote' );
				$login = SpecialPage::getTitleFor( 'Userlogin' );
				$link = $skin->makeKnownLinkObj( $login, wfMsgHtml( 'vote-login-link' ), 'returnto=' . $self->getPrefixedUrl() );
				$wgOut->addHtml( wfMsgWikiHtml( 'vote-login', $link ) );
				return;
			} elseif( !$wgUser->isAllowed( 'vote' ) ) {
				$wgOut->permissionRequired( 'vote' );
				return;
			} else {
				$this->showNormal();
			}
		}
	}

	private function showNormal() {
		global $wgOut, $wgRequest, $wgUser;
		$self = SpecialPage::getTitleFor( 'Vote' );
		$token = $wgRequest->getText( 'token' );
		if( $wgUser->isAllowed( 'voteadmin' ) ) {
			$skin = $wgUser->getSkin();
			$rtitle = Title::makeTitle( NS_SPECIAL, $self->getText() . '/results' );
			$rlink = $skin->makeKnownLinkObj( $rtitle, wfMsgHtml( 'vote-view-results' ) );
			$wgOut->addHtml( '<p class="mw-voteresultslink">' . $rlink . '</p>' );
		}
		$wgOut->addWikiText( wfMsgNoTrans( 'vote-header' ) );
		$current = self::getExistingVote( $wgUser );
		if( $wgRequest->wasPosted() && $wgUser->matchEditToken( $token, 'vote' ) ) {
			$vote = strtolower( $wgRequest->getText( 'vote' ) );
			if( in_array( $vote, array_keys( $this->getChoices() ) ) ) {
				self::updateVote( $wgUser, $vote );
				$wgOut->addHtml( '<p class="mw-votesuccess">' . wfMsgHtml( 'vote-registered' ) . '</p>' );
			} else {
				$wgOut->addHtml( '<p class="mw-voteerror">' . wfMsgHtml( 'vote-invalid-choice' ) . '</p>' );
				$wgOut->addHtml( $this->makeForm( $current ) );
			}
		} else {
			if( $current !== false ) {
				$wgOut->addWikiText( wfMsgNoTrans( 'vote-current', $this->getChoiceDesc( $current ) ) );
			}
			$wgOut->addHtml( $this->makeForm( $current ) );
		}
	}

	private static function getExistingVote( $user ) {
		$dbr = wfGetDB( DB_SLAVE );
		$choice = $dbr->selectField( 'vote', 'vote_choice', array( 'vote_user' => $user->getId() ), __METHOD__ );
		return $choice;
	}

	private static function updateVote( $user, $choice ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		$dbw->delete( 'vote', array( 'vote_user' => $user->getId() ), __METHOD__ );
		$dbw->insert( 'vote', array( 'vote_user' => $user->getId(), 'vote_choice' => $choice ), __METHOD__ );
		$dbw->commit();
	}

	private function showResults() {
		global $wgOut, $wgLang;
		$wgOut->setPageTitle( wfMsg( 'vote-results' ) );
		$dbr = wfGetDB( DB_SLAVE );
		$vote = $dbr->tableName( 'vote' );
		$res = $dbr->query( "SELECT vote_choice, COUNT(*) as count FROM {$vote} GROUP BY vote_choice ORDER BY count DESC", __METHOD__ );
		if( $res && $dbr->numRows( $res ) > 0 ) {
			$wgOut->addHtml( '<table class="mw-votedata"><tr>' );
			$wgOut->addHtml( '<th>' . wfMsgHtml( 'vote-results-choice' ) . '</th>' );
			$wgOut->addHtml( '<th>' . wfMsgHtml( 'vote-results-count' ) . '</th></tr>' );
			while( $row = $dbr->fetchObject( $res ) ) {
				$wgOut->addHtml( '<tr><td>' . htmlspecialchars( $this->getChoiceDesc( $row->vote_choice ) ) . '</td>' );
				$wgOut->addHtml( '<td>' . $wgLang->formatNum( $row->count ) . '</td></tr>' );
			}
			$wgOut->addHtml( '</table>' );
		} else {
			$wgOut->addWikiText( wfMsgNoTrans( 'vote-results-none' ) );
		}
	}

	private function getChoices() {
		static $return = false;
		if( !$return ) {
			$return = array();
			$lines = explode( "\n", wfMsgForContent( 'vote-choices' ) );
			foreach( $lines as $line ) {
				list( $short, $long ) = explode( '|', $line, 2 );
				$return[ strtolower( $short ) ] = $long;
			}
		}
		return $return;
	}

	private function getChoiceDesc( $short ) {
		$choices = $this->getChoices();
		return $choices[$short];
	}

	private function makeForm( $current ) {
		global $wgUser;
		$self = $this->getTitle();
		$form  = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $self->getLocalUrl() ) );
		$form .= Xml::hidden( 'token', $wgUser->editToken( 'vote' ) );
		$form .= '<fieldset><legend>' . wfMsgHtml( 'vote-legend' ) . '</legend>';
		$form .= '<p>' . Xml::label( wfMsg( 'vote-caption' ), 'vote' ) . '&nbsp;';
		$form .= Xml::openElement( 'select', array( 'name' => 'vote', 'id' => 'vote' ) );
		foreach( $this->getChoices() as $short => $desc ) {
			$checked = $short == $current;
			$form .= self::makeSelectOption( $short, $desc, $checked );
		}
		$form .= Xml::closeElement( 'select' );
		$form .= '&nbsp;' . Xml::submitButton( wfMsg( 'vote-submit' ) );
		$form .= '</fieldset></form>';
		return $form;
	}

	private static function makeSelectOption( $value, $label, $selected = false ) {
		$attribs = array();
		$attribs['value'] = $value;
		if( $selected )
			$attribs['selected'] = 'selected';
		return Xml::openElement( 'option', $attribs ) . htmlspecialchars( $label ) . Xml::closeElement( 'option' );
	}

}
