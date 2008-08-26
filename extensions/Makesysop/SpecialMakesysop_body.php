<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "MakeSysop extension\n";
	exit( 1 );
}

class MakeSysopPage extends SpecialPage {
	function __construct() {
		parent::__construct( 'Makesysop', 'makesysop' );
		wfLoadExtensionMessages( 'Makesysop' );
	}

	function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest;

		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if ( !$wgUser->isAllowed( 'makesysop' ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();

		$f = new MakesysopForm( $wgRequest );
		if ( $f->mSubmit ) {
			$f->doSubmit();
		} else {
			$f->showForm( '' );
		}
	}
}

/**
 *
 * @addtogroup SpecialPage
 */
class MakesysopForm {
	var $mTarget, $mAction, $mRights, $mUser, $mReason, $mSubmit, $mSetBureaucrat;

	function MakesysopForm( &$request ) {
		global $wgUser;

		$this->mAction = $request->getText( 'action' );
		$this->mRights = $request->getVal( 'wpRights' );
		$this->mUser = $request->getText( 'wpMakesysopUser' );
		$this->mReason = $request->getText( 'wpMakesysopReason' );
		$this->mSubmit = $request->getBool( 'wpMakesysopSubmit' ) &&
			$request->wasPosted() &&
			$wgUser->matchEditToken( $request->getVal( 'wpEditToken' ) );		
		$this->mSetBureaucrat = $request->getBool( 'wpSetBureaucrat' );
	}

	function showForm( $err = '') {
		global $wgOut, $wgUser, $wgLang;

		$wgOut->setPagetitle( wfMsg( "makesysoptitle" ) );
		$wgOut->addWikiText( wfMsg( "makesysoptext" ) );

		$titleObj = Title::makeTitle( NS_SPECIAL, "Makesysop" );
		$action = $titleObj->getLocalUrl( "action=submit" );

		if( $wgUser->isAllowed( 'userrights' ) ) {
			$wgOut->addWikiText( wfMsg( 'makesysop-see-userrights' ) );
		}

		if ( "" != $err ) {
			$wgOut->setSubtitle( wfMsg( "formerror" ) );
			$wgOut->addHTML( "<p class='error'>{$err}</p>\n" );
		}
		$namedesc = wfMsg( "makesysopname" );
		if ( !is_null( $this->mUser ) ) {
			$encUser = htmlspecialchars( $this->mUser );
		} else {
			$encUser = "";
		}

		$reason = htmlspecialchars( wfMsg( "userrights-reason" ) );
		$makebureaucrat = wfMsg( "setbureaucratflag" );
		$mss = wfMsg( "set_user_rights" );

		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'method' => 'post', 'action' => $action, 'id' => 'makesysop' ) ) .
			Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', array(), wfMsg( 'makesysoptitle' ) ) .
			"<table border='0'>
			<tr>
				<td align='right'>$namedesc</td>
				<td align='left'>" . Xml::input( 'wpMakesysopUser', 40, $encUser ) . "</td>
			</tr><tr>
				<td align='right'>$reason</td>
				<td align='left'>" . Xml::input( 'wpMakesysopReason', 40, $this->mReason, array( 'maxlength' => 255 ) ) . "</td>
			</tr><tr>
				<td>&nbsp;</td>
				<td align='left'>" . Xml::checkLabel( $makebureaucrat, 'wpSetBureaucrat', 'wpSetBureaucrat', $this->mSetBureaucrat ) . "</td>
			</tr><tr>
				<td>&nbsp;</td>
				<td align='left'>" . Xml::submitButton( $mss, array( 'name' => 'wpMakesysopSubmit' ) ) . "</td>
			</tr>
			</table>" .
			Xml::hidden( 'wpEditToken', $wgUser->editToken() ) .
			Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' ) . "\n"
		);
	}

	function doSubmit() {
		global $wgOut, $wgUser, $wgLang;
		global $wgDBname, $wgMemc, $wgLocalDatabases, $wgSharedDB;

		$fname = 'MakesysopForm::doSubmit';

		$dbw =& wfGetDB( DB_MASTER );
		$user_groups = $dbw->tableName( 'user_groups' );
		$usertable   = $dbw->tableName( 'user' );

		$username = $this->mUser;

		// Clean up username
		$t = Title::newFromText( $username );
		if ( !$t ) {
			$this->showFail();
			return;
		}
		$username = $t->getText();

		if ( $username{0} == "#" ) {
			$id = intval( substr( $username, 1 ) );
		} else {
			$id = $dbw->selectField( $usertable, 'user_id', array( 'user_name' => $username ), $fname );
		}
		if ( !$id ) {
			$this->showFail();
			return;
		}

		$sql = "SELECT ug_user,ug_group FROM $user_groups WHERE ug_user=$id FOR UPDATE";
		$res = $dbw->query( $sql, $fname );

		$row = false;
		$oldGroups = array();
		while ( $row = $dbw->fetchObject( $res ) ) {
			$oldGroups[] = $row->ug_group;
		}
		$dbw->freeResult( $res );
		$newGroups = $oldGroups;

		$wasSysop = in_array( 'sysop', $oldGroups );
		$wasBureaucrat = in_array( 'bureaucrat', $oldGroups );

		$addedGroups = array();
		if ( ( $this->mSetBureaucrat ) && ( $wasBureaucrat ) ) {
			$this->showFail( 'already_bureaucrat' );
			return;
		} elseif ( ( !$this->mSetBureaucrat ) && ( $wasSysop ) ) {
			$this->showFail( 'already_sysop' );
			return;
		} elseif ( !$wasSysop ) {
			$dbw->insert( $user_groups, array( 'ug_user' => $id, 'ug_group' => 'sysop' ), $fname );
			$addedGroups[] = "sysop";
		}
		if ( ( $this->mSetBureaucrat ) && ( !$wasBureaucrat ) ) {
			$dbw->insert( $user_groups, array( 'ug_user' => $id, 'ug_group' => 'bureaucrat' ), $fname );
			$addedGroups[] = "bureaucrat";
		}

		if ( function_exists( 'wfMemcKey' ) ) {
			$wgMemc->delete( wfMemcKey( 'user', 'id', $id ) );
		} else {
			$wgMemc->delete( "$wgDBname:user:id:$id" );
		}

		$newGroups = array_merge($newGroups, $addedGroups);

		$log = new LogPage( 'rights' );
		$log->addEntry( 'rights', Title::makeTitle( NS_USER, $username ), $this->mReason,
			array( $this->makeGroupNameList( $oldGroups ), $this->makeGroupNameList( $newGroups ) ) );

		$this->showSuccess();
	}

	function showSuccess() {
		global $wgOut, $wgUser;

		$wgOut->setPagetitle( wfMsg( "makesysoptitle" ) );
		$text = wfMsg( "makesysopok", $this->mUser );
		if ( $this->mSetBureaucrat ) {
			$text .= "<br />" . wfMsg( "makebureaucratok", $this->mUser );
		}
		$text .= "\n\n";
		$wgOut->addWikiText( $text );
		$this->showForm();

	}

	function showFail( $msg = 'set_rights_fail' ) {
		global $wgOut, $wgUser;

		$wgOut->setPagetitle( wfMsg( "makesysoptitle" ) );
		$this->showForm( wfMsg( $msg, $this->mUser ) );
	}

	function makeGroupNameList( $ids ) {
		return implode( ', ', $ids );
	}

}
