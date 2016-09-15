<?

class DiscussionsHelper {

	/**
	 * @return bool
	 */
	public static function areForumsArchivedAndDiscussionsEnabled() {
		return true;
//		global $wgArchiveWikiForums, $wgEnableDiscussions;
//
//
//		return $wgArchiveWikiForums && $wgEnableDiscussions;
	}

	public static function getTitle(Title $title) {
		if ( $title->isSpecial( 'Forum' ) ||
		     in_array( $title->getNamespace(), ForumHelper::$forumNamespaces )
		) {
			return $title;
		}

		if ( $title->getNamespace() === NS_USER_WALL_MESSAGE ) {
			$mainTitle = Title::newFromID( $title->getText() );
			/*
			 * if we visit the thread using Thread:xxxxx url, $wgTitle's namespace is 1201 for both, wall and forum
			 * threads. But when we create new title from it using newFromId, we're able to distinguish those two
			 */
			if ( $mainTitle instanceof Title && in_array( $mainTitle->getNamespace(), ForumHelper::$forumNamespaces )) {
				return $title;
			}
		}

		return null;
	}

	private static function redirectToDiscussions() {
		return '/d';
	}

	private static function redirectToDiscussionsCategory( $categoryId ) {
		if ( !empty( $categoryId ) ) {
			return '/d/f/' . $categoryId;
		} else {
			return self::redirectToDiscussions();
		}
	}

	private static function redirectToDiscussionsPost( $postId ) {
		if ( !empty( $categoryId ) ) {
			return '/d/p/' . $postId;
		} else {
			return self::redirectToDiscussions();
		}
	}

	public static function getDiscussionsUrl(
		Title $title
	) {
		$namespace = $title->getNamespace();
		$t = Title::newFromText( $title->getText() );
		$id = $t->getArticleID();

		if ( $namespace == NS_WIKIA_FORUM_TOPIC_BOARD ) {
			return DiscussionsHelper::redirectToDiscussionsCategory( $id );
		}
		if ( $namespace == NS_WIKIA_FORUM_BOARD ) {
			return DiscussionsHelper::redirectToDiscussionsCategory( $id );
		}
		if ( $namespace == NS_WIKIA_FORUM_BOARD_THREAD ) {
			return DiscussionsHelper::redirectToDiscussionsPost( $id );
		}
		return self::redirectToDiscussions();
	}

}
