<?
class ForumHelper {
	public static $forumNamespaces = [NS_WIKIA_FORUM_BOARD, NS_WIKIA_FORUM_TOPIC_BOARD, NS_WIKIA_FORUM_BOARD_THREAD];

	private static $isForumCached = null;

	/**
	 * @return bool
	 */
	public static function isForum() {
		global $wgTitle;

		// called to early?
		if ( ( $wgTitle instanceof Title ) === false ) {
			return false;
		}

		// this method can be called 30+ times on each page, cache the result as $wgTitle is not likely to change
		if ( self::$isForumCached === null ) {
			self::$isForumCached = self::isTitleForum( $wgTitle );
		}

		return self::$isForumCached;
	}

	/**
	 * @param Title $title
	 * @return bool
	 */
	private static function isTitleForum( $title ) {
		if ( $title instanceof Title ) {
			if ( $title->isSpecial( 'Forum' ) || in_array( $title->getNamespace(), self::$forumNamespaces ) ) {
				return true;
			} else if ( $title->getNamespace() === NS_USER_WALL_MESSAGE ) {
				$mainTitle = Title::newFromID( $title->getText() );
				/*
				 * if we visit the thread using Thread:xxxxx url, $title's namespace is 1201 for both, wall and forum
				 * threads. But when we create new title from it using newFromId, we're able to distinguish those two
				 */
				if ( $mainTitle instanceof Title ) {
					return in_array( $mainTitle->getNamespace(), self::$forumNamespaces );
				}
			}
		}
		return false;
	}
}
