<?php

/**
 * Provides the UI through which users can perform editing
 * operations on collaborative watchlists
 *
 * @ingroup CollabWatchlist
 * @author Rob Church <robchur@gmail.com>
 * @author Florian Hackenberger <f.hackenberger@chello.at>
 */
class CollabWatchlistEditor {

	/**
	 * Editing modes
	 */
	const EDIT_CLEAR = 1;
	const CATEGORIES_EDIT_RAW = 2;
	const EDIT_NORMAL = 3;
	const TAGS_EDIT_RAW = 4;
	const SET_TAGS = 5;
	const UNSET_TAGS = 6;
	const USERS_EDIT_RAW = 7;
	const NEW_LIST = 8;
	const DELETE_LIST = 9;

	/**
	 * Main execution point
	 *
	 * @param $rlId Collaborative watchlist id
	 * @param $listIdsAndNames An array mapping from list id to list name
	 * @param $output OutputPage
	 * @param $request WebRequest
	 * @param $mode int
	 */
	public function execute( $rlId, $listIdsAndNames, $output, $request, $mode ) {
		global $wgUser, $wgCollabWatchlistPermissionDeniedPage;
		if ( wfReadOnly() ) {
			$output->readOnlyPage();
			return;
		}
		if ( ( $mode === self::EDIT_CLEAR ||
			$mode === self::CATEGORIES_EDIT_RAW ||
			$mode === self::USERS_EDIT_RAW ||
			$mode === self::EDIT_NORMAL ||
			$mode === self::TAGS_EDIT_RAW ||
			$mode === self::DELETE_LIST ) && ( !isset( $rlId ) || $rlId === 0 ) ) {
			$thisTitle = SpecialPage::getTitleFor( 'CollabWatchlist' );
			$output->redirect( $thisTitle->getLocalURL() );
			return;
		}
		$permissionDeniedTarget = Title::newFromText( $wgCollabWatchlistPermissionDeniedPage )->getLocalURL();
		switch( $mode ) {
			case self::EDIT_CLEAR:
				// The "Clear" link scared people too much.
				// Pass on to the raw editor, from which it's very easy to clear.
			case self::CATEGORIES_EDIT_RAW:
				$output->setPageTitle( $listIdsAndNames[$rlId] . ' ' . wfMsg( 'collabwatchlistedit-raw-title' ) );
				if ( $request->wasPosted() ) {
					if ( ! $this->checkToken( $request, $wgUser, $rlId ) ) {
						$output->redirect( $permissionDeniedTarget );
						break;
					}
					$wanted = $this->extractCollabWatchlistCategories( $request->getText( 'titles' ) );
					$current = $this->getCollabWatchlistCategories( $rlId );
					if ( count( $wanted ) > 0 ) {
						$toWatch = array_diff( $wanted, $current );
						$toUnwatch = array_diff( $current, $wanted );
						$toWatch = $this->watchTitles( $toWatch, $rlId );
						$this->unwatchTitles( $toUnwatch, $rlId, $wgUser );
						if ( count( $toWatch ) > 0 || count( $toUnwatch ) > 0 )
							$output->addHTML( wfMsgExt( 'collabwatchlistedit-raw-done', 'parse' ) );
						if ( ( $count = count( $toWatch ) ) > 0 ) {
							$output->addHTML( wfMsgExt( 'collabwatchlistedit-raw-added', 'parse', $count ) );
							$this->showTitles( $toWatch, $output, $wgUser->getSkin() );
						}
						if ( ( $count = count( $toUnwatch ) ) > 0 ) {
							$output->addHTML( wfMsgExt( 'collabwatchlistedit-raw-removed', 'parse', $count ) );
							$this->showTitles( $toUnwatch, $output, $wgUser->getSkin() );
						}
					} else {
						$this->clearCollabWatchlist( $rlId );
						$output->addHTML( wfMsgExt( 'collabwatchlistedit-raw-removed', 'parse', count( $current ) ) );
						$this->showTitles( $current, $output, $wgUser->getSkin() );
					}
				}
				$this->showRawForm( $output, $rlId, $listIdsAndNames[$rlId] );
				break;
			case self::USERS_EDIT_RAW:
				$output->setPageTitle( $listIdsAndNames[$rlId] . ' ' . wfMsg( 'collabwatchlistedit-users-raw-title' ) );
				if ( $request->wasPosted() ) {
					if ( ! $this->checkToken( $request, $wgUser, $rlId ) ) {
						$output->redirect( $permissionDeniedTarget );
						break;
					}
					$wanted = $this->extractCollabWatchlistUsers( $request->getText( 'titles' ) );
					$current = $this->getCollabWatchlistUsers( $rlId );
					$isOwnerCb = create_function( '$a', 'return stripos($a, "' . CollabWatchlist::$USER_OWNER_TEXT . ' ' . '") === 0;' );
					$wantedOwners = array_filter( $wanted, $isOwnerCb );
					if ( count( $wantedOwners ) < 1 ) {
						// Make sure there is at least one owner left
						$currentOwners = array_filter( $current, $isOwnerCb );
						$reAddedOwner = current( $currentOwners );
						$wanted[] = $reAddedOwner;
						list( $type, $typeText, $titleText ) = $this->extractTypeTypeTextAndUsername( $reAddedOwner );
						$output->addHTML( wfMsgExt( 'collabwatchlistedit-users-last-owner', 'parse' ) );
						$this->showTitles( array( $titleText ), $output, $wgUser->getSkin() );
					}
					if ( count( $wanted ) > 0 ) {
						$toAdd = array_diff( $wanted, $current );
						$toDel = array_diff( $current, $wanted );
						$toAdd = $this->addUsers( $toAdd, $rlId );
						$this->delUsers( $toDel, $rlId );
						if ( count( $toAdd ) > 0 || count( $toDel ) > 0 )
							$output->addHTML( wfMsgExt( 'collabwatchlistedit-users-raw-done', 'parse' ) );
						if ( ( $count = count( $toAdd ) ) > 0 ) {
							$output->addHTML( wfMsgExt( 'collabwatchlistedit-users-raw-added', 'parse', $count ) );
							$this->showTitles( $toAdd, $output, $wgUser->getSkin() );
						}
						if ( ( $count = count( $toDel ) ) > 0 ) {
							$output->addHTML( wfMsgExt( 'collabwatchlistedit-users-raw-removed', 'parse', $count ) );
							$this->showTitles( $toDel, $output, $wgUser->getSkin() );
						}
					} else {
						$this->clearCollabWatchlist( $rlId );
						$output->addHTML( wfMsgExt( 'collabwatchlistedit-users-raw-removed', 'parse', count( $current ) ) );
						$this->showTitles( $current, $output, $wgUser->getSkin() );
					}
				}
				$this->showUsersRawForm( $output, $rlId, $listIdsAndNames[$rlId] );
				break;
			case self::TAGS_EDIT_RAW:
				$output->setPageTitle( $listIdsAndNames[$rlId] . ' ' . wfMsg( 'collabwatchlistedit-tags-raw-title' ) );
				if ( $request->wasPosted() ) {
					if ( ! $this->checkToken( $request, $wgUser, $rlId ) ) {
						$output->redirect( $permissionDeniedTarget );
						break;
					}
					$wanted = $this->extractCollabWatchlistTags( $request->getText( 'titles' ) );
					$current = $this->getCollabWatchlistTags( $rlId );
					if ( count( $wanted ) > 0 ) {
						$newTags = array_diff_assoc( $wanted, $current );
						$removeTags = array_diff_assoc( $current, $wanted );
						$this->removeTags( array_keys( $removeTags ), $rlId );
						$this->addTags( $newTags, $rlId );
						if ( count( $newTags ) > 0 || count( $removeTags ) > 0 )
							$output->addHTML( wfMsgExt( 'collabwatchlistedit-tags-raw-done', 'parse' ) );
						if ( ( $count = count( $newTags ) ) > 0 ) {
							$output->addHTML( wfMsgExt( 'collabwatchlistedit-tags-raw-added', 'parse', $count ) );
							$this->showTagList( $newTags, $output, $wgUser->getSkin() );
						}
						if ( ( $count = count( $removeTags ) ) > 0 ) {
							$output->addHTML( wfMsgExt( 'collabwatchlistedit-tags-raw-removed', 'parse', $count ) );
							$this->showTagList( $removeTags, $output, $wgUser->getSkin() );
						}
					} else {
						$this->clearCollabWatchlist( $rlId );
						$output->addHTML( wfMsgExt( 'collabwatchlistedit-tags-raw-removed', 'parse', count( $current ) ) );
						$this->showTagList( $current, $output, $wgUser->getSkin() );
					}
				}
				$this->showTagsRawForm( $output, $rlId, $listIdsAndNames[$rlId] );
				break;
			case self::EDIT_NORMAL:
				$output->setPageTitle( $listIdsAndNames[$rlId] . ' ' . wfMsg( 'collabwatchlistedit-normal-title' ) );
				if ( $request->wasPosted() ) {
					if ( ! $this->checkToken( $request, $wgUser, $rlId ) ) {
						$output->redirect( $permissionDeniedTarget );
						break;
					}
					$titles = $this->extractCollabWatchlistCategories( $request->getArray( 'titles' ) );
					$this->unwatchTitles( $titles, $rlId, $wgUser );
					$output->addHTML( wfMsgExt( 'collabwatchlistedit-normal-done', 'parse',
						$GLOBALS['wgLang']->formatNum( count( $titles ) ) ) );
					$this->showTitles( $titles, $output, $wgUser->getSkin() );
				}
				$this->showNormalForm( $output, $rlId );
				break;
			case self::SET_TAGS:
				$redirTarget = SpecialPage::getTitleFor( 'CollabWatchlist' )->getLocalUrl();
				if ( $request->wasPosted() ) {
					$rlId = $request->getInt( 'collabwatchlist', -1 );
					if ( ! $this->checkPermissions( $wgUser, $rlId, array( CollabWatchlist::$USER_USER, CollabWatchlist::$USER_OWNER ) ) ) {
						$output->redirect( $permissionDeniedTarget );
						break;
					}
					$redirTarget = $request->getText( 'redirTarget', $redirTarget );
					$tagToAdd = $request->getText( 'collabwatchlisttag' );
					$tagcomment = $request->getText( 'tagcomment' );
					$setPatrolled = $request->getBool( 'setpatrolled', false );
					$pagesToTag = array();
					if ( strlen( $tagToAdd ) !== 0 && $rlId !== -1 ) {
						$postValues = $request->getValues();
						foreach ( $postValues as $key => $value ) {
							if ( stripos( $key, 'collaborative-watchlist-addtag-' ) === 0 ) {
								$pageRevRcId = explode( '|', $value );
								if ( count( $pageRevRcId ) < 3 ) {
									continue;
								}
								$pagesToTag[$pageRevRcId[0]][] = array( 'rev_id' => $pageRevRcId[1], 'rc_id' => $pageRevRcId[2] );
							}
						}
						$this->setTags( $pagesToTag, $tagToAdd, $wgUser->getId(), $rlId, $tagcomment, $setPatrolled );
					}
				}
				$output->redirect( $redirTarget );
				break;
			case self::UNSET_TAGS:
				$rlId = $request->getInt( 'collabwatchlist', -1 );
				if ( ! $this->checkPermissions( $wgUser, $rlId, array( CollabWatchlist::$USER_USER, CollabWatchlist::$USER_OWNER ) ) ) {
					$output->redirect( $permissionDeniedTarget );
					break;
				}
				$redirTarget = SpecialPage::getTitleFor( 'CollabWatchlist' )->getLocalUrl();
				$redirTarget = $request->getText( 'redirTarget', $redirTarget );
				$page = $request->getText( 'collabwatchlistpage' );
				$tagToDel = $request->getText( 'collabwatchlisttag' );
				$rcId = $request->getInt( 'collabwatchlistrcid', -1 );
				if ( strlen( $page ) !== 0 && strlen( $tagToDel ) !== 0 && $rlId !== -1 && $rcId !== -1 ) {
					$pagesToUntag[$page][] = array( 'rc_id' => $rcId );
					$this->unsetTags( $pagesToUntag, $tagToDel, $wgUser->getId(), $rlId );
				}
				$output->redirect( $redirTarget );
				break;
			case self::NEW_LIST:
				if ( $request->wasPosted() ) {
					$redirTarget = SpecialPage::getTitleFor( 'CollabWatchlist' )->getLocalUrl();
					$listId = $this->createNewList( $request->getText( 'listname' ) );
					if ( isset( $listId ) ) {
						$output->redirect( $redirTarget );
					} else {
						$output->addHTML( wfMsgExt( 'collabwatchlistnew-name-exists', 'parse' ) );
					}
				} else {
					$this->showNewListForm( $output );
				}
				break;
			case self::DELETE_LIST:
				$output->setPageTitle( $listIdsAndNames[$rlId] . ' ' . wfMsg( 'collabwatchlistdelete-title' ) );
				$rlId = $request->getInt( 'collabwatchlist', -1 );
				if ( $request->wasPosted() ) {
					if ( ! $this->checkToken( $request, $wgUser, $rlId ) ) {
						$output->redirect( $permissionDeniedTarget );
						break;
					}
					$this->deleteList( $rlId );
					$redirTarget = SpecialPage::getTitleFor( 'CollabWatchlist' )->getLocalUrl();
					$output->redirect( $redirTarget );
				} else {
					$this->showDeleteListForm( $output, $rlId );
				}
				break;
		}
	}

