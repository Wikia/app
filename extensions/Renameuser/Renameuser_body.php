<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "RenameUser extension\n";
	exit( 1 );
}

/**
 * Special page allows authorised users to rename
 * user accounts
 */
class SpecialRenameuser extends SpecialPage {
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'Renameuser', 'renameuser' );
	}

	/**
	 * Show the special page
	 *
	 * @param mixed $par Parameter passed to the page
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser, $wgRequest, $wgContLang;
		global $wgCapitalLinks;

		$this->setHeaders();
		$wgOut->addWikiMsg( 'renameuser-summary' );

		if ( !$wgUser->isAllowed( 'renameuser' ) ) {
			$wgOut->permissionRequired( 'renameuser' );
			return;
		}

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		if( $wgUser->isBlocked() ){
			$wgOut->blockedPage();
		}

		$showBlockLog = $wgRequest->getBool( 'submit-showBlockLog' );
		$oldnamePar = trim( str_replace( '_', ' ', $wgRequest->getText( 'oldusername', $par ) ) );
		$oldusername = Title::makeTitle( NS_USER, $oldnamePar );
		// Force uppercase of newusername, otherwise wikis with wgCapitalLinks=false can create lc usernames
		$newusername = Title::makeTitleSafe( NS_USER, $wgContLang->ucfirst( $wgRequest->getText( 'newusername' ) ) );
		$oun = is_object( $oldusername ) ? $oldusername->getText() : '';
		$nun = is_object( $newusername ) ? $newusername->getText() : '';
		$token = $wgUser->editToken();
		$reason = $wgRequest->getText( 'reason' );

		$move_checked = $wgRequest->getBool( 'movepages', !$wgRequest->wasPosted());
		$suppress_checked = $wgRequest->getCheck( 'suppressredirect' );

		$warnings = array();
		if ( $oun && $nun && !$wgRequest->getCheck( 'confirmaction' )  ) {
			wfRunHooks( 'RenameUserWarning', array( $oun, $nun, &$warnings ) );
		}

		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->getTitle()->getLocalUrl(), 'id' => 'renameuser' ) ) .
			Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', null, wfMsg( 'renameuser' ) ) .
			Xml::openElement( 'table', array( 'id' => 'mw-renameuser-table' ) ) .
			"<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'renameuserold' ), 'oldusername' ) .
				"</td>
				<td class='mw-input'>" .
					Xml::input( 'oldusername', 20, $oun, array( 'type' => 'text', 'tabindex' => '1' ) ) . ' ' .
				"</td>
			</tr>
			<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'renameusernew' ), 'newusername' ) .
				"</td>
				<td class='mw-input'>" .
					Xml::input( 'newusername', 20, $nun, array( 'type' => 'text', 'tabindex' => '2' ) ) .
				"</td>
			</tr>
			<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'renameuserreason' ), 'reason' ) .
				"</td>
				<td class='mw-input'>" .
					Xml::input( 'reason', 40, $reason, array( 'type' => 'text', 'tabindex' => '3', 'maxlength' => 255 ) ) .
				"</td>
			</tr>"
		);
		if ( $wgUser->isAllowed( 'move' ) ) {
			$wgOut->addHTML( "
				<tr>
					<td>&#160;
					</td>
					<td class='mw-input'>" .
						Xml::checkLabel( wfMsg( 'renameusermove' ), 'movepages', 'movepages',
							$move_checked, array( 'tabindex' => '4' ) ) .
					"</td>
				</tr>"
			);

			if ( $wgUser->isAllowed( 'suppressredirect' ) ) {
				$wgOut->addHTML( "
					<tr>
						<td>&#160;
						</td>
						<td class='mw-input'>" .
							Xml::checkLabel( wfMsg( 'renameusersuppress' ), 'suppressredirect', 'suppressredirect',
								$suppress_checked, array( 'tabindex' => '5' ) ) .
						"</td>
					</tr>"
				);
			}
		}
		if ( $warnings ) {
			$warningsHtml = array();
			foreach ( $warnings as $warning )
				$warningsHtml[] = is_array( $warning ) ?
					call_user_func_array( 'wfMsgWikiHtml', $warning ) :
					wfMsgHtml( $warning );
			$wgOut->addHTML( "
				<tr>
					<td class='mw-label'>" . wfMsgWikiHtml( 'renameuserwarnings' ) . "
					</td>
					<td class='mw-input'>" .
						'<ul style="color: red; font-weight: bold"><li>' .
							implode( '</li><li>', $warningsHtml ) . '</li></ul>' .
					"</td>
				</tr>"
			);
			$wgOut->addHTML( "
				<tr>
					<td>&#160;
					</td>
					<td class='mw-input'>" .
						Xml::checkLabel( wfMsg( 'renameuserconfirm' ), 'confirmaction', 'confirmaction',
							false, array( 'tabindex' => '6' ) ) .
					"</td>
				</tr>"
			);
		}
		$wgOut->addHTML( "
			<tr>
				<td>&#160;
				</td>
				<td class='mw-submit'>" .
					Xml::submitButton( wfMsg( 'renameusersubmit' ), array( 'name' => 'submit',
						'tabindex' => '7', 'id' => 'submit' ) ) .
					' ' .
					Xml::submitButton( wfMsg( 'blocklogpage' ), array ( 'name' => 'submit-showBlockLog',
						'id' => 'submit-showBlockLog', 'tabindex' => '8' ) ) .
				"</td>
			</tr>" .
			Xml::closeElement( 'table' ) .
			Xml::closeElement( 'fieldset' ) .
			Html::hidden( 'token', $token ) .
			Xml::closeElement( 'form' ) . "\n"
		);

		// Show block log if requested
		if ( $showBlockLog && is_object( $oldusername ) ) {
			$this->showLogExtract( $oldusername, 'block', $wgOut ) ;
			return;
		}

		if ( $wgRequest->getText( 'token' ) === '' ) {
			# They probably haven't even submitted the form, so don't go further.
			return;
		} elseif ( $warnings ) {
			# Let user read warnings
			return;
		} elseif ( !$wgRequest->wasPosted() || !$wgUser->matchEditToken( $wgRequest->getVal( 'token' ) ) ) {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">$1</div>", 'renameuser-error-request' );
			return;
		} elseif ( !is_object( $oldusername ) ) {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">$1</div>",
				array( 'renameusererrorinvalid', $wgRequest->getText( 'oldusername' ) ) );
			return;
		} elseif ( !is_object( $newusername ) ) {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">$1</div>",
				array( 'renameusererrorinvalid', $wgRequest->getText( 'newusername' ) ) );
			return;
		} elseif ( $oldusername->getText() == $newusername->getText() ) {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">$1</div>", 'renameuser-error-same-user' );
			return;
		}

		// Suppress username validation of old username
		$olduser = User::newFromName( $oldusername->getText(), false );
		$newuser = User::newFromName( $newusername->getText(), 'creatable' );

		// It won't be an object if for instance "|" is supplied as a value
		if ( !is_object( $olduser ) ) {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">$1</div>",
				array( 'renameusererrorinvalid', $oldusername->getText() ) );
			return;
		}
		if ( !is_object( $newuser ) || !User::isCreatableName( $newuser->getName() ) ) {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">$1</div>",
				array( 'renameusererrorinvalid', $newusername->getText() ) );
			return;
		}

		// Check for the existence of lowercase oldusername in database.
		// Until r19631 it was possible to rename a user to a name with first character as lowercase
		if ( $oldusername->getText() !== $wgContLang->ucfirst( $oldusername->getText() ) ) {
			// oldusername was entered as lowercase -> check for existence in table 'user'
			$dbr = wfGetDB( DB_SLAVE );
			$uid = $dbr->selectField( 'user', 'user_id',
				array( 'user_name' => $oldusername->getText() ),
				__METHOD__ );
			if ( $uid === false ) {
				if ( !$wgCapitalLinks ) {
					$uid = 0; // We are on a lowercase wiki but lowercase username does not exists
				} else {
					// We are on a standard uppercase wiki, use normal
					$uid = $olduser->idForName();
					$oldusername = Title::makeTitleSafe( NS_USER, $olduser->getName() );
				}
			}
		} else {
			// oldusername was entered as upperase -> standard procedure
			$uid = $olduser->idForName();
		}

		if ( $uid == 0 ) {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">$1</div>",
				array( 'renameusererrordoesnotexist', $oldusername->getText() ) );
			return;
		}

		if ( $newuser->idForName() != 0 ) {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">$1</div>",
				array( 'renameusererrorexists', $newusername->getText() ) );
			return;
		}

		// Always get the edits count, it will be used for the log message
		$contribs = User::edits( $uid );

		// Give other affected extensions a chance to validate or abort
		if ( !wfRunHooks( 'RenameUserAbort', array( $uid, $oldusername->getText(), $newusername->getText() ) ) ) {
			return;
		}

		// Do the heavy lifting...
		$rename = new RenameuserSQL( $oldusername->getText(), $newusername->getText(), $uid );
		if ( !$rename->rename() ) {
			return;
		}

		// If this user is renaming his/herself, make sure that Title::moveTo()
		// doesn't make a bunch of null move edits under the old name!
		if ( $wgUser->getId() == $uid ) {
			$wgUser->setName( $newusername->getText() );
		}

		// Log this rename
		$log = new LogPage( 'renameuser' );
		$log->addEntry( 'renameuser', $oldusername, wfMsgExt( 'renameuser-log', array( 'parsemag', 'content' ),
			$wgContLang->formatNum( $contribs ), $reason ), $newusername->getText() );

		// Move any user pages
		if ( $wgRequest->getCheck( 'movepages' ) && $wgUser->isAllowed( 'move' ) ) {
			$dbr = wfGetDB( DB_SLAVE );

			$pages = $dbr->select(
				'page',
				array( 'page_namespace', 'page_title' ),
				array(
					'page_namespace IN (' . NS_USER . ',' . NS_USER_TALK . ')',
					'(page_title ' . $dbr->buildLike( $oldusername->getDBkey() . '/', $dbr->anyString() ) .
						' OR page_title = ' . $dbr->addQuotes( $oldusername->getDBkey() ) . ')'
				),
				__METHOD__
			);

			$suppressRedirect = false;

			if ( $wgRequest->getCheck( 'suppressredirect' ) && $wgUser->isAllowed( 'suppressredirect' ) ) {
				$suppressRedirect = true;
			}

			$output = '';
			foreach ( $pages as $row ) {
				$oldPage = Title::makeTitleSafe( $row->page_namespace, $row->page_title );
				$newPage = Title::makeTitleSafe( $row->page_namespace,
					preg_replace( '!^[^/]+!', $newusername->getDBkey(), $row->page_title ) );
				# Do not autodelete or anything, title must not exist
				if ( $newPage->exists() && !$oldPage->isValidMoveTarget( $newPage ) ) {
					$link = Linker::linkKnown( $newPage );
					$output .= Html::rawElement(
								'li',
								array( 'class' => 'mw-renameuser-pe' ),
								wfMessage( 'renameuser-page-exists' )->rawParams( $link )->escaped()
							);
				} else {
					$success = $oldPage->moveTo(
								$newPage,
								false, 
								wfMessage(
									'renameuser-move-log',
									$oldusername->getText(),
									$newusername->getText() )->inContentLanguage()->text(),
								!$suppressRedirect
							);
					if ( $success === true ) {
						# oldPage is not known in case of redirect suppression
						$oldLink = Linker::link( $oldPage, null, array(), array( 'redirect' => 'no' ) );

						# newPage is always known because the move was successful
						$newLink = Linker::linkKnown( $newPage );

						$output .= Html::rawElement(
									'li',
									array( 'class' => 'mw-renameuser-pm' ),
									wfMessage( 'renameuser-page-moved' )->rawParams( $oldLink, $newLink )->escaped()
								);
					} else {
						$oldLink = Linker::linkKnown( $oldPage );
						$newLink = Linker::link( $newPage );
						$output .= Html::rawElement(
									'li', array( 'class' => 'mw-renameuser-pu' ),
									wfMessage( 'renameuser-page-unmoved' )->rawParams( $oldLink, $newLink )->escaped()
								);
					}
				}
			}
			if ( $output ) {
				$wgOut->addHTML( Html::rawElement( 'ul', array(), $output ) );
			}
		}

		// Output success message stuff :)
		$wgOut->wrapWikiMsg( "<div class=\"successbox\">$1</div><br style=\"clear:both\" />",
			array( 'renameusersuccess', $oldusername->getText(), $newusername->getText() ) );
	}

	/**
	 * @param $username Title
	 * @param $type
	 * @param $out OutputPage
	 */
	function showLogExtract( $username, $type, &$out ) {
		# Show relevant lines from the logs:
		$out->addHTML( Xml::element( 'h2', null, LogPage::logName( $type ) ) . "\n" );
		LogEventsList::showLogExtract( $out, $type, $username->getPrefixedText() );
	}
}

