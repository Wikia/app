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
	public static function getFilePageRedirect( Title $title ) {
		global $wgMemc;

		//fallback to main page
		$url = Title::newMainPage()->getFullURL();
		//wiki needs read privileges
		if ( !$title->userCan( 'read' ) ) {
			return $url;
		}
		$redirKey = wfMemcKey( 'redir', $title->getPrefixedText() );

		$img = wfFindFile( $title );
		if ( !$img ) {
			$img = wfLocalFile( $title );
		}

		if ( !$img || $img && !$img->exists() ) {
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
				$ImageTitle = Title::newFromRow( $row );
				if ( $ImageTitle->isRedirect() ) {
					continue;
				}
				if ( !$ImageTitle->userCan( 'read' ) ) {
					continue;
				}
				$url = $ImageTitle->getFullURL();
				break;
			}
		}
		if ( $url === Title::newMainPage()->getFullURL() ) {
			$url = wfAppendQuery($url, [
				'file' => $title->getText()
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
