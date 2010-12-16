<?php
/** \file
* \brief Contains code for the UserMerge Class (extends SpecialPage).
*/

///Special page class for the User Merge and Delete extension
/**
 * Special page that allows sysops to merge referances from one
 * user to another user - also supports deleting users following
 * merge.
 *
 * @addtogroup Extensions
 * @author Tim Laqua <t.laqua@gmail.com>
 */
class UserMerge extends SpecialPage {
	function __construct() {
		parent::__construct( 'UserMerge', 'usermerge' );
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;

		wfLoadExtensionMessages( 'UserMerge' );

		$this->setHeaders();

		if ( !$wgUser->isAllowed( 'usermerge' ) ) {
			$wgOut->permissionRequired( 'usermerge' );
			return;
		}

		// init variables
		$olduser_text = '';
		$newuser_text = '';
		$deleteUserCheck = false;
		$validNewUser = false;

		if ( strlen( $wgRequest->getText( 'olduser' ).$wgRequest->getText( 'newuser' ) ) > 0 || $wgRequest->getText( 'deleteuser' ) ) {
			//POST data found
			$olduser = Title::newFromText( $wgRequest->getText( 'olduser' ) );
			$olduser_text = is_object( $olduser ) ? $olduser->getText() : '';

			$newuser = Title::newFromText( $wgRequest->getText( 'newuser' ) );
			$newuser_text = is_object( $newuser ) ? $newuser->getText() : '';

			if ( $wgRequest->getText( 'deleteuser' ) ) {
				$deleteUserCheck = true;
			}

			if ( strlen( $olduser_text ) > 0 ) {
				$objOldUser = User::newFromName( $olduser_text );
				$olduserID = $objOldUser->idForName();

				global $wgUser;

				if ( !is_object( $objOldUser ) ) {
					$validOldUser = false;
					$wgOut->wrapWikiMsg( "<div class='error'>\n$1</div>", 'usermerge-badolduser' );
				} elseif ( $olduserID == $wgUser->getID() ) {
					$validOldUser = false;
					$wgOut->wrapWikiMsg( "<div class='error'>\n$1</div>", 'usermerge-noselfdelete' );
				} else {
					global $wgUserMergeProtectedGroups;

					$boolProtected = false;
					foreach ( $objOldUser->getGroups() as $userGroup ) {
						if ( in_array( $userGroup, $wgUserMergeProtectedGroups ) ) {
							$boolProtected = true;
						}
					}

					if ( $boolProtected ) {
						$validOldUser = false;
						$wgOut->wrapWikiMsg( "<div class='error'>\n$1</div>", 'usermerge-protectedgroup' );
					} else {
						$validOldUser = true;

						if (strlen( $newuser_text ) > 0 ) {

							$objNewUser = User::newFromName( $newuser_text );
							$newuserID = $objNewUser->idForName();

							if ( !is_object( $objNewUser ) || $newuserID == 0 ) {
								if ( $newuser_text == 'Anonymous' ) {
									// Merge to anonymous
									$validNewUser = true;
									$newuserID = 0;
								} else {
									//invalid newuser entered
									$validNewUser = false;
									$wgOut->wrapWikiMsg( "<div class='error'>$1</div>", 'usermerge-badnewuser' );
								}
							} else {
								//newuser looks good
								$validNewUser = true;
							}
						} else {
							//empty newuser string
							$validNewUser = false;
							$newuser_text = "Anonymous";
							$wgOut->wrapWikiMsg( "<div class='error'>$1</div>", array( 'usermerge-nonewuser', $newuser_text ) );
						}
					}
				}
			} else {
				$validOldUser = false;
				$wgOut->addHTML( "<span style=\"color: red;\">" . wfMsg('usermerge-noolduser') . "</span><br />\n" );
			}
		} else {
			//NO POST data found
		}

 		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->getTitle()->getLocalUrl(), 'id' => 'usermergeform' ) ) .
			Xml::fieldset( wfMsg( 'usermerge-fieldset' ) ) .
			Xml::openElement( 'table', array( 'id' => 'mw-usermerge-table' ) ) .
			"<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'usermerge-olduser' ), 'olduser' ) .
				"</td>
				<td class='mw-input'>" .
					Xml::input( 'olduser', 20, $olduser_text, array( 'type' => 'text', 'tabindex' => '1', 'onFocus' => "document.getElementById('olduser').select;" ) ) . ' ' .
				"</td>
			</tr>
			<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'usermerge-newuser' ), 'newuser' ) .
				"</td>
				<td class='mw-input'>" .
					Xml::input( 'newuser', 20, $newuser_text, array( 'type' => 'text', 'tabindex' => '2', 'onFocus' => "document.getElementById('newuser').select;" ) ) .
				"</td>
			</tr>
			<tr>
				<td>&nbsp;" .
				"</td>
				<td class='mw-input'>" .
					Xml::checkLabel( wfMsg( 'usermerge-deleteolduser' ), 'deleteuser', 'deleteuser', $deleteUserCheck, array( 'tabindex' => '3' ) ) .
				"</td>
			</tr>
			<tr>
				<td>&nbsp;
				</td>
				<td class='mw-submit'>" .
					Xml::submitButton( wfMsg( 'usermerge-submit' ), array( 'tabindex' => '4' ) ) .
				"</td>
			</tr>" .
			Xml::closeElement( 'table' ) .
			Xml::closeElement( 'fieldset' ) .
			Xml::hidden( 'token', $wgUser->editToken() ) .
			Xml::closeElement( 'form' ) . "\n"
		);

		if ( $validNewUser && $validOldUser ) {
			//go time, baby
			if ( !$wgUser->matchEditToken( $wgRequest->getVal( 'token' ) ) ) {
				//bad editToken
				$wgOut->addHTML( "<span style=\"color: red;\">" . wfMsg( 'usermerge-badtoken' ) . "</span><br />\n" );
			} else {
				//good editToken
				$this->mergeUser( $newuser_text, $newuserID, $olduser_text, $olduserID );
				if ( $wgRequest->getText( 'deleteuser' ) ) {
					$this->deleteUser($olduserID, $olduser_text);
				}
			}
		}
	}

	///Function to delete users following a successful mergeUser call
	/**
	 * Removes user entries from the user table and the user_groups table
	 *
	 * @param $olduserID int ID of user to delete
	 * @param $olduser_text string Username of user to delete
	 *
	 * @return Always returns true - throws exceptions on failure.
	 */
	private function deleteUser( $olduserID, $olduser_text ) {
		global $wgOut,$wgUser;

		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'user_groups', array( 'ug_user' => $olduserID ) );
		$dbw->delete( 'user', array( 'user_id' => $olduserID ) );
		$wgOut->addHTML( wfMsg( 'usermerge-userdeleted', $olduser_text, $olduserID ) );

		$log = new LogPage( 'usermerge' );
		$log->addEntry( 'deleteuser', $wgUser->getUserPage(),'',array($olduser_text,$olduserID) );

		$users = $dbw->selectField( 'user', 'COUNT(*)', array() );
		$admins = $dbw->selectField( 'user_groups', 'COUNT(*)', array( 'ug_group' => 'sysop' ) );
		$dbw->update( 'site_stats',
			array( 'ss_users' => $users, 'ss_admins' => $admins ),
			array( 'ss_row_id' => 1 ) );
		return true;
	}

	///Function to merge database referances from one user to another user
	/**
	 * Merges database references from one user ID or username to another user ID or username
	 * to preserve referential integrity.
	 *
	 * @param $newuser_text string Username to merge referances TO
	 * @param $newuserID int ID of user to merge referances TO
	 * @param $olduser_text string Username of user to remove referances FROM
	 * @param $olduserID int ID of user to remove referances FROM
	 *
	 * @return Always returns true - throws exceptions on failure.
	 */
	private function mergeUser( $newuser_text, $newuserID, $olduser_text, $olduserID ) {
		global $wgOut, $wgUser;

		$textUpdateFields = array(
			array('archive','ar_user_text'),
			array('revision','rev_user_text'),
			array('filearchive','fa_user_text'),
			array('image','img_user_text'),
			array('oldimage','oi_user_text'),
			array('recentchanges','rc_user_text'),
			array('ipblocks','ipb_address')
		);

		$idUpdateFields = array(
			array('archive','ar_user'),
			array('revision','rev_user'),
			array('filearchive','fa_user'),
			array('image','img_user'),
			array('oldimage','oi_user'),
			array('recentchanges','rc_user'),
			array('logging','log_user')
		);

		$dbw = wfGetDB( DB_MASTER );

		foreach ( $idUpdateFields as $idUpdateField ) {
			$dbw->update( $idUpdateField[0], array( $idUpdateField[1] => $newuserID ), array( $idUpdateField[1] => $olduserID ) );
			$wgOut->addHTML( wfMsg('usermerge-updating', $idUpdateField[0], $olduserID, $newuserID ) . "<br />\n" );
		}

		foreach ( $textUpdateFields as $textUpdateField ) {
			$dbw->update( $textUpdateField[0], array( $textUpdateField[1] => $newuser_text ), array( $textUpdateField[1] => $olduser_text ) );
			$wgOut->addHTML( wfMsg( 'usermerge-updating', $textUpdateField[0], $olduser_text, $newuser_text ) . "<br />\n" );
		}

		$dbw->delete( 'user_newtalk', array( 'user_id' => $olduserID ));

		$wgOut->addHTML("<hr />\n" . wfMsg('usermerge-success',$olduser_text,$olduserID,$newuser_text,$newuserID) . "\n<br />");

		$log = new LogPage( 'usermerge' );
		$log->addEntry( 'mergeuser', $wgUser->getUserPage(),'',array($olduser_text,$olduserID,$newuser_text,$newuserID) );

		return true;
	}
}
