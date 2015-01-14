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
		wfProfileIn( __METHOD__ );
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
		 * The language code for the wfMessage
		 * @var string
		 */
		$sTargetLanguage = $this->request->getVal( 'targetLanguage' );

		/**
		 * Steps to get the native wikia's ID:
		 * 1. Retrieve a source domain from the passed wgServer value (e.g. community.wikia.com)
		 * 2. Concat it with the target language ( e.g. ja.community.wikia.com )
		 * 3. Get the native wikia's ID from the city_domains table
		 */
		$sWikiDomain = $this->getWikiDomain( $sCurrentUrl );
		if ( $sWikiDomain !== false ) {
			$sNativeWikiDomain = $this->getNativeWikiDomain( $sWikiDomain, $sTargetLanguage );
			$iNativeWikiId = $this->getWikiIdByDomain( $sNativeWikiDomain );

			/**
			 * If a wikia is found - send a response with its url and sitename.
			 * Send success=false otherwise.
			 */
			if ( $iNativeWikiId > 0 ) {
				$oNativeWiki = WikiFactory::getWikiById( $iNativeWikiId );

				// Check for false-positives - see CE-1216
				if ( $oNativeWiki->city_lang == $sTargetLanguage ) {
					$aMessageParams = [
						$sCurrentSitename,
						$oNativeWiki->city_url,
						$oNativeWiki->city_title,
					];

					$sMessage = $this->prepareMessage( $sTargetLanguage, $aMessageParams );
					$this->response->setVal( 'success', true );
					$this->response->setVal( 'message', $sMessage );
				} else {
					$this->response->setVal( 'success', false );
					$this->response->setVal( 'error', "A native wikia with a domain {$sNativeWikiDomain} matches the original." );
				}
			} else {
				$this->response->setVal( 'success', false );
				$this->response->setVal( 'error', "A native wikia with a domain {$sNativeWikiDomain} not found." );
			}
		} else {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'error', 'An invalid URL passed for parsing.' );
		}

		/**
		 * Cache the response aggresively
		 */
		$this->response->setCacheValidity( WikiaResponse::CACHE_LONG );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Retrieves a domain (host) from a full URL
	 * Using preg_match to handle all languages
	 * e.g. get pad.wikia.com from zh.pad.wikia.com
	 * @param  string $sCurrentUrl A full URL to parse
	 * @return string              The retrieved domain
	 */
	public function getWikiDomain( $sCurrentUrl ) {
		$aParsed = parse_url( $sCurrentUrl );
		// Assume false
		$sWikiDomain = false;

		if ( isset( $aParsed['host'] ) ) {
			$sHost = $aParsed['host'];
			$regExp = "/(sandbox.{3}\.|preview\.|verify\.)?(([a-z]{2,3}|[a-z]{2}\-[a-z]{2})\.)?([^\.]+\.)(.*)/i";
			/**
			 * preg_match returns similar array as a third parameter:
			 * [
			 * 	0 => sandbox-s3.zh.example.wikia.com,
			 * 	1 => (sandbox-s3. | preview. | verify. | empty)
			 * 	2 => (zh. | empty),
			 * 	3 => (zh | empty),
			 * 	4 => example.
			 * 	5 => ( wikia.com | adamk.wikia-dev.com )
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
				$sWikiDomain = $aMatches[4] . self::WIKIAINYOURLANG_WIKIA_DOMAIN;
			}
		}

		return $sWikiDomain;
	}

	/**
	 * Concats a lang code with a domain
	 * @param  string $sWikiDomain     A domain (host) (e.g. community.wikia.com)
	 * @param  string $sTargetLanguage A lang code (e.g. ja)
	 * @return string                  A native wikia URL (e.g. ja.community.wikia.com)
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
	 * @return int                  A wikia's ID or 0 if not found.
	 */
	private function getWikiIdByDomain( $sWikiDomain ) {
		$oDB = wfGetDB( DB_SLAVE, array(), $this->wg->ExternalSharedDB );

		$oRow = $oDB->selectRow(
			'`city_domains`',
			[ '`city_id`' ],
			[ 'city_domain' => $sWikiDomain ],
			__METHOD__
		);

		if ( $oRow !== false ) {
			return $oRow->city_id;
		} else {
			return 0;
		}
	}

	private function prepareMessage( $sTargetLanguage, $aMessageParams ) {
		$sMsg = wfMessage( 'wikia-in-your-lang-available' )
			->params( $aMessageParams )
			->inLanguage( $sTargetLanguage )
			->parse();

		return $sMsg;
	}
}