	/**
	 * Check the edit token from a form submission
	 *
	 * @param $request WebRequest
	 * @param $user User
	 * @param $rlId Id of the collaborative watchlist to check users against
	 * @param $memberTypes Which types of members are allowed
	 * @return bool
	 */
	private function checkToken( $request, $user, $rlId, $memberTypes = NULL ) {
		if ( is_null($member_types) )
			$member_types = array( CollabWatchlist::$USER_OWNER );

		$tokenOk = $user->matchEditToken( $request->getVal( 'token' ), 'watchlistedit' ) && $request->getVal( 'collabwatchlist' ) !== 0;
		if ( $tokenOk === false )
			return $tokenOk;
		return $this->checkPermissions( $user, $rlId, $memberTypes );
	}

	private function checkPermissions( $user, $rlId, $memberTypes = NULL ) {
		if ( is_null($member_types) )
			$member_types = array( CollabWatchlist::$USER_OWNER );

		// Check permissions
		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select( 'collabwatchlistuser',
			'COUNT(*) AS count',
			array( 'cw_id' => $rlId, 'user_id' => $user->getId(), 'rlu_type' => $memberTypes ),
			__METHOD__
		);
		$row = $dbr->fetchObject( $res );
		return $row->count >= 1;
	}

	/**
	 * Extract a list of categories from a blob of text, returning
	 * (prefixed) strings
	 *
	 * @param $list mixed
	 * @return array
	 */
	private function extractCollabWatchlistCategories( $list ) {
		$titles = array();
		if ( !is_array( $list ) ) {
			$list = explode( "\n", trim( $list ) );
			if ( !is_array( $list ) )
				return array();
		}
		foreach ( $list as $text ) {
			$subtract = false;
			$text = trim( $text );
			$titleText = $text;
			if ( stripos( $text, '- ' ) === 0 ) {
				$subtract = true;
				$titleText = trim( substr( $text, 2 ) );
			}
			if ( strlen( $text ) > 0 ) {
				$title = Title::newFromText( $titleText );
				if ( $title instanceof Title && $title->isWatchable() ) {
					$titles[] = $subtract ? '- ' . $title->getPrefixedText() : $title->getPrefixedText();
				}
			}
		}
		return array_unique( $titles );
	}

