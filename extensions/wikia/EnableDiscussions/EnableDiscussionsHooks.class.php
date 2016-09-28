<?php


class EnableDiscussionsHooks {

	const DISCUSSIONS_URL = '/d/f';
	const DISCUSSIONS_FORUM_URL = '/d/f/';
	const DISCUSSIONS_POST_URL = '/d/p/';
	// Forum namespaces should be available
	// because both Forum.setup and ForumDisabled.setup define them
	private static $forumNamespaces = [
		NS_WIKIA_FORUM_BOARD,
		NS_WIKIA_FORUM_TOPIC_BOARD,
		NS_WIKIA_FORUM_BOARD_THREAD,
	];


	public static function onBeforeInitialize(
		Title $title = null, $unused, OutputPage $output = null, $user, $request, $mediaWiki
	) {
		if ( !self::shouldRedirectToDiscussions() || $title == null ) {
			return true;
		}
		$forumTitle = self::getForumTitle( $title );
		if ( empty( $forumTitle ) ) {
			return true;
		}

		$url = self::getDiscussionsUrl( $forumTitle->getNamespace(), $forumTitle->getArticleID() );
		$output->redirect( $url );

		return false;
	}

	/**
	 * @return bool
	 */
	private static function shouldRedirectToDiscussions() {
		global $wgEnableForumExt, $wgEnableDiscussions;

		return empty( $wgEnableForumExt ) && $wgEnableDiscussions;
	}

	/**
	 * @param $title
	 * @return null|Title
	 */
	public static function getForumTitle( Title $title ) {
		if ( $title->isSpecial( 'Forum' ) ||
		     in_array( $title->getNamespace(), self::$forumNamespaces )
		) {
			return $title;
		}
		if ( $title->getNamespace() === NS_USER_WALL_MESSAGE ) {
	        // if we visit the thread using Thread:xxxxx url
			// title's namespace is NS_USER_WALL_MESSAGE for both, wall and forum threads.
			// But when we create new title from it using newFromId we can distinguish those two
			$mainTitle = Title::newFromID( $title->getText() );
			if ( $mainTitle instanceof Title &&
			     in_array( $mainTitle->getNamespace(), self::$forumNamespaces )
			) {
				return $mainTitle;
			}
		}
		if ( $title->getNamespace() === NS_MAIN ) {
			// For paths like Board:Fun_And_Games getArticleID has to be used
			$mainTitle = Title::newFromID( $title->getArticleID() );
			if ( $mainTitle instanceof Title &&
			     in_array( $mainTitle->getNamespace(), self::$forumNamespaces )
			) {
				return $mainTitle;
			}
		}

		return null;
	}

	private static function getDiscussionsUrl( $namespace, $id ) {
		if ( empty( $id ) ) {
			return self::DISCUSSIONS_URL;
		}
		if ( $namespace == NS_WIKIA_FORUM_TOPIC_BOARD || $namespace == NS_WIKIA_FORUM_BOARD ) {
			return self::DISCUSSIONS_FORUM_URL . $id;
		}
		if ( $namespace == NS_WIKIA_FORUM_BOARD_THREAD ) {
			return self::DISCUSSIONS_POST_URL . $id;
		}

		return self::DISCUSSIONS_URL;
	}

}
