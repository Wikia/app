<?php

class ForumHooksHelper {
	/**
	 * Render the alternative version of thread page
	 */
	static public function onWallBeforeRenderThread( $title, $wm ) {
		$app = F::App();
		if ( $title->getNamespace() == NS_WIKIA_FORUM_BOARD_THREAD ) {
			$app->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/Forum/css/ForumThread.scss' ) );
		}
		return true;
	}

	/**
	 * on thread header change header title
	 */
	static public function onWallThreadHeader( $title, $wallMessage, &$path, &$response, &$request ) {
		if ( MWNamespace::getSubject( $title->getNamespace() ) == NS_WIKIA_FORUM_BOARD ) {
			$path = array_merge( static::getPath( $wallMessage ), array( $path[1] ) );
			OasisController::addBodyParameter( ' itemscope itemtype="http://schema.org/WebPage"' );
		}
		return true;
	}

	static public function onWallHistoryThreadHeader( $title, $wallMessage, &$path, &$response, &$request ) {
		if ( MWNamespace::getSubject( $title->getNamespace() ) == NS_WIKIA_FORUM_BOARD ) {
			$path = array_merge( static::getPath( $wallMessage ), array( $path[1] ) );
		}

		return true;
	}

	static public function onWallHistoryHeader( $title, &$path, &$response, &$request ) {
		if ( MWNamespace::getSubject( $title->getNamespace() ) == NS_WIKIA_FORUM_BOARD ) {
			$app = F::App();

			$response->setVal( 'pageTitle', wfMessage( 'forum-board-history-title' )->escaped() );
			$app->wg->Out->setPageTitle( wfMessage( 'forum-board-history-title' )->plain() );

			$path = array( static::getIndexPath(), array( 'title' => wfMessage( 'forum-board-title', $title->getText() )->escaped(), 'url' => $title->getFullUrl() ) );
		}
		return true;
	}

	static public function onWallHeader( $title, &$path, &$response, &$request ) {
		if ( $title->getNamespace() === NS_WIKIA_FORUM_BOARD ) {
			$path[] = static::getIndexPath();
			$path[] = array( 'title' => wfMessage( 'forum-board-title', $title->getText() )->escaped(), );

		}
		return true;
	}

	static public function onWallNewMessage( $title, &$response ) {
		if ( $title->getNamespace() === NS_WIKIA_FORUM_BOARD ) {
			$response->setVal( 'wall_message', wfMessage( 'forum-discussion-placeholder-message', $title->getText() )->escaped() );
		}

		if ( $title->getNamespace() === NS_WIKIA_FORUM_TOPIC_BOARD ) {
			$response->setVal( 'wall_message', wfMessage( 'forum-discussion-placeholder-message-short' )->escaped() );
		}
		return true;
	}

	static protected function getPath( $wallMessage ) {
		$path = array();
		$path[] = static::getIndexPath();
		$path[] = array( 'title' => wfMessage( 'forum-board-title', $wallMessage->getArticleTitle()->getText() )->escaped(), 'url' => $wallMessage->getArticleTitle()->getFullUrl() );

		return $path;
	}

	static protected function getIndexPath() {
		$indexPage = Title::newFromText( 'Forum', NS_SPECIAL );
		return array( 'title' => wfMessage( 'forum-forum-title' )->escaped(), 'url' => $indexPage->getFullUrl() );
	}

	/**
	 * change the message in WikiActivity for forum namespace
	 */

	static public function onAfterWallWikiActivityFilter( &$item, $wmessage ) {
		if ( !empty( $item['ns'] ) && MWNamespace::getSubject( $item['ns'] ) == NS_WIKIA_FORUM_BOARD ) {
			if ( $item['ns'] == NS_WIKIA_FORUM_BOARD ) {
				// new board - we build Title object from current article id
				$board = Title::newFromID( $item['article-id'] );
				$item['title'] = $board->getBaseText();
				$item['url'] = $board->getFullURL();
				$item['new_board'] = true;
				$item['wall-msg'] = '';
				$item['wall-url'] = '';
			} else {
				// new comments on existing board - we build Title object based on id from WallMessage class logic ( getting parent )
				$board = $wmessage->getArticleTitle();
				$item['wall-msg'] = wfMessage( 'forum-wiki-activity-msg' )->rawParams( '<a href="' . $board->getFullURL() . '">' . wfMessage( 'forum-wiki-activity-msg-name', $board->getText() )->escaped() . '</a>' )->escaped();
			}
		}

		return true;
	}

