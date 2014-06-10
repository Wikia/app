<?php

class EvergreensController extends WikiaController {

	public function log() {
		wfProfileIn( __METHOD__ );
		if ( $this->request->wasPosted() ) {
			$sHeaderInfo = $this->request->getVal( 'headerInfo', null );
			if ( $sHeaderInfo && is_string( $sHeaderInfo ) ) {
				$sHash = sha1( $sHeaderInfo );
				$oHeaderInfo = json_decode( $sHeaderInfo );

				if (is_array($oHeaderInfo->response[0]->responseHeaders)
					&& is_array($oHeaderInfo->request[0]->requestHeaders) )
				{

					\Wikia\Logger\WikiaLogger::instance()->info(
						'Evergreens: stale page cache detected',
						[
							'hash' => $sHash,
							'request' => $oHeaderInfo->request[0]->requestHeaders,
							'response' => $oHeaderInfo->response[0]->responseHeaders
						]
					);
				}

				$this->response->setVal( 'hash', $sHash );
			}
		}
		$this->response->setFormat( 'json' );
		wfProfileOut( __METHOD__ );
	}

}
