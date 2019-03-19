<?

class FilePageHelper {

	public static function stripCategoriesFromDescription( $content ) {
		// Strip out the category tags so they aren't shown to the user
		$content = preg_replace( '/\[\[Category[^\]]+\]\]/', '', $content );

		// If we have an empty string or a bunch of whitespace, return null
		if ( trim( $content ) == "" ) {
			$content = null;
		}

		return $content;
	}

	/**
	 * Returns an url when file needs to be redirected.
	 *
	 * @param Title $title - page title object
	 * @param bool $onlyDB - ignore memcache and fetch based on db
	 *
	 * @return string $purl - prefixedText to redirect to
	 */
	public static function getFilePageRedirectUrl( Title $title, bool $onlyDB = false ) {
		global $wgRedirectFilePagesForAnons;
		if ( !$wgRedirectFilePagesForAnons ) {
			return "";
		}
		$prefixedText = self::getFilePageRedirectPrefixedText( $title, $onlyDB );
		if ( $prefixedText == "" ) {
			\Wikia\Logger\WikiaLogger::instance()->warning( __FUNCTION__, [
				'key' => "empty",
			] );
			return "";
		}
		$redirTitle = Title::newFromText( $prefixedText );
		$url = $redirTitle->getFullURL();
		if( Title::newMainPage()->getPrefixedText() == $prefixedText ){
			$url = wfAppendQuery( $url, [
				'file' => $title->getText(),
			] );
		}
		\Wikia\Logger\WikiaLogger::instance()->debugSampled( __FUNCTION__, [
			'url' => $url,
			'prefix' => $prefixedText,
			'key' => wfMemcKey( 'redirprefix', WebRequest::detectProtocol(), $title->getPrefixedText() ),
		] );
		return $url;
	}

	/**
	 * Returns an url when file needs to be redirected.
	 *
	 * @param Title $title - page title object
	 * @param bool $onlyDB - ignore memcache and fetch based on db
	 *
	 * @return string $prefixedText - prefixedText to redirect to
	 */
	public static function getFilePageRedirectPrefixedText( Title $title, bool $onlyDB = false ) {
		global $wgMemc;

		//fallback to main page
		$prefixedText = Title::newMainPage()->getPrefixedText();
		//wiki needs read privileges
		if ( !$title->userCan( 'read' ) ) {
			return $prefixedText;
		}
		$redirKey = wfMemcKey( 'redirprefix', WebRequest::detectProtocol(), $title->getPrefixedText() );

		$img = wfFindFile( $title );
		if ( !$img ) {
			$img = wfLocalFile( $title );
		}

		if ( !$img || $img && !$img->exists() ) {
			$wgMemc->set( $redirKey, $prefixedText );

			return $prefixedText;
		}

		if ( !$onlyDB ) {
			$urlMem = $wgMemc->get( $redirKey );
			if ( $urlMem ) {
				$prefixedText = $urlMem;

				return $prefixedText;
			}
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
				$prefixedText = $PageTitle->getPrefixedText();
				break;
			}
		}
		if ( !$onlyDB ) {
			$wgMemc->set( $redirKey, $prefixedText );
		}

		return $prefixedText;
	}

	/**
	 * Returns list of surrogate keys for purging.
	 *
	 * @param Title
	 *
	 * @return array $keys - surrogate keys to purge
	 */
	public static function getSurrogateKeys( Title $title ) {
		$keys = [];
		$keys[] = self::getRedirSurrogateKey( $title );
		if ( $title->inNamespace( NS_FILE ) ) {
			$prefixedText = self::getFilePageRedirectPrefixedText( $title );
			if ( isset( $prefixedText ) ) {
				$pageTitle = Title::newFromText( $prefixedText );
				if ( $pageTitle ) {
					$keys = array_merge( $keys, self::getSurrogateKeys( $pageTitle ) );
				}
			}
			$prefixedTextFromDB = self::getFilePageRedirectPrefixedText( $title, true );
			if ( isset( $prefixedTextFromDB ) && $prefixedText != $prefixedTextFromDB ) {
				$pageTitle = Title::newFromText( $prefixedTextFromDB );
				if ( $pageTitle ) {
					$keys = array_merge( $keys, self::getSurrogateKeys( $pageTitle ) );
				}
			}
		}

		return $keys;
	}

	/**
	 * Returns surrogate keys for purging
	 *
	 * @param Title
	 *
	 * @return string $key - surrogate key to purge
	 */
	protected static function getRedirSurrogateKey( Title $title ) {
		return Wikia::surrogateKey( 'redirect', $title->getPrefixedText() );
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

		return $dbr->select( [ 'imagelinks' ], [ 'il_to' ], [ 'il_from' => $id ], __METHOD__,
			[ 'ORDER BY' => 'il_to', ] );
	}
}