	static public function onFilePageImageUsageSingleLink( &$link, &$element ) {

		if ( $element->page_namespace == NS_WIKIA_FORUM_BOARD_THREAD ) {

			$titleData = WallHelper::getWallTitleData( null, $element );

			$boardText = wfMessage( 'forum-wiki-activity-msg' )->rawParams( '<a href="' . $titleData['wallPageFullUrl'] . '">' . wfMessage( 'forum-wiki-activity-msg-name', $titleData['wallPageName'] )->escaped() . '</a>' )->escaped();
			$link = '<a href="' . $titleData['articleFullUrl'] . '">' . $titleData['articleTitleTxt'] . '</a> ' . $boardText;
		}
		return true;
	}

	static public function getUserPermissionsErrors( &$title, &$user, $action, &$result ) {
		$result = null;

		if ( Forum::$allowToEditBoard == true ) {
			return true;
		}

		if ( $action == 'read' || $title->getNamespace() != NS_WIKIA_FORUM_BOARD ) {
			return true;
		}

		$result = array( 'protectedpagetext' );
		return false;
	}

	/**
	 * @brief Adjusting Special:Contributions
	 *
	 * @param ContribsPager $contribsPager
	 * @param String $ret string passed to wgOutput
	 * @param Object $row Std Object with values from database table
	 *
	 * @return true
	 */
	static public function onContributionsLineEnding( &$contribsPager, &$ret, $row ) {

		if ( isset( $row->page_namespace ) && in_array( MWNamespace::getSubject( $row->page_namespace ), array( NS_WIKIA_FORUM_BOARD ) ) ) {

			if ( $row->page_namespace == NS_WIKIA_FORUM_BOARD ) {
				return true;
			}

			if ( class_exists( 'WallHooksHelper' ) ) {
				$wallHooks = new WallHooksHelper();
				return $wallHooks->contributionsLineEndingProcess( $contribsPager, $ret, $row );
			}
		}
		return true;
	}

	static public function onOasisAddPageDeletedConfirmationMessage( Title &$title, &$message ) {

		if ( $title->getNamespace() == NS_WIKIA_FORUM_BOARD ) {

			$pageName = $title->getPrefixedText();
			$message = wfMessage( 'forum-confirmation-board-deleted', $pageName )->parse();
		}

		return true;
	}

	static public function onWallRecentchangesMessagePrefix( $namespace, &$prefix ) {
		if ( $namespace == NS_WIKIA_FORUM_BOARD ) {
			$prefix = 'forum-recentchanges';
			return false;
		}
		return true;
	}

	/**
	 * Hook: add comments_index table when adding board
	 */
	static public function onArticleInsertComplete( &$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision ) {
		$title = $article->getTitle();
		if ( $title->getNamespace() == NS_WIKIA_FORUM_BOARD ) {
			$commentsIndex = ( new CommentsIndex );
			$commentsIndex->createTableCommentsIndex();
		}

		return true;
	}

	/**
	 * clear the caches
	 */

	static public function onAfterBuildNewMessageAndPost( &$mw ) {
		$title = $mw->getTitle();
		if ( $title->getNamespace() == NS_WIKIA_FORUM_BOARD_THREAD ) {
			$forum = ( new Forum );
			$forum->clearCacheTotalActiveThreads();
			$forum->clearCacheTotalThreads();
		}
		return true;
	}

	/**
	 * overriding message
	 */

	static public function onWallMessageDeleted( &$mw, &$response ) {
		$title = $mw->getTitle();
		if ( $title->getNamespace() == NS_WIKIA_FORUM_BOARD_THREAD ) {
			$response->setVal( 'returnTo', wfMessage( 'forum-thread-deleted-return-to', $mw->getArticleTitle()->getText() )->escaped() );
		}
		return true;
	}

	/**
	 * @brief Block any attempts of editing anything in NS_FORUM namespace
	 *
	 * @return true
	 *
	 * @author Tomasz Odrobny
	 **/

	static function onGetUserPermissionsErrors( Title &$title, User &$user, $action, &$result ) {
		if ( $action == 'read' ) {
			return true;
		}

		$ns = $title->getNamespace();

		# check namespace(s)
		if ( $ns == NS_FORUM || $ns == NS_FORUM_TALK ) {
			if ( !static::canEditOldForum( $user ) ) {
				$result = array( 'protectedpagetext' );
				return false;
			}
		}

		return true;
	}