class RenameuserSQL {
	/**
	  * The old username
	  *
	  * @var string
	  * @access private
	  */
	var $old;

	/**
	  * The new username
	  *
	  * @var string
	  * @access private
	  */
	var $new;

	/**
	  * The user ID
	  *
	  * @var integer
	  * @access private
	  */
	var $uid;

	/**
	  * The the tables => fields to be updated
	  *
	  * @var array
	  * @access private
	  */
	var $tables;

	/**
	 * Constructor
	 *
	 * @param $old string The old username
	 * @param $new string The new username
	 * @param $uid
	 */
	function __construct( $old, $new, $uid ) {
		$this->old = $old;
		$this->new = $new;
		$this->uid = $uid;

		$this->tables = array(); // Immediate updates
		$this->tables['image'] = array( 'img_user_text', 'img_user' );
		$this->tables['oldimage'] = array( 'oi_user_text', 'oi_user' );
		$this->tables['filearchive'] = array('fa_user_text','fa_user');
		$this->tablesJob = array(); // Slow updates
		// If this user has a large number of edits, use the jobqueue
		if ( User::edits( $this->uid ) > RENAMEUSER_CONTRIBJOB ) {
			$this->tablesJob['revision'] = array( 'rev_user_text', 'rev_user', 'rev_timestamp' );
			$this->tablesJob['archive'] = array( 'ar_user_text', 'ar_user', 'ar_timestamp' );
			$this->tablesJob['logging'] = array( 'log_user_text', 'log_user', 'log_timestamp' );
		} else {
			$this->tables['revision'] = array( 'rev_user_text', 'rev_user' );
			$this->tables['archive'] = array( 'ar_user_text', 'ar_user' );
			$this->tables['logging'] = array( 'log_user_text', 'log_user' );
		}
		// Recent changes is pretty hot, deadlocks occur if done all at once
		if ( wfQueriesMustScale() ) {
			$this->tablesJob['recentchanges'] = array( 'rc_user_text', 'rc_user', 'rc_timestamp' );
		} else {
			$this->tables['recentchanges'] = array( 'rc_user_text', 'rc_user' );
		}

		wfRunHooks( 'RenameUserSQL', array( $this ) );
	}