	private function extractTypeTypeTextAndUsername( $typeAndUsernameStr ) {
		$type = CollabWatchlist::$USER_USER;
		$typeText = CollabWatchlist::$USER_USER_TEXT;
		$text = trim( $typeAndUsernameStr );
		$titleText = $text;
		if ( stripos( $text, CollabWatchlist::$USER_OWNER_TEXT . ' ' ) === 0 ) {
			$type = CollabWatchlist::$USER_OWNER;
			$typeText = CollabWatchlist::$USER_OWNER_TEXT;
			$titleText = trim( substr( $text, strlen( CollabWatchlist::$USER_OWNER_TEXT . ' ' ) ) );
		} elseif ( stripos( $text, CollabWatchlist::$USER_USER_TEXT . ' ' ) === 0 ) {
			$type = CollabWatchlist::$USER_USER;
			$typeText = CollabWatchlist::$USER_USER_TEXT;
			$titleText = trim( substr( $text, strlen( CollabWatchlist::$USER_USER_TEXT . ' ' ) ) );
		} elseif ( stripos( $text, CollabWatchlist::$USER_TRUSTED_EDITOR_TEXT . ' ' ) === 0 ) {
			$type = CollabWatchlist::$USER_TRUSTED_EDITOR;
			$typeText = CollabWatchlist::$USER_TRUSTED_EDITOR_TEXT;
			$titleText = trim( substr( $text, strlen( CollabWatchlist::$USER_TRUSTED_EDITOR_TEXT . ' ' ) ) );
		}
		return array( $type, $typeText, $titleText );
	}

	/**
	 * Extract a list of users from a blob of text, returning
	 * (prefixed) strings
	 *
	 * @param $list mixed
	 * @return array
	 */
	private function extractCollabWatchlistUsers( $list ) {
		$titles = array();
		if ( !is_array( $list ) ) {
			$list = explode( "\n", trim( $list ) );
			if ( !is_array( $list ) )
				return array();
		}
		foreach ( $list as $text ) {
			list( $type, $typeText, $titleText ) = $this->extractTypeTypeTextAndUsername( $text );
			if ( strlen( $text ) > 0 ) {
				$user = User::newFromName( $titleText );
				if ( $user instanceof User ) {
					$titles[] = $typeText . ' ' . $user->getName();
				}
			}
		}
		return array_unique( $titles );
	}

	/**
	 * Extract a list of tags from a blob of text, returning
	 * (prefixed) strings
	 *
	 * @param $list mixed
	 * @return array
	 */
	private function extractCollabWatchlistTags( $list ) {
		$tags = array();
		if ( !is_array( $list ) ) {
			$list = explode( "\n", trim( $list ) );
			if ( !is_array( $list ) )
				return array();
		}
		foreach ( $list as $text ) {
			$subtract = false;
			$text = trim( $text );
			if ( strlen( $text ) > 0 ) {
				$pipepos = stripos( $text, '|' );
				$description = '';
				if ( $pipepos > 0 ) {
					if ( ( $pipepos + 1 ) < strlen( $text ) )
						$description = trim( substr( $text, $pipepos + 1 ) );
					$text = trim( substr( $text, 0, $pipepos ) );
				}
				$tags[$text] = $description;
			}
		}
		return $tags;
	}

	/**
	 * Print out a list of linked titles
	 *
	 * $titles can be an array of strings or Title objects; the former
	 * is preferred, since Titles are very memory-heavy
	 *
	 * @param $titles An array of strings, or Title objects
	 * @param $output OutputPage
	 * @param $skin Skin
	 */
	private function showTitles( $titles, $output, $skin ) {
		$talk = wfMsgHtml( 'talkpagelinktext' );
		// Do a batch existence check
		$batch = new LinkBatch();
		foreach ( $titles as $title ) {
			if ( !$title instanceof Title )
				$title = Title::newFromText( $title );
			if ( $title instanceof Title ) {
				$batch->addObj( $title );
				$batch->addObj( $title->getTalkPage() );
			}
		}
		$batch->execute();
		// Print out the list
		$output->addHTML( "<ul>\n" );
		foreach ( $titles as $title ) {
			if ( !$title instanceof Title )
				$title = Title::newFromText( $title );
			if ( $title instanceof Title ) {
				$output->addHTML( "<li>" . $skin->link( $title )
				. ' (' . $skin->link( $title->getTalkPage(), $talk ) . ")</li>\n" );
			}
		}
		$output->addHTML( "</ul>\n" );
	}

	/**
	 * Print out a list of tags with description
	 *
	 * $titles can be an array of strings or Title objects; the former
	 * is preferred, since Titles are very memory-heavy
	 *
	 * @param $tagsAndDesc An array of strings mapping from tag name to description
	 * @param $output OutputPage
	 * @param $skin Skin
	 */
	private function showTagList( $tagsAndDesc, $output, $skin ) {
		// Print out the list
		$output->addHTML( "<ul>\n" );
		foreach ( $tagsAndDesc as $title => $description ) {
			$output->addHTML( "<li>" . $title
			. ' (' . $description . ")</li>\n" );
		}
		$output->addHTML( "</ul>\n" );
	}

	/**
	 * Count the number of categories on a collaborative watchlist
	 *
	 * @param $rlId Collaborative watchlist id
	 * @return int
	 */
	private function countCollabWatchlistCategories( $rlId ) {
		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select( 'collabwatchlistcategory', 'COUNT(*) AS count', array( 'cw_id' => $rlId ), __METHOD__ );
		$row = $dbr->fetchObject( $res );
		return $row->count;
	}

