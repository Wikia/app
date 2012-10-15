<?php
/**
 * Special:WikiForum -- an overview of all available boards on the forum
 *
 * @file
 * @ingroup Extensions
 */

class WikiForum extends SpecialPage {
	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'WikiForum' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser, $wgRequest, $wgScriptPath;

		// If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		// Checking for wfReadOnly() is done in the individual functions
		// in WikiForumClass.php; besides, we should be able to browse the
		// forum even when the DB is in read-only mode

		$this->setHeaders();

		$forum = new WikiForumClass;
		$values = array();

		// Add CSS
		$wgOut->addModuleStyles( 'ext.wikiForum' );

		// If a parameter to the special page is specified, check its type
		// and either display a forum (if parameter is a number) or a thread
		// (if it's the title of a topic)
		if ( $par ) {
			// Let search spiders index our content
			$wgOut->setRobotPolicy( 'index,follow' );

			if ( is_numeric( $par ) ) {
				$wgOut->addHTML( $forum->showForum( $par ) );
			} else {
				$threadId = WikiForumClass::findThreadIDByTitle( $par );
				$wgOut->addHTML( $forum->showThread( $threadId ) );
			}
		} else {
			// That's...a lot of variables. No kidding.
			$mod_category		= $wgRequest->getInt( 'category' );
			$mod_forum			= $wgRequest->getInt( 'forum' );
			$mod_thread		= $wgRequest->getInt( 'thread' );
			$mod_writethread	= $wgRequest->getInt( 'writethread' );
			$mod_addcomment	= $wgRequest->getInt( 'addcomment' );
			$mod_addthread		= $wgRequest->getInt( 'addthread' );
			$mod_editcomment	= $wgRequest->getInt( 'editcomment' );
			$mod_editthread	= $wgRequest->getInt( 'editthread' );
			$mod_deletecomment	= $wgRequest->getInt( 'deletecomment' );
			$mod_deletethread	= $wgRequest->getInt( 'deletethread' );
			$mod_closethread	= $wgRequest->getInt( 'closethread' );
			$mod_reopenthread	= $wgRequest->getInt( 'reopenthread' );
			$mod_addcategory	= $wgRequest->getBool( 'addcategory' );
			$mod_addforum		= $wgRequest->getInt( 'addforum' );
			$mod_editcategory	= $wgRequest->getInt( 'editcategory' );
			$mod_editforum		= $wgRequest->getInt( 'editforum' );
			$mod_deletecategory	= $wgRequest->getInt( 'deletecategory' );
			$mod_deleteforum	= $wgRequest->getInt( 'deleteforum' );
			$mod_makesticky		= $wgRequest->getInt( 'makesticky' );
			$mod_removesticky	= $wgRequest->getInt( 'removesticky' );
			$mod_categoryup		= $wgRequest->getInt( 'categoryup' );
			$mod_categorydown	= $wgRequest->getInt( 'categorydown' );
			$mod_forumup		= $wgRequest->getInt( 'forumup' );
			$mod_forumdown		= $wgRequest->getInt( 'forumdown' );
			$mod_search			= $wgRequest->getVal( 'txtSearch' );
			$mod_submit			= $wgRequest->getBool( 'butSubmit' );
			$mod_pastethread	= $wgRequest->getInt( 'pastethread' );

			// Define this variable to prevent E_NOTICEs about undefined variable
			$mod_none = false;

			// Figure out what we're going to do here...post a reply, a new thread,
			// edit a reply, edit a thread...and so on.
			if ( isset( $mod_addcomment ) && $mod_addcomment > 0 ) {
				$data_text = $wgRequest->getVal( 'frmText' );
				$data_preview = $wgRequest->getBool( 'butPreview' );
				$data_save = $wgRequest->getBool( 'butSave' );
				if ( $data_save == true ) {
					$result = $forum->addReply( $mod_addcomment, $data_text );
					$mod_thread = $mod_addcomment;
				} elseif ( $data_preview == true ) {
					$result = $wgOut->addHTML(
						$forum->previewIssue(
							'addcomment',
							$mod_addcomment,
							false,
							$data_text
						)
					);
					$mod_none = true;
				}
			} elseif ( isset( $mod_addthread ) && $mod_addthread > 0 ) {
				$data_title = $wgRequest->getVal( 'frmTitle' );
				$data_text = $wgRequest->getVal( 'frmText' );
				$data_preview = $wgRequest->getBool( 'butPreview' );
				$data_save = $wgRequest->getBool( 'butSave' );

				if ( $data_save == true ) {
					$result = $forum->addThread(
						$mod_addthread,
						$data_title,
						$data_text
					);
					$mod_forum = $mod_addthread;
				} elseif ( $data_preview == true ) {
					$result = $wgOut->addHTML(
						$forum->previewIssue(
							'addthread',
							$mod_addthread,
							$data_title,
							$data_text
						)
					);
					$mod_none = true;
				} else {
					$mod_writethread = $mod_addthread;
				}
			} elseif ( isset( $mod_editcomment ) && $mod_editcomment > 0 ) {
				$data_text = $wgRequest->getVal( 'frmText' );
				$data_preview = $wgRequest->getBool( 'butPreview' );
				$data_save = $wgRequest->getBool( 'butSave' );

				if ( $data_save == true ) {
					$result = $forum->editReply(
						$mod_editcomment,
						$data_text
					);
					$mod_thread = $mod_thread;
				} elseif ( $data_preview == true ) {
					$result = $wgOut->addHTML(
						$forum->previewIssue(
							'editcomment',
							$mod_editcomment,
							false,
							$data_text
						)
					);
					$mod_none = true;
				}
			} elseif ( isset( $mod_editthread ) && $mod_editthread > 0 ) {
				$data_title = $wgRequest->getVal( 'frmTitle' );
				$data_text = $wgRequest->getVal( 'frmText' );
				$data_preview = $wgRequest->getBool( 'butPreview' );
				$data_save = $wgRequest->getBool( 'butSave' );

				if ( $data_save == true ) {
					$result = $forum->editThread(
						$mod_editthread,
						$data_title,
						$data_text
					);
					$mod_thread = $mod_editthread;
				} elseif ( $data_preview == true ) {
					$result = $wgOut->addHTML(
						$forum->previewIssue(
							'editthread',
							$mod_editthread,
							$data_title,
							$data_text
						)
					);
					$mod_none = true;
				} else {
					$mod_writethread = $mod_editthread;
				}
			} elseif ( isset( $mod_deletecomment ) && $mod_deletecomment > 0 ) {
				$result = $forum->deleteReply( $mod_deletecomment );
			} elseif ( isset( $mod_deletethread ) && $mod_deletethread > 0 ) {
				$result = $forum->deleteThread( $mod_deletethread );
			} elseif ( isset( $mod_deletecategory ) && $mod_deletecategory > 0 ) {
				$result = $forum->deleteCategory( $mod_deletecategory );
			} elseif ( isset( $mod_deleteforum ) && $mod_deleteforum > 0 ) {
				$result = $forum->deleteForum( $mod_deleteforum );
			} elseif ( isset( $mod_categoryup ) && $mod_categoryup > 0 ) {
				$result = $forum->sortKeys( $mod_categoryup, 'category', true );
			} elseif ( isset( $mod_categorydown ) && $mod_categorydown > 0 ) {
				$result = $forum->sortKeys( $mod_categorydown, 'category', false );
			} elseif ( isset( $mod_forumup ) && $mod_forumup > 0 ) {
				$result = $forum->sortKeys( $mod_forumup, 'forum', true );
			} elseif ( isset( $mod_forumdown ) && $mod_forumdown > 0 ) {
				$result = $forum->sortKeys( $mod_forumdown, 'forum', false );
			} elseif ( isset( $mod_closethread ) && $mod_closethread > 0 ) {
				$result = $forum->closeThread( $mod_closethread );
				$mod_thread = $mod_closethread;
			} elseif ( isset( $mod_reopenthread ) && $mod_reopenthread > 0 ) {
				$result = $forum->reopenThread( $mod_reopenthread );
				$mod_thread = $mod_reopenthread;
			} elseif ( isset( $mod_makesticky ) && $mod_makesticky > 0 ) {
				$result = $forum->makeSticky( $mod_makesticky, true );
				$mod_thread = $mod_makesticky;
			} elseif ( isset( $mod_removesticky ) && $mod_removesticky > 0 ) {
				$result = $forum->makeSticky( $mod_removesticky, false );
				$mod_thread = $mod_removesticky;
			} elseif ( isset( $mod_pastethread ) && $mod_pastethread > 0 ) {
				$result = $forum->pasteThread( $mod_pastethread, $mod_forum );
			} elseif (
				isset( $mod_addcategory ) && $mod_addcategory == true &&
				$wgUser->isAllowed( 'wikiforum-admin' )
			) {
				if ( $mod_submit == true ) {
					$values['title'] = $wgRequest->getVal( 'frmTitle' );
					$mod_submit = $forum->addCategory( $values['title'] );
				}

				if ( $mod_submit == false ) {
					$mod_showform = true;
					$type = 'addcategory';
					$id = $mod_addcategory;
				}
			} elseif (
				isset( $mod_addforum ) && $mod_addforum > 0 &&
				$wgUser->isAllowed( 'wikiforum-admin' )
			) {
				if ( $mod_submit == true ) {
					$values['title'] = $wgRequest->getVal( 'frmTitle' );
					$values['text'] = $wgRequest->getVal( 'frmText' );

					if ( $wgRequest->getBool( 'chkAnnouncement' ) == true ) {
						$values['announce'] = '1';
					} else {
						$values['announce'] = '0';
					}
					$mod_submit = $forum->addForum(
						$mod_addforum,
						$values['title'],
						$values['text'],
						$values['announce']
					);
				}

				if ( $mod_submit == false ) {
					$mod_showform = true;
					$type = 'addforum';
					$id = $mod_addforum;
				}
			} elseif (
				isset( $mod_editcategory ) && $mod_editcategory > 0 &&
				$wgUser->isAllowed( 'wikiforum-admin' )
			) {
				if ( $mod_submit == true ) {
					$values['title'] = $wgRequest->getVal( 'frmTitle' );
					$mod_submit = $forum->editCategory(
						$mod_editcategory,
						$values['title']
					);
				}

				if ( $mod_submit == false ) {
					$mod_showform = true;
					$type = 'editcategory';
					$id = $mod_editcategory;
				}
			} elseif (
				isset( $mod_editforum ) && $mod_editforum > 0 &&
				$wgUser->isAllowed( 'wikiforum-admin' )
			) {
				if ( $mod_submit == true ) {
					$values['title'] = $wgRequest->getVal( 'frmTitle' );
					$values['text'] = $wgRequest->getVal( 'frmText' );

					if ( $wgRequest->getBool( 'chkAnnouncement' ) == true ) {
						$values['announce'] = '1';
					} else {
						$values['announce'] = '0';
					}
					$mod_submit = $forum->editForum(
						$mod_editforum,
						$values['title'],
						$values['text'],
						$values['announce']
					);
				}

				if ( $mod_submit == false ) {
					$mod_showform = true;
					$type = 'editforum';
					$id = $mod_editforum;
				}
			}

			// Only in certain cases we want search spiders to index our content
			// and follow links. These are overview (Special:WikiForum), individual
			// threads, forums and categories.
			if ( isset( $mod_search ) && $mod_search == true ) {
				$wgOut->addHTML( $forum->showSearchResults( $mod_search ) );
			} elseif ( $mod_none == true ) {
				// no data
			} elseif ( isset( $mod_category ) && $mod_category > 0 ) {
				// Let search spiders index our content
				$wgOut->setRobotPolicy( 'index,follow' );
				$wgOut->addHTML( $forum->showCategory( $mod_category ) );
			} elseif ( isset( $mod_forum ) && $mod_forum > 0 ) {
				// Let search spiders index our content
				$wgOut->setRobotPolicy( 'index,follow' );
				$wgOut->addHTML( $forum->showForum( $mod_forum ) );
			} elseif ( isset( $mod_thread ) && $mod_thread > 0 ) {
				// Let search spiders index our content
				$wgOut->setRobotPolicy( 'index,follow' );
				$wgOut->addHTML( $forum->showThread( $mod_thread ) );
			} elseif ( isset( $mod_writethread ) && $mod_writethread > 0 ) {
				$wgOut->addHTML( $forum->writeThread( $mod_writethread ) );
			} elseif ( isset( $mod_showform ) && $mod_showform ) {
				$wgOut->addHTML(
					$forum->showEditorCatForum( $id, $type, $values )
				);
			} else {
				// Let search spiders index our content
				$wgOut->setRobotPolicy( 'index,follow' );
				$wgOut->addHTML( $forum->showOverview() );
			}
		} // else from line 55 (the if $par is not specified one)
	} // execute()
}