	/**
	 * Do the rename operation
	 */
	function rename() {
		global $wgMemc, $wgAuth, $wgUpdateRowsPerJob;

		wfProfileIn( __METHOD__ );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		wfRunHooks( 'RenameUserPreRename', array( $this->uid, $this->old, $this->new ) );

		// Rename and touch the user before re-attributing edits,
		// this avoids users still being logged in and making new edits while
		// being renamed, which leaves edits at the old name.
		$dbw->update( 'user',
			array( 'user_name' => $this->new, 'user_touched' => $dbw->timestamp() ),
			array( 'user_name' => $this->old ),
			__METHOD__
		);
		if ( !$dbw->affectedRows() ) {
			$dbw->rollback();
			return false;
		}
		// Reset token to break login with central auth systems.
		// Again, avoids user being logged in with old name.
		$user = User::newFromId( $this->uid );
		$authUser = $wgAuth->getUserInstance( $user );
		$authUser->resetAuthToken();

		// Delete from memcached.
		$wgMemc->delete( wfMemcKey( 'user', 'id', $this->uid ) );

		// Update ipblock list if this user has a block in there.
		$dbw->update( 'ipblocks',
			array( 'ipb_address' => $this->new ),
			array( 'ipb_user' => $this->uid, 'ipb_address' => $this->old ),
			__METHOD__ );
		// Update this users block/rights log. Ideally, the logs would be historical,
		// but it is really annoying when users have "clean" block logs by virtue of
		// being renamed, which makes admin tasks more of a pain...
		$oldTitle = Title::makeTitle( NS_USER, $this->old );
		$newTitle = Title::makeTitle( NS_USER, $this->new );
		$dbw->update( 'logging',
			array( 'log_title' => $newTitle->getDBkey() ),
			array( 'log_type' => array( 'block', 'rights' ),
				'log_namespace' => NS_USER,
				'log_title' => $oldTitle->getDBkey() ),
			__METHOD__ );
		// Do immediate updates!
		foreach ( $this->tables as $table => $fieldSet ) {
			list( $nameCol, $userCol ) = $fieldSet;
			$dbw->update( $table,
				array( $nameCol => $this->new ),
				array( $nameCol => $this->old, $userCol => $this->uid ),
				__METHOD__
			);
		}

		// Increase time limit (like CheckUser); this can take a while...
		if ( $this->tablesJob ) {
			wfSuppressWarnings();
			set_time_limit( 120 );
			wfRestoreWarnings();
		}

		$jobs = array(); // jobs for all tables
		// Construct jobqueue updates...
		// FIXME: if a bureaucrat renames a user in error, he/she
		// must be careful to wait until the rename finishes before
		// renaming back. This is due to the fact the the job "queue"
		// is not really FIFO, so we might end up with a bunch of edits
		// randomly mixed between the two new names. Some sort of rename
		// lock might be in order...
		foreach ( $this->tablesJob as $table => $params ) {
			$userTextC = $params[0]; // some *_user_text column
			$userIDC = $params[1]; // some *_user column
			$timestampC = $params[2]; // some *_timestamp column

			$res = $dbw->select( $table,
				array( $timestampC ),
				array( $userTextC => $this->old, $userIDC => $this->uid ),
				__METHOD__,
				array( 'ORDER BY' => "$timestampC ASC" )
			);

			$jobParams = array();
			$jobParams['table'] = $table;
			$jobParams['column'] = $userTextC;
			$jobParams['uidColumn'] = $userIDC;
			$jobParams['timestampColumn'] = $timestampC;
			$jobParams['oldname'] = $this->old;
			$jobParams['newname'] = $this->new;
			$jobParams['userID'] = $this->uid;
			// Timestamp column data for index optimizations
			$jobParams['minTimestamp'] = '0';
			$jobParams['maxTimestamp'] = '0';
			$jobParams['count'] = 0;

			// Insert jobs into queue!
			while ( true ) {
				$row = $dbw->fetchObject( $res );
				if ( !$row ) {
					# If there are any job rows left, add it to the queue as one job
					if ( $jobParams['count'] > 0 ) {
						$jobs[] = Job::factory( 'renameUser', $oldTitle, $jobParams );
					}
					break;
				}
				# Since the ORDER BY is ASC, set the min timestamp with first row
				if ( $jobParams['count'] == 0 ) {
					$jobParams['minTimestamp'] = $row->$timestampC;
				}
				# Keep updating the last timestamp, so it should be correct
				# when the last item is added.
				$jobParams['maxTimestamp'] = $row->$timestampC;
				# Update row counter
				$jobParams['count']++;
				# Once a job has $wgUpdateRowsPerJob rows, add it to the queue
				if ( $jobParams['count'] >= $wgUpdateRowsPerJob ) {
					$jobs[] = Job::factory( 'renameUser', $oldTitle, $jobParams );
					$jobParams['minTimestamp'] = '0';
					$jobParams['maxTimestamp'] = '0';
					$jobParams['count'] = 0;
				}
			}
			$dbw->freeResult( $res );
		}

		if ( count( $jobs ) > 0 ) {
			Job::safeBatchInsert( $jobs ); // don't commit yet
		}

		// Commit the transaction
		$dbw->commit();

		// Delete from memcached again to make sure
		$wgMemc->delete( wfMemcKey( 'user', 'id', $this->uid ) );

		// Clear caches and inform authentication plugins
		$user = User::newFromId( $this->uid );
		$wgAuth->updateExternalDB( $user );
		wfRunHooks( 'RenameUserComplete', array( $this->uid, $this->old, $this->new ) );

		wfProfileOut( __METHOD__ );
		return true;
	}
}
