<?php

use Wikia\Logger\Loggable;

class AnnotateWikiNotSpamController extends WikiaController {

	use Loggable;

	const WIKI_ID = 'wikiId';
	const REASON = 'reason';
	const USER_ID = 'reviewingUserId';

	public function init() {
		$this->assertCanAccessController();
	}

	public function annotateNotSpam() {
		$context = $this->getContext();
		$request = $context->getRequest();

		$wikiId = $request->getVal( self::WIKI_ID );
		$reason = $request->getVal( self::REASON );
		$userId = $request->getVal( self::USER_ID );

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		if ( !is_numeric( $wikiId ) || empty( $reason ) || !is_numeric( $userId)) {
			// No wikiId, userId or reason given: Bad Request
			$this->response->setCode( 400 );
			$this->info('no wikiId or reason parameter in request');
		} else {
			$user = User::newFromId($userId);
			$res = WikiFactory::log( WikiFactory::LOG_STATUS, $reason, $wikiId, null,  $user);
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