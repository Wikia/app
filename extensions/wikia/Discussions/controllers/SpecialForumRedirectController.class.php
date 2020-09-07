<?php

class SpecialForumRedirectController extends WikiaSpecialPageController {

	const DISCUSSIONS_LINK = '/f';

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
		global $wgScriptPath;

		$this->response->redirect( $wgScriptPath . self::DISCUSSIONS_LINK );
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
		global $wgScriptPath;

		// No template for this, we're only interested in setting the redirect.
		$this->skipRendering();

		$boardId = $this->getBoardId();
		$redirectUrl = $this->legacyRedirect->getBoardRedirect( $boardId );

		if ( empty( $redirectUrl ) ) {
			// If there's any problem, just redirect to main discussion page
			$redirectUrl = self::DISCUSSIONS_LINK;
		}

		$this->response->redirect( $wgScriptPath . $redirectUrl );
	}

	/**
	 * Redirect requests for a thread to discussions, e.g. from:
	 *
	 *   https://terrabattle.wikia.com/wiki/Thread:xxx
	 * or
	 *   https://terrabattle.wikia.com/wiki/Board_Thread:yyy/@comment-x.x.x.x-xxx
	 * or
	 *   https://terrabattle.wikia.com/wiki/Board_Thread:yyy/@comment-x.x.x.x-xxx/@comment-x.x.x.x-xxx
	 *
	 * to:
	 *
	 *   https://terrabattle.wikia.com/d/p/zzz
	 *
	 * @param Title $thread
	 */
	public static function redirectThreadToPost( Title $thread ) {
		global $wgScriptPath;

		$threadId = $thread->getArticleID();

		$legacyRedirect = new LegacyRedirect( F::App()->wg->CityId );
		$redirectUrl = $legacyRedirect->getThreadRedirect( $threadId );

		if ( empty( $redirectUrl ) ) {
			// If there's any problem, just redirect to main discussion page
			$redirectUrl = self::DISCUSSIONS_LINK;
		}

		F::app()->wg->Out->redirect( $wgScriptPath . $redirectUrl );
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

		if ( $title->inNamespace( NS_WIKIA_FORUM_BOARD_THREAD ) ) {
			// /wiki/Board_Thread:xxx/@comment-xxx
			// and /wiki/Board_Thread:xxx/@comment-xxx/@comment-xxx
			return self::getTitleForForumBoardThread( $title );
		}

		// /wiki/Thread:xxx
		return self::getTitleForWallMessage( $title );
	}

	private static function getTitleForForumBoardThread( Title $title ): Title {
		if ( self::isThreadReply( $title->getDBkey() ) ) {
			$title = Title::makeTitle( NS_WIKIA_FORUM_BOARD_THREAD, $title->getBaseText() );
		}

		return $title;
	}

	public static function isThreadReply( string $dbkey ): bool {
		$lookFor = explode( '/@' , $dbkey );

		// Board_Thread:xxx/@comment-xxx/@comment-xxx
		if ( count( $lookFor ) > 2 ) {
			return true;
		}
		return false;
	}

	private static function getTitleForWallMessage( Title $title ) {
		$titleText = $title->getText();

		if ( $title->getNamespace() != NS_USER_WALL_MESSAGE || intval( $titleText ) <= 0 ) {
			return null;
		}

		$mainTitle = Title::newFromId( $titleText );

		if ( empty( $mainTitle ) ) {
			return null;
		}

		if ( !( new WallHelper() )->isDbkeyFromWall( $mainTitle->getDBkey() ) ) {
			return null;
		}

		return $mainTitle;
	}
}
