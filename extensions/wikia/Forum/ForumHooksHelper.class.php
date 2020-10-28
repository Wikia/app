<?php

use Wikia\Logger\WikiaLogger;
use Wikia\PageHeader\Button;

class ForumHooksHelper {
	/**
	 * Render the alternative version of thread page
	 * @param Title $title
	 * @param $wm
	 * @return bool
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
	 * @param Title $title
	 * @param $wallMessage
	 * @param $path
	 * @param $response
	 * @param $request
	 * @return bool
	 */
	static public function onWallThreadHeader( $title, $wallMessage, &$path, &$response, &$request ) {
		if ( MWNamespace::getSubject( $title->getNamespace() ) == NS_WIKIA_FORUM_BOARD ) {
			$path = array_merge( static::getPath( $wallMessage ), [ $path[1] ] );
			OasisController::addBodyParameter( ' itemscope itemtype="http://schema.org/WebPage"' );
		}
		return true;
	}

	/**
	 * @param Title $title
	 * @param $wallMessage
	 * @param $path
	 * @param $response
	 * @param $request
	 * @return bool
	 */
	static public function onWallHistoryThreadHeader( $title, $wallMessage, &$path, &$response, &$request ) {
		if ( MWNamespace::getSubject( $title->getNamespace() ) == NS_WIKIA_FORUM_BOARD ) {
			$path = array_merge( static::getPath( $wallMessage ), [ $path[1] ] );
		}

		return true;
	}

	/**
	 * @param Title $title
	 * @param $path
	 * @param WikiaResponse $response
	 * @param $request
	 * @return bool
	 */
	static public function onWallHistoryHeader( $title, &$path, &$response, &$request ) {
		if ( MWNamespace::getSubject( $title->getNamespace() ) == NS_WIKIA_FORUM_BOARD ) {
			$app = F::App();

			$response->setVal( 'pageTitle', wfMessage( 'forum-board-history-title' )->escaped() );
			$app->wg->Out->setPageTitle( wfMessage( 'forum-board-history-title' )->plain() );

			$path = [ static::getIndexPath(), [ 'title' => wfMessage( 'forum-board-title', $title->getText() )->escaped(), 'url' => $title->getFullUrl() ] ];
		}
		return true;
	}

	/**
	 * @param Title $title
	 * @param $path
	 * @param $response
	 * @param $request
	 * @return bool
	 */
	static public function onWallHeader( $title, &$path, &$response, &$request ) {
		if ( $title->getNamespace() === NS_WIKIA_FORUM_BOARD ) {
			$path[] = static::getIndexPath();
			$path[] = [ 'title' => wfMessage( 'forum-board-title', $title->getText() )->escaped(), ];
		}
		return true;
	}

	/**
	 * @param Title $title
	 * @param WikiaResponse $response
	 * @return bool
	 */
	static public function onWallNewMessage( $title, &$response ) {
		if ( $title->getNamespace() === NS_WIKIA_FORUM_BOARD ) {
			$response->setVal( 'wall_message', wfMessage( 'forum-discussion-placeholder-message', $title->getText() )->escaped() );
		}

		if ( $title->getNamespace() === NS_WIKIA_FORUM_TOPIC_BOARD ) {
			$response->setVal( 'wall_message', wfMessage( 'forum-discussion-placeholder-message-short' )->escaped() );
		}
		return true;
	}

	/**
	 * @param WallMessage $wallMessage
	 * @return array
	 */
	static protected function getPath( $wallMessage ) {
		$path = [ ];
		$path[] = static::getIndexPath();
		$path[] = [ 'title' => wfMessage( 'forum-board-title', $wallMessage->getArticleTitle()->getText() )->escaped(), 'url' => $wallMessage->getArticleTitle()->getFullUrl() ];

		return $path;
	}

	static protected function getIndexPath() {
		$indexPage = Title::newFromText( 'Forum', NS_SPECIAL );
		return [ 'title' => wfMessage( 'forum-forum-title' )->escaped(), 'url' => $indexPage->getFullUrl() ];
	}

