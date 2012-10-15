<?php
/** \file
* \brief Contains code for the UserMerge Class (extends SpecialPage).
*/

/**
 * Special page class for the User Merge and Delete extension
 * allows sysops to merge references from one user to another user.
 * It also supports deleting users following merge.
 *
 * @ingroup Extensions
 * @author Tim Laqua <t.laqua@gmail.com>
 * @author Thomas Gries <mail@tgries.de>
 * @author Matthew April <Matthew.April@tbs-sct.gc.ca>
 *
 */

class UserMerge extends SpecialPage {
	function __construct() {
		parent::__construct( 'UserMerge', 'usermerge' );
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;

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

				if ( !is_object( $objOldUser ) || $objOldUser->getID() == 0 ) {
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

							if ( !is_object( $objNewUser ) || $newuserID === 0 ) {
								if ( $newuser_text === 'Anonymous' ) {
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
				$wgOut->addHTML( "<span style=\"color: red;\">" . wfMsg( 'usermerge-noolduser' ) . "</span><br />\n" );
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
					Xml::input( 'olduser', 20, $olduser_text, array( 'type' => 'text', 'tabindex' => '1', 'onFocus' => "document.getElementById( 'olduser' ).select;" ) ) . ' ' .
				"</td>
			</tr>
			<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'usermerge-newuser' ), 'newuser' ) .
				"</td>
				<td class='mw-input'>" .
					Xml::input( 'newuser', 20, $newuser_text, array( 'type' => 'text', 'tabindex' => '2', 'onFocus' => "document.getElementById( 'newuser' ).select;" ) ) .
				"</td>
			</tr>
			<tr>
				<td>&#160;" .
				"</td>
				<td class='mw-input'>" .
					Xml::checkLabel( wfMsg( 'usermerge-deleteolduser' ), 'deleteuser', 'deleteuser', $deleteUserCheck, array( 'tabindex' => '3' ) ) .
				"</td>
			</tr>
			<tr>
				<td>&#160;
				</td>
				<td class='mw-submit'>" .
					Xml::submitButton( wfMsg( 'usermerge-submit' ), array( 'tabindex' => '4' ) ) .
				"</td>
			</tr>" .
			Xml::closeElement( 'table' ) .
			Xml::closeElement( 'fieldset' ) .
			Html::Hidden( 'token', $wgUser->editToken() ) .
			Xml::closeElement( 'form' ) . "\n"
		);

		if ( $validNewUser && $validOldUser ) {
			//go time, baby
			if ( !$wgUser->matchEditToken( $wgRequest->getVal( 'token' ) ) ) {
				//bad editToken
				$wgOut->addHTML( "<span style=\"color: red;\">" . wfMsg( 'usermerge-badtoken' ) . "</span><br />\n" );
			} else {
				//good editToken
				$this->mergeEditcount( $newuserID, $olduserID );
				$this->mergeUser( $objNewUser, $newuser_text, $newuserID, $objOldUser, $olduser_text, $olduserID );
				if ( $wgRequest->getText( 'deleteuser' ) ) {
					$this->movePages( $newuser_text, $olduser_text );
					$this->deleteUser( $objOldUser, $olduserID, $olduser_text);
				}
			}
		}
	}

	/**
	 * Function to delete users following a successful mergeUser call
	 *
	 * Removes user entries from the user table and the user_groups table
	 *
	 * @param $olduserID int ID of user to delete
	 * @param $olduser_text string Username of user to delete
	 *
	 * @return Always returns true - throws exceptions on failure.
	 */
	private function deleteUser( $objOldUser, $olduserID, $olduser_text ) {
		global $wgOut,$wgUser;

		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'user_groups', array( 'ug_user' => $olduserID ) );
		$dbw->delete( 'user', array( 'user_id' => $olduserID ) );
		$wgOut->addHTML( wfMsg( 'usermerge-userdeleted', $olduser_text, $olduserID ) );

		$log = new LogPage( 'usermerge' );
		$log->addEntry( 'deleteuser', $wgUser->getUserPage(), '', array( $olduser_text, $olduserID ) );

		wfRunHooks( 'DeleteAccount', array( &$objOldUser ) );

