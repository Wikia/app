<?php

use Wikia\Logger\Loggable;

class MarkWikiAsClosedController extends WikiaController {

	use Loggable;

	const WIKI_ID = 'wikiId';
	const USER_ID = 'reason';

	public function init() {
		$this->assertCanAccessController();
	}

	public function markWikiAsClosed() {
		global $wgUser;

		$context = $this->getContext();
		$request = $context->getRequest();

		$wikiId = $request->getVal( self::WIKI_ID );
		$reason = $request->getVal( self::REASON );
		$userId = $request->getVal( self::USER_ID );

		$wgUser = User::newFromId($userId);

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		if ( !is_numeric( $wikiId ) || empty( $reason ) ) {
			// No wikiId or reason given: Bad Request
			$this->response->setCode( 400 );
			$this->info('no wikiId or reason parameter in request');
		} else {
			$res = WikiFactory::setPublicStatus( WikiFactory::CLOSE_ACTION, $wikiId, $reason);

			if ( $res === WikiFactory::CLOSE_ACTION ) {
				WikiFactory::setFlags( $wikiId,
					WikiFactory::FLAG_FREE_WIKI_URL | WikiFactory::FLAG_CREATE_DB_DUMP |
					WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE );
				WikiFactory::clearCache( $wikiId );
				$this->response->setCode( 200 );

				return;
			} else {
				$this->response->setCode( 500 );
				$this->info("could not mark Wiki to be closed in MW. Wiki id: " . $wikiId);

				return;
			}
		}
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