	/**
	 * Count the number of users on a collaborative watchlist
	 *
	 * @param $rlId Collaborative watchlist id
	 * @return int
	 */
	private function countCollabWatchlistUsers( $rlId ) {
		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select( 'collabwatchlistuser', 'COUNT(*) AS count', array( 'cw_id' => $rlId ), __METHOD__ );
		$row = $dbr->fetchObject( $res );
		return $row->count;
	}

	/**
	 * Count the number of tags on a collaborative watchlist
	 *
	 * @param $rlId Collaborative watchlist id
	 * @return int
	 */
	private function countCollabWatchlistTags( $rlId ) {
		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select( 'collabwatchlisttag', 'COUNT(*) AS count', array( 'cw_id' => $rlId ), __METHOD__ );
		$row = $dbr->fetchObject( $res );
		return $row->count;
	}

	/**
	 * Count the number of set edit tags on a collaborative watchlist
	 *
	 * @param $rlId Collaborative watchlist id
	 * @return int
	 */
	private function countCollabWatchlistSetTags( $rlId ) {
		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select( 'collabwatchlistrevisiontag', 'COUNT(*) AS count', array( 'cw_id' => $rlId ), __METHOD__ );
		$row = $dbr->fetchObject( $res );
		return $row->count;
	}

	/**
	 * Prepare a list of categories on a collaborative watchlist
	 * and return an array of (prefixed) strings
	 *
	 * @param $rlId Collaborative watchlist id
	 * @return array
	 */
	private function getCollabWatchlistCategories( $rlId ) {
		$list = array();
		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select(
			array( 'collabwatchlistcategory', 'page' ),
			array( 'page_title', 'page_namespace', 'subtract' ),
			array(
				'cw_id' => $rlId,
			),
			__METHOD__, array(),
			 # Join conditions
			array(	'page' => array( 'JOIN', 'page.page_id = collabwatchlistcategory.cat_page_id' ) )
		);
		if ( $res->numRows() > 0 ) {
			foreach ( $res as $row ) {
				$title = Title::makeTitleSafe( $row->page_namespace, $row->page_title );
				if ( $title instanceof Title && !$title->isTalkPage() )
					$list[] = $row->subtract ? '- ' . $title->getPrefixedText() : $title->getPrefixedText();
			}
		}
		return $list;
	}

	/**
	 * Prepare a list of users on a collaborative watchlist
	 * and return an array of (prefixed) strings
	 *
	 * @param $rlId Collaborative watchlist id
	 * @return array
	 */
	private function getCollabWatchlistUsers( $rlId ) {
		$list = array();
		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select(
			array( 'collabwatchlistuser', 'user' ),
			array( 'user_name', 'rlu_type' ),
			array(
				'cw_id' => $rlId,
			),
			__METHOD__, array(),
			 # Join conditions
			array(	'user' => array( 'JOIN', 'user.user_id = collabwatchlistuser.user_id' ) )
		);
		if ( $res->numRows() > 0 ) {
			foreach ( $res as $row ) {
				$typeText = Collabwatchlist::userTypeToText( $row->rlu_type );
				$list[] = $typeText . ' ' . $row->user_name;
			}
		}
		return $list;
	}

	/**
	 * Prepare a list of tags on a collaborative watchlist
	 * and return an array of tag names mapping to tag descriptions
	 *
	 * @param $rlId Collaborative watchlist id
	 * @return array
	 */
	private function getCollabWatchlistTags( $rlId ) {
		$list = array();
		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select(
			array( 'collabwatchlisttag' ),
			array( 'rt_name', 'rt_description' ),
			array(
				'cw_id' => $rlId,
			), __METHOD__
		);
		if ( $res->numRows() > 0 ) {
			foreach ( $res as $row ) {
				$list[$row->rt_name] = $row->rt_description;
			}
		}
		return $list;
	}

	/**
	 * Get a list of categories on collaborative watchlist, excluding talk pages,
	 * and return as a two-dimensional array with namespace and title which
	 * maps to an array with 'redirect' and 'subtract' keys.
	 *
	 * @param $rlId Collaborative watchlist id
	 * @return array
	 */
	private function getWatchlistInfo( $rlId ) {
		$titles = array();
		$dbr = wfGetDB( DB_MASTER );

		$res = $dbr->select(
			array( 'collabwatchlistcategory', 'page' ),
			array( 'page_title', 'page_namespace', 'page_id', 'page_len', 'page_is_redirect', 'subtract' ),
			array(
				'cw_id' => $rlId,
			),
			__METHOD__, array(),
			 # Join conditions
			array(	'page' => array( 'JOIN', 'page.page_id = collabwatchlistcategory.cat_page_id' ) )
		);

		if ( $res && $dbr->numRows( $res ) > 0 ) {
			$cache = LinkCache::singleton();
			foreach ( $res as $row ) {
				$title = Title::makeTitleSafe( $row->page_namespace, $row->page_title );
				if ( $title instanceof Title ) {
					// Update the link cache while we're at it
					if ( $row->page_id ) {
						$cache->addGoodLinkObj( $row->page_id, $title, $row->page_len, $row->page_is_redirect );
					} else {
						$cache->addBadLinkObj( $title );
					}
					// Ignore non-talk
					if ( !$title->isTalkPage() )
						$titles[$row->page_namespace][$row->page_title] = array( 'redirect' => $row->page_is_redirect, 'subtract' => $row->subtract );
				}
			}
		}
		return $titles;
	}

	/**
	 * Show a message indicating the number of categories on the collaborative watchlist,
	 * and return this count for additional checking
	 *
	 * @param $output OutputPage
	 * @param $rlId The id of the collaborative watchlist
	 * @return int
	 */
	private function showItemCount( $output, $rlId ) {
		if ( ( $count = $this->countCollabWatchlistCategories( $rlId ) ) > 0 ) {
			$output->addHTML( wfMsgExt( 'collabwatchlistedit-numitems', 'parse',
				$GLOBALS['wgLang']->formatNum( $count ) ) );
		} else {
			$output->addHTML( wfMsgExt( 'collabwatchlistedit-noitems', 'parse' ) );
		}
		return $count;
	}

	/**
	 * Show a message indicating the number of categories on the collaborative watchlist,
	 * and return this count for additional checking
	 *
	 * @param $output OutputPage
	 * @param $rlId The id of the collaborative watchlist
	 * @return int
	 */
	private function showTagItemCount( $output, $rlId ) {
		if ( ( $count = $this->countCollabWatchlistTags( $rlId ) ) > 0 ) {
			$output->addHTML( wfMsgExt( 'collabwatchlistedit-tags-numitems', 'parse',
				$GLOBALS['wgLang']->formatNum( $count ) ) );
		} else {
			$output->addHTML( wfMsgExt( 'collabwatchlistedit-tags-noitems', 'parse' ) );
		}
		return $count;
	}

