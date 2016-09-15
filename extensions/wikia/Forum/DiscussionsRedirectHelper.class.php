<?
class DiscussionsRedirectHelper {
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

	private static function discussionsUrl() {
		return '/d';
	}

	private static function categoryUrl( $categoryId ) {
		if ( !empty( $categoryId ) ) {
			return '/d/f/' . $categoryId;
		} else {
			return self::discussionsUrl();
		}
	}
	private static function postUrl( $postId ) {
		if ( !empty( $categoryId ) ) {
			return '/d/p/' . $postId;
		} else {
			return self::discussionsUrl();
		}
	}

	private static function getDiscussionsUrl($namespace, $id) {
		if ( $namespace == NS_WIKIA_FORUM_TOPIC_BOARD ) {
			return DiscussionsRedirectHelper::categoryUrl( $id );
		}
		if ( $namespace == NS_WIKIA_FORUM_BOARD ) {
			return DiscussionsRedirectHelper::categoryUrl( $id );
		}
		if ( $namespace == NS_WIKIA_FORUM_BOARD_THREAD ) {
			return DiscussionsRedirectHelper::postUrl( $id );
		}
		return self::discussionsUrl();
	}

	public static function redirect(
		OutputPage $out, WikiaResponse $response
	) {
		self::clearBodyAndSetMaxCache( $out );
		list($namespace, $id) = self::getNamespaceAndId();
		$response->redirect( self::getDiscussionsUrl($namespace, $id) );
	}

	private static function clearBodyAndSetMaxCache( OutputPage $out ) {
		$out->setArticleBodyOnly( true );
		$out->setSquidMaxage( WikiaResponse::CACHE_LONG );
	}

	public static function getNamespaceAndId() {
		$title = self::getTitle();
		if (! empty($title) ) {
			return [$title->getNamespace(), $title->getArticleID() ];
		}
		return [null, null];
	}

	public static function getTitle() {
		global $wgTitle;
		if ( $wgTitle instanceof Title ) {
			if ( $wgTitle->isSpecial( 'Forum' ) || in_array( $wgTitle->getNamespace(),
					ForumHelper::$forumNamespaces ) ) {
				return $wgTitle;
			} else if ( $wgTitle->getNamespace() === NS_USER_WALL_MESSAGE ) {
				return Title::newFromID( $wgTitle->getText() );
			}
		}
		return null;
	}



}
