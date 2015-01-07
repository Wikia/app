<?php
/**
 * @package Wikia\extensions\WikiaInYourLang
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

class WikiaInYourLangController extends WikiaController {

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
		$sNativeWikiDomain = $this->getNativeWikiDomain( $sWikiDomain, $sTargetLanguage );
		$iNativeWikiId = $this->getWikiIdByDomain( $sNativeWikiDomain );

		/**
		 * If a wikia is found - send a response with its url and sitename.
		 * Send success=false otherwise.
		 */
		if ( $iNativeWikiId > 0 ) {
			$oNativeWiki = WikiFactory::getWikiById( $iNativeWikiId );

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
		}

		/**
		 * Cache the response aggresively
		 */
		$this->response->setCacheValidity( WikiaResponse::CACHE_LONG );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Retrieves a domain (host) from a full URL
	 * @param  string $sCurrentUrl A full URL to parse
	 * @return string              The retrieved domain
	 */
	private function getWikiDomain( $sCurrentUrl ) {
		$aParsed = parse_url( $sCurrentUrl );
		return $aParsed['host'];
	}

	/**
	 * Concats a lang code with a domain
	 * @param  string $sWikiDomain     A domain (host) (e.g. community.wikia.com)
	 * @param  string $sTargetLanguage A lang code (e.g. ja)
	 * @return string                  A native wikia URL (e.g. ja.community.wikia.com)
	 */
	private function getNativeWikiDomain( $sWikiDomain, $sTargetLanguage ) {
		$sNativeWikiDomain = $sTargetLanguage . '.' . $sWikiDomain;
		return $sNativeWikiDomain;
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
