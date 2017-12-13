<?php
/**
 * @package Wikia\extensions\WikiaInYourLang
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

class WikiaInYourLangController extends WikiaController {

	const WIKIAINYOURLANG_WIKIA_DOMAIN = 'wikia.com';

	/**
	 * Searches the city_list table for the given wikia in the target language.
	 * Takes the currentUrl and targetLanguage parameters from the Request object.
	 */
	public function getNativeWikiaInfo() {
		global $wgWikiaEnvironment;

		wfProfileIn( __METHOD__ );
		/**
		 * Set a default success value to false
		 */
		$this->response->setVal( 'success', false );
		/**
		 * URL of the posting wikia
		 * @var string
		 */
		$sCurrentUrl = $this->wg->Server;
		/**
		 * Name of the posting wikia
		 * @var string
		 */
		$sCurrentSitename = $this->wg->Sitename;
		/**
		 * A language code's core for the wfMessage
		 * @var string
		 */
		$sTargetLanguage = $this->request->getVal( 'targetLanguage' );
		$sArticleTitle = $this->request->getVal( 'articleTitle', false );
		$sInterlangTitle = $this->request->getVal('interlangTitle', null);

		/**
		 * Steps to get the native wikia's ID:
		 * 1. Retrieve a source domain from the passed wgServer value (e.g. community.wikia.com)
		 * 2. Concat it with the target language ( e.g. ja.community.wikia.com )
		 * 3. Get the native wikia's ID from the city_domains table
		 */
		$sWikiDomain = $this->getWikiDomain( $sCurrentUrl );
		if ( $sWikiDomain !== false ) {
			/**
			 * Get native domain and include it in the response
			 */
			$sNativeWikiDomain = $this->getNativeWikiDomain( $sWikiDomain, $sTargetLanguage );
			$this->response->setVal( 'nativeDomain', $sNativeWikiDomain );
			$oNativeWiki = $this->getNativeWikiByDomain( $sNativeWikiDomain );

			/**
			 * If a wikia is found - send a response with its url and sitename.
			 * Send success=false otherwise.
			 */
			if ( is_object( $oNativeWiki ) ) {
				$this->response->setVal( 'linkAddress', $oNativeWiki->city_url );

				/**
				 * Check for false-positives - see CE-1216
				 * Per request we should unify dialects like pt and pt-br
				 * @see CE-1220
				 */
				if ( $this->isNativeWikiaValid( $oNativeWiki, $sTargetLanguage ) ) {
					$aMessageParams = [
						$sCurrentSitename,
						$oNativeWiki->city_url,
						$oNativeWiki->city_title,
					];
					$isMainPageLink = true;
					$articleURL = null;
					if ( $sInterlangTitle && strlen($sInterlangTitle) ) { //If main page, then $sInterlang is ''
						$articleURL = $this->getArticleURL( $sInterlangTitle, $oNativeWiki->city_id );
					} else {
						$articleURL = $this->getArticleURL( $sArticleTitle, $oNativeWiki->city_id );
					}
					if ( $articleURL ) {
						$aMessageParams[1] = $articleURL;
						$this->response->setVal( 'linkAddress', $articleURL );
						$isMainPageLink = false;
					}

					$aMessages = $this->prepareMessage( $sTargetLanguage, $aMessageParams, $isMainPageLink );
					$this->response->setVal( 'success', true );
					$this->response->setVal( 'message', $aMessages['desktop'] );
					$this->response->setVal( 'messageMobile', $aMessages['mobile'] );
				}
			}
		}

		/**
		 * Cache the response for a day
		 */
		$this->response->setCachePolicy( WikiaResponse::CACHE_PUBLIC );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Retrieves a domain (host) from a full URL
	 * Using preg_match to handle all languages
	 * e.g. get pad.wikia.com from zh.pad.wikia.com
	 * @param  string $sCurrentUrl A full URL to parse
	 * @return string The retrieved domain
	 */
	public function getWikiDomain( $sCurrentUrl ) {
		$aParsed = parse_url( $sCurrentUrl );
		// Assume false
		$sWikiDomain = false;

		if ( isset( $aParsed['host'] ) ) {
			$sHost = $aParsed['host'];
			$sHost = preg_replace( '/\.((?:sandbox-.+?|preview|verify)\.)?wikia\.com/i', '.wikia.com', $sHost );
			$regExp = '/(([a-z]{2,3}|[a-z]{2}\-[a-z]{2})\.)?([^\.]+\.)([^\.]+\.)(.*)/i';
			/**
			 * preg_match returns similar array as a third parameter:
			 * [
			 *  0 => sandbox-s3.zh.example.wikia.com,
			 *  1 => (zh. | empty),
			 *  2 => (zh | empty),
			 *  3 => example.
			 *  4 => ( wikia | adamk)
			 *  5 => (com | wikia-dev.com)
			 * ]
			 * [4] is a domain without the language prefix
			 * @var Array
			 */
			$aMatches = [];
			$iMatchesCount = preg_match( $regExp, $sHost, $aMatches );
			/**
			 * Domains are stored only with an original domain - wikia.com
			 * This allows the extension to work on devboxes
			 */
			if ( $iMatchesCount == 1 ) {
				$sWikiDomain = $aMatches[3] . self::WIKIAINYOURLANG_WIKIA_DOMAIN;
			}
		}

		if ( !$sWikiDomain ) {
			$this->response->setVal( 'error', 'An invalid URL passed for parsing.' );
		}
		return $sWikiDomain;
	}

	/**
	 * Concats a lang code with a domain
	 * @param  string $sWikiDomain A domain (host) (e.g. community.wikia.com)
	 * @param  string $sTargetLanguage A lang code (e.g. ja)
	 * @return string A native wikia URL (e.g. ja.community.wikia.com)
	 */
	private function getNativeWikiDomain( $sWikiDomain, $sTargetLanguage ) {
		if ( $sTargetLanguage !== 'en' ) {
			$sNativeWikiDomain = $sTargetLanguage . '.' . $sWikiDomain;
			return $sNativeWikiDomain;
		}
		else {
			return $sWikiDomain;
		}
	}

	/**
	 * Retrieves a wikia's ID from a database using its domain
	 * @param  string $sWikiDomain  A domain (host) (e.g. ja.community.wikia.com)
	 * @return ResultWrapper|bool A wikia's object or false if not found.
	 */
	private function getNativeWikiByDomain( $sWikiDomain ) {
		$oDB = wfGetDB( DB_SLAVE, array(), $this->wg->ExternalSharedDB );

		$oRow = $oDB->selectRow(
			'`city_domains`',
			[ '`city_id`' ],
			[ 'city_domain' => $sWikiDomain ],
			__METHOD__
		);

		if ( $oRow !== false ) {
			$iNativeWikiId = $oRow->city_id;
			$oNativeWiki = WikiFactory::getWikiById( $iNativeWikiId );
			if ( is_object( $oNativeWiki ) ) {
				return $oNativeWiki;
			} else {
				$this->response->setVal( 'error', "A native wikia with id={$iNativeWikiId} not found." );
				return false;
			}
		} else {
			$this->response->setVal( 'error', "A native wikia not found." );
			return false;
		}
	}

	/**
	 * Checks if a native wikia is not:
	 * - closed
	 * - in a different language than the target one
	 * @param object $oWiki A native wikia city_list row
	 * @param string $sTargetLanguage The target language code
	 * @return bool
	 */
	private function isNativeWikiaValid( $oWiki, $sTargetLanguage ) {
		if ( $oWiki->city_public === WikiFactory::CLOSE_ACTION ) {
			$this->response->setVal( 'error', "A native wikia is closed." );
			return false;
		}

		if ( $oWiki->city_lang != $sTargetLanguage ) {
			$this->response->setVal( 'error', "A native wikia matches the original." );
			return false;
		}

		return true;
	}

	private function prepareMessage( $sTargetLanguage, $aMessageParams, $isMainPageLink ) {
		if ( $isMainPageLink ) {
			$sMsg = wfMessage( 'wikia-in-your-lang-available' )
				->params( $aMessageParams )
				->inLanguage( $sTargetLanguage )
				->parse();
		} else {
			$sMsg = wfMessage( 'wikia-in-your-lang-article-available' )
				->params( $aMessageParams )
				->inLanguage( $sTargetLanguage )
				->parse();
		}

		$sMsgMobile = wfMessage( 'wikia-in-your-lang-available-for-mobile' )
			->params( $aMessageParams )
			->inLanguage( $sTargetLanguage )
			->parse();

		return ['desktop' => $sMsg, 'mobile' => $sMsgMobile];
	}

	private function getArticleURL( $sArticleTitle, $cityId ) {
		$sArticleAnchor = null;
		$articleURL = null;

		if ( $sArticleTitle !== false ) {
			$sArticleTitle = str_replace( ' ', '_', $sArticleTitle );
			// `#` is not included in some titles, which breaks string splitting
			// so we want to make sure there are exactly 2 items in array
			list($sArticleTitle, $sArticleAnchor) = array_pad( explode( '#', $sArticleTitle, 2 ), 2, '' );
			$title = GlobalTitle::newFromText( $sArticleTitle, NS_MAIN, $cityId );

			if ( !is_null( $title ) && $title->exists() ) {
				$articleURL = $title->getFullURL();
			}
			if ( $sArticleAnchor ) {
				$articleURL = $articleURL . '#' . $sArticleAnchor;
			}
		}
		return $articleURL;
	}
}