	/**
	 * override button on forum
	 */

	static public function onPageHeaderIndexAfterActionButtonPrepared( $response, $ns, $skin ) {
		$app = F::App();
		$title = $app->wg->Title;

		$ns = $title->getNamespace();
		# check namespace(s)
		if ( $ns == NS_FORUM || $ns == NS_FORUM_TALK ) {
			if ( !static::canEditOldForum( $app->wg->User ) ) {
				$action = array( 'class' => '', 'text' => wfMessage( 'viewsource' )->escaped(), 'href' => $title->getLocalUrl( array( 'action' => 'edit' ) ), 'id' => 'ca-viewsource', 'primary' => 1 );
				$response->setVal( 'actionImage', MenuButtonController::LOCK_ICON );
				$response->setVal( 'action', $action );
				return false;
			}
		}
		return true;
	}

	/**
	 * helper function for onGetUserPermissionsErrors/onPageHeaderIndexAfterActionButtonPrepared
	 */

	static public function canEditOldForum( $user ) {
		return $user->isAllowed( 'forumoldedit' );
	}

	/**
	 * show the info box for old forums
	 */

	static public function onArticleViewHeader( &$article, &$outputDone, &$useParserCache ) {
		$title = $article->getTitle();
		$ns = $title->getNamespace();
		# check namespace(s)
		if ( $ns == NS_FORUM || $ns == NS_FORUM_TALK ) {
			$app = F::App();
			$html = $app->renderView( 'Forum', 'oldForumInfo' );
			$app->wg->Out->addHTML( $html );
		}
		return true;
	}

	/**
	 * Display Related Discussion (Forum posts) in bottom of article
	 * @param OutputPage $out
	 * @param string $text article HTML
	 * @return bool: true because it is a hook
	 */
	static public function onOutputPageBeforeHTML( OutputPage $out, &$text ) {
		$app = F::app();
		$title = $out->getTitle();
		if ( $out->isArticle()
			&& $title->exists()
			&& $title->getNamespace() == NS_MAIN
			&& !Wikia::isMainPage()
			&& $out->getRequest()->getVal( 'diff' ) === null
			&& $out->getRequest()->getVal( 'action' ) !== 'render'
			&& !( $app->checkSkin( 'wikiamobile', $out->getSkin() ) )
		) {
			// VOLDEV-46: Omit zero-state, only render if there are related forum threads
			$messages = RelatedForumDiscussionController::getData( $title->getArticleId() );
			unset( $messages['lastupdate'] );
			if ( !empty( $messages ) ) {
				$text .= $app->renderView( 'RelatedForumDiscussionController', 'index', array( 'messages' => $messages ) );
			}
		}
		return true;
	}

	/**
	 * purge memc and vernish cache for pages releated to this thread
	 *
	 * in case of edit this hook is run two time before (WallBeforeEdit) edit and after edit (WallAction)
	 *
	 */

	static public function onWallAction( $action, $parent, $comment_id ) {
		$title = Title::newFromId( $comment_id, Title::GAID_FOR_UPDATE );

		if ( !empty( $title ) && MWNamespace::getSubject( $title->getNamespace() ) == NS_WIKIA_FORUM_BOARD ) {
			$threadId = empty( $parent ) ? $comment_id: $parent;
			RelatedForumDiscussionController::purgeCache( $threadId );

			// cleare board info
			$commentsIndex = CommentsIndex::newFromId( $comment_id );
			if ( empty( $commentsIndex ) ) {
				return true;
			}
			$board = ForumBoard::newFromId( $commentsIndex->getParentPageId() );
			if ( empty( $board ) ) {
				return true;
			}

			$thread = WallThread::newFromId( $threadId );
			if ( !empty( $thread ) ) {
				$thread->purgeLastMessage();
			}
		}
		return true;
	}

