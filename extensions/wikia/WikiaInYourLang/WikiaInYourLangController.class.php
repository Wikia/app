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
		if ( !$this->checkRequest() ) {
			wfProfileOut( __METHOD__ );
			return;
		}
		
		global $wgExternalSharedDB;

		/**
		 * wgServer value of the posting wikia
		 * @var string
		 */
		$sCurrentUrl = $this->request->getVal( 'currentUrl' );
		/**
		 * The language code from a user's Geo cookie
		 * @var string
		 */
		$sTargetLanguage = $this->request->getVal( 'targetLanguage' );

		$sTargetUrl = $this->convertWikiUrl( $sCurrentUrl, $sTargetLanguage );
		$oDB = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$oRes = $this->getWikiByUrl( $sTargetUrl, $oDB );

		/**
		 * If a wikia is found - send a response with its url and sitename
		 */
		if ( $oRes->numRows() > 0 ) {
			while( $oRow = $oDB->fetchObject( $oRes ) ) {
				$this->response->setVal( 'success', true );
				$this->response->setVal( 'wikiaUrl', $oRow->city_url );
				$this->response->setVal( 'wikiaSitename', $oRow->city_title );
			}
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
	 * Selects a wikia from city_list by a city_url matching $sTargetUrl
	 * @param  string        $sTargetUrl  A url of the native wikia
	 * @param  DatabaseMysql $oDB         Shared database object
	 * @return ResultWrapper $oRes
	 */
	private function getWikiByUrl( $sTargetUrl, DatabaseMysql $oDB ) {
		$oRes = $oDB->select(
			'`city_list`',
			[ '`city_url`', '`city_title`' ],
			[ 'city_url' => $sTargetUrl ],
			__METHOD__,
			[ 'LIMIT' => 1 ]
		);
		return $oRes;
	}

	/**
	 * Converts a $wgServer value of the posting wikia to its localized version
	 * @param  string $sCurrentUrl     The posting wikia's wgServer value
	 * @param  string $sTargetLanguage The language code from user's Geo cookie
	 * @return string  A localized version of the wgServer url
	 */
	private function convertWikiUrl( $sCurrentUrl, $sTargetLanguage ) {
		$regExp = "/(http:\/\/)([a-z]{2}\.)?(.*)/";
		$aRes = [];
		preg_match( $regExp, $sCurrentUrl, $aRes );
		$sTargetUrl = $aRes[1] . $sTargetLanguage . '.' . $aRes[3];
		return $sTargetUrl;
	}

	/**
	 * Checks if it's the request was actually posted
	 * @return bool
	 */
	private function checkRequest() {
		if ( !$this->request->wasPosted() ) {
			$this->response->setVal( 'success', false );
			return false;
		}
		return true;
	}
}
