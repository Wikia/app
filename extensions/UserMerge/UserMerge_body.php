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
class UserMerge extends SpecialPage
{
        function UserMerge() {
                SpecialPage::SpecialPage("UserMerge","usermerge");
        }

        function execute( $par ) {
                global $wgRequest, $wgOut, $wgUser, $wgTitle;

	 	wfLoadExtensionMessages('UserMerge');

                $this->setHeaders();

                if ( !$wgUser->isAllowed( 'usermerge' ) ) {
                        $wgOut->permissionRequired( 'usermerge' );
                        return;
                }

				// init variables
				$olduser_text = '';
				$newuser_text = '';
				$deleteUserCheck = '';
				$validNewUser = false;

                if (strlen($wgRequest->getText('olduser').$wgRequest->getText('newuser'))>0 || $wgRequest->getText( 'deleteuser' )) {
                    //POST data found
                    $olduser = Title::newFromText( $wgRequest->getText( 'olduser' ) );
                    $olduser_text = is_object( $olduser ) ? $olduser->getText() : '';

                    $newuser = Title::newFromText( $wgRequest->getText( 'newuser' ) );
                    $newuser_text = is_object( $newuser ) ? $newuser->getText() : '';

                    if ($wgRequest->getText( 'deleteuser' )) {
                      $deleteUserCheck = "CHECKED ";
                    }

                    if (strlen($olduser_text)>0) {
                      $objOldUser = User::newFromName( $olduser_text );
                      $olduserID = $objOldUser->idForName();

					  global $wgUser;

                      if ( !is_object( $objOldUser ) ) {
                        $validOldUser = false;
                        $wgOut->addHTML( "<span style=\"color: red;\">" . wfMsg('usermerge-badolduser') . "</span><br />\n" );
					  } elseif ( $olduserID == $wgUser->getID() ) {
                        $validOldUser = false;
                        $wgOut->addHTML( "<span style=\"color: red;\">" . wfMsg('usermerge-noselfdelete') . "</span><br />\n" );
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
							$wgOut->addHTML( "<span style=\"color: red;\">" . wfMsg('usermerge-protectedgroup') . "</span><br />\n" );
						} else {
	                        $validOldUser = true;

	                        if (strlen($newuser_text)>0) {

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
									$wgOut->addHTML( "<span style=\"color: red;\">" . wfMsg('usermerge-badnewuser') . "</span><br />\n" );
								}
	                          } else {
	                            //newuser looks good
	                            $validNewUser = true;
	                          }
	                        } else {
	                          //empty newuser string
	                          $validNewUser = false;
							  $newuser_text = "Anonymous";
	                          $wgOut->addHTML( "<span style=\"color: red;\">" . wfMsg('usermerge-nonewuser', $newuser_text) . "</span><br />\n" );
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

                $action = $wgTitle->escapeLocalUrl();
                $token = $wgUser->editToken();

                $wgOut->addHTML( "
<form id='usermergeform' method='post' action=\"$action\">
<table>
        <tr>
                <td align='right'>" . wfMsg('usermerge-olduser') . "</td>
                <td align='left'><input tabindex='1' type='text' size='20' name='olduser' id='olduser' value=\"$olduser_text\" onFocus=\"document.getElementById('olduser').select;\" /></td>
        </tr>
        <tr>
                <td align='right'>" . wfMsg('usermerge-newuser') . "</td>
                <td align='left'><input tabindex='2' type='text' size='20' name='newuser' id='newuser' value=\"$newuser_text\" onFocus=\"document.getElementById('newuser').select;\" /></td>
        </tr>
        <tr>
                <td align='right'>" . wfMsg('usermerge-deleteolduser') . "</td>
                <td align='left'><input tabindex='3' type='checkbox' name='deleteuser' id='deleteuser' $deleteUserCheck/></td>
        </tr>
        <tr>
                <td>&nbsp;</td>
                <td align='right'><input type='submit' name='submit' value=\"" . wfMsg('usermerge-submit') . "\" /></td>
        </tr>
</table>
<input type='hidden' name='token' value='$token' />
</form>");

                if ($validNewUser && $validOldUser) {
                  //go time, baby
                  if (!$wgUser->matchEditToken( $wgRequest->getVal( 'token' ) ) ) {
                    //bad editToken
                    $wgOut->addHTML( "<span style=\"color: red;\">" . wfMsg('usermerge-badtoken') . "</span><br />\n" );
                  } else {
                    //good editToken
                    $this->mergeUser($newuser_text,$newuserID,$olduser_text,$olduserID);
                    if ($wgRequest->getText( 'deleteuser' )) {
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
        private function deleteUser ($olduserID, $olduser_text) {
                global $wgOut,$wgUser;

                $dbw =& wfGetDB( DB_MASTER );
                $dbw->delete( 'user_groups', array( 'ug_user' => $olduserID ));
                $dbw->delete( 'user', array( 'user_id' => $olduserID ));
                $wgOut->addHTML(wfMsg('usermerge-userdeleted', $olduser_text, $olduserID));

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
		 private function mergeUser ($newuser_text, $newuserID, $olduser_text, $olduserID) {
                global $wgOut, $wgUser;

                $textUpdateFields = array(array('archive','ar_user_text'),
                                          array('revision','rev_user_text'),
                                          array('filearchive','fa_user_text'),
                                          array('image','img_user_text'),
                                          array('oldimage','oi_user_text'),
                                          array('recentchanges','rc_user_text'),
                                          array('ipblocks','ipb_address'));

                $idUpdateFields = array(array('archive','ar_user'),
                                          array('revision','rev_user'),
                                          array('filearchive','fa_user'),
                                          array('image','img_user'),
                                          array('oldimage','oi_user'),
                                          array('recentchanges','rc_user'),
                                          array('logging','log_user'));

                $dbw =& wfGetDB( DB_MASTER );

                foreach ($idUpdateFields as $idUpdateField) {
                  $dbw->update($idUpdateField[0], array( $idUpdateField[1] => $newuserID ), array( $idUpdateField[1] => $olduserID ));
                  $wgOut->addHTML(wfMsg('usermerge-updating', $idUpdateField[0], $olduserID, $newuserID) . "<br />\n");
                }

                foreach ($textUpdateFields as $textUpdateField) {
                  $dbw->update($textUpdateField[0], array( $textUpdateField[1] => $newuser_text ), array( $textUpdateField[1] => $olduser_text ));
                  $wgOut->addHTML(wfMsg('usermerge-updating', $textUpdateField[0], $olduser_text, $newuser_text) . "<br />\n");
                }


                $dbw->delete( 'user_newtalk', array( 'user_id' => $olduserID ));

                $wgOut->addHTML("<hr />\n" . wfMsg('usermerge-success',$olduser_text,$olduserID,$newuser_text,$newuserID) . "\n<br />");

				$log = new LogPage( 'usermerge' );
				$log->addEntry( 'mergeuser', $wgUser->getUserPage(),'',array($olduser_text,$olduserID,$newuser_text,$newuserID) );

				return true;
        }
}