	/**
	 * Show a message indicating the number of set tags for edits on the collaborative watchlist,
	 * and return this count for additional checking
	 *
	 * @param $output OutputPage
	 * @param $rlId The id of the collaborative watchlist
	 * @return int
	 */
	private function showSetTagsItemCount( $output, $rlId ) {
		if ( ( $count = $this->countCollabWatchlistSetTags( $rlId ) ) > 0 ) {
			$output->addHTML( wfMsgExt( 'collabwatchlistedit-set-tags-numitems', 'parse',
				$GLOBALS['wgLang']->formatNum( $count ) ) );
		} else {
			$output->addHTML( wfMsgExt( 'collabwatchlistedit-set-tags-noitems', 'parse' ) );
		}
		return $count;
	}

	/**
	 * Show a message indicating the number of categories on the collaborative watchlist,
	 * and return this count for additional checking
	 *
	 * @param $output OutputPage
	 * @param $rlId The id of the collaborative watchlist
	 * @return int
	 */
	private function showUserItemCount( $output, $rlId ) {
		if ( ( $count = $this->countCollabWatchlistUsers( $rlId ) ) > 0 ) {
			$output->addHTML( wfMsgExt( 'collabwatchlistedit-users-numitems', 'parse',
				$GLOBALS['wgLang']->formatNum( $count ) ) );
		} else {
			$output->addHTML( wfMsgExt( 'collabwatchlistedit-users-noitems', 'parse' ) );
		}
		return $count;
	}