		$users = $dbw->selectField( 'user', 'COUNT(*)', array() );
		$dbw->update( 'site_stats',
			array( 'ss_users' => $users ),
			array( 'ss_row_id' => 1 ) );
		return true;
	}


	/**
	 * Function to merge database references from one user to another user
	 *
	 * Merges database references from one user ID or username to another user ID or username
	 * to preserve referential integrity.
	 *
	 * @param $newuser_text string Username to merge references TO
	 * @param $newuserID int ID of user to merge references TO
	 * @param $olduser_text string Username of user to remove references FROM
	 * @param $olduserID int ID of user to remove references FROM
	 *
	 * @return Always returns true - throws exceptions on failure.
	 */
	private function mergeUser( $objNewUser, $newuser_text, $newuserID, $objOldUser, $olduser_text, $olduserID ) {
		global $wgOut, $wgUser;

		$idUpdateFields = array(
			array('archive','ar_user'),
			array('revision','rev_user'),
			array('filearchive','fa_user'),
			array('image','img_user'),
			array('oldimage','oi_user'),
			array('recentchanges','rc_user'),
			array('logging','log_user'),
			array('ipblocks', 'ipb_id'),
			array('ipblocks', 'ipb_by'),
			array('watchlist', 'wl_user'),
		);

		$textUpdateFields = array(
			array('archive','ar_user_text'),
			array('revision','rev_user_text'),
			array('filearchive','fa_user_text'),
			array('image','img_user_text'),
			array('oldimage','oi_user_text'),
			array('recentchanges','rc_user_text'),
			array('ipblocks','ipb_address'),
			array('ipblocks','ipb_by_text'),
		);

		$dbw = wfGetDB( DB_MASTER );

		foreach ( $idUpdateFields as $idUpdateField ) {
			$dbw->update( $idUpdateField[0], array( $idUpdateField[1] => $newuserID ), array( $idUpdateField[1] => $olduserID ) );
			$wgOut->addHTML( wfMsg( 'usermerge-updating', $idUpdateField[0], $olduserID, $newuserID ) . "<br />\n" );
		}

		foreach ( $textUpdateFields as $textUpdateField ) {
			$dbw->update( $textUpdateField[0], array( $textUpdateField[1] => $newuser_text ), array( $textUpdateField[1] => $olduser_text ) );
			$wgOut->addHTML( wfMsg( 'usermerge-updating', $textUpdateField[0], $olduser_text, $newuser_text ) . "<br />\n" );
		}

		$dbw->delete( 'user_newtalk', array( 'user_id' => $olduserID ));

		$wgOut->addHTML( "<hr />\n" . wfMsg( 'usermerge-success', $olduser_text, $olduserID, $newuser_text, $newuserID ) . "\n<br />" );

		$log = new LogPage( 'usermerge' );
		$log->addEntry( 'mergeuser', $wgUser->getUserPage(), '', array( $olduser_text, $olduserID, $newuser_text, $newuserID ) );

           	wfRunHooks( 'MergeAccountFromTo', array( &$objOldUser, &$objNewUser ) );

		return true;
	}
	

	/**
	 * Function to add edit count
	 *
	 * Adds edit count of both users
	 *
	 * @param $newuserID int ID of user to merge references TO
	 * @param $olduserID int ID of user to remove references FROM
	 *
	 * @return Always returns true - throws exceptions on failure.
	 *
	 * @author Matthew April <Matthew.April@tbs-sct.gc.ca>
	 */
	private function mergeEditcount( $newuserID, $olduserID ) {
		global $wgOut;

		$dbw = wfGetDB( DB_MASTER );
		
		# old user edit count
		$result = $dbw->selectField( 'user',
				'user_editcount',
				array( 'user_id' => $olduserID ),
				__METHOD__
			  );
		$row = $dbw->fetchRow($result);
		
		$oldEdits = $row[0];
		
		# new user edit count
		$result = $dbw->selectField( 'user',
				'user_editcount',
				array( 'user_id' => $newuserID ),
				__METHOD__
			  );
		$row = $dbw->fetchRow($result);
		$newEdits = $row[0];
		
		# add edits
		$totalEdits = $oldEdits + $newEdits;
		
		# don't run querys if neither user has any edits
		if( $totalEdits > 0 ) {
			# update new user with total edits
			$dbw->update( 'user',
				array( 'user_editcount' => $totalEdits ),
				array( 'user_id' => $newuserID ),
				__METHOD__
			);
			
			#clear old users edits
			$dbw->update( 'user',
				array( 'user_editcount' => 0 ),
				array( 'user_id' => $olduserID ),
				__METHOD__
			);
		}
		
		$wgOut->addHTML( wfMsgForContent( 'usermerge-editcount-success', $olduserID, $newuserID ) . "<br />\n" );

		return true;
	}
	

	/**
	 * Function to merge user pages
	 *
	 * Deletes all pages when merging to Anon
	 * Moves user page when the target user page does not exist or is empty
	 * Deletes redirect if nothing links to old page
	 * Deletes the old user page when the target user page exists
	 *
	 * @param $newuser_text string Username to merge pages TO
	 * @param $olduser_text string Username of user to remove pages FROM
	 *
	 * @return returns true on completion
	 *
	 * @author Matthew April <Matthew.April@tbs-sct.gc.ca>
	 */
	private function movePages( $newuser_text, $olduser_text ) {
		global $wgOut, $wgContLang, $wgUser;
		
		$oldusername = trim( str_replace( '_', ' ', $olduser_text ) );
		$oldusername = Title::makeTitle( NS_USER, $oldusername );
		$newusername = Title::makeTitleSafe( NS_USER, $wgContLang->ucfirst( $newuser_text ) );
		
		# select all user pages and sub-pages
		$dbr = wfGetDB( DB_SLAVE );
		$oldkey = $oldusername->getDBkey();
		$pages = $dbr->select( 'page',
				array( 'page_namespace', 'page_title' ),
				array( 'page_namespace IN (' . NS_USER . ',' . NS_USER_TALK . ')',
					'page_title' . $dbr->buildLike( $oldusername->getDBkey() . '/', $dbr->anyString() )
					.' OR page_title = ' . $dbr->addQuotes( $oldusername->getDBkey() )
				)
			 );

		$output = '';
		$skin = $wgUser->getSkin();

		foreach ( $pages as $row ) {
			$oldPage = Title::makeTitleSafe( $row->page_namespace, $row->page_title );
			$newPage = Title::makeTitleSafe( $row->page_namespace, 
				preg_replace( '!^[^/]+!', $newusername->getDBkey(), $row->page_title ) );

			
			if( $newuser_text === "Anonymous" ) { # delete ALL old pages
				
				if( $oldPage->exists() ) {
					$oldPageArticle = new Article( $oldPage, 0 );
					$oldPageArticle->doDeleteArticle( wfMsgHtml( 'usermerge-autopagedelete' ) );
					
					$oldLink = $skin->linkKnown( $oldPage );
					$output .= '<li class="mw-renameuser-pe">' . wfMsgHtml( 'usermerge-page-deleted', $oldLink ) . '</li>';
				}
				
			} elseif( $newPage->exists() && !$oldPage->isValidMoveTarget( $newPage ) && $newPage->getLength() > 0) { # delete old pages that can't be moved
				
				$oldPageArticle = new Article( $oldPage, 0 );
				$oldPageArticle->doDeleteArticle( wfMsgHtml( 'usermerge-autopagedelete' ) );
				
				$link = $skin->linkKnown( $oldPage );
				$output .= '<li class="mw-renameuser-pe">' . wfMsgHtml( 'usermerge-page-deleted', $link ) . '</li>';
				
			} else { # move content to new page
				
				# delete target page if it exists and is blank
				if( $newPage->exists() ) {
					$newPageArticle = new Article( $newPage, 0 );
					$newPageArticle->doDeleteArticle( 'usermerge-autopagedelete' );
				}
				
				# move to target location
				$success = $oldPage->moveTo( $newPage, false, wfMsgForContent( 'usermerge-move-log', 
					$oldusername->getText(), $newusername->getText() ) );
				if( $success === true ) {
					$oldLink = $skin->linkKnown(
							$oldPage,
							null,
							array(),
							array( 'redirect' => 'no' )
					);
					$newLink = $skin->linkKnown( $newPage );
					$output .= '<li class="mw-renameuser-pm">' . wfMsgHtml( 'usermerge-page-moved', $oldLink, $newLink ) . '</li>';
				} else {
					$oldLink = $skin->linkKnown( $oldPage );
					$newLink = $skin->linkKnown( $newPage );
					$output .= '<li class="mw-renameuser-pu">' . wfMsgHtml( 'usermerge-page-unmoved', $oldLink, $newLink ) . '</li>';
				}
				
				# check if any pages link here
				$res = $dbr->selectField( 'pagelinks',
						'pl_title',
						array( 'pl_title' => $olduser_text ),
						__METHOD__
                                	);
				if( !$dbr->numRows( $res ) ) {
						# nothing links here, so delete unmoved page/redirect
						$oldPageArticle = new Article( $oldPage, 0 );
						$oldPageArticle->doDeleteArticle( wfMsgHtml( 'usermerge-autopagedelete' ) );
				}

			}
		}
		
		if ( $output ) {
			$wgOut->addHTML( '<ul>' . $output . '</ul>' );
		}
		
		return true;
	}
}
