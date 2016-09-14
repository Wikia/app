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

	public static function redirectToDiscussions( OutputPage $out, WikiaResponse $response ) {
		self::clearBodyAndSetMaxCache( $out );
		$response->redirect( '/d' );
	}

	public static function redirectToDiscussionsCategory(
		OutputPage $out, WikiaResponse $response, $categoryId
	) {
		if ( !empty( $categoryId ) ) {
			self::clearBodyAndSetMaxCache( $out );
			$response->redirect( '/d/f/' . $categoryId );
		} else {
			self::redirectToDiscussions( $out, $response );
		}
	}

	public static function redirectToDiscussionsPost(
		OutputPage $out, WikiaResponse $response, $postId
	) {
		if ( !empty( $categoryId ) ) {
			self::clearBodyAndSetMaxCache( $out );
			$response->redirect( '/d/p/' . $postId );
		} else {
			self::redirectToDiscussions( $out, $response );
		}
	}

	/**
	 * @param OutputPage $out
	 */
	public static function clearBodyAndSetMaxCache( OutputPage $out ) {
		$out->setArticleBodyOnly( true );
		$out->setSquidMaxage( WikiaResponse::CACHE_LONG );
	}
}
