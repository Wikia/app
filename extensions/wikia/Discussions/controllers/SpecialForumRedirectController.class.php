<?php

class SpecialForumRedirectController extends WikiaSpecialPageController {

	const DISCUSSIONS_LINK = '/d/f';

	public function __construct() {
		parent::__construct( 'Forum', '', false );
	}

	public function index() {
		$this->redirectForumToDiscussions();
	}

	/**
	 * Redirect requests for Special:Forum to discussions, e.g. from:
	 *
	 *   http://garth.wikia.com/wiki/Special:Forum
	 *
	 * to:
	 *
	 *   http://garth.wikia.com/d/f?sort=latest
	 */
	public function redirectForumToDiscussions() {
		$discussionUrl = $this->getDiscussionUrl();
		$this->response->redirect( $discussionUrl );
	}

	/**
	 * Redirect requests for the board page to discussions, e.g, from:
	 *
	 *   http://garth.wikia.com/wiki/Board:Some_Board_Name
	 *
	 * to:
	 *
	 *   http://garth.wikia.com/d/f?catId=2016136434548737693
	 *
	 * This is handled by registering a namespace controller (deprecated currently, but how wall
	 * works) e.g. this line in Discussions.setup.php:
	 *
	 * $app->registerNamespaceController(
	 *     NS_WIKIA_FORUM_BOARD,
	 *     'SpecialForumRedirectController',
	 *     'redirectBoardToCategory',
	 * );
	 *
	 */
	public function redirectBoardToCategory() {
		$boardId = $this->getBoardId();
		$categoryUrl = $this->getDiscussionCategoryUrl( $boardId );

		gmark("Redirect board $boardId to $categoryUrl");
		$this->response->redirect( $categoryUrl );
	}

	/**
	 * Redirect requests for a thread to discussions, e.g. from:
	 *
	 *   http://garth.garth.wikia-dev.us/wiki/Thread:2892
	 *
	 * to:
	 *
	 *   http://garth.wikia.com/d/p/2914856863801542335
	 *
	 * @param Title $thread
	 */
	public static function redirectThreadToPost( Title $thread ) {
		$threadId = $thread->getArticleID();
		$postUrl = self::getDiscussionPostDetailUrl( $threadId );

		gmark("Redirect thread $threadId to $postUrl");
		F::app()->wg->Out->redirect( $postUrl );
	}

	private function getDiscussionUrl() {
		return self::DISCUSSIONS_LINK;
	}

	private function getDiscussionCategoryUrl( $boardId ) {
		// TODO Implement fetching of discussions category URL from board ID.
		return "";
	}

	private static function getDiscussionPostDetailUrl( $threadId ) {
		// TODO Implement fetching of discussions post detail URL from Forum thread ID
		return "";
	}

	private function getBoardId() {
		return $this->wg->Title->getArticleID();
	}

	/**
	 * @param Article $article
	 * @param bool $outputDone
	 * @param bool $useParserCache
	 *
	 * @return bool
	 */
	public static function onArticleViewHeader( &$article, &$outputDone, &$useParserCache ) {
		$mainTitle = self::getMainTitle( $article );
		if ( empty( $mainTitle ) ) {
			return true;
		}

		// Redirect to discussions
		self::redirectThreadToPost( $mainTitle );
		return true;
	}

	/**
	 * Some of this logic has been borrowed from WallHooksHelper::onArticleViewHeader
	 *
	 * @param Article $article
	 * @return null|Title
	 */
	private static function getMainTitle( Article $article ) {
		$title = $article->getTitle();

		if ( $title->getNamespace() != NS_USER_WALL_MESSAGE || $title->getText() <= 0  ) {
			return null;
		}

		$mainTitle = Title::newFromId( $title->getText() );

		if ( empty( $mainTitle ) ) {
			return null;
		}

		$dbKey = $mainTitle->getDBkey();

		$helper = new WallHelper();
		if ( !$helper->isDbkeyFromWall( $dbKey ) ) {
			return null;
		}

		return $mainTitle;
	}
}
