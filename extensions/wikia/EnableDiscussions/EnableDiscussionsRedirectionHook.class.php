<?php


class EnableDiscussionsRedirectionHook {

	const DISCUSSIONS_URL = '/d/f';
	// Forum namespaces should be available
	// because both Forum.setup and ForumDisabled.setup define them
	private static $forumNamespaces = [
		NS_WIKIA_FORUM_BOARD,
		NS_WIKIA_FORUM_TOPIC_BOARD,
		NS_WIKIA_FORUM_BOARD_THREAD,
	];


	public static function onBeforeInitialize(
		Title $title = null, $unused, OutputPage $output = null, User $user = null,
		WebRequest $request = null, MediaWiki $mediaWiki
	) {
		if ( !self::shouldRedirectToDiscussions() || $title == null ) {
			return true;
		}
		$forumTitle = self::getForumTitle( $title );
		if ( empty( $forumTitle ) ) {
			return true;
		}

		$output->redirect( self::getDiscussionsUrl( $forumTitle->getNamespace(),
			$forumTitle->getArticleID() ) );

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
			$mainTitle = Title::newFromID( $title->getText() );
			/*
			 * if we visit the thread using Thread:xxxxx url, $wgTitle's namespace is 1201 for both, wall and forum
			 * threads. But when we create new title from it using newFromId, we're able to distinguish those two
			 */
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
		if ( $namespace == NS_WIKIA_FORUM_TOPIC_BOARD || NS_WIKIA_FORUM_BOARD ) {
			return '/d/f/' . $id;
		}
		if ( $namespace == NS_WIKIA_FORUM_BOARD_THREAD ) {
			return '/d/p/' . $id;
		}

		return self::DISCUSSIONS_URL;
	}

}
