<?

class FilePageHelper {

	public static function stripCategoriesFromDescription( $content ) {
		// Strip out the category tags so they aren't shown to the user
		$content = preg_replace( '/\[\[Category[^\]]+\]\]/', '', $content );

		// If we have an empty string or a bunch of whitespace, return null
		if( trim($content) == "" ) {
			$content = null;
		}

		return $content;
	}

	/**
	 * Returns an url when file needs to be redirected.
	 *
	 * @requestParam Title
	 *
	 * @return string $url - url to redirect to
	 */
	public static function fileRedir(ImagePage $page) {
		global $wgMemc;

		$page = $page->getContext();

		//fallback to main page
		$url = Title::newMainPage()->getFullURL();
		//wiki needs read privileges
		if ( !$page->getTitle()->userCan( 'read' ) ) {
			return $url;
		}
		$redirKey = wfMemcKey( 'redir', $page->getTitle()->getPrefixedText() );

		$displayImg = $img = false;
		Hooks::run( 'ImagePageFindFile', [ $page, &$img, &$displayImg ] );
		if ( !$img ) { // not set by hook?
			$img = wfFindFile( $page->getTitle() );
			if ( !$img ) {
				$img = wfLocalFile( $page->getTitle() );
			}
		}

		if ( !$img || $img && !$img->fileExists ) {
			$wgMemc->set( $redirKey, $url );
			return $url;
		}

		$urlMem = $wgMemc->get( $redirKey );
		if ( $urlMem ) {
			$url = $urlMem;
			return $url;
		}

		$res = self::fetchLinks( $img->getTitle()->getDBkey() );
		if ( $res ) {
			foreach ( $res as $row ) {
				$title = Title::newFromRow( $row );
				if ( $title->isRedirect() ) {
					continue;
				}
				if ( !$title->userCan( 'read' ) ) {
					continue;
				}
				$url = $title->getFullURL();
				break;
			}
		}
		if ( $url === Title::newMainPage()->getFullURL() ) {
			$url = wfAppendQuery($url, [
				'file' => $page->getTitle()->getText()
			] );
		}
		$wgMemc->set( $redirKey, $url );
		return $url;
	}


	/**
	 * Fetch informationabout pages linked to image
	 * @param string $dbKey
	 * @return ResultWrapper -  image links
	 */
	private static function fetchLinks( $dbKey ) {
		$dbr = wfGetDB( DB_SLAVE );

		return $dbr->select( [ 'imagelinks', 'page' ], [
			'page_title',
			'page_namespace',
		], [
			'il_to' => $dbKey,
			'page_is_redirect' => 0,
			'page_namespace' => NS_MAIN,
			'il_from = page_id',
		], __METHOD__, [
			'LIMIT' => 5,
			'ORDER BY' => 'page_namespace, page_id',
		] );
	}
}
