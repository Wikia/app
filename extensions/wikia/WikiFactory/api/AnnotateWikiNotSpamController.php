<?php

use Wikia\Logger\Loggable;

class AnnotateWikiNotSpamController extends WikiaController {

	use Loggable;

	const WIKI_ID = 'wikiId';
	const REASON = 'reason';

	public function init() {
		$this->assertCanAccessController();
	}

	public function annotateNotSpam() {
		$context = $this->getContext();
		$request = $context->getRequest();

		$wikiId = $request->getVal( self::WIKI_ID );
		$reason = $request->getVal( self::REASON );

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		if ( !is_numeric( $wikiId ) || empty( $reason ) ) {
			// wikiId or reason given: Bad Request
			$this->response->setCode( 400 );
			$this->info('no wikiId or reason parameter in request');
		} else {
			$res = WikiFactory::log( WikiFactory::LOG_STATUS, $reason, $wikiId );
			if ( $res ) {
				$this->response->setCode( 200 );
				return;
			} else {
				$this->response->setCode( 500 );
				$this->info("could not annotate wiki NOT SPAM in MW. Wiki id: " . $wikiId);
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