<?php

class SpecialForumRedirectController extends WikiaSpecialPageController {

	const DISCUSSIONS_LINK = '/d/f';

	private $legacyRedirect;

	public function __construct() {
		parent::__construct( 'Forum', '', false );

		$this->legacyRedirect = new LegacyRedirect( F::App()->wg->CityId );
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
		// No template for this, we're only interested in setting the redirect.
		$this->skipRendering();

		$boardId = $this->getBoardId();
		$redirectUrl = $this->legacyRedirect->getBoardRedirect( $boardId );

		if ( empty( $redirectUrl ) ) {
			// If there's any problem, just redirect to main discussion page
			$redirectUrl = self::DISCUSSIONS_LINK;
		}

		$this->response->redirect( $redirectUrl );
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

		$legacyRedirect = new LegacyRedirect( F::App()->wg->CityId );
		$redirectUrl = $legacyRedirect->getThreadRedirect( $threadId );

		if ( empty( $redirectUrl ) ) {
			// If there's any problem, just redirect to main discussion page
			$redirectUrl = self::DISCUSSIONS_LINK;
		}

		F::app()->wg->Out->redirect( $redirectUrl );
	}

	private function getDiscussionUrl() {
		return self::DISCUSSIONS_LINK;
	}

	private function getBoardId() {
		return $this->wg->Title->getArticleID();
	}

	/**
	 * @param Article $article
	 *
	 * @return bool
	 */
	public static function onBeforePageHistory( Article $article ): bool {
		self::redirectPage( $article );
		return true;
	}

	/**
	 * @param Article $article
	 * @param bool $outputDone
	 * @param bool $useParserCache
	 *
	 * @return bool
	 */
	public static function onArticleViewHeader(
		Article $article, bool &$outputDone, bool &$useParserCache
	): bool {
		self::redirectPage( $article );

		return true;
	}

	private static function redirectPage( Article $article ) {
		$title = self::getRedirectableForumTitle( $article );
		if ( empty( $title ) ) {
			return;
		}

		// Redirect to discussions
		self::redirectThreadToPost( $title );
	}

	/**
	 * Given an Article, return the actual title of a Forum thread if it exists.  If this isn't
	 * a Forum thread or doesn't have a valid title, return null.
	 *
	 * @param Article $article
	 *
	 * @return null|Title
	 */
	public static function getRedirectableForumTitle( Article $article ) {
		$mainTitle = self::getMainTitle( $article );
		if ( empty( $mainTitle ) ) {
			return null;
		}

		// Ignore non-forum board threads.  This allows MessageWall to display properly
		if ( !$mainTitle->inNamespace( NS_WIKIA_FORUM_BOARD_THREAD ) ) {
			return null;
		}

		return $mainTitle;
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
