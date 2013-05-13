<?php

class ForumHooksHelper {
	/**
	 * Render the alternative version of thread page
	 */
	public function onWallBeforeRenderThread( $title, $wm ) {
		$app = F::App();
		if ( $title->getNamespace() == NS_WIKIA_FORUM_BOARD_THREAD ) {
			$app->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/Forum/css/ForumThread.scss' ) );
			$app->wg->IsForum = true;
		}
		return true;
	}

	/**
	 * on thread header change header title
	 */
	public function onWallThreadHeader( $title, $wallMessage, &$path, &$response, &$request ) {
		if ( MWNamespace::getSubject( $title->getNamespace() ) == NS_WIKIA_FORUM_BOARD ) {
			$app = F::App();
			$path = array_merge( $this->getPath( $wallMessage ), array( $path[1] ) );
			OasisController::addBodyParameter(' itemscope itemtype="http://schema.org/WebPage"');
		}
		return true;
	}

	public function onWallHistoryThreadHeader( $title, $wallMessage, &$path, &$response, &$request ) {
		if ( MWNamespace::getSubject( $title->getNamespace() ) == NS_WIKIA_FORUM_BOARD ) {
			$app = F::App();
			$indexPage = F::build( 'Title', array( 'Forum', NS_SPECIAL ), 'newFromText' );
			$path = array_merge( $this->getPath( $wallMessage ), array( $path[1] ) );
		}

		return true;
	}

	public function onWallHistoryHeader( $title, &$path, &$response, &$request ) {
		if ( MWNamespace::getSubject( $title->getNamespace() ) == NS_WIKIA_FORUM_BOARD ) {
			$app = F::App();

			$response->setVal( 'pageTitle', wfMsg( 'forum-board-history-title' ) );
			$app->wg->Out->setPageTitle( wfMsg( 'forum-board-history-title' ) );

			$indexPage = F::build( 'Title', array( 'Forum', NS_SPECIAL ), 'newFromText' );
			$path = array( $this->getIndexPath(), array( 'title' => wfMsg( 'forum-board-title', $title->getText() ), 'url' => $title->getFullUrl() ) );
		}
		return true;
	}

	public function onWallHeader($title, &$path, &$response, &$request) {
		if ( $title->getNamespace() === NS_WIKIA_FORUM_BOARD ) {
			$path[] = $this->getIndexPath();
			$path[] = array( 'title' => wfMsg( 'forum-board-title', $title->getText() ), );

		}
		return true;
	}

	public function onWallNewMessage($title, &$response) {
		if ( $title->getNamespace() === NS_WIKIA_FORUM_BOARD) {
			$response->setVal( 'wall_message', wfMsg( 'forum-discussion-placeholder-message', $title->getText() ) );
		}

		if ( $title->getNamespace() === NS_WIKIA_FORUM_TOPIC_BOARD ) {
			$response->setVal( 'wall_message', wfMsg( 'forum-discussion-placeholder-message-short' ) );
		}
		return true;
	}

	protected function getPath($wallMessage) {
		$path = array();
		$app = F::App();
		$indexPage = F::build( 'Title', array( 'Forum', NS_SPECIAL ), 'newFromText' );
		$path[] = $this->getIndexPath();
		$path[] = array( 'title' => wfMsg( 'forum-board-title', $wallMessage->getArticleTitle()->getText() ), 'url' => $wallMessage->getArticleTitle()->getFullUrl() );

		return $path;
	}

	protected function getIndexPath() {
		$app = F::App();
		$indexPage = F::build( 'Title', array( 'Forum', NS_SPECIAL ), 'newFromText' );
		return array( 'title' => wfMsg( 'forum-forum-title', $app->wg->sitename ), 'url' => $indexPage->getFullUrl() );
	}

	/**
	 * change the message in WikiActivity for forum namespace
	 */

