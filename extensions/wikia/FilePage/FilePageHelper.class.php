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
	public static function getFilePageRedirect( Title $title , bool $onlyDB) {
		global $wgMemc;

		//fallback to main page
		$url = Title::newMainPage()->getFullURL();
		//wiki needs read privileges
		if ( !$title->userCan( 'read' ) ) {
			return $url;
		}
		$redirKey = wfMemcKey( 'redir', WebRequest::detectProtocol(), $title->getPrefixedText() );

		$img = wfFindFile( $title );
		if ( !$img ) {
			$img = wfLocalFile( $title );
		}

		if ( !$img || $img && !$img->exists() ) {
			$wgMemc->set( $redirKey, $url );
			return $url;
		}

		$urlMem = $wgMemc->get( $redirKey );
		if ( $urlMem && !$onlyDB ) {
			$url = $urlMem;
			return $url;
		}

		$res = self::fetchLinks( $img->getTitle()->getDBkey() );
		if ( $res ) {
			foreach ( $res as $row ) {
				$PageTitle = Title::newFromRow( $row );
				if ( $PageTitle->isRedirect() ) {
					continue;
				}
				if ( !$PageTitle->userCan( 'read' ) ) {
					continue;
				}
				$url = $PageTitle->getFullURL();
				break;
			}
		}
		if ( $url === Title::newMainPage()->getFullURL() ) {
			$url = wfAppendQuery($url, [
				'file' => $title->getText()
			] );
		}
		if( !$onlyDB ) {
			$wgMemc->set( $redirKey, $url );
		}
		return $url;
	}

	/**
	 * Returns list of surrogate keys for purging.
	 *
	 * @requestParam Title
	 *
	 * @return array $keys - surrogate keys to purge
	 */
	public static function getSurrogateKeys( Title $title ) {
		$keys = [];
		$keys[] = self::getRedirSurrogateKey( $title );
		if ( $title->inNamespace( NS_FILE ) ) {
			$url = self::getFilePageRedirect( $title );
			if( isset($url) ){
				$aUrl = explode( "?", $url);
				$aUrl = explode( "/", $aUrl[0]);
				$titleString = array_pop($aUrl);
				$pageTitle = Title::newFromURL($titleString);
				$keys[] = array_merge( $keys, self::getSurrogateKeys( $pageTitle ) );
			}
			$url2 = self::getFilePageRedirect( $title, true );
			if( isset($url2) && $url != $url2 ){
				$aUrl = explode( "?", $url2);
				$aUrl = explode( "/", $aUrl[0]);
				$titleString = array_pop($aUrl);
				$pageTitle = Title::newFromURL($titleString);
				$keys[] = array_merge( $keys, self::getSurrogateKeys( $pageTitle ) );
			}
		}
		return $keys;
	}

	/**
	 * Returns surrogate keys for purging
	 *
	 * @requestParam Title
	 *
	 * @return string $key - surrogate key to purge
	 */
	public static function getRedirSurrogateKey( Title $title ) {
		return 'redirect-' . $title->getPrefixedText();
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

	/**
	 * getFileLinks get links to material
	 *
	 * @param $id Int: page_id value of the page being deleted
	 *
	 * @return ResultWrapper -  image links
	 */
	public static function getFileLinks( $id ) {
		$dbr = wfGetDB( DB_SLAVE );

		return $dbr->select(
			[ 'imagelinks' ],
			[ 'il_to' ],
			[ 'il_from' => $id ],
			__METHOD__,
			[ 'ORDER BY' => 'il_to', ] );
	}
}
