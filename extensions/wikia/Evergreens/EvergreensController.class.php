<?php
/**
 * The controller class for the Evergreens MediaWiki extension.
 *
 * @author Michał ‘Mix’ Roszka <mix@wikia-inc.com>
 * @date Tuesday, 10 June 2014 (created)
 */
class EvergreensController extends WikiaController {

	/**
	 * Logs the data sent by the Evergreens extension for Google Chrome
	 *
	 * In addition, the data are labelled with a hash which is then returned in the response as JSON.
	 */
	public function log() {
		wfProfileIn( __METHOD__ );
		if ( $this->request->wasPosted() ) {


			$sHeaderInfo = $this->request->getVal( 'headerInfo', null );

			// preliminary validation of the input data
			if ( $sHeaderInfo && is_string( $sHeaderInfo ) ) {

				// generate a hash
				$sHash = sha1( $sHeaderInfo );

				// decode, validate and log the data
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

				// add the hash to the response
				$this->response->setVal( 'hash', $sHash );
			}
		}

		$this->response->setFormat( 'json' );
		wfProfileOut( __METHOD__ );
	}

}
