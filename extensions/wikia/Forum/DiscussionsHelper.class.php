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

	public static function redirectToDiscussions() {
		return '/d';
	}

	public static function redirectToDiscussionsCategory( $categoryId ) {
		if ( !empty( $categoryId ) ) {
			return '/d/f/' . $categoryId;
		} else {
			return self::redirectToDiscussions();
		}
	}

	public static function redirectToDiscussionsPost( $postId ) {
		if ( !empty( $categoryId ) ) {
			return '/d/p/' . $postId;
		} else {
			return self::redirectToDiscussions();
		}
	}

}
