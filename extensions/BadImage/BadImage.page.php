<?php

/**
 * Class provides a special page to manage the bad image list
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence Copyright holder allows use of the code for any purpose
 */

class BadImageManipulator extends SpecialPage {

	function __construct() {
		parent::__construct( 'Badimages' );
	}
	
	function execute() {
		global $wgUser, $wgOut, $wgRequest;
		$this->setHeaders();
		
		# Check permissions
		if( $wgUser->isAllowed( 'badimages' ) ) {
			# Check for actions pending
			$action = $wgRequest->getText( 'action' );
			if( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getText( 'wpToken' ) ) ) {
				if( $action == 'add' ) {
					$this->attemptAdd( $wgRequest, $wgOut, $wgUser );
				} elseif( $action == 'remove' ) {
					$this->attemptRemove( $wgRequest, $wgOut, $wgUser );
				}
			} elseif( $action == 'remove' ) {
				$this->showRemove( $wgOut, $wgRequest->getText( 'image' ), $wgUser );
			} else {
				$this->showAdd( $wgOut, $wgUser );
			}
		} else {
			$wgOut->addWikiMsg( 'badimages-unprivileged' );
		}
		
		# List existing bad images
		$this->listExisting();
	}
	
	function showAdd( &$output, &$user ) {
		$self = Title::makeTitle( NS_SPECIAL, 'Badimages' );
		$form  = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $self->getLocalUrl() ) );
		$form .= Xml::hidden( 'action', 'add' ) . Xml::hidden( 'wpToken', $user->editToken() );
		$form .= '<table><tr><td align="right">' . wfMsgHtml( 'badimages-name' ) . '</td>';
		$form .= '<td>' . Xml::input( 'wpImage' ) . '</td></tr>';
		$form .= '<tr><td align="right">' . wfMsgHtml( 'badimages-reason' ) . '</td>';
		$form .= '<td>' . Xml::input( 'wpReason', 40 ) . '</td><tr></tr><td></td><td>';
		$form .= Xml::submitButton( wfMsg( 'badimages-add-btn' ) ) . '</td></tr></table></form>';
		$output->addHtml( $form );
	}
	
	function attemptAdd( &$request, &$output, &$user ) {
		wfProfileIn( __METHOD__ );
		# TODO: Errors should be puked back up, not tucked out of sight
		# -- the user should be informed when providing dud titles, etc.
		$title = $this->title( $request->getText( 'wpImage' ) );
		if( is_object( $title ) ) {
			BadImageList::add( $title->getDBkey(), $user->getId(), $request->getText( 'wpReason' ) );
			$this->touch( $title );
			$this->log( 'add', $title, $request->getText( 'wpReason' ) );
			$skin =& $user->getSkin();
			$link = $skin->makeKnownLinkObj( $title, htmlspecialchars( $title->getText() ) );
			$output->setSubtitle( wfMsgHtml( 'badimages-added', $link ) );
		} else {
			# TODO: Tell the user it was a dud title
			$output->setSubtitle( wfMsgHtml( 'badimages-not-added' ) );
		}
		$this->showAdd( $output, $user ); # FIXME: This hack sucks a bit
		wfProfileOut( __METHOD__ );
	}
	
	function showRemove( &$output, $name, &$user ) {
		$self = Title::makeTitle( NS_SPECIAL, 'Badimages' );
		$skin =& $user->getSkin();
		$title = Title::makeTitleSafe( NS_IMAGE, $name );
		$link = $skin->makeKnownLinkObj( $title, htmlspecialchars( $title->getText() ) );
		$output->addHtml( '<p>' . wfMsgHtml( 'badimages-remove-confirm', $link ) . '</p>' );
		$form  = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $self->getLocalUrl() ) );
		$form .= Xml::hidden( 'action', 'remove' ) . Xml::hidden( 'wpToken', $user->editToken() ) . Xml::hidden( 'wpImage', $name );
		$form .= '<table><tr><td align="right">' . wfMsgHtml( 'badimages-name' ) . '</td>';
		$form .= '<td>' . Xml::input( 'wpImage2', false, $name, array( 'readonly' => 'readonly' ) ) . '</td></tr>';
		$form .= '<tr><td align="right">' . wfMsgHtml( 'badimages-reason' ) . '</td>';
		$form .= '<td>' . Xml::input( 'wpReason', 40 ) . '</td><tr></tr><td></td><td>';
		$form .= Xml::submitButton( wfMsg( 'badimages-remove-btn' ) ) . '</td></tr></table></form>';
		$output->addHtml( $form );
	}

	function attemptRemove( &$request, &$output, &$user ) {
		wfProfileIn( __METHOD__ );
		$title = $this->title( $request->getText( 'wpImage' ) );
		if( is_object( $title ) ) {
			BadImageList::remove( $title->getDBkey() );
			$this->touch( $title );
			$this->log( 'remove', $title, $request->getText( 'wpReason' ) );
			$skin =& $user->getSkin();
			$link = $skin->makeKnownLinkObj( $title, htmlspecialchars( $title->getText() ) );
			$output->setSubtitle( wfMsgHtml( 'badimages-removed', $link ) );
		} else {
			# Shouldn't happen in normal (dumb user) usage
			$output->setSubtitle( wfMsgHtml( 'badimages-not-removed' ) );
		}
		$this->showAdd( $output, $user );
		wfProfileOut( __METHOD__ );
	}
	
	function title( $name ) {
		$title = Title::newFromText( $name );
		if( is_object( $title ) ) {
			return $title->getNamespace() == NS_IMAGE
					? $title
					: Title::makeTitle( NS_IMAGE, $title->getText() );
		} else {
			return NULL;
		}
	}
	
	function log( $action, &$target, $reason ) {
		$log = new LogPage( 'badimage' );
		$log->addEntry( $action, $target, $reason );
	}
	
	function touch( &$title ) {
		wfProfileIn( __METHOD__ );
		$update = new HTMLCacheUpdate( $title, 'imagelinks' );
		$update->doUpdate();
		wfProfileOut( __METHOD__ );
	}

	function listExisting() {
		global $wgOut, $wgUser, $wgLang;
		wfProfileIn( __METHOD__ );
		$dbr =& wfGetDB( DB_SLAVE );
		extract( $dbr->tableNames( 'bad_images', 'user' ) );
		$sql = "SELECT * FROM {$bad_images} LEFT JOIN {$user} ON bil_user = user_id";
		$res = $dbr->query( $sql, __METHOD__ );
		$wgOut->addHtml( Xml::element( 'h2', null, wfMsg( 'badimages-subheading' ) ) );
		if( $res ) {
			$count = $wgLang->formatNum( $dbr->numRows( $res ) );
			$wgOut->addWikiMsg( 'badimages-count', $count );
			$skin =& $wgUser->getSkin();
			$wgOut->addHtml( '<ul>' );
			while( $row = $dbr->fetchObject( $res ) )
				$wgOut->addHtml( $this->makeListRow( $row, $skin, $wgLang, $wgUser->isAllowed( 'badimages' ) ) );
			$wgOut->addHtml( '</ul>' );
		}
		wfProfileOut( __METHOD__ );
	}
	
	function makeListRow( $result, &$skin, &$lang, $priv ) {
		$title = Title::makeTitleSafe( NS_IMAGE, $result->bil_name );
		$ilink = $skin->makeLinkObj( $title, htmlspecialchars( $title->getText() ) );
		if( $priv ) {
			$self = Title::makeTitle( NS_SPECIAL, 'Badimages' );
			$ilink .= ' ' . $skin->makeKnownLinkObj( $self, wfMsgHtml( 'badimages-remove' ), 'action=remove&image=' . $title->getPartialUrl() );
		}
		$ulink = $skin->userLink( $result->bil_user, $result->user_name ) . $skin->userToolLinks( $result->bil_user, $result->user_name );
		$time = $lang->timeAndDate( $result->bil_timestamp, true );
		$comment = $skin->commentBlock( $result->bil_reason );
		return "<li>{$ilink} . . {$time} . . {$ulink} {$comment}</li>";
	}

}

