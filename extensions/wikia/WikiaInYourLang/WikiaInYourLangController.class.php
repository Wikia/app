<?php

class WikiaInYourLangController extends WikiaController {

	public function getNativeWikiaInfo() {
		wfProfileIn( __METHOD__ );
		if ( !$this->checkRequest() ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		global $wgExternalSharedDB;

		$sCurrentUrl = $this->request->getVal( 'currentUrl' );
		$sTargetLanguage = $this->request->getVal( 'targetLanguage' );

		$sTargetUrl = $this->convertWikiUrl( $sCurrentUrl, $sTargetLanguage );

		$oDB = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$oRes = $oDB->select(
			'`city_list`',
			[ '`city_url`', '`city_title`' ],
			[ 'city_url' => $sTargetUrl ],
			__METHOD__,
			[ 'LIMIT' => 1 ]
		);

		if ( $oRes->numRows() > 0 ) {
			while( $oRow = $oDB->fetchObject( $oRes ) ) {
				$this->response->setVal( 'success', true );
				$this->response->setVal( 'wikiaUrl', $oRow->city_url );
				$this->response->setVal( 'wikiaSitename', $oRow->city_title );
			}
		} else {
			$this->response->setVal( 'success', false );
		}

		$this->response->setCacheValidity( WikiaResponse::CACHE_LONG );

		wfProfileOut( __METHOD__ );
	}

	private function convertWikiUrl( $sCurrentUrl, $sTargetLanguage ) {
		$regExp = "/(http:\/\/)([a-z]{2}\.)?(.*)/";
		$aRes = [];
		preg_match( $regExp, $sCurrentUrl, $aRes );
		$sTargetUrl = $aRes[1] . $sTargetLanguage . '.' . $aRes[3];
		return $sTargetUrl;
	}

	private function checkRequest() {
		if ( !$this->request->wasPosted() ) {
			$this->response->setVal( 'success', false );
			return false;
		}
		return true;
	}
}