	/**
	 * Makes sure the correct URLs for thread pages get purged.
	 *
	 * @param $title Title
	 * @param $urls String[]
	 * @return bool
	 */
	public static function onTitleGetSquidURLs( $title, &$urls ) {
		wfProfileIn( __METHOD__ );

		if ( $title->inNamespaces( NS_WIKIA_FORUM_BOARD, NS_WIKIA_FORUM_BOARD_THREAD, NS_WIKIA_FORUM_TOPIC_BOARD ) ) {
			// CONN-430: Resign from default ArticleComment purges
			$urls = [];
		}

		if ( $title->inNamespaces( NS_WIKIA_FORUM_BOARD_THREAD, NS_WIKIA_FORUM_TOPIC_BOARD ) ) {
			$wallMessage = WallMessage::newFromTitle( $title );
			$urls = array_merge( $urls, $wallMessage->getSquidURLs( NS_WIKIA_FORUM_BOARD ) );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @desc Makes sure we don't send unnecessary ArticleComments links to purge
	 *
	 * @param Title $title
	 * @param String[] $urls
	 *
	 * @return bool
	 */
	public static function onArticleCommentGetSquidURLs( $title, &$urls ) {
		wfProfileIn( __METHOD__ );

		if ( $title->inNamespaces( NS_WIKIA_FORUM_BOARD, NS_WIKIA_FORUM_BOARD_THREAD, NS_WIKIA_FORUM_TOPIC_BOARD ) ) {
			// CONN-430: Resign from default ArticleComment purges
			$urls = [];
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * just proxy to onWallStoreRelatedTopicsInDB
	 */
	static public function onWallStoreRelatedTopicsInDB( $parent, $id, $namespace ) {
		self::onWallAction( null, $parent, $id );
		return true;
	}

	static public function onArticleFromTitle( &$title ) {

		$currentNs = MWNamespace::getSubject( $title->getNamespace() );
		if ( $currentNs == NS_WIKIA_FORUM_BOARD || $currentNs == NS_WIKIA_FORUM_TOPIC_BOARD
			|| $currentNs == NS_WIKIA_FORUM_BOARD_THREAD ) {
			OasisController::addBodyParameter( ' itemscope itemtype="http://schema.org/WebPage"' );
		}
		return true;
	}

	/**
	 * Create a tag for including the Forum Activity Module on pages
	 */
	static public function onParserFirstCallInit( Parser &$parser ) {
		wfProfileIn( __METHOD__ );
		$parser->setHook( 'wikiaforum', array( __CLASS__, 'parseForumActivityTag' ) );

		// Add styling for forum tag
		$scssFile = AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/Forum/css/ForumTag.scss' );
		F::app()->wg->Out->addStyle( $scssFile );
		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function parseForumActivityTag( $input, $args, $parser ) {
		wfProfileIn( __METHOD__ );

		$html = F::app()->renderView( 'Forum', 'forumActivityModule' );

		wfProfileOut( __METHOD__ );
		return $html;
	}

	/**
	 * Set Topic page links as known if they are connected to related article
	 * (because Topic is not save in 'Page' table like other articles)
	 *
	 * @param $skin
	 * @param $target
	 * @param $text
	 * @param $customAttribs
	 * @param $query
	 * @param $options
	 * @param $ret
	 * @return bool
	 */
	static public function onLinkBegin( $skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret ) {
		if ( !( $target instanceof Title ) ) {
			return true;
		}

		if ( $target->getNamespace() == NS_WIKIA_FORUM_TOPIC_BOARD ) {
			$topicTitle =  Title::newFromURL( $target->getText() );
			if ( $topicTitle->exists() ) {
				$index = array_search( 'broken', $options );
				unset( $options[$index] );
				$options[] = 'known';
			}
		}

		return true;
	}

	static public function onWallMessageGetWallOwnerName( $title, &$wallOwnerName ) {
		if ( $title->getNamespace() === NS_WIKIA_FORUM_BOARD ) {
			$wallOwnerName = $title->getText();
		}

		return true;
	}

	/**
	 * Ensure that the comments_index record (if it exists) for an article is marked as deleted
	 * when an article is deleted. This event must be run inside the transaction in WikiPage::doDeleteArticleReal
	 * otherwise the Article referenced will no longer exist and the lookup for it's associated
	 * comments_index row will fail.
	 *
	 * @param WikiPage $page WikiPage object
	 * @param User $user User object [not used]
	 * @param string $reason [not used]
	 * @param int $id [not used]
	 * @return bool true
	 *
	 */
	static public function onArticleDoDeleteArticleBeforeLogEntry( &$page, &$user, $reason, $id ) {
		$title = $page->getTitle();
		if ( $title instanceof Title ) {
			$wallMessage = WallMessage::newFromTitle( $title );
			$wallMessage->setInCommentsIndex( WPP_WALL_ADMINDELETE, 1 );
		}

		return true;
	}

}