	/**
	 * change the message in WikiActivity for forum namespace
	 * @param $item
	 * @param WallMessage $wmessage
	 * @return bool
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

	/**
	 * @param Title $title
	 * @param $user
	 * @param $action
	 * @param $result
	 * @return bool
	 */
	static public function getUserPermissionsErrors(
		Title $title, User $user, string $action, &$result
	): bool {
		$result = null;

		if ( Forum::$allowToEditBoard == true ) {
			return true;
		}

		if ( $action == 'read' || $title->getNamespace() != NS_WIKIA_FORUM_BOARD ) {
			return true;
		}

		$result = [ 'protectedpagetext' ];
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
	static public function onContributionsLineEnding( ContribsPager $contribsPager, &$ret, $row ): bool {

		if ( isset( $row->page_namespace ) && in_array( MWNamespace::getSubject( $row->page_namespace ), [ NS_WIKIA_FORUM_BOARD ] ) ) {

			if ( $row->page_namespace == NS_WIKIA_FORUM_BOARD ) {
				return true;
			}

			if ( class_exists( 'WallHooksHelper' ) ) {
				return WallHooksHelper::contributionsLineEndingProcess( $contribsPager, $ret, $row );
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
	 * clear the caches
	 * @param WallMessage $mw
	 * @return bool
	 */

	static public function onAfterBuildNewMessageAndPost( WallMessage $mw ): bool {
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
	 * @param Title $parentTitle
	 * @param WikiaResponse $response
	 * @return bool
	 */
	static public function onWallMessageDeleted(
		Title $parentTitle, WikiaResponse $response
	): bool {
		if ( $parentTitle->inNamespace( NS_WIKIA_FORUM_BOARD ) ) {
			$response->setVal( 'returnTo',
				wfMessage( 'forum-thread-deleted-return-to', $parentTitle->getBaseText() )->escaped() );
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
		global $wgEnableRecirculationDiscussions;

		$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/Forum/css/ForumTag.scss' ) );
		$title = $out->getTitle();
		if ( $out->isArticle()
			&& $title->exists()
			&& $title->getNamespace() == NS_MAIN
			&& !Wikia::isMainPage()
			&& $out->getRequest()->getVal( 'diff' ) === null
			&& $out->getRequest()->getVal( 'action' ) !== 'render'
			&& $out->getSkin()->getSkinName() !== 'wikiamobile'
			&& empty( $wgEnableRecirculationDiscussions )
		) {
			// VOLDEV-46: Omit zero-state, only render if there are related forum threads
			$messages = RelatedForumDiscussionController::getData( $title->getArticleId() );
			unset( $messages['lastupdate'] );
			if ( !empty( $messages ) ) {
				$text .= F::app()->renderView( 'RelatedForumDiscussionController', 'index', [ 'messages' => $messages ] );
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
			$threadId = empty( $parent ) ? $comment_id:$parent;
			RelatedForumDiscussionController::purgeCache( $threadId );

			// clear board info
			try {
				$commentsIndex = CommentsIndex::getInstance()->entryFromId( $comment_id );
				$board = ForumBoard::newFromId( $commentsIndex->getParentPageId() );
				if ( empty( $board ) ) {
					return true;
				}

				$thread = WallThread::newFromId( $threadId );
				if ( !empty( $thread ) ) {
					$thread->purgeLastMessage();
				}
			} catch ( CommentsIndexEntryNotFoundException $entryNotFoundException ) {
				// don't fail if comment was invalid
			}

			// SUS-4084: Purge Forum activity module cache here - we don't need to purge it when a Wall thread changes
			CachedForumActivityService::purgeCache();
		}
		return true;
	}

	/**
	 * CONN-430: Don't purge any default URLs for Forum content
	 * @see WallMessage::invalidateCache() for where the magic happens ⭐️
	 *
	 * @param $title Title
	 * @param $urls String[]
	 * @return bool
	 */
	public static function onTitleGetSquidURLs( $title, &$urls ) {
		if ( $title->inNamespaces( NS_WIKIA_FORUM_BOARD, NS_WIKIA_FORUM_BOARD_THREAD, NS_WIKIA_FORUM_TOPIC_BOARD ) ) {
			$urls = [];
		}

		return true;
	}

	/**
	 * just proxy to onWallStoreRelatedTopicsInDB
	 */
	static public function onWallStoreRelatedTopicsInDB( $parent, $id, $namespace ) {
		self::onWallAction( null, $parent, $id );
		return true;
	}

	/**
	 * @param Title $title
	 * @return bool
	 */
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
	 * @param Parser $parser
	 * @return bool true
	 */
	static public function onParserFirstCallInit( Parser $parser ): bool {
		$parser->setHook( 'wikiaforum', [ __CLASS__, 'parseForumActivityTag' ] );
		return true;
	}

	static public function parseForumActivityTag( $input, $args, $parser ) {
		wfProfileIn( __METHOD__ );

		$html = F::app()->renderView( 'Forum', 'forumActivityModule' );

		// remove newlines so parser does not try to wrap lines into paragraphs
		$html = str_replace( "\n", "", $html );

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

	/**
	 * @param Title $title
	 * @param $wallOwnerName
	 * @return bool
	 */
	static public function onWallMessageGetWallOwnerName( $title, &$wallOwnerName ) {
		if ( $title->getNamespace() === NS_WIKIA_FORUM_BOARD ) {
			$wallOwnerName = $title->getText();
		}

		return true;
	}

	/**
	 * SUS-1196: Invalidate "Forum Activity" rail module cache if thread is deleted via Nuke / Quick Tools
	 * @param Article|WikiPage|Page $page
	 * @param User $user
	 * @param string $reason
	 * @param int $id
	 * @return bool always true to continue hook processing
	 */
	static public function onArticleDeleteComplete( Page $page, User $user, string $reason, int $id ): bool {
		$pageTitle = $page->getTitle();

		if ( $pageTitle->inNamespace( NS_WIKIA_FORUM_BOARD_THREAD ) ) {
			CachedForumActivityService::purgeCache();

			// SUS-2757: After the main transaction is closed, delete watchlist entries for thread
			$threadWatchlistDeleteUpdate = new ThreadWatchlistDeleteUpdate( $pageTitle );
			DeferredUpdates::addUpdate( $threadWatchlistDeleteUpdate );
		}

		return true;
	}

	/**
	 * SUS-260: Prevent moving pages within, into, or out of Forum namespaces
	 * @param bool $result whether to allow page moves
	 * @param int $ns namespace number
	 * @return bool false if this is Forum namespace to prevent page moves, true otherwise to resume hook processing
	 */
	public static function onNamespaceIsMovable( bool &$result, int $ns ): bool {
		global $wgAllowForumThreadOperations;

		// IW-4687: Relax Forum thread move restrictions if needed
		if ( $wgAllowForumThreadOperations && $ns === NS_WIKIA_FORUM_BOARD_THREAD ) {
			return true;
		}

		if ( in_array( $ns, [ NS_WIKIA_FORUM_BOARD, NS_WIKIA_FORUM_BOARD_THREAD, NS_WIKIA_FORUM_TOPIC_BOARD ] ) ) {
			$result = false;
			return false;
		}

		return true;
	}

	/**
	 * @param string $pageSubtitle
	 *
	 * @param Title $title
	 * @return bool
	 */
	public static function onAfterPageHeaderPageSubtitle( &$pageSubtitle, Title $title ): bool {
		if (
			in_array( $title->getNamespace(), [
				NS_WIKIA_FORUM_BOARD,
				NS_WIKIA_FORUM_TOPIC_BOARD
			] ) &&
			RequestContext::getMain()->getRequest()->getVal( 'action' ) !== 'history'
		) {
			$pageSubtitle = F::app()->renderView(
				'Forum',
				'brickHeader',
				[
					'id' => $title->getText()
				]
			);
		}

		return true;
	}

	/**
	 * @param Title $title
	 * @param bool $shouldDisplayActionButton
	 *
	 * @return bool
	 */
	public static function onPageHeaderActionButtonShouldDisplay(
		Title $title,
		bool &$shouldDisplayActionButton
	): bool {
		if ( in_array( $title->getNamespace(), [
			NS_WIKIA_FORUM_BOARD,
			NS_WIKIA_FORUM_BOARD_THREAD,
			NS_WIKIA_FORUM_TOPIC_BOARD,
		] ) ) {
			$shouldDisplayActionButton = false;
		}

		return true;
	}

	/**
	 * @param Title $title
	 * @param array $buttons
	 *
	 * @return bool
	 */
	public static function onAfterPageHeaderButtons( \Title $title, array &$buttons ): bool {
		if ( $title->isSpecial( 'Forum' ) ) {
			$label = wfMessage( 'forum-specialpage-policies' )->escaped();
			$buttons[] = new Button( $label, 'wds-icons-clipboard-small', '#', 'policies-link' );
		}

		return true;
	}
}
