<?php

use Wikia\Logger\Loggable;

class MarkWikiAsClosedController extends WikiaController {

	use Loggable;

	const WIKI_ID = 'wikiId';
	const REASON = 'reason';

	public function init() {
		$this->assertCanAccessController();
	}

	public function markWikiAsClosed() {
		$context = $this->getContext();
		$request = $context->getRequest();

		$wikiId = $request->getVal( self::WIKI_ID );
		$reason = $request->getVal( self::REASON );

		if ( is_null( $wikiId ) || is_null( $reason ) ) {
			// No wikiId or reason given: Bad Request
			$this->response->setCode( 400 );
		} else {
			try {
				$res = WikiFactory::setPublicStatus( WikiFactory::CLOSE_ACTION, $wikiId, $reason );
			}
			catch ( Solarium_Client_HttpException $exception ) {
				// This is horrible hack due to Solar not working on dev
				$this->error( "Solar not working properly", [ 'exception' => $exception ] );
			}

			if ( $res === WikiFactory::CLOSE_ACTION ) {
				WikiFactory::setFlags( $wikiId,
					WikiFactory::FLAG_FREE_WIKI_URL | WikiFactory::FLAG_CREATE_DB_DUMP |
					WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE );
				WikiFactory::clearCache( $wikiId );
				$this->response->setCode( 200 );
			} else {
				$this->response->setCode( 500 );
			}
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	/**
	 * Make sure to only allow authorized POST methods.
	 * @throws WikiaHttpException
	 */
	public function assertCanAccessController() {
		if ( !$this->getContext()->getRequest()->isWikiaInternalRequest() ) {
			throw new ForbiddenException( 'Access to this controller is restricted' );
		}
		if ( !$this->getContext()->getRequest()->wasPosted() ) {
			throw new MethodNotAllowedException( 'Only POST allowed' );
		}
	}
}
