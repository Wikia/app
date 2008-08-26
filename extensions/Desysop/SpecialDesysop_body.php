<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "DeSysop extension\n";
	exit( 1 );
}

require_once( 'SpecialUserrights.php' );
require_once( "LinksUpdate.php" );

class DeSysopPage extends SpecialPage {
	function __construct() {
		parent::__construct( 'Desysop', 'desysop' );
	}

	function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest;

		wfLoadExtensionMessages( 'Desysop' );

		if ( $wgUser->isAnon() or $wgUser->isBlocked() ) {
			$wgOut->errorpage( "movenologin", "movenologintext" );
			return;
		}
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if ( !$wgUser->isAllowed( 'desysop' ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();

		$f = new DesysopForm( $wgRequest );
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
class DesysopForm {
	var $mTarget, $mAction, $mRights, $mUser, $mSubmit, $mSetBureaucrat;

	function DesysopForm( &$request ) {
		global $wgUser;

		$this->mAction = $request->getText( 'action' );
		$this->mRights = $request->getVal( 'wpRights' );
		$this->mUser = $request->getText( 'wpDesysopUser' );
		$this->mSubmit = $request->getBool( 'wpDesysopSubmit' ) &&
			$request->wasPosted() &&
			$wgUser->matchEditToken( $request->getVal( 'wpEditToken' ) );
	}

	function showForm( $err = '') {
		global $wgOut, $wgUser, $wgLang;

		$wgOut->setPagetitle( wfMsg( "desysoptitle" ) );
		$wgOut->addWikiText( wfMsg( "desysoptext" ) );

		$titleObj = Title::makeTitle( NS_SPECIAL, "Desysop" );
		$action = $titleObj->escapeLocalURL( "action=submit" );

		if ( "" != $err ) {
			$wgOut->setSubtitle( wfMsg( "formerror" ) );
			$wgOut->addHTML( "<p class='error'>{$err}</p>\n" );
		}
		$namedesc = wfMsg( "desysopname" );
		if ( !is_null( $this->mUser ) ) {
			$encUser = htmlspecialchars( $this->mUser );
		} else {
			$encUser = "";
		}

		$wgOut->addHTML( "
			<form id=\"desysop\" method=\"post\" action=\"{$action}\">
			<table border='0'>
			<tr>
				<td align='right'>$namedesc</td>
				<td align='left'>
					<input type='text' size='40' name=\"wpDesysopUser\" value=\"$encUser\" />
				</td>
			</tr>"
		);

		$mss = wfMsg( "desysopsetrights" );

		$token = htmlspecialchars( $wgUser->editToken() );
		$wgOut->addHTML(
			"<tr>
				<td>&nbsp;</td><td align='left'>
					<input type='submit' name=\"wpDesysopSubmit\" value=\"{$mss}\" />
				</td></tr></table>
				<input type='hidden' name='wpEditToken' value=\"{$token}\" />
			</form>\n"
		);
	}

	function doSubmit() {
		global $wgOut, $wgUser, $wgLang;
		global $wgDBname, $wgMemc, $wgLocalDatabases, $wgSharedDB;

		$fname = 'DesysopForm::doSubmit';

		$dbw =& wfGetDB( DB_MASTER );
		$user_groups = $dbw->tableName( 'user_groups' );
		$usertable   = $dbw->tableName( 'user' );

		$username = $this->mUser;
		$dbName = $wgDBname;

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
		if ( $wasSysop ) {
			$dbw->delete( 'user_groups',
                        	array(
                                	'ug_user' => $id,
                                	'ug_group' => 'sysop',
                        	),
                        	'DesysopForm::doSubmit' );
			$addedGroups[] = "sysop";
		} elseif ( !$wasSysop ) {
			$this->showFail( 'desysopnot_sysop' );
			return;
		}

		$wgMemc->delete( "$dbName:user:id:$id" );

		//array_diff does the trick.
		$newGroups = array_diff($oldGroups, $addedGroups);

		$log = new LogPage( 'rights' );
		$log->addEntry( 'rights', Title::makeTitle( NS_USER, $this->mUser ), '',
			array( $this->makeGroupNameList( $oldGroups ), $this->makeGroupNameList( $newGroups ) ) );

		$this->showSuccess();
	}

	function showSuccess() {
		global $wgOut, $wgUser;

		$wgOut->setPagetitle( wfMsg( "desysoptitle" ) );
		$text = wfMsg( "desysopok", $this->mUser );
		$text .= "\n\n";
		$wgOut->addWikiText( $text );
		$this->showForm();

	}

	function showFail( $msg = 'desysoprightsfail' ) {
		global $wgOut, $wgUser;

		$wgOut->setPagetitle( wfMsg( "desysoptitle" ) );
		$this->showForm( wfMsg( $msg, $this->mUser ) );
	}

	function makeGroupNameList( $ids ) {
		return implode( ', ', $ids );
	}

}
