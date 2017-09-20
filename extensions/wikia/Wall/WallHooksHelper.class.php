<?php

use Wikia\Logger\WikiaLogger;

/**
 * Hooks for Message Wall.
 *
 * All of these hooks will be executed when Forums are enabled
 * even if Message Wall is disabled, so appropriate checks are
 * needed if the hook should only take effect if Wall is enabled.
 */
class WallHooksHelper {
	const RC_WALL_COMMENTS_MAX_LEN = 50;
	const RC_WALL_SECURENAME_PREFIX = 'WallMessage_';
	static private $rcWallActionTypes = [ 'wall_remove', 'wall_restore', 'wall_admindelete', 'wall_archive', 'wall_reopen' ];

	static public function onBlockIpCompleteWatch( $name, $title ) {
		$app = F::App();
		$watchTitle = Title::makeTitle( NS_USER_WALL, $name );
		$app->wg->User->addWatch( $watchTitle );
		return true;
	}

	/**
	 * @param $user
	 * @param Title $title
	 * @param $blocked
	 * @param $allowUsertalk
	 * @return bool
	 */
	static public function onUserIsBlockedFrom( $user, $title, &$blocked, &$allowUsertalk ) {

		if ( !$user->mHideName && $allowUsertalk && $title->inNamespace( NS_USER_WALL_MESSAGE  ) ) {
			$wm = new WallMessage( $title );

			$blocked = !( $wm->isWallOwner( $user ) );
		}

		return true;
	}

	/**
	 * @param Article $article
	 * @param $outputDone
	 * @param $useParserCache
	 * @return bool
	 * @throws MWException
	 */
	static public function onArticleViewHeader( Article $article, bool &$outputDone, bool &$useParserCache ): bool {

		$app = F::app();
		$helper = new WallHelper();
		$title = $article->getTitle();

		if ( $title->getNamespace() === NS_USER_WALL_MESSAGE && is_numeric( $title->getText() ) ) {
			// message wall index - brick page

			$threadId = $title->getText();
			$outputDone = true;

			$mainTitle = Title::newFromId( $threadId );
			if ( empty( $mainTitle ) ) {
				$dbkey = null;
			} else {
				$dbkey = $mainTitle->getDBkey();
			}

			if ( empty( $dbkey ) ) {
				// try master
				$mainTitle = Title::newFromId( $threadId, Title::GAID_FOR_UPDATE );
				if ( !empty( $mainTitle ) ) {
					WikiaLogger::instance()->info( 'Wall thread master fallback - found', [
						'threadId' => $threadId
					] );

					$dbkey = $mainTitle->getDBkey();
				} else {
					WikiaLogger::instance()->info( 'Wall thread master fallback - not found', [
						'threadId' => $threadId
					] );
				}
			}

			if ( empty( $dbkey ) || !$helper->isDbkeyFromWall( $dbkey ) ) {
				// no dbkey or not from wall, redirect to Main Page
				$app->wg->Out->redirect( Title::newMainPage()->getFullUrl(), 301 );
				return true;
			}

			$wallMessage = WallMessage::newFromTitle( $mainTitle );
			$isDeleted = !$wallMessage->isVisible( $app->wg->User );
			$showDeleted = ( $wallMessage->canViewDeletedMessage( $app->wg->User )
				&& $app->wg->Request->getVal( 'show' ) == '1' );

			// SUS-2576: set response code to HTTP 410 Gone for deleted wall messages and forum threads
			if ( $wallMessage->isRemove() ) {
				$app->wg->Out->setStatusCode( 410 );
			}

			if ( $isDeleted ) {
				$app->wg->Out->setStatusCode( 404 );
			}

			if ( $isDeleted && !$showDeleted ) {
				$app->wg->Out->addHTML( $app->renderView(
					'WallController',
					'messageDeleted'
				) );
				return true;
			}

			if ( !Hooks::run( 'WallBeforeRenderThread', [ $mainTitle, $wallMessage ] ) ) {
				return true;
			}

			$app->wg->Out->addHTML( $app->renderView(
				'WallController',
				'thread',
				[ 'id' => $threadId, 'title' => $wallMessage->getArticleTitle() ]
			) );

			return true;
		}

		if ( empty( $app->wg->EnableWallExt ) ) {
			return true;
		}


		if ( $title->getNamespace() === NS_USER_WALL && !$title->isSubpage()
		) {
			// message wall index
			$outputDone = true;
			$app->wg->Out->addHTML( $app->renderView( 'WallController', 'index', [ 'title' => $article->getTitle() ] ) );
		}

		if ( $title->getNamespace() === NS_USER_TALK
				&& !$title->isSubpage()
		) {
			$title = static::getWallTitle();
			if ( empty( $title ) ) {
				return true;
			}
			// user talk page -> redirect to message wall
			$outputDone = true;
			$app->wg->Out->redirect( $title->getFullUrl(), 301 );

			return true;
		}

		$parts = explode( '/', $title->getText() );

		if ( $title->getNamespace() === NS_USER_TALK
				&& $title->isSubpage()
				&& !empty( $parts[0] )
				&& !empty( $parts[1] )
		) {
			// user talk subpage -> redirects to message wall namespace subpage
			$outputDone = true;

			$title = Title::newFromText( $parts[0] . '/' . $parts[1], NS_USER_WALL );
			$app->wg->Out->redirect( $title->getFullUrl(), 301 );

			return true;
		}

		if ( $title->getNamespace() === NS_USER_WALL
				&& $title->isSubpage()
				&& !empty( $app->wg->EnableWallExt )
				&& !empty( $parts[1] )
				&& mb_strtolower( str_replace( ' ', '_', $parts[1] ) ) === mb_strtolower( $helper->getArchiveSubPageText() )
		) {
			// user talk archive
			$outputDone = true;

			$app->wg->Out->addHTML( $app->renderView( 'WallController', 'renderOldUserTalkPage', [ 'wallUrl' => static::getWallTitle()->getFullUrl() ] ) );
		} else if ( $title->getNamespace() === NS_USER_WALL && $title->isSubpage() ) {
			// message wall subpage (sometimes there are old user talk subpages)
			$outputDone = true;

			$app->wg->Out->addHTML( $app->renderView( 'WallController', 'renderOldUserTalkSubpage', [ 'subpage' => $parts[1], 'wallUrl' => static::getWallTitle()->getFullUrl() ] ) );

			return true;
		}

		return true;
	}

	/**
	 * @brief Hook to change tabs on user wall page
	 *
	 * @param Skin $skin
	 * @param array $contentActions
	 * @return bool
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	static public function onSkinTemplateTabs( Skin $skin, &$contentActions ): bool {
		global $wgEnableWallExt;

		if ( !empty( $wgEnableWallExt ) ) {
			$title = $skin->getTitle();
			$wallTabsRenderer = new WallTabsRenderer( $skin );

			if ( $title->getNamespace() === NS_USER ) {
				$wallTabsRenderer->renderUserPageContentActions( $contentActions );
			}

			if ( $title->getNamespace() === NS_USER_WALL || $title->getNamespace() === NS_USER_WALL_MESSAGE ) {
				$wallTabsRenderer->renderWallContentActions( $contentActions );
			}

			if ( $title->getNamespace() === NS_USER_WALL && $title->isSubpage() ) {
				$wallTabsRenderer->renderUserTalkArchiveContentActions( $contentActions );
			}
		}

		return true;
	}

	/**
	 * @brief Redirects any attempts of editing anything in NS_USER_WALL namespace
	 *
	 * @param $editPage
	 * @return bool true
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	static public function onAlternateEdit( EditPage $editPage ): bool {
		static::doSelfRedirect( $editPage->getTitle() );

		return true;
	}

	/**
	 * @brief Redirects any attempts of viewing history of any page in NS_USER_WALL namespace
	 *
	 * @param Article $article
	 * @return bool true
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */

	static public function onBeforePageHistory( Article $article ): bool {
		$title = $article->getTitle();

		// Skip remaining logic if this is a Forum Thread and we are doing Discussion redirects
		if ( self::isRedirectableForumThread( $article ) ) {
			return true;
		}

		$app = F::App();
		$page = $app->wg->Request->getVal( 'page', 1 );

		if ( !empty( $title ) ) {
			if (  WallHelper::isWallNamespace( $title->getNamespace() )  && !$title->isTalkPage() && !$title->isSubpage() ) {
				$app->wg->Out->addHTML( $app->renderView( 'WallHistoryController', 'index', [ 'title' => $title, 'page' => $page ] ) );
				return false;
			}

			if (  WallHelper::isWallNamespace( $title->getNamespace() ) && $title->isTalkPage() ) {
				$app->wg->Out->addHTML( $app->renderView( 'WallHistoryController', 'index', [ 'title' => $title, 'page' => $page, 'threadLevelHistory' => true ] ) );
				return false;
			}
		}

		static::doSelfRedirect( $title );
		return true;
	}