	/**
	 * Remove all categories from a collaborative watchlist
	 *
	 * @param $rlId Collaborative watchlist if
	 */
	private function clearCollabWatchlist( $rlId ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'collabwatchlistcategory', array( 'cw_id' => $rlId ), __METHOD__ );
	}

	/**
	 * Add a list of categories to a collaborative watchlist
	 *
	 * $titles is an array of strings, prefixed with '- ', if the
	 * category is subtracted
	 *
	 * @param $titles An array of strings
	 * @param $rlId The id of the collaborative watchlist
	 */
	private function watchTitles( $titles, $rlId ) {
		$dbw = wfGetDB( DB_MASTER );
		$rows = array();
		$added = array();
		foreach ( $titles as $title ) {
			$subtract = false;
			$title = trim( $title );
			$titleText = $title;
			if ( stripos( $title, '- ' ) === 0 ) {
				$subtract = true;
				$titleText = trim( substr( $title, 2 ) );
			}
			$titleObj = Title::newFromText( $titleText );
			if ( $titleObj instanceof Title && $titleObj->exists() ) {
				$rows[] = array(
					'cw_id' => $rlId,
					'cat_page_id' => $titleObj->getArticleID(),
					'subtract' => $subtract,
				);
				$added[] = $title;
			}
		}
		$dbw->insert( 'collabwatchlistcategory', $rows, __METHOD__, 'IGNORE' );
		return $added;
	}

	/**
	 * Add a list of users to a collaborative watchlist
	 *
	 * $titles is an array of strings, prefixed with the user type text and ' '
	 *
	 * @param $titles An array of strings
	 * @param $rlId The id of the collaborative watchlist
	 */
	private function addUsers( $users, $rlId ) {
		$dbw = wfGetDB( DB_MASTER );
		$rows = array();
		$added = array();
		foreach ( $users as $userString ) {
			list( $type, $typeText, $titleText ) = $this->extractTypeTypeTextAndUsername( $userString );
			$user = User::newFromName( $titleText );
			if ( $user instanceof User && $user->getId() !== 0 ) {
				$rows[] = array(
					'cw_id' => $rlId,
					'user_id' => $user->getId(),
					'rlu_type' => $type,
				);
				$added[] = $userString;
			}
		}
		$dbw->insert( 'collabwatchlistuser', $rows, __METHOD__, 'IGNORE' );
		return $added;
	}

	private function setTags( $titlesAndTagInfo, $tag, $userId, $rlId, $comment, $setPatrolled = false ) {
		// XXX Attach a hook to delete tags from the collabwatchlistrevisiontag table as soon as the actual tags are deleted from the change_tags table
		$allowedTagsAndInfo = $this->getCollabWatchlistTags( $rlId );
		if ( !array_key_exists( $tag, $allowedTagsAndInfo ) ) {
			return false;
		}
		$dbw = wfGetDB( DB_MASTER );
		foreach ( $titlesAndTagInfo as $title => $infos ) {
			$rcIds = array();
			// Add entries for the tag to the change_tags table
			// optionally mark edit as patrolled
			foreach ( $infos as $infoKey => $info ) {
				ChangeTags::addTags( $tag, $info['rc_id'], $info['rev_id'] );
				$rcIds[] = $info['rc_id'];
				if ( $setPatrolled ) {
					RecentChange::markPatrolled( $info['rc_id'] );
				}
			}
			// Add the tagged revisions to the collaborative watchlist
			$sql = 'INSERT IGNORE INTO collabwatchlistrevisiontag (ct_rc_id, ct_tag, cw_id, user_id, rrt_comment)
					SELECT ct_rc_id, ct_tag, ' . $dbw->strencode( $rlId ) . ',' .
						$dbw->strencode( $userId ) . ',' .
						$dbw->addQuotes( $comment ) . ' FROM change_tag WHERE ct_tag = ? AND ct_rc_id ';
			if ( count( $rcIds ) > 1 ) {
				$sql .= 'IN (' . $dbw->makeList( $rcIds ) . ')';
				$params = array( $tag );
			} else {
				$sql .= '= ?';
				$params = array( $tag, $rcIds[0] );
			}
			$prepSql = $dbw->prepare( $sql );
			$res = $dbw->execute( $prepSql, $params );
			$dbw->freePrepared( $prepSql );
			return true;
		}
	}

	private function unsetTags( $titlesAndTagInfo, $tag, $userId, $rlId ) {
		$dbw = wfGetDB( DB_MASTER );
		foreach ( $titlesAndTagInfo as $title => $infos ) {
			$rcIds = array();
			foreach ( $infos as $infoKey => $info ) {
			// XXX Remove entries for the tag from the change_tags table
//				ChangeTags::addTags($tag, $info['rc_id'], $info['rev_id']);
				$rcIds[] = $info['rc_id'];
			}
			// Remove the tag from the collaborative watchlist
			$sql = 'DELETE FROM collabwatchlistrevisiontag WHERE ct_tag = ? AND ct_rc_id ';
			if ( count( $rcIds ) > 1 ) {
				$sql .= 'IN (' . $dbw->makeList( $rcIds ) . ')';
				$params = array( $tag );
			} else {
				$sql .= '= ?';
				$params = array( $tag, $rcIds[0] );
			}
			$prepSql = $dbw->prepare( $sql );
			$res = $dbw->execute( $prepSql, $params );
			$dbw->freePrepared( $prepSql );
		}
	}

	/**
	 * Add a list of tags to a collaborative watchlist
	 *
	 * $titles is an array of strings
	 *
	 * @param $titles An array of strings (tag names) mapping to tag descriptions
	 * @param $rlId The id of the collaborative watchlist
	 */
	private function addTags( $titles, $rlId ) {
		$dbw = wfGetDB( DB_MASTER );
		$rows = array();
		foreach ( $titles as $title => $description ) {
			$rows[] = array(
				'cw_id' => $rlId,
				'rt_name' => $title,
				'rt_description' => $description,
			);
		}
		$dbw->insert( 'collabwatchlisttag', $rows, __METHOD__, 'IGNORE' );
	}

	/**
	 * Remove a list of categories from a collaborative watchlist
	 *
	 * $titles is an array of strings, prefixed with '- ', if the
	 * category is subtracted
	 *
	 * @param $titles An array of strings
	 * @param $rlId The id of the collaborative watchlist
	 */
	private function unwatchTitles( $titles, $rlId, $user ) {
		$dbw = wfGetDB( DB_MASTER );
		foreach ( $titles as $title ) {
			$subtract = false;
			$title = trim( $title );
			$titleText = $title;
			if ( stripos( $title, '- ' ) === 0 ) {
				$subtract = true;
				$titleText = trim( substr( $title, 2 ) );
			}
			$title = Title::newFromText( $titleText );
			if ( $title instanceof Title ) {
				$dbw->delete(
					'collabwatchlistcategory',
					array(
						'cw_id' => $rlId,
						'cat_page_id' => $title->getArticleID(),
						'subtract' => $subtract,
					),
					__METHOD__
				);
				$article = new Article( $title );
				// XXX Check if we can simply rename the hook, or if we need to register it
				wfRunHooks( 'UnwatchArticleComplete', array( &$user, &$article ) );
			}
		}
	}

	/**
	 * Remove a list of users from a collaborative watchlist
	 *
	 * $titles is an array of strings, prefixed with the user type text and ' '
	 *
	 * @param $titles An array of strings
	 * @param $rlId The id of the collaborative watchlist
	 */
	private function delUsers( $users, $rlId ) {
		$dbw = wfGetDB( DB_MASTER );
		foreach ( $users as $userString ) {
			list( $type, $typeText, $titleText ) = $this->extractTypeTypeTextAndUsername( $userString );
			$user = User::newFromName( $titleText );
			if ( $user instanceof User && $user->getId() !== 0 ) {
				$dbw->delete(
					'collabwatchlistuser',
					array(
						'cw_id' => $rlId,
						'user_id' => $user->getId(),
						'rlu_type' => $type,
					),
					__METHOD__
				);
			}
		}
		// XXX Check if we can simply rename the hook, or if we need to register it
		// wfRunHooks('UnwatchArticleComplete',array(&$user,&$article));
	}

	/**
	 * Remove a list of tags from a collaborative watchlist
	 *
	 * $titles is an array of strings
	 *
	 * @param $titles An array of strings
	 * @param $rlId The id of the collaborative watchlist
	 */
	private function removeTags( $titles, $rlId ) {
		$dbw = wfGetDB( DB_MASTER );
		foreach ( $titles as $title ) {
			$dbw->delete(
				'collabwatchlisttag',
				array(
					'cw_id' => $rlId,
					'rt_name' => $title,
				),
				__METHOD__
			);
			// $article = new Article($title);
			// XXX Check if we can simply rename the hook, or if we need to register it
			// wfRunHooks('UnwatchArticleComplete',array(&$user,&$article));
		}
	}

	/**
	 * Show the standard collaborative watchlist editing form
	 *
	 * @param $output OutputPage
	 * @param $rlId Collaborative watchlist id
	 */
	private function showNormalForm( $output, $rlId ) {
		global $wgUser;
		if ( ( $count = $this->showItemCount( $output, $rlId ) ) > 0 ) {
			$self = SpecialPage::getTitleFor( 'CollabWatchlist' );
			$form  = Xml::openElement( 'form', array( 'method' => 'post',
				'action' => $self->getLocalUrl( array( 'action' => 'edit' ) ) ) );
			$form .= Html::hidden( 'token', $wgUser->editToken( 'watchlistedit' ) );
			$form .= Html::hidden( 'collabwatchlist', $rlId );
			$form .= "<fieldset>\n<legend>" . wfMsgHtml( 'collabwatchlistedit-normal-legend' ) . "</legend>";
			$form .= wfMsgExt( 'collabwatchlistedit-normal-explain', 'parse' );
			$form .= $this->buildRemoveList( $rlId, $wgUser->getSkin() );
			$form .= '<p>' . Xml::submitButton( wfMsg( 'collabwatchlistedit-normal-submit' ) ) . '</p>';
			$form .= '</fieldset></form>';
			$output->addHTML( $form );
		}
	}

	private function showNewListForm( $output ) {
		global $wgUser;
		$self = SpecialPage::getTitleFor( 'CollabWatchlist' );
		$form  = Xml::openElement( 'form', array( 'method' => 'post',
			'action' => $self->getLocalUrl( array( 'action' => 'newList' ) ) ) );
		$form .= Html::hidden( 'token', $wgUser->editToken( 'watchlistedit' ) );
		$form .= "<fieldset>\n<legend>" . wfMsgHtml( 'collabwatchlistnew-legend' ) . "</legend>";
		$form .= wfMsgExt( 'collabwatchlistnew-explain', 'parse' );
		$form .= Xml::label( wfMsg( 'collabwatchlistnew-name' ), 'listname' ) . '&nbsp;' . Xml::input( 'listname' ) . '&nbsp;';
		$form .= '<p>' . Xml::submitButton( wfMsg( 'collabwatchlistnew-submit' ) ) . '</p>';
		$form .= '</fieldset></form>';
		$output->addHTML( $form );
	}

	private function showDeleteListForm( $output, $rlId ) {
		global $wgUser;
		$self = SpecialPage::getTitleFor( 'CollabWatchlist' );
		$form  = Xml::openElement( 'form', array( 'method' => 'post',
			'action' => $self->getLocalUrl( array( 'action' => 'delete' ) ) ) );
		$form .= Html::hidden( 'token', $wgUser->editToken( 'watchlistedit' ) );
		$form .= Html::hidden( 'collabwatchlist', $rlId );
		$form .= "<fieldset>\n<legend>" . wfMsgHtml( 'collabwatchlistdelete-legend' ) . "</legend>";
		$form .= wfMsgExt( 'collabwatchlistdelete-explain', 'parse' );
		$this->showUserItemCount( $output, $rlId );
		$this->showSetTagsItemCount( $output, $rlId );
		$form .= '<p>' . Xml::submitButton( wfMsg( 'collabwatchlistdelete-submit' ) ) . '</p>';
		$form .= '</fieldset></form>';
		$output->addHTML( $form );
	}

	private function createNewList( $name ) {
		global $wgUser;
		if ( !isset( $name ) || empty( $name ) )
			return;
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		try {
			$cw_id = $dbw->nextSequenceValue( 'collabwatchlist_cw_id_seq' );
			$dbw->insert( 'collabwatchlist', array(
				'cw_id'           => $cw_id,
				'cw_name'    => $name,
				'cw_start'	=> wfTimestamp( TS_ISO_8601 ),
			), __METHOD__, 'IGNORE' );

			$affected = $dbw->affectedRows();
			if ( $affected ) {
				$newid = $dbw->insertId();
			} else {
				return;
			}
			$rlu_id = $dbw->nextSequenceValue( 'collabwatchlistuser_rlu_id_seq' );
			$dbw->insert( 'collabwatchlistuser', array(
				'rlu_id'	=> $rlu_id,
				'cw_id'		=> $newid,
				'user_id'	=> $wgUser->getId(),
				'rlu_type'	=> CollabWatchlist::$USER_OWNER,
			), __METHOD__, 'IGNORE' );
			$affected = $dbw->affectedRows();
			if ( ! $affected ) {
				$dbw->rollback();
				return;
			}
			$dbw->commit();
			return $newid;
		} catch ( Exception $e ) {
			$dbw->rollback();
		}
	}

	private function deleteList( $rlId ) {
		if ( !isset( $rlId ) || empty( $rlId ) )
			return;
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		try {
			$dbw->delete( 'collabwatchlistrevisiontag', array(
				'cw_id' => $rlId,
			), __METHOD__ );
			$dbw->delete( 'collabwatchlisttag', array(
				'cw_id' => $rlId,
			), __METHOD__ );
			$dbw->delete( 'collabwatchlistcategory', array(
				'cw_id' => $rlId,
			), __METHOD__ );
			$dbw->delete( 'collabwatchlistuser', array(
				'cw_id' => $rlId,
			), __METHOD__ );
			$dbw->delete( 'collabwatchlist', array(
				'cw_id' => $rlId,
			), __METHOD__ );
			$affected = $dbw->affectedRows();
			if ( ! $affected ) {
				$dbw->rollback();
				return;
			}
			$dbw->commit();
			return $rlId;
		} catch ( Exception $e ) {
			$dbw->rollback();
		}
	}

	/**
	 * Build the part of the standard collaborative watchlist editing form with the actual
	 * title selection checkboxes and stuff.  Also generates a table of
	 * contents if there's more than one heading.
	 *
	 * @param $rlId The id of the collaborative watchlist
	 * @param $skin Skin (really, Linker)
	 */
	private function buildRemoveList( $rlId, $skin ) {
		$list = "";
		$toc = $skin->tocIndent();
		$tocLength = 0;
		foreach ( $this->getWatchlistInfo( $rlId ) as $namespace => $pages ) {
			$tocLength++;
			$heading = htmlspecialchars( $this->getNamespaceHeading( $namespace ) );
			$anchor = "editwatchlist-ns" . $namespace;

			$list .= $skin->makeHeadLine( 2, ">", $anchor, $heading, "" );
			$toc .= $skin->tocLine( $anchor, $heading, $tocLength, 1 ) . $skin->tocLineEnd();

			$list .= "<ul>\n";
			foreach ( $pages as $dbkey => $info ) {
				$title = Title::makeTitleSafe( $namespace, $dbkey );
				$list .= $this->buildRemoveLine( $title, $info, $skin );
			}
			$list .= "</ul>\n";
		}
		// ISSUE: omit the TOC if the total number of titles is low?
		if ( $tocLength > 1 ) {
			$list = $skin->tocList( $toc ) . $list;
		}
		return $list;
	}

	/**
	 * Get the correct "heading" for a namespace
	 *
	 * @param $namespace int
	 * @return string
	 */
	private function getNamespaceHeading( $namespace ) {
		return $namespace == NS_MAIN
			? wfMsgHtml( 'blanknamespace' )
			: htmlspecialchars( $GLOBALS['wgContLang']->getFormattedNsText( $namespace ) );
	}

	/**
	 * Build a single list item containing a check box selecting a title
	 * and a link to that title, with various additional bits
	 *
	 * @param $title Title
	 * @param $info array with info about the category ('redirect' and 'subtract' keys)
	 * @param $skin Skin
	 * @return string
	 */
	private function buildRemoveLine( $title, $catInfo, $skin ) {
		global $wgLang;

		$link = $skin->link( $title );
		if ( $catInfo['redirect'] )
			$link = '<span class="watchlistredir">' . $link . '</span>';
		$tools[] = $skin->link( $title->getTalkPage(), wfMsgHtml( 'talkpagelinktext' ) );
		if ( $title->exists() ) {
			$tools[] = $skin->link(
				$title,
				wfMsgHtml( 'history_short' ),
				array(),
				array( 'action' => 'history' ),
				array( 'known', 'noclasses' )
			);
		}
		if ( $title->getNamespace() == NS_USER && !$title->isSubpage() ) {
			$tools[] = $skin->link(
				SpecialPage::getTitleFor( 'Contributions', $title->getText() ),
				wfMsgHtml( 'contributions' ),
				array(),
				array(),
				array( 'known', 'noclasses' )
			);
		}
		return "<li>"
			. ( $catInfo['subtract'] ? '<span class="collabwatchlistsubtract">- </span>' : '' )
			. Xml::check( 'titles[]', false, array( 'value' => $catInfo['subtract'] ? '- ' . $title->getPrefixedText() : $title->getPrefixedText() ) )
			. $link . " (" . $wgLang->pipeList( $tools ) . ")" . "</li>\n";
		}

	/**
	 * Show a form for editing the watchlist in "raw" mode
	 *
	 * @param $output OutputPage
	 * @param $rlId Collaborative watchlist id
	 * @param $rlName Collaborative watchlist name
	 */
	private function showRawForm( $output, $rlId, $rlName ) {
		global $wgUser;
		$this->showItemCount( $output, $rlId );
		$self = SpecialPage::getTitleFor( 'CollabWatchlist' );
		$form  = Xml::openElement( 'form', array( 'method' => 'post',
			'action' => $self->getLocalUrl( array( 'action' => 'rawCategories' ) ) ) );
		$form .= Html::hidden( 'token', $wgUser->editToken( 'watchlistedit' ) );
		$form .= Html::hidden( 'collabwatchlist', $rlId );
		$form .= '<fieldset><legend>' . $rlName . ' ' . wfMsgHtml( 'watchlistedit-raw-legend' ) . '</legend>';
		$form .= wfMsgExt( 'watchlistedit-raw-explain', 'parse' );
		$form .= Xml::label( wfMsg( 'watchlistedit-raw-titles' ), 'titles' );
		$form .= "<br />\n";
		$form .= Xml::openElement( 'textarea', array( 'id' => 'titles', 'name' => 'titles',
			'rows' => $wgUser->getIntOption( 'rows' ), 'cols' => $wgUser->getIntOption( 'cols' ) ) );
		$categories = $this->getCollabWatchlistCategories( $rlId );
		foreach ( $categories as $category )
			$form .= htmlspecialchars( $category ) . "\n";
		$form .= '</textarea>';
		$form .= '<p>' . Xml::submitButton( wfMsg( 'watchlistedit-raw-submit' ) ) . '</p>';
		$form .= '</fieldset></form>';
		$output->addHTML( $form );
	}

	/**
	 * Show a form for editing the tags of a collaborative watchlist in "raw" mode
	 *
	 * @param $output OutputPage
	 * @param $rlId Collaborative watchlist id
	 * @param $rlName Collaborative watchlist name
	 */
	private function showTagsRawForm( $output, $rlId, $rlName ) {
		global $wgUser;
		$this->showTagItemCount( $output, $rlId );
		$self = SpecialPage::getTitleFor( 'CollabWatchlist' );
		$form  = Xml::openElement( 'form', array( 'method' => 'post',
			'action' => $self->getLocalUrl( array( 'action' => 'rawTags' ) ) ) );
		$form .= Html::hidden( 'token', $wgUser->editToken( 'watchlistedit' ) );
		$form .= Html::hidden( 'collabwatchlist', $rlId );
		$form .= '<fieldset><legend>' . $rlName . ' ' . wfMsgHtml( 'collabwatchlistedit-tags-raw-legend' ) . '</legend>';
		$form .= wfMsgExt( 'collabwatchlistedit-tags-raw-explain', 'parse' );
		$form .= Xml::label( wfMsg( 'collabwatchlistedit-tags-raw-titles' ), 'titles' );
		$form .= "<br />\n";
		$form .= Xml::openElement( 'textarea', array( 'id' => 'titles', 'name' => 'titles',
			'rows' => $wgUser->getIntOption( 'rows' ), 'cols' => $wgUser->getIntOption( 'cols' ) ) );
		$tags = $this->getCollabWatchlistTags( $rlId );
		foreach ( $tags as $tag => $description )
			$form .= htmlspecialchars( $tag ) . "|" . $description . "\n";
		$form .= '</textarea>';
		$form .= '<p>' . Xml::submitButton( wfMsg( 'collabwatchlistedit-tags-raw-submit' ) ) . '</p>';
		$form .= '</fieldset></form>';
		$output->addHTML( $form );
	}

	/**
	 * Show a form for editing the users of a collaborative watchlist in "raw" mode
	 *
	 * @param $output OutputPage
	 * @param $rlId Collaborative watchlist id
	 * @param $rlName Collaborative watchlist name
	 */
	private function showUsersRawForm( $output, $rlId, $rlName ) {
		global $wgUser;
		$this->showUserItemCount( $output, $rlId );
		$self = SpecialPage::getTitleFor( 'CollabWatchlist' );
		$form  = Xml::openElement( 'form', array( 'method' => 'post',
			'action' => $self->getLocalUrl( array( 'action' => 'rawUsers' ) ) ) );
		$form .= Html::hidden( 'token', $wgUser->editToken( 'watchlistedit' ) );
		$form .= Html::hidden( 'collabwatchlist', $rlId );
		$form .= '<fieldset><legend>' . $rlName . ' ' . wfMsgHtml( 'collabwatchlistedit-users-raw-legend' ) . '</legend>';
		$form .= wfMsgExt( 'collabwatchlistedit-users-raw-explain', 'parse' );
		$form .= Xml::label( wfMsg( 'collabwatchlistedit-users-raw-titles' ), 'titles' );
		$form .= "<br />\n";
		$form .= Xml::openElement( 'textarea', array( 'id' => 'titles', 'name' => 'titles',
			'rows' => $wgUser->getIntOption( 'rows' ), 'cols' => $wgUser->getIntOption( 'cols' ) ) );
		$users = $this->getCollabWatchlistUsers( $rlId );
		foreach ( $users as $userString )
			$form .= htmlspecialchars( $userString ) . "\n";
		$form .= '</textarea>';
		$form .= '<p>' . Xml::submitButton( wfMsg( 'collabwatchlistedit-users-raw-submit' ) ) . '</p>';
		$form .= '</fieldset></form>';
		$output->addHTML( $form );
	}

	/**
	 * Determine whether we are editing the watchlist, and if so, what
	 * kind of editing operation
	 *
	 * @param $request WebRequest
	 * @param $par mixed
	 * @return int
	 */
	public static function getMode( $request, $par ) {
		$mode = strtolower( $request->getVal( 'action', $par ) );
		switch( $mode ) {
			case 'clear':
				return self::EDIT_CLEAR;
			case 'rawcategories':
				return self::CATEGORIES_EDIT_RAW;
			case 'rawtags':
				return self::TAGS_EDIT_RAW;
			case 'edit':
				return self::EDIT_NORMAL;
			case 'settags':
				return self::SET_TAGS;
			case 'unsettags':
				return self::UNSET_TAGS;
			case 'rawusers':
				return self::USERS_EDIT_RAW;
			case 'newlist':
				return self::NEW_LIST;
			case 'delete':
				return self::DELETE_LIST;
			default:
				return false;
		}
	}

	/**
	 * Build a set of links for convenient navigation
	 * between collaborative watchlist viewing and editing modes
	 *
	 * @param $listIdsAndNames An array mapping from list ids to list names
	 * @param $skin Skin to use
	 * @return string
	 */
	public static function buildTools( $listIdsAndNames, $skin ) {
		global $wgLang, $wgUser;
		$modes = array( 'view' => false, 'delete' => 'delete', 'edit' => 'edit',
			'rawCategories' => 'rawCategories', 'rawTags' => 'rawTags',
			'rawUsers' => 'rawUsers' );
		$r = '';
		// Insert link for new list
		$r .= $skin->link(
			SpecialPage::getTitleFor( 'CollabWatchlist', 'newList' ),
			wfMsgHtml( "collabwatchlisttools-newList" ),
			array(),
			array(),
			array( 'known', 'noclasses' )
		) . '<br />';
		if ( !isset( $listIdsAndNames ) || empty( $listIdsAndNames ) )
			return $r;
		foreach ( $listIdsAndNames as $listId => $listName ) {
			$tools = array();
			foreach ( $modes as $mode => $subpage ) {
				// can use messages 'watchlisttools-view', 'watchlisttools-edit', 'watchlisttools-raw'
				$tools[] = $skin->link(
					SpecialPage::getTitleFor( 'CollabWatchlist', $subpage ),
					wfMsgHtml( "collabwatchlisttools-{$mode}" ),
					array(),
					array( 'collabwatchlist' => $listId ),
					array( 'known', 'noclasses' )
				);
			}
			$r .= $listName . ' ' . $wgLang->pipeList( $tools ) . '<br />';
		}
		return $r;
	}

	/** Returns a URL for unsetting a specific tag on a specific edit on a given list
	 *
	 * @param String $redirUrl The url to redirect after the tag was removed
	 * @param String $pageName The name of the page the tag is set on
	 * @param int $rlId The id of the collab watchlist
	 * @param String $tag The tag to remove
	 * @param int $rcId The id of the edit in the recent changes
	 * @return String an URL string
	 */
	public static function getUnsetTagUrl( $redirUrl, $pageName, $rlId, $tag, $rcId ) {
		return SpecialPage::getTitleFor( 'CollabWatchlist' )->getLocalUrl( array(
			'action' => 'unsetTags',
			'redirTarget' => $redirUrl,
			'collabwatchlisttag' => $tag,
			'collabwatchlist' => $rlId,
			'collabwatchlistpage' => $pageName,
			'collabwatchlistrcid' => $rcId
		) );
	}
}