	public function onAfterWallWikiActivityFilter(&$item, $wmessage) {
		if ( !empty( $item['ns'] ) && MWNamespace::getSubject( $item['ns'] ) == NS_WIKIA_FORUM_BOARD ) {
			$app = F::App();
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
				$item['wall-msg'] = wfMsg( 'forum-wiki-activity-msg', '<a href="' . $board->getFullURL() . '">' . wfMsg( 'forum-wiki-activity-msg-name', $board->getText() ) . '</a>' );
			}
		}

		return true;
	}

	public static function onFilePageImageUsageSingleLink(&$link, &$element) {

		if ( $element->page_namespace == NS_WIKIA_FORUM_BOARD_THREAD ) {

			$titleData = WallHelper::getWallTitleData(null, $element, true);

			$boardText = wfMsg( 'forum-wiki-activity-msg', '<a href="' .$titleData['wallPageFullUrl'] . '">' . wfMsg( 'forum-wiki-activity-msg-name', $titleData['wallPageName'] ) . '</a>' );
			$link = '<a href="'.$titleData['articleFullUrl'].'">'.$titleData['articleTitleTxt'].'</a> ' . $boardText;
		}
		return true;
	}

	public static function getUserPermissionsErrors(&$title, &$user, $action, &$result) {
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
	public function onContributionsLineEnding(&$contribsPager, &$ret, $row) {

		if( isset( $row->page_namespace ) && in_array( MWNamespace::getSubject($row->page_namespace), array(NS_WIKIA_FORUM_BOARD) ) ) {

			if ( $row->page_namespace == NS_WIKIA_FORUM_BOARD ) {
				return true;
			}

			if ( class_exists('WallHooksHelper') ) {
				$wallHooks = new WallHooksHelper();
				return $wallHooks->contributionsLineEndingProcess( $contribsPager, $ret, $row );
			}
		}
		return true;
	}

	public function onOasisAddPageDeletedConfirmationMessage( Title &$title, &$message ) {

		if ( $title->getNamespace() == NS_WIKIA_FORUM_BOARD ) {

			$pageName = $title->getPrefixedText();
			$message = wfMsgExt( 'forum-confirmation-board-deleted', array('parseinline'), $pageName );
		}

		return true;
	}

	public function onWallContributionsLine($pageNamespace, $wallMessage, $wfMsgOptsBase, &$ret) {
		if ( $pageNamespace != NS_WIKIA_FORUM_BOARD ) {
			return true;
		}

		$app = F::App();

		if ( empty( $wfMsgOptsBase['articleTitleVal'] ) ) {
			$wfMsgOptsBase['articleTitleTxt'] = $app->wf->Msg( 'forum-recentchanges-deleted-reply-title' );
		}

		$wfMsgOpts = array(
			$wfMsgOptsBase['articleFullUrl'],
			$wfMsgOptsBase['articleTitleTxt'],
			$wfMsgOptsBase['wallPageFullUrl'],
			$wfMsgOptsBase['wallPageName'],
			$wfMsgOptsBase['createdAt'],
			$wfMsgOptsBase['DiffLink'],
			$wfMsgOptsBase['historyLink']
		);

		if ( $wfMsgOptsBase['isThread'] && $wfMsgOptsBase['isNew'] ) {
			$wfMsgOpts[7] = Xml::element( 'strong', array(), wfMessage( 'newpageletter' )->plain() . ' ' );
		} else {
			$wfMsgOpts[7] = '';
		}

		$ret .= $app->wf->Msg( 'forum-contributions-line', $wfMsgOpts );

		return false;
	}

	public function onWallRecentchangesMessagePrefix($namespace, &$prefix) {
		if ( $namespace == NS_WIKIA_FORUM_BOARD ) {
			$prefix = 'forum-recentchanges';
			return false;
		}
		return true;
	}

	// Hook: clear cache when editing comment
	public function onEditCommentsIndex($title, $commentsIndex) {
		if ( $title->getNamespace() == NS_WIKIA_FORUM_BOARD_THREAD ) {
			$parentPageId = $commentsIndex->getParentPageId();

			$board = F::build( 'ForumBoard', array( $parentPageId ), 'newFromId' );
			$board->clearCacheBoardInfo();
		}

		return true;
	}

	/**
	 * Hook: add comments_index table when adding board
	 */
	public function onArticleInsertComplete(&$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision) {
		$title = $article->getTitle();
		if ( $title->getNamespace() == NS_WIKIA_FORUM_BOARD ) {
			$commentsIndex = F::build( 'CommentsIndex' );
			$commentsIndex->createTableCommentsIndex();
		}

		return true;
	}

	/**
	 * clear the caches
	 */

	public function onAfterBuildNewMessageAndPost(&$mw) {
		$title = $mw->getTitle();
		if ( $title->getNamespace() == NS_WIKIA_FORUM_BOARD_THREAD ) {
			$forum = F::build( 'Forum' );
			$forum->clearCacheTotalActiveThreads();
			$forum->clearCacheTotalThreads();
		}
		return true;
	}

	/**
	 * overriding message
	 */

	public function onWallMessageDeleted(&$mw, &$response) {
		$title = $mw->getTitle();
		if ( $title->getNamespace() == NS_WIKIA_FORUM_BOARD_THREAD ) {
			$response->setVal( 'returnTo', wfMsg( 'forum-thread-deleted-return-to', $mw->getWallTitle()->getText() ) );
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

	function onGetUserPermissionsErrors(Title &$title, User &$user, $action, &$result) {
		if ( $action == 'read' ) {
			return true;
		}

		$ns = $title->getNamespace();

		#check namespace(s)
		if ( $ns == NS_FORUM || $ns == NS_FORUM_TALK ) {
			if ( !$this->canEditOldForum( $user ) ) {
				$result = array( 'protectedpagetext' );
				return false;
			}
		}

		return true;
	}

	/**
	 * override button on forum
	 */

	public function onPageHeaderIndexAfterActionButtonPrepared($response, $ns, $skin) {
		$app = F::App();
		$title = $app->wg->Title;

		$ns = $title->getNamespace();
		#check namespace(s)
		if ( $ns == NS_FORUM || $ns == NS_FORUM_TALK ) {
			if ( !$this->canEditOldForum( $app->wg->User ) ) {
				$action = array( 'class' => '', 'text' => $app->wf->Msg( 'viewsource' ), 'href' => $title->getLocalUrl( array( 'action' => 'edit' ) ), 'id' => 'ca-viewsource', 'primary' => 1 );
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

	public function canEditOldForum($user) {
		return $user->isAllowed( 'forumoldedit' );
	}

	/**
	 * show the info box for old forums
	 */

	public function onArticleViewHeader(&$article, &$outputDone, &$useParserCache) {
		$title = $article->getTitle();
		$ns = $title->getNamespace();
		#check namespace(s)
		if ( $ns == NS_FORUM || $ns == NS_FORUM_TALK ) {
			$app = F::App();
			$html = $app->renderView( 'Forum', 'oldForumInfo' );
			$app->wg->Out->addHTML( $html );
		}
		return true;
	}

	/**
	 * Display Related Discussion (Forum posts) in bottom of article
	 */
	public static function onOutputPageBeforeHTML( OutputPage $out, &$text ) {
		$app = F::App();
		if ( $out->isArticle() && $app->wg->Title->exists()
			&& $app->wg->Title->getNamespace() == NS_MAIN && !Wikia::isMainPage()
			&& $app->wg->Request->getVal( 'diff' ) === null
			&& $app->wg->Request->getVal( 'action' ) !== 'render'
			&& !( $app->checkSkin( 'wikiamobile' ) )
		) {
			$text .= $app->renderView( 'RelatedForumDiscussionController', 'index');
		}
		return true;
	}

	/**
	 * purge memc and vernish cache for pages releated to this thread
	 *
	 * in case of edit this hook is run two time before (WallBeforeEdit) edit and after edit (WallAction)
	 *
	 */

	public static function onWallAction($action, $parent, $comment_id) {
		$app = F::App();
		$title = Title::newFromId($comment_id, Title::GAID_FOR_UPDATE);

		if ( !empty($title) && MWNamespace::getSubject( $title->getNamespace() ) == NS_WIKIA_FORUM_BOARD ) {
			$threadId = empty($parent) ? $comment_id:$parent;
			$app->sendRequest( "RelatedForumDiscussion", "purgeCache", array('threadId' => $threadId ));

			//cleare board info
			$commentsIndex = F::build( 'CommentsIndex', array( $comment_id ), 'newFromId' );
			if(empty($commentsIndex)) {
				return true;
			}
			$board = F::build( 'ForumBoard', array( $commentsIndex->getParentPageId() ), 'newFromId' );
			if(empty($board)) {
				return true;
			}

			$board->clearCacheBoardInfo();

			$thread = WallThread::newFromId( $threadId );
			if(!empty($thread)) {
				$thread->purgeLastMessage();
				$threadTitle = Title::newFromId( $threadId );
				// the title can be empty if this is a create action
				if ( !empty( $threadTitle ) ) {
					$threadTitle->purgeSquid();
					$threadTitle->invalidateCache();
				}
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
		if ( $title->inNamespace( NS_WIKIA_FORUM_BOARD_THREAD ) ) {
			$wallMessage = WallMessage::newFromTitle( $title );
			$urls = array(
				$wallMessage->getMessagePageUrl(),
				$wallMessage->getMessagePageUrl() . '?action=history',
			);
		}

		return true;
	}

	/**
	 * just proxy to onWallStoreRelatedTopicsInDB
	 */
	public static function onWallStoreRelatedTopicsInDB($parent, $id, $namespace) {
		self::onWallAction(null, $parent, $id);
		return true;
	}

	static public function onArticleFromTitle( &$title ){

		$currentNs = MWNamespace::getSubject( $title->getNamespace() );
		if ( $currentNs == NS_WIKIA_FORUM_BOARD || $currentNs == NS_WIKIA_FORUM_TOPIC_BOARD
			|| $currentNs == NS_WIKIA_FORUM_BOARD_THREAD ) {
			OasisController::addBodyParameter(' itemscope itemtype="http://schema.org/WebPage"');
		}
		return true;
	}

	/**
	 * Create a tag for including the Forum Activity Module on pages
	 */
	public static function onParserFirstCallInit( Parser &$parser ) {
		wfProfileIn( __METHOD__ );
		$parser->setHook( 'wikiaforum', array( __CLASS__, 'parseForumActivityTag' ) );

		// Add styling for forum tag
		$scssFile = F::build( 'AssetsManager', array(), 'getInstance' )->getSassCommonURL( 'extensions/wikia/Forum/css/ForumTag.scss' );
		F::app()->wg->Out->addStyle( $scssFile );
		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function parseForumActivityTag( $input, $args, $parser ) {
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
	public function onLinkBegin($skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret) {
		if( !($target instanceof Title) ) {
			return true;
		}

		if ($target->getNamespace() == NS_WIKIA_FORUM_TOPIC_BOARD) {
			$topicTitle =  Title::newFromURL($target->getText());
			if ($topicTitle->exists()) {
				$index = array_search('broken', $options);
				unset($options[$index]);
				$options[] = 'known';
			}
		}

		return true;
	}

	public static function onWallMessageGetWallOwnerName( $title, &$wallOwnerName ) {
		if ( $title->getNamespace() === NS_WIKIA_FORUM_BOARD ) {
			$wallOwnerName = $title->getText();
		}

		return true;
	}
}