	/**
	 * Check to see if this is an article that will be redirected by the
	 * SpecialForumRedirectController.  Since the hook handler in this class returns false and
	 * renders its own page, it stops the hook handling and the hook
	 * in SpecialForumRedirectController is never called.
	 *
	 * @param Article $article
	 *
	 * @return bool
	 */
	static public function isRedirectableForumThread( Article $article ): bool {
		$wg = F::app()->wg;

		// Make sure discussions are active but forums are not
		if ( !empty( $wg->EnableDiscussions ) && empty( $wg->EnableForumExt ) ) {
			$title = SpecialForumRedirectController::getRedirectableForumTitle( $article );
			if ( !empty( $title ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @brief Overrides descrpiton of history page
	 *
	 * @param $description
	 * @return true
	 *
	 * @author Jakub Olek
	 */

	static public function onGetHistoryDescription( &$description ) {
		$app = F::app();

		if ( WallHelper::isWallNamespace( $app->wg->Title->getNamespace() ) ) {
			$description = '';
		}

		return true;
	}

	/**
	 * @brief modify toolbar
	 *
	 * @param $items
	 *
	 * @return bool
	 */
	static public function onBeforeToolbarMenu( &$items, $type ) {
		$app = F::app();
		if ( empty( $app->wg->EnableWallExt ) ) {
			return true;
		}

		$title = $app->wg->Title;

		if ( $title instanceof Title && $title->isTalkPage()  &&  WallHelper::isWallNamespace( $title->getNamespace() ) ) {
			if ( is_array( $items ) ) {
				foreach ( $items as $k => $value ) {
					if ( $value['type'] == 'follow' ) {
						unset( $items[$k] );
						break;
					}
				}

			}
		}

		return true;
	}

	/**
	 * @brief Redirects any attempts of protecting any page in NS_USER_WALL namespace
	 *
	 * @param $article
	 * @return bool true
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	static public function onBeforePageProtect( Article $article ): bool {
		static::doSelfRedirect( $article->getTitle() );

		return true;
	}

	/**
	 * @brief Redirects any attempts of unprotecting any page in NS_USER_WALL namespace
	 *
	 * @param $article
	 * @return bool true
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	static public function onBeforePageUnprotect( Article $article ): bool {
		static::doSelfRedirect( $article->getTitle() );

		return true;
	}

	/**
	 * @brief Redirects any attempts of deleting any page in NS_USER_WALL namespace
	 *
	 * @param $article
	 * @return true
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	static public function onBeforePageDelete( Article $article ) {
		static::doSelfRedirect( $article->getTitle() );

		return true;
	}

	/**
	 * @brief Changes "My talk" to "Message wall" in the user links.
	 *
	 * @param array $personalUrls
	 * @param Title $title
	 * @param Skin $skin
	 * @return bool true
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 * @author Piotrek Bablok
	 */
	static public function onPersonalUrls( array &$personalUrls, Title $title, Skin $skin ): bool {
		global $wgEnableWallExt;

		if ( empty( $wgEnableWallExt ) ) {
			return true;
		}

		JSMessages::enqueuePackage( 'Wall', JSMessages::EXTERNAL );

		if ( $skin->getUser()->isLoggedIn() ) {
			$userWallTitle = $skin->getUser()->getTalkPage();

			$personalUrls['mytalk']['href'] = $userWallTitle->getLocalUrl();
			$personalUrls['mytalk']['text'] = $skin->msg( 'wall-message-wall' )->text();

			if ( !empty( $personalUrls['mytalk']['class'] ) ) {
				unset( $personalUrls['mytalk']['class'] );
			}
		}

		return true;
	}

	/**
	 * @brief Changes "My talk" to "Message wall" in Oasis (in the tabs on the User page).
	 *
	 * @param $tabs
	 * @param $namespace
	 * @param $userName
	 * @return true
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	static public function onUserPagesHeaderModuleAfterGetTabs( &$tabs, $namespace, $userName ) {
		$app = F::App();

		if ( !empty( $app->wg->EnableWallExt ) ) {
			foreach ( $tabs as $key => $tab ) {
				if ( !empty( $tab['data-id'] ) && $tab['data-id'] === 'talk' ) {
					$userWallTitle = static::getWallTitle();

					if ( $userWallTitle instanceof Title ) {
						$tabs[$key]['link'] = Xml::element( 'a', [ 'href' => $userWallTitle->getLocalUrl(), 'title' => $userWallTitle->getPrefixedText() ], wfMessage( 'wall-message-wall' )->text() );
						$tabs[$key]['data-id'] = 'wall';

						if ( $namespace === NS_USER_WALL ) {
							$tabs[$key]['selected'] = true;
						}
					}

					break;
				}
			}
		}
		return true;
	}

	/**
	 * @brief Remove Message Wall:: from back link
	 *
	 * @param Title $title
	 * @param $ptext
	 * @param $cssClass
	 * @return bool
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	static public function onSkinSubPageSubtitleAfterTitle( $title, &$ptext, &$cssClass ) {
		if ( !empty( $title ) && $title->getNamespace() == NS_USER_WALL ) {
			$ptext = $title->getText();
			$cssClass = 'back-user-wall';
		}

		return true;
	}

	/**
	 * @brief Redirects to current title if it is in NS_USER_WALL namespace
	 *
	 * @param Title $title
	 * @return void
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	static protected function doSelfRedirect( Title $title ) {
		$app = F::App();

		if ( $app->wg->Request->getVal( 'action' ) == 'history' || $app->wg->Request->getVal( 'action' ) == 'historysubmit' ) {
			return;
		}

		if ( $title->getNamespace() === NS_USER_WALL ) {
			$app->wg->Out->redirect( $title->getLocalUrl(), 301 );
			$app->wg->Out->enableRedirects( false );
		}

		if ( $title->getNamespace() === NS_USER_WALL_MESSAGE ) {
			$wm = new WallMessage( $title );

			$app->wg->Out->redirect( $wm->getWallPageUrl(), 301 );
			$app->wg->Out->enableRedirects( false );
		}
	}

	/**
	 * @brief Returns message wall title if any
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 *
	 * @param null $subpage
	 * @param null $user
	 * @return Title | null
	 */
	static protected function getWallTitle( $subpage = null, $user = null ) {
		$helper = new WallHelper();

		return $helper->getTitle( NS_USER_WALL, $subpage, $user );
	}

	/**
	 * clean history after delete
	 * @param Article $article
	 * @param $user
	 * @param $reason
	 * @param $id
	 * @return bool
	 */
	static public function onArticleDeleteComplete( $article, $user, $reason, $id ) {
		$title = $article->getTitle();
		if ( $title instanceof Title && $title->getNamespace() == NS_USER_WALL_MESSAGE ) {
			$wh = new WallHistory();
			$wh->remove( $id );
		}
		return true;
	}

	/**
	 * @param Article $article
	 * @param User $user
	 * @param $reason
	 * @param $error
	 * @return bool
	 */
	static public function onArticleDelete( Article $article, &$user, &$reason, &$error ): bool {
		$title = $article->getTitle();
		if ( $title instanceof Title && $title->getNamespace() == NS_USER_WALL_MESSAGE ) {
			$wallMessage = WallMessage::newFromTitle( $title );
			return $wallMessage->canDelete( $user );
		}
		return true;
	}

	/**
	 * @param ArticleComment $comment
	 * @return bool
	 */
	static public function onArticleCommentBeforeWatchlistAdd( $comment ) {
		$commentTitle = $comment->getTitle();
		$app = F::app();
		if ( $commentTitle instanceof Title &&
			in_array( MWNamespace::getSubject( $commentTitle->getNamespace() ), $app->wg->WallNS ) ) {
			$parentTitle = $comment->getTopParentObj();

			if ( !( $comment->mUser instanceof User ) ) {
				// force load from cache
				$comment->load( true );
			}

			if ( !( $comment->mUser instanceof User ) ) {
				// comment in master has no valid User
				// log error
				$logmessage = 'WallHooksHelper.class.php, ' . __METHOD__ . ' ';
				$logmessage .= 'ArticleId: ' . $commentTitle->getArticleID();

				Wikia::log( __METHOD__, false, $logmessage );

				// parse following hooks
				return true;
			}

			if ( !empty( $parentTitle ) ) {
				$comment->mUser->addWatch( $parentTitle->getTitle() );
			} else {
				$comment->mUser->addWatch( $comment->getTitle() );
			}

			return false;
		}

		return true;
	}


	/**
	 * @brief Allows to edit or not archived talk pages and its subpages
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 *
	 * @param $permErrors
	 * @param Title $title
	 * @param $removeArray
	 * @return boolean true -- because it's a hook
	 */
	static public function onAfterEditPermissionErrors( &$permErrors, $title, $removeArray ) {
		$app = F::App();
		$canEdit = $app->wg->User->isAllowed( 'editwallarchivedpages' );

		if ( !empty( $app->wg->EnableWallExt )
				&& defined( 'NS_USER_TALK' )
				&& $title->getNamespace() == NS_USER_TALK
				&& !$canEdit
		) {
			$permErrors[] = [
					0 => 'protectedpagetext',
					1 => 'archived'
			];
		}

		return true;
	}

	/**
	 * @brief Just adjusting links and removing history from brick pages (My Tools bar)
	 *
	 * @param array $contentActions passed by reference array with anchors elements
	 *
	 * @return true because this is a hook
	 */
	static public function onSkinTemplateContentActions( &$contentActions ) {
		$app = F::app();

		$title = null;
		if ( !empty( $app->wg->EnableWallExt ) && $app->wg->Title instanceof Title ) {
			$title = $app->wg->Title;
			$parts = explode( '/', $title->getText() );
			$helper = new WallHelper();
		}

		if ( $title instanceof Title
				&& $title->getNamespace() == NS_USER_WALL
				&& $title->isSubpage() === true
				&& mb_strtolower( str_replace( ' ', '_', $parts[1] ) ) !== mb_strtolower( $helper->getArchiveSubPageText() )
		) {
			// remove "History" and "View source" tabs in Monobook & don't show history in "My Tools" in Oasis
			// because it leads to Message Wall (redirected) and a user could get confused
			if ( isset( $contentActions['history']['href'] ) ) {
				unset( $contentActions['history'] );
			}

			if ( isset( $contentActions['view-source']['href'] ) ) {
				unset( $contentActions['view-source'] );
			}
		}

		return true;
	}

	/**
	 * @brief Adjusting recent changes for Wall
	 *
	 * This method doesn't let display flags for message wall replies (they are displayed only for messages from message wall)
	 *
	 * @param ChangesList $list
	 * @param string $flags
	 * @param RecentChange $rc
	 *
	 * @return true because this is a hook
	 *
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	static public function onChangesListInsertFlags( $list, &$flags, $rc ) {
		if ( $rc->getAttribute( 'rc_type' ) == RC_NEW && $rc->getAttribute( 'rc_namespace' ) == NS_USER_WALL_MESSAGE ) {
			// we don't need flags if this is a reply on a message wall

			$rcTitle = $rc->getTitle();

			if ( !( $rcTitle instanceof Title ) ) {
				// it can be media wiki deletion of an article -- we ignore them
				Wikia::log( __METHOD__, false, "WALL_NOTITLE_FROM_RC " . print_r( $rc, true ) );
				return true;
			}

			$wm = new WallMessage( $rcTitle );
			$wm->load();

			if ( !$wm->isMain() ) {
				$flags = '';
			}
		}

		return true;
	}

	/**
	 * @brief Adjusting recent changes for Wall
	 *
	 * This method shows link to message wall thread page
	 *
	 * @param ChangesList $list
	 * @param string $articleLink
	 * @param string $s
	 * @param RecentChange $rc
	 * @param boolean $unpatrolled
	 * @param boolean $watched
	 *
	 * @return true because this is a hook
	 *
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	static public function onChangesListInsertArticleLink( $list, &$articleLink, &$s, $rc, $unpatrolled, $watched ) {
		$rcType = $rc->getAttribute( 'rc_type' );
		$app = F::app();
		if ( in_array( $rcType, [ RC_NEW, RC_EDIT, RC_LOG ] ) && in_array( MWNamespace::getSubject( $rc->getAttribute( 'rc_namespace' ) ), $app->wg->WallNS ) ) {

			if ( in_array( $rc->getAttribute( 'rc_log_action' ), static::$rcWallActionTypes ) ) {
				$articleLink = '';

				return true;
			} else {
				$rcTitle = $rc->getTitle();

				if ( !( $rcTitle instanceof Title ) ) {
					// it can be media wiki deletion of an article -- we ignore them
					Wikia::log( __METHOD__, false, "WALL_NOTITLE_FROM_RC " . print_r( $rc, true ) );
					return true;
				}

				if ( !$rcTitle->isTalkPage() ) {
					return true;
				}



				$wm = new WallMessage( $rcTitle );
				$wm->load();

				if ( !$wm->isMain() ) {
					$link = $wm->getMessagePageUrl( false, false );
					$wm = $wm->getTopParentObj();
					if ( is_null( $wm ) ) {
						Wikia::log( __METHOD__, false, "WALL_NO_PARENT_MSG_OBJECT " . print_r( $rc, true ) );
						return true;
					} else {
						$wm->load();
					}
				} else {
					$link = $wm->getMessagePageUrl( false, false );
				}

				$title = $wm->getMetaTitle();
				$titleText = $wm->getArticleTitle()->getPrefixedText();
				$pageText = $wm->getMainPageText();
				$class = '';

				$articleLink = ' <a href="' . $link . '" class="' . $class . '" >' . $title . '</a> ' . wfMessage( static::getMessagePrefix( $rc->getAttribute( 'rc_namespace' ) ) . '-new-message', [ $titleText, $pageText ] )->parse();

				# Bolden pages watched by this user
				# Check if the user is following the thread or the board
				$user = $app->wg->User;
				if ( $wm->isWatched( $user ) || $wm->isWallWatched( $user ) ) {
					$articleLink = '<strong class="mw-watched">' . $articleLink . '</strong>';
				}
			}

			# RTL/LTR marker
			$articleLink .= $app->wg->ContLang->getDirMark();
		}

		return true;
	}

	/**
	 * @brief Adjusting recent changes for Wall
	 *
	 * This method doesn't let display diff history links
	 *
	 * @param ChangesList $list
	 * @param $diffLink
	 * @param $historyLink
	 * @param string $s
	 * @param RecentChange $rc
	 * @param boolean $unpatrolled
	 *
	 * @internal param string $articleLink
	 * @return true because this is a hook
	 *
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	static public function onChangesListInsertDiffHist( $list, &$diffLink, &$historyLink, &$s, $rc, $unpatrolled ) {
		wfProfileIn( __METHOD__ );

		$app = F::app();
		if ( in_array( MWNamespace::getSubject( intval( $rc->getAttribute( 'rc_namespace' ) ) ), $app->wg->WallNS ) ) {
			$rcTitle = $rc->getTitle();

			if ( !( $rcTitle instanceof Title ) ) {
				// it can be media wiki deletion of an article -- we ignore them
				Wikia::log( __METHOD__, false, "WALL_NOTITLE_FOR_DIFF_HIST " . print_r( [ $rc ], true ) );
				wfProfileOut( __METHOD__ );
				return true;
			}

			if ( in_array( $rc->getAttribute( 'rc_log_action' ), static::$rcWallActionTypes ) ) {
				// delete, remove, restore
				$parts = explode( '/@', $rcTitle->getText() );
				$isThread = ( count( $parts ) === 2 ) ? true : false;

				if ( $isThread ) {
					$wallTitleObj = Title::newFromText( $parts[0], NS_USER_WALL );
					$historyLink = ( !empty( $parts[0] ) && $wallTitleObj instanceof Title ) ? $wallTitleObj->getFullURL( [ 'action' => 'history' ] ) : '#';
					$historyLink = Xml::element( 'a', [ 'href' => $historyLink ], wfMessage( static::getMessagePrefix( $rc->getAttribute( 'rc_namespace' ) ) . '-history-link' )->text() );
				} else {
					$wallMessage = new WallMessage( $rcTitle );
					$historyLink = $wallMessage->getMessagePageUrl( true ) . '?action=history';
					$historyLink = Xml::element( 'a', [ 'href' => $historyLink ], wfMessage( static::getMessagePrefix( $rc->getAttribute( 'rc_namespace' ) ) . '-thread-history-link' )->text() );
				}

				$s = '(' . $historyLink . ')';
			} else {
				// new, edit
				if ( $rc->mAttribs['rc_type'] == RC_NEW || $rc->mAttribs['rc_type'] == RC_LOG ) {
					$diffLink = wfMessage( 'diff' )->escaped();
				} else if ( !ChangesList::userCan( $rc, Revision::DELETED_TEXT ) ) {
					$diffLink = wfMessage( 'diff' )->escaped();
				} else {
					$query = [
							'curid' => $rc->mAttribs['rc_cur_id'],
							'diff'  => $rc->mAttribs['rc_this_oldid'],
							'oldid' => $rc->mAttribs['rc_last_oldid']
					];

					if ( $unpatrolled ) {
						$query['rcid'] = $rc->mAttribs['rc_id'];
					}

					$diffLink = Xml::element( 'a', [
							'href' => $rcTitle->getLocalUrl( $query ),
							'tabindex' => $rc->counter,
							'class' => 'known noclasses',
					], wfMessage( 'diff' )->text() );
				}

				$wallMessage = new WallMessage( $rcTitle );
				$historyLink = $wallMessage->getMessagePageUrl( true ) . '?action=history';
				$historyLink = Xml::element( 'a', [ 'href' => $historyLink ], wfMessage( 'hist' )->text() );
				$s = '(' . $diffLink . wfMessage( 'pipe-separator' )->escaped() . $historyLink . ') . . ';
			}

		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @brief Adjusting recent changes for Wall
	 *
	 * This method doesn't let display rollback link for message wall inputs
	 *
	 * @param ChangesList $list
	 * @param string $s
	 * @param string $rollbackLink
	 * @param RecentChange $rc
	 *
	 * @return true because this is a hook
	 *
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	static public function onChangesListInsertRollback( $list, &$s, &$rollbackLink, $rc ) {
		if ( !empty( $rc->mAttribs['rc_namespace'] ) && $rc->mAttribs['rc_namespace'] == NS_USER_WALL_MESSAGE ) {
			$rollbackLink = '';
		}

		return true;
	}

	/**
	 * @brief Adjusting recent changes for Wall
	 *
	 * This method creates comment to a recent change line
	 *
	 * @param ChangesList $list
	 * @param RecentChange $rc
	 * @param string $comment
	 * @internal param string $s
	 * @return true because this is a hook
	 *
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	static public function onChangesListInsertComment( $list, $rc, &$comment ) {
		$rcType = $rc->getAttribute( 'rc_type' );
		$app = F::app();
		if ( in_array( $rcType, [ RC_NEW, RC_EDIT, RC_LOG ] ) && in_array( MWNamespace::getSubject( $rc->getAttribute( 'rc_namespace' ) ), $app->wg->WallNS ) ) {

			if ( $rcType == RC_EDIT ) {
				$comment = ' ';

				$summary = $rc->mAttribs['rc_comment'];

				if ( empty( $summary ) ) {
					$summary = wfMessage( static::getMessagePrefix( $rc->getAttribute( 'rc_namespace' ) ) . '-edit' )->inContentLanguage()->text();
				}

				$comment .= Linker::commentBlock( $summary, $rc->getTitle() );
			} else if ( $rcType == RC_LOG && in_array( $rc->getAttribute( 'rc_log_action' ), static::$rcWallActionTypes ) ) {
				// this will be deletion/removal/restore summary
				$text = $rc->getAttribute( 'rc_comment' );

				$comment = Linker::commentBlock( $text );
			} else {
				$comment = '';
			}
		}

		return true;
	}

	/**
	 * @brief Adjusting recent changes for Wall
	 *
	 * This method creates comment about revision deletion of a message on message wall
	 *
	 * @param ChangesList $list
	 * @param RecentChange $rc
	 * @param String $s
	 * @param $formatter
	 * @param string $mark
	 *
	 * @return true because this is a hook
	 *
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	static public function onChangesListInsertLogEntry( $list, $rc, &$s, $formatter, &$mark ) {
		$app = F::app();
		if ( $rc->getAttribute( 'rc_type' ) == RC_LOG
				&& in_array( MWNamespace::getSubject( $rc->getAttribute( 'rc_namespace' ) ), $app->wg->WallNS )
				&& in_array( $rc->getAttribute( 'rc_log_action' ), static::$rcWallActionTypes ) ) {

			$wfMsgOptsBase = static::getMessageOptions( $rc );

			$wfMsgOpts = [
				$wfMsgOptsBase['articleTitle'],
				$wfMsgOptsBase['articleTitleTxt'],
				$wfMsgOptsBase['wallTitleTxt'],
				$wfMsgOptsBase['wallPageName'],
				$wfMsgOptsBase['actionUser']
			];

			$msgType = ( $wfMsgOptsBase['isThread'] ) ? 'thread' : 'reply';

			// created in WallHooksHelper::getMessageOptions()
			// and there is not needed to be passed to wfMessage()
			unset( $wfMsgOpts['isThread'], $wfMsgOpts['isNew'] );

			switch( $rc->getAttribute( 'rc_log_action' ) ) {
				case 'wall_remove':
					$actionText = wfMessage( static::getMessagePrefix( $rc->getAttribute( 'rc_namespace' ) ) . '-removed-' . $msgType, $wfMsgOpts )->parse();
					break;
				case 'wall_restore':
					$actionText = wfMessage( static::getMessagePrefix( $rc->getAttribute( 'rc_namespace' ) ) . '-restored-' . $msgType, $wfMsgOpts )->parse();
					break;
				case 'wall_admindelete':
					$actionText = wfMessage( static::getMessagePrefix( $rc->getAttribute( 'rc_namespace' ) ) . '-deleted-' . $msgType, $wfMsgOpts )->parse();
					break;
				case 'wall_archive':
					$actionText = wfMessage( static::getMessagePrefix( $rc->getAttribute( 'rc_namespace' ) ) . '-closed-thread', $wfMsgOpts )->parse();
					break;
				case 'wall_reopen':
					$actionText = wfMessage( static::getMessagePrefix( $rc->getAttribute( 'rc_namespace' ) ) . '-reopened-thread', $wfMsgOpts )->parse();
					break;
				default:
					$actionText = wfMessage( static::getMessagePrefix( $rc->getAttribute( 'rc_namespace' ) ) . '-unrecognized-log-action', $wfMsgOpts )->escaped();
					break;
			}

			$s = '';
			$list->insertUserRelatedLinks( $s, $rc );
			$s .= ' ' . $actionText . ' ' . $list->insertComment( $rc );
		}

		return true;
	}

	/**
	 * @brief Adjusting recent changes for Wall
	 *
	 * This method clears or leaves as it was the text which is being send as a content of <li /> elements in RC page
	 *
	 * @param $changelist
	 * @param string $s
	 * @param RecentChange $rc
	 *
	 * @internal param \ChangesList $list
	 * @return true because this is a hook
	 *
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	static public function onOldChangesListRecentChangesLine( $changelist, &$s, $rc ) {
		if ( $rc->getAttribute( 'rc_namespace' ) == NS_USER_WALL_MESSAGE ) {
			wfProfileIn( __METHOD__ );
			$rcTitle = $rc->getTitle();

			if ( !( $rcTitle instanceof Title ) ) {
				// it can be media wiki deletion of an article -- we ignore them
				Wikia::log( __METHOD__, false, "WALL_NOTITLE_FROM_RC " . print_r( $rc, true ) );
				wfProfileOut( __METHOD__ );
				return true;
			}

			$wm = new WallMessage( $rcTitle );
			$wm->load();
			if ( !$wm->isMain() ) {
				$wm = $wm->getTopParentObj();

				if ( is_null( $wm ) ) {
					Wikia::log( __METHOD__, false, "WALL_NO_PARENT_MSG_OBJECT " . print_r( $rc, true ) );
					wfProfileOut( __METHOD__ );
					return true;
				} else {
					$wm->load();
				}
			}

			if ( $wm->isAdminDelete() && $rc->getAttribute( 'rc_log_action' ) != 'wall_admindelete' ) {
				wfProfileOut( __METHOD__ );
				return false;
			}
		}

		return true;
	}

	/**
	 * @brief Adjusting recent changes for Wall
	 *
	 * This method decides rather put a log information about deletion or not
	 *
	 * @param WikiPage $wikipage a referance to WikiPage instance
	 * @param string $logType a referance to string with type of log
	 * @param Title $title
	 * @param string $reason
	 * @param boolean $hookAddedLogEntry set it to true if you don't want Article::doDeleteArticle() to add a log entry
	 *
	 * @return true because this is a hook
	 *
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	static public function onArticleDoDeleteArticleBeforeLogEntry( WikiPage $wikipage, string &$logType, Title $title, string $reason, bool &$hookAddedLogEntry ): bool {
		if ( $title instanceof Title && $title->getNamespace() == NS_USER_WALL_MESSAGE ) {
			$wm = new WallMessage( $title );
			$parentObj = $wm->getTopParentObj();
			$reason = ''; // we don't want any comment
			$log = new LogPage( $logType );

			if ( empty( $parentObj ) ) {
				// thread message
				$log->addEntry( 'delete', $title, $reason, [ ] );
			} else {
				// reply
				$result = $parentObj->load( true );

				if ( $result ) {
					// if its parent still exists only this reply is being deleted, so log about it
					$log->addEntry( 'delete', $title, $reason, [ ] );
				}
			}

			$hookAddedLogEntry = true;
		}

		return true;
	}

	/**
	 * @brief Adjusting recent changes for Wall
	 *
	 * This method decides rather put a log information about restored article or not
	 *
	 * @param PageArchive $pageArchive a referance to Article instance
	 * @param LogPage $logPage a referance to LogPage instance
	 * @param Title $title a referance to Title instance
	 * @param string $reason
	 * @param boolean $hookAddedLogEntry set it to true if you don't want Article::doDeleteArticle() to add a log entry
	 *
	 * @return bool true because this is a hook
	 *
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	static public function onPageArchiveUndeleteBeforeLogEntry( PageArchive $pageArchive, LogPage &$logPage, Title &$title, string $reason, bool &$hookAddedLogEntry ): bool {
		if ( $title instanceof Title && $title->getNamespace() == NS_USER_WALL_MESSAGE ) {
			$wm = new WallMessage( $title );
			$parentObj = $wm->getTopParentObj();
			$reason = ''; // we don't want any comment

			if ( empty( $parentObj ) ) {
				// thread message
				$logPage->addEntry( 'restore', $title, $reason, [ ] );
			} else {
				// reply
				$result = $parentObj->load( true );

				if ( $result ) {
					// if its parent still exists only this reply is being restored, so log about it
					$logPage->addEntry( 'restore', $title, $reason, [ ] );
				}
			}

			$hookAddedLogEntry = true;
		}

		return true;
	}

	/**
	 * @brief Adjusting select box with namespaces on RecentChanges page
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	static public function onXmlNamespaceSelectorAfterGetFormattedNamespaces( &$namespaces ) {
		if ( defined( 'NS_USER_WALL' ) && defined( 'NS_USER_WALL_MESSAGE' ) ) {
			if ( isset( $namespaces[NS_USER_WALL] ) && isset( $namespaces[NS_USER_WALL_MESSAGE] ) ) {
				unset( $namespaces[NS_USER_WALL], $namespaces[NS_USER_WALL_MESSAGE] );
				$namespaces[NS_USER_WALL_MESSAGE] = wfMessage( static::getMessagePrefix( NS_USER_WALL ) . '-namespace-selector-message-wall' )->text();
			}
		}

		return true;
	}

	/**
	 * @brief Adjusting title of a block group on RecentChanges page
	 *
	 * @param ChangesList $oChangeList
	 * @param string $r
	 * @param array $oRCCacheEntryArray an array of RCCacheEntry instances
	 * @param boolean $changeRecentChangesHeader a flag saying Wikia's hook if we want to change header or not
	 * @param Title $oTitle
	 * @param string $headerTitle string which will be put as a header for RecentChanges block
	 *
	 * @return bool
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	static public function onWikiaRecentChangesBlockHandlerChangeHeaderBlockGroup( $oChangeList, $r, $oRCCacheEntryArray, &$changeRecentChangesHeader, $oTitle, &$headerTitle ) {
		wfProfileIn( __METHOD__ );

		$namespace = MWNamespace::getSubject( $oTitle->getNamespace() );

		if ( WallHelper::isWallNamespace( $namespace ) ) {
			$changeRecentChangesHeader = true;

			$titleData = self::getMessageOptions( $oRCCacheEntryArray[0], null );

			$titleObj = Title::newFromText( $titleData['articleTitle'] );
			$threadLink = Linker::link( $titleObj, htmlspecialchars( $titleData['articleTitleTxt'] ),
				[ 'title' => $titleData['articleTitleTxt'] ] );

			$headerTitle = wfMessage( static::getMessagePrefix( $namespace ) . '-thread-group' )
				->rawParams( $threadLink )
				->params( $titleData['wallTitleTxt'], $titleData['wallPageName'] )
				->parse();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @brief get prefixed message name for recent changes, helpful for using wall on others namesapces
	 *
	 * @param int $namespace
	 * @return string
	 * @internal param string $message
	 */

	static protected function getMessagePrefix( $namespace ) {
		$namespace = MWNamespace::getSubject( $namespace );
		$prefix = '';
		if ( !Hooks::run( 'WallRecentchangesMessagePrefix', [ $namespace, &$prefix ] ) ) {
			return $prefix;
		}

		return 'wall-recentchanges';

	}

	/**
	 * @brief Adjusting blocks on Enhanced Recent Changes page
	 *
	 * Changes $secureName which is an array key in RC cache by which blocks on enchance RC page are displayed
	 *
	 * @param ChangesList $changesList
	 * @param string $secureName
	 * @param RecentChange $rc
	 *
	 * @return bool
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	static public function onChangesListMakeSecureName( $changesList, &$secureName, $rc ) {
		if ( WallHelper::isWallNamespace( intval( $rc->getAttribute( 'rc_namespace' ) ) ) ) {
			$oTitle = $rc->getTitle();

			if ( $oTitle instanceof Title ) {
				$wm = new WallMessage( $oTitle );
				$parent = $wm->getTopParentObj();
				$isMain = is_null( $parent );

				if ( !$isMain ) {
					$wm = $parent;
					unset( $parent );
				}

				$secureName = self::RC_WALL_SECURENAME_PREFIX . $wm->getId();
			}
		}

		return true;
	}

	/**
	 * @brief Changing all links to Message Wall to blue links
	 *
	 * @param $skin
	 * @param $target
	 * @param $text
	 * @param $customAttribs
	 * @param $query
	 * @param $options
	 * @param $ret
	 * @internal param \Title $title
	 * @internal param bool $result
	 *
	 * @return true -- because it's a hook
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	static public function onLinkBegin( $skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret ) {
		// paranoia
		if ( !( $target instanceof Title ) ) {
			return true;
		}

		$namespace = $target->getNamespace();
		if ( WallHelper::isWallNamespace( $namespace ) ) {

			// remove "broken" assumption/override
			$brokenKey = array_search( 'broken', $options );
			if ( $brokenKey !== false ) {
				unset( $options[$brokenKey] );
			}

			// make the link "blue"
			$options[] = 'known';
		}

		return true;
	}

	/**
	 * @param WikiPage $article
	 * @param User $user
	 * @param $text
	 * @param $summary
	 * @param $minoredit
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param $revision
	 * @param Status $status
	 * @param $baseRevId
	 * @return bool
	 */
	static public function onArticleSaveComplete(
		WikiPage $article, User $user, $text, $summary, $minoredit, $watchthis,
		$sectionanchor, $flags, $revision, Status &$status, $baseRevId
	): bool {
		$app = F::app();
		$title = $article->getTitle();

		if ( !empty( $app->wg->EnableWallExt )
				&& $title instanceof Title
				&& $title->getNamespace() === NS_USER_TALK
				&& !$title->isSubpage() )
		{
			// user talk page was edited -> redirect to user talk archive
			$helper = new WallHelper();

			$app->wg->Out->redirect( static::getWallTitle()->getFullUrl() . '/' . $helper->getArchiveSubPageText(), 301 );
			$app->wg->Out->enableRedirects( false );
		}

		return true;
	}

	/**
	 * @param $editor
	 * @param Title $title
	 * @return bool
	 */
	static public function onAllowNotifyOnPageChange( $editor, $title ) {
		$app = F::app();
		if ( in_array( MWNamespace::getSubject( $title->getNamespace() ), $app->wg->WallNS ) || $title->getNamespace() == NS_USER_WALL_MESSAGE_GREETING ) {
			return false;
		}
		return true;
	}

	/**
	 * @param User $user
	 * @param Article $article
	 * @return bool
	 */
	static public function onWatchArticle( &$user, &$article ) {
		$app = F::app();
		$title = $article->getTitle();

		if ( !empty( $app->wg->EnableWallExt ) && static::isWallMainPage( $title ) ) {
			static::processActionOnWatchlist( $user, $title->getText(), 'add' );
		}

		return true;
	}

	/**
	 * @param User $user
	 * @param Article $article
	 *
	 * @return bool
	 */
	static public function onUnwatchArticle( &$user, &$article ) {
		$title = $article->getTitle();

		// Wall code makes up fake Title objects to trick MW into handling its "Thread:1234" style
		// title text.  It also reuses the same namespaces for Forums, user walls, replies, etc.
		// Since we need a real Title backed by a DB row, we need to reconstruct a title object
		// if the current one looks fake.  If this already is a real Title the normal unwatch handling
		// that called this hook will take care of this for us.
		if ( ( $article->getId() == 0 ) && preg_match( '/^(\d+)$/', $title->getText(), $matches ) ) {
			$id = $matches[1];
			$realTitle = Title::newFromID( $id );

			if ( empty( $realTitle ) ) {
				WikiaLogger::instance()->debug( 'Unknown thread ID', [
					'method' => __METHOD__,
					'titleText' => $title->getText(),
					'titleId' => $id,
				] );
				return false;
			}

			static::processActionOnWatchlist( $user, $realTitle, 'remove' );
		}

		return true;
	}

	static private function isWallMainPage( Title $title ) {
		if ( $title->getNamespace() == NS_USER_WALL && strpos( $title->getText(), '/' ) === false ) {
			return true;
		}

		return false;
	}

	/**
	 * @param User $user
	 * @param $title
	 * @param string $action
	 *
	 * @throws MWException
	 */
	static private function processActionOnWatchlist( $user, $title, $action ) {
		$wallMessage = WallMessage::newFromTitle( $title );

		if ( $action == 'remove' ) {
			$wallMessage->removeWatch( $user );
		} elseif ( $action == 'add' ) {
			$wallMessage->addWatch( $user );
		}
	}

	/**
	 * @param User $user
	 * @param $preferences
	 * @return bool
	 */
	static public function onGetPreferences( $user, &$preferences ) {
		$app = F::app();

		if ( $user->isLoggedIn() ) {
			if ( $app->wg->EnableUserPreferencesV2Ext ) {
				$message = 'wallshowsource-toggle-v2';
				$section = 'under-the-hood/advanced-displayv2';
			}
			else {
				$message = 'wallshowsource-toggle';
				$section = 'misc/wall';
			}
			$preferences['wallshowsource'] = [
					'type' => 'toggle',
					'label-message' => $message, // a system message
					'section' => $section
			];

			if ( $user->isAllowed( 'walldelete' ) ) {
				$preferences['walldelete'] = [
						'type' => 'toggle',
						'label-message' => 'walldelete-toggle', // a system message
						'section' => $section
				];
			}
		}

		return true;
	}

	/**
	 * @brief Adjusting Special:Contributions
	 *
	 * @param ContribsPager $contribsPager
	 * @param String $ret string passed to wgOutput
	 * @param Object $row Std Object with values from database table
	 *
	 * @return bool true
	 */
	static public function onContributionsLineEnding( ContribsPager $contribsPager, string &$ret, $row ): bool {

		if ( isset( $row->page_namespace ) && in_array( MWNamespace::getSubject( $row->page_namespace ), [ NS_USER_WALL ] ) ) {
			return static::contributionsLineEndingProcess( $contribsPager, $ret, $row );
		}
		return true;
	}

	static public function contributionsLineEndingProcess( ContribsPager $contribsPager, string &$ret, $row ): bool {
		wfProfileIn( __METHOD__ );

		$rev = new Revision( $row );
		$page = $rev->getTitle();
		$page->resetArticleId( $row->rev_page );

		$wfMsgOptsBase = self::getMessageOptions( null, $row );

		$isThread = $wfMsgOptsBase['isThread'];
		$isNew = $wfMsgOptsBase['isNew'];

		// Don't show useless link to people who cannot hide revisions
		$del = Linker::getRevDeleteLink( $contribsPager->getUser(), $rev, $page );
		if ( $del !== '' ) {
			$del .= ' ';
		} else {
			$del = '';
		}

		// VOLDEV-40: remove html messages
		$ret = $del;
		$ret .= Linker::linkKnown(
			$page,
			$contribsPager->getLanguage()->userTimeAndDate( $row->rev_timestamp, $contribsPager->getUser() ),
			[],
			[ 'oldid' => $row->rev_id ]
		) . ' (';

		if ( $isNew ) {
			$ret .= $contribsPager->msg( 'diff' )->escaped();
		} else {
			$ret .= Linker::linkKnown(
				$page,
				$contribsPager->msg( 'diff' )->escaped(),
				[],
				[
					'diff' => 'prev',
					'oldid' => $row->rev_id
				]
			);
		}

		$wallMessage = new WallMessage( $page );
		$threadId = $wallMessage->getMessagePageId();
		$threadTitle = Title::newFromText( $threadId, NS_USER_WALL_MESSAGE );
		$ret .= ' | ' . Linker::linkKnown( $threadTitle, $contribsPager->msg( 'hist' )->escaped(), [], [ 'action' => 'history' ] ) . ') ';

		if ( $isThread && $isNew ) {
			$ret .= ChangesList::flag( 'newpage' ) . ' ';
		}

		if ( MWNamespace::getSubject( $row->page_namespace ) === NS_WIKIA_FORUM_BOARD && empty( $wfMsgOptsBase['articleTitleVal'] ) ) {
			$wfMsgOptsBase['articleTitleTxt'] = $contribsPager->msg( 'forum-recentchanges-deleted-reply-title' )->text();
		}

		$prefix = MWNamespace::getSubject( $row->page_namespace ) === NS_WIKIA_FORUM_BOARD ? 'forum' : 'wall';
		$ret .= $contribsPager->msg( $prefix . '-contributions-line' )
			->params( $wfMsgOptsBase['articleTitle'] )
			->rawParams( htmlspecialchars( $wfMsgOptsBase['articleTitleTxt'] ) )
			->params( $wfMsgOptsBase['wallTitleTxt'], $wfMsgOptsBase['wallPageName'] )
			->parse();

		if ( !$isNew ) {
			$summary = $rev->getComment();

			if ( empty( $summary ) ) {
				$msg = Linker::commentBlock( $contribsPager->msg( static::getMessagePrefix( $row->page_namespace ) . '-edit' )->inContentLanguage()->text() );
			} else {
				$msg = Linker::revComment( $rev, false, true );
			}

			$ret .= ' ' . $contribsPager->getLanguage()->getDirMark() . $msg;
		}

		wfProfileOut( __METHOD__ );

		return true;
	}


	/**
	 * @brief Collects data basing on RC object or std object
	 * Those lines of code were used a lot in this class. Better keep them in one place.
	 *
	 * @param $rc
	 * @param Object $row
	 *
	 * @return array
	 */
	static public function getMessageOptions( $rc = null, $row = null ) {
		return WallHelper::getWallTitleData( $rc, $row );
	}


	static public function onFilePageImageUsageSingleLink( &$link, &$element ) {

		if ( $element->page_namespace == NS_USER_WALL_MESSAGE ) {
			$titleData = WallHelper::getWallTitleData( null, $element );
			$titleObj = Title::newFromText( $titleData['articleTitle'] );
			$threadLink = Linker::link( $titleObj, htmlspecialchars( $titleData['articleTitleTxt'] ),
				[ 'title' => $titleData['articleTitleTxt'] ] );

			$link = wfMessage( static::getMessagePrefix( NS_USER_WALL_MESSAGE ) . '-thread-group' )
				->rawParams( $threadLink )
				->params( $titleData['wallTitleTxt'], $titleData['wallPageName'] )
				->parse();
		}
		return true;
	}

	/**
	 * @brief Adjusting Special:Whatlinkshere
	 *
	 * @param Object $row
	 * @param Integer $level
	 * @param Boolean $defaultRendering
	 *
	 * @return Boolean
	 */
	static public function onRenderWhatLinksHereRow( &$row, &$level, &$defaultRendering ) {
		wfProfileIn( __METHOD__ );

		if ( isset( $row->page_namespace ) && in_array( intval( $row->page_namespace ), [ NS_USER_WALL_MESSAGE, NS_WIKIA_FORUM_BOARD_THREAD ] ) ) {
			$defaultRendering = false;

			$app = F::app();
			$wlhTitle = SpecialPage::getTitleFor( 'Whatlinkshere' );
			$titleData = self::getMessageOptions( null, $row );

			$app->wg->Out->addHtml(
					Xml::openElement( 'li' ) .
					wfMessage( 'wall-whatlinkshere-wall-line' )
						->params( $titleData['articleTitle'] )
						->rawParams( htmlspecialchars( $titleData['articleTitleTxt'] ) )
						->params( $titleData['wallTitleTxt'], $titleData['wallPageName'] )
						->parse() .
					' (' .
					Linker::linkKnown(
						$wlhTitle,
						wfMessage( 'whatlinkshere-links' )->escaped(),
						[],
						[ 'target' => $titleData['articleTitle'] ]
					) .
					')' .
					Xml::closeElement( 'li' )
			);
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Changes fields in a DifferenceEngine instance to display correct content in <title /> tag
	 *
	 * @param DifferenceEngine $differenceEngine
	 * @param $oldRev
	 * @param $newRev
	 *
	 * @return true
	 */
	static public function onDiffViewHeader( $differenceEngine, $oldRev, $newRev ) {
		wfProfileIn( __METHOD__ );

		$app = F::App();

		if ( $app->wg->Title instanceof Title && WallHelper::isWallNamespace( $app->wg->Title->getNamespace() ) ) {
			$metaTitle = static::getMetatitleFromTitleObject( $app->wg->Title );
			$differenceEngine->mOldPage->mPrefixedText = $metaTitle;
			$differenceEngine->mNewPage->mPrefixedText = $metaTitle;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Helper method which gets meta title from an WallMessage instance; used in WallHooksHelper::onDiffViewHeader()
	 * @param Title $title
	 * @param mixed $wmRef a variable which value will be created WallMessage instance
	 *
	 * @return String
	 */
	static private function getMetatitleFromTitleObject( $title, &$wmRef = null ) {
		wfProfileIn( __METHOD__ );

		$wm = new WallMessage( $title );

		if ( $wm instanceof WallMessage ) {
			$wm->load();
			$metaTitle = $wm->getMetaTitle();
			if ( empty( $metaTitle ) ) {
			// if wall message is a reply
				$wmParent = $wm->getTopParentObj();
				if ( $wmParent instanceof WallMessage ) {
					$wmParent->load();
					if ( !is_null( $wmRef ) ) {
						$wmRef = $wmParent;
					}

					wfProfileOut( __METHOD__ );
					return $wmParent->getMetaTitle();
				}
			}

			if ( !is_null( $wmRef ) ) {
				$wmRef = $wm;
			}

			wfProfileOut( __METHOD__ );
			return $metaTitle;
		}

		wfProfileOut( __METHOD__ );
		return '';
	}

	/**
	 * Changes link from User_talk: page to Message_wall: page of the user
	 *
	 * @param int $id id of user who's contributions page is displayed
	 * @param Title $nt instance of Title object of the page
	 * @param Array $tools a reference to an array with links in the header of Special:Contributions page
	 *
	 * @return true
	 */
	static public function onContributionsToolLinks( $id, $nt, &$tools ) {
		wfProfileIn( __METHOD__ );

		$app = F::app();

		if ( !empty( $app->wg->EnableWallExt ) && !empty( $tools[0] ) && $nt instanceof Title ) {
			// tools[0] is the first link in subheading of Special:Contributions which is "User talk" page
			$wallTitle = Title::newFromText( $nt->getText(), NS_USER_WALL );

			if ( $wallTitle instanceof Title ) {
				$tools[0] = Xml::element( 'a', [
						'href' => $wallTitle->getFullUrl(),
						'title' => $wallTitle->getPrefixedText(),
				], wfMessage( 'wall-message-wall-shorten' )->text() );
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Changes user talk page link to user's message wall link added during MW1.19 migration
	 *
	 * @param integer $userId
	 * @param string $userText
	 * @param $userTalkLink
	 *
	 * @return true
	 */
	static public function onLinkerUserTalkLinkAfter( $userId, $userText, &$userTalkLink ) {
		wfProfileIn( __METHOD__ );

		$app = F::app();
		static $cache = [ ];

		if ( !empty( $app->wg->EnableWallExt ) ) {
			if ( empty( $cache[$userText] ) ) {
				$messageWallPage = Title::makeTitle( NS_USER_WALL, $userText );
				$userTalkLink = Linker::link(
					$messageWallPage,
					wfMessage( 'wall-message-wall-shorten' )->escaped(),
					[ ],
					[ ],
					[ 'known', 'noclasses' ]
				);
				$cache[$userText] = $userTalkLink;
			} else {
				$userTalkLink = $cache[$userText];
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}


	static public function onArticleBeforeVote( &$user_id, &$page, $vote ) {
		$app = F::app();
		$title = Title::newFromId( $page );

		if ( ( $title instanceof Title ) && in_array( MWNamespace::getSubject( $title->getNamespace()  ), $app->wg->WallNS ) ) {
			return false;
		}

		return true;
	}

	/**
	 * @static
	 * @param Block $block
	 * @param $user
	 * @return bool
	 */
	static public function onBlockIpComplete( $block, $user ) {
		$blockTarget = $block->getTarget();
		if ( $blockTarget instanceof User && $blockTarget->isLoggedIn() ) {
			$vote = new VoteHelper( $block->getTarget(), null );
			$vote->invalidateUser();
		}
		return true;
	}

	static public function onBeforeCategoryData( &$extraConds ) {
		$app = F::App();

		$excludedNS = $app->wg->WallNS;
		foreach ( $app->wg->WallNS as $ns ) {
			$excludedNS[] = MWNamespace::getTalk( $ns );
		}

		$extraConds[] = 'page_namespace not in(' . implode( ',', $excludedNS ) . ')';
		return true;
	}

	static public function onGetRailModuleSpecialPageList( &$railModuleList ) {
		$app = F::App();

		$namespace = $app->wg->Title->getNamespace();
		$diff = $app->wg->Request->getVal( 'diff', false );

		$isDiff = !empty( $diff ) &&  $app->wg->Request->getVal( 'oldid', false );

		if ( $isDiff && WallHelper::isWallNamespace( $namespace ) ) {
			// SuppressRail
			$railModuleList = [ ];
		}

		return true;
	}

	/**
	 * @param OutputPage $out
	 * @param User $user
	 * @return bool
	 */
	static public function onSpecialWikiActivityExecute( $out, $user ) {
		$app = F::App();
		$out->addScript( "<script type=\"{$app->wg->JsMimeType}\" src=\"{$app->wg->ExtensionsPath}/wikia/Wall/js/WallWikiActivity.js\"></script>\n" );
		$out->addExtensionStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/Wall/css/WallWikiActivity.scss' ) );

		return true;
	}

	static protected function getQueryNS() {
		$app = F::App();
		$ns = [ ];

		foreach ( $app->wg->WallNS as $val ) {
			$ns[] = $val;
			$ns[] = MWNamespace::getTalk( $val );
		}
		return implode( ',', $ns );
	}

	static public function onListredirectsPageGetQueryInfo( ListredirectsPage $self, array &$query ): bool {
		wfProfileIn( __METHOD__ );

		$query['conds'][] = 'p1.page_namespace not in (' . static::getQueryNS() . ')';

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onWantedPagesGetQueryInfo( WantedPagesPage $self, array &$query ): bool {
		wfProfileIn( __METHOD__ );

		$query['conds'][] = 'pl_namespace not in (' . static::getQueryNS() . ')';

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param $title Title
	 * @param $unused
	 * @param $output
	 * @param $user
	 * @param $request
	 * @param $mediawiki
	 * @return bool
	 */
	static public function onBeforeInitialize( $title, $unused, $output, $user, $request, $mediawiki ) {
		global $wgHooks;
		if ( !empty( $title ) && $title->isSpecial( 'Allpages' ) ) {
			$wgHooks['LanguageGetNamespaces'][] = 'WallHooksHelper::onLanguageGetNamespaces';
		}
		return true;
	}

	static public function onLanguageGetNamespaces( &$namespaces ) {
		wfProfileIn( __METHOD__ );
		$app = F::App();
		$title = $app->wg->Title;

		if ( empty( $title ) || !$title->isSpecial( 'Allpages' ) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		foreach ( $app->wg->WallNS as $val ) {
			$ns = MWNamespace::getTalk( $val );
			if ( !empty( $namespaces[$ns] ) ) {
				unset( $namespaces[$ns] );
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Purge wiki navigation cache when disabling/enabling Forum and Wall
	 *
	 * @param String $name
	 * @param String $val
	 *
	 * @return bool
	 */
	public static function onAfterToggleFeature( $name, $val ) {
		if ( $name == 'wgEnableWallExt' || $name == 'wgEnableForumExt' ) {
			$nm = new NavigationModel();
			$nm->clearMemc( NavigationModel::WIKIA_GLOBAL_VARIABLE );
		}
		return true;
	}

	static public function onAdvancedBoxSearchableNamespaces( &$namespace ) {
		$namespace = WallHelper::clearNamespaceList( $namespace );
		return true;
	}

	static public function onArticleRobotPolicy( &$policy, Title $title ) {
		$ns = $title->getNamespace();
		if ( $ns == NS_USER_WALL_MESSAGE ) {
			$policy = [
				'index'  => 'index',
				'follow' => 'follow'
			];
		}
		elseif ( $ns == NS_USER_WALL ) {
			$policy = [
				'index'  => 'noindex',
				'follow' => 'nofollow'
			];
		}
		return true;
	}

	/**
	 * HAWelcome
	 *
	 * @param $prefixedText
	 * @param Title $title
	 *
	 * @internal param $String $$prefixedText
	 * @access public
	 * @author Tomek
	 *
	 * @return boolean
	 */

	static public function onHAWelcomeGetPrefixText( &$prefixedText, $title ) {

		if ( $title->exists() && WallHelper::isWallNamespace( $title->getNamespace() ) ) {
			$wallMessage = WallMessage::newFromId( $title->getArticleID() );
			$wallMessageParent = $wallMessage->getTopParentObj();
			if ( empty( $wallMessageParent ) ) {
				$wallMessageParent = $wallMessage;
			}
			$wallMessage->load();
			$wallMessageParent->load();
			$pageId = $wallMessage->getMessagePageId();
			$postFix = $wallMessage->getPageUrlPostFix();
			$threadTitle = Title::newFromText( $pageId, NS_USER_WALL_MESSAGE );
			$prefixedText = $threadTitle->getPrefixedText() . ( empty( $postFix ) ? '' : "#{$postFix}" ) . '|' . $wallMessageParent->getMetaTitle();
		}

		return true;
	}

	/**
	 * @param $link
	 * @param RecentChange $rcObj
	 * @return bool
	 */
	static public function onChangesListItemGroupRegular( &$link, &$rcObj ) {
		if ( WallHelper::isWallNamespace( intval( $rcObj->getAttribute( 'rc_namespace' ) ) ) ) {

			/** @var WallMessage $wallMsg */
			$wallMsg = WallMessage::newFromId( $rcObj->getAttribute( 'rc_cur_id' ) );
			if ( !empty( $wallMsg ) ) {
				$url = $wallMsg->getMessagePageUrl();
				$link = '<a href="' . $url . '">' . $rcObj->timestamp . '</a>';
				$rcObj->curlink = '<a href="' . $url . '">' . wfMessage( 'cur' )->escaped() . '</a>';
			}
		}
		return true;
	}

	/**
	 * Add user links to toolbar in Monobook for Message Wall
	 *
	 * @access public
	 * @author Sactage
	 *
	 * @param QuickTemplate $quickTemplate
	 * @return bool
	 */
	static public function onBuildMonobookToolbox( QuickTemplate $quickTemplate ): bool {
		$skin = $quickTemplate->getSkin();
		$title = $skin->getTitle();
		$curUser = $skin->getUser();

		if ( !$title->inNamespace( NS_USER_WALL ) ) {
			return true;
		}

		$user = User::newFromName( $title->getText(), false );

		echo '<li id="t-contributions">' . Linker::link( SpecialPage::getSafeTitleFor( 'Contributions', $user->getName() ), wfMessage( 'contributions' )->escaped() ) . '</li>';
		if ( $curUser->isAllowed( 'block' ) ) {
			echo '<li id="t-blockip">' . Linker::link( SpecialPage::getSafeTitleFor( 'Block', $user->getName() ), wfMessage( 'block' )->escaped() ) . '</li>';
		}

		echo '<li id="t-log">' . Linker::link( SpecialPage::getTitleFor( 'Log' ), wfMessage( 'log' )->escaped(), [ ], [ 'user' => $user->getName() ] ) . '</li>';
		return true;
	}

	/**
	 * Fills the $info parameter with a human readable article title and a URL that links directly to
	 * a wall or forum post
	 *
	 * @param $info - Associative array to hold the result
	 * @param $title - The article title of the wall/forum post
	 * @param $ns - The namespace of the wall/forum post
	 * @return bool - The status of the hook
	 */
	public static function onFormatForumLinks( &$info, $title, $ns ) {

		// Handle message wall and forum board links
		if ( isset( $ns ) && in_array( $ns, [ NS_USER_WALL_MESSAGE, NS_WIKIA_FORUM_BOARD_THREAD ] ) ) {
			// The method expects a DB result row. Set the data and then pass it as an object
			$row['page_namespace'] = $ns;
			$row['page_title'] = $title;
			$opts = WallHelper::getWallTitleData( null, (object)$row );

			// Set the human readable title and a link
			$info['titleText'] = $opts['articleTitleTxt'];
			$info['url'] = $opts['articleFullUrl'];
		}

		return true;
	}

	/**
	 * Makes sure the correct URLs for thread pages and message wall page get purged.
	 *
	 * @param $title Title
	 * @param $urls String[]
	 * @return bool
	 */
	public static function onTitleGetSquidURLs( Title $title, &$urls ) {

		if ( $title->inNamespace( NS_USER_WALL ) ) {
			// CONN-430: Resign from default ArticleComment purges
			$urls = [];
		}

		if ( $title->inNamespace( NS_USER_WALL_MESSAGE ) ) {
			// CONN-430: purge cache only for main thread page and owner's wall page
			// while running AfterBuildNewMessageAndPost hook
			$wallMessage = WallMessage::newFromTitle( $title );
			$urls = $wallMessage->getSquidURLs( NS_USER_WALL );
		}

		if ( $title->inNamespace( NS_USER_WALL_MESSAGE_GREETING ) ) {
			// SUS-2756: For Message Wall Greetings, just purge the greeting page + user wall
			$dbKey = $title->getDBkey();
			$wallTitle = Title::makeTitle( NS_USER_WALL, $dbKey );

			$urls = [
				$title->getFullURL(),
				$wallTitle->getFullURL(),
			];
		}

		return true;
	}

	/**
	 * Makes sure we don't send unnecessary ArticleComments links to purge
	 *
	 * @param Title $title
	 * @param String[] $urls
	 *
	 * @return bool
	 */
	public static function onArticleCommentGetSquidURLs( $title, &$urls ) {
		if ( $title->inNamespaces( NS_USER_WALL, NS_USER_WALL_MESSAGE, NS_USER_WALL_MESSAGE_GREETING ) ) {
			// CONN-430: Resign from default ArticleComment purges
			$urls = [];
		}

		return true;
	}

	/**
	 * Convert talk page links to wall page links for wall enabled wikis
	 *
	 * @param Title $title
	 * @param Title $talkPageTitle
	 *
	 * @return bool
	 */
	public static function onGetTalkPage( Title $title, Title &$talkPageTitle ) {
		if ( !empty( F::app()->wg->EnableWallExt )
			&& !$title->isSubpage()
			&& $title->getNamespace() == NS_USER
		) {
			$talkPageTitle = Title::makeTitle( NS_USER_WALL, $title->getDBkey() );
		}

		return true;
	}

	/**
	 * SUS-260: Prevent moving pages within, into, or out of Wall namespaces
	 * @param bool $result whether to allow page moves
	 * @param int $ns namespace number
	 * @return bool false if this is a Wall namespace, otherwise true
	 */
	public static function onNamespaceIsMovable( bool &$result, int $ns ): bool {
		// User Rename process needs to be able to move message walls
		global $wgCommandLineMode;
		if ( $wgCommandLineMode ) {
			return true;
		}

		// If Message Wall is enabled, moving a page to User talk namespace makes it an archive
		// This option is irreversible so it is prevented
		if ( in_array( $ns, [ NS_USER_WALL, NS_USER_WALL_MESSAGE, NS_USER_WALL_MESSAGE_GREETING, NS_USER_TALK ] ) ) {
			$result = false;
			return false;
		}

		return true;
	}

	/**
	 * SUS-1554: Prevent invalid content manipulation in Wall Namespaces
	 *
	 * @param Title $title
	 * @param User $user
	 * @param string $action
	 * @param array|null $result error message array (message name and optional params) or null
	 * @return bool true if action is not handled or allowed, false if action should be prevented
	 */
	public static function onGetUserPermissionsErrors( Title $title, User $user, string $action, &$result ): bool {
		$ns = $title->getNamespace();
		if ( $ns === NS_USER_WALL_MESSAGE_GREETING ) {
			return static::checkWallGreeting( $title, $user, $action, $result );
		}

		if ( !WallHelper::isWallNamespace( $ns ) ) {
			return true;
		}

		global $wgIsValidWallTransaction, $wgCommandLineMode;
		$isValidContext = $wgIsValidWallTransaction || $wgCommandLineMode;
		$allow = true;

		if ( !$isValidContext ) {
			switch ( $action ) {
				// don't let user create Message Wall page, or bogus Thread
				case 'create':
				case 'edit':
				case 'move':
				case 'move-target':
					$allow = false;
					$result = [ 'badtitle' ];

					break;

				// don't let user edit or delete Message Wall page
				case 'delete':
					if ( $ns === NS_USER_WALL ) {
						$allow = false;
						$result = [ 'badtitle' ];
					}

					break;
			}
		}

		return $allow;
	}


	/**
	 * control access to articles in the namespace NS_USER_WALL_MESSAGE_GREETING
	 *
	 * @param Title $title
	 * @param User $user
	 * @param $action
	 * @param $result
	 * @return bool
	 *
	 * @author Tomek Odrobny
	 */
	static private function checkWallGreeting( Title $title, User $user, string $action, &$result ) {
		$allow = true;

		switch ( $action ) {
			case 'create':
			case 'edit':
			case 'move':
				$owningUserName = $title->getBaseText();

				if ( !$user->isAllowed( 'walledit' ) && $owningUserName !== $user->getName() ) {
					$allow = false;
					$result = [ 'badaccess-group0' ];
				}
		}

		return $allow;
	}

	/**
	 * @param string $pageSubtitle
	 *
	 * @param Title $title
	 * @return bool
	 */
	public static function onAfterPageHeaderPageSubtitle( &$pageSubtitle, Title $title ): bool {
		if (
			$title->getNamespace() === NS_USER_WALL_MESSAGE &&
			RequestContext::getMain()->getRequest()->getVal( 'action' ) !== 'history'
		) {
			$pageSubtitle = F::app()->renderView(
				'Wall',
				'brickHeader',
				[
					'id' => $title->getText()
				]
			);
		}

		return true;
	}
}
