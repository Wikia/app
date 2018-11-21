<?php

use Wikia\Logger\Loggable;

class WikiFounderIpController extends WikiaController {
	use Loggable;
	const PARAMETER_ID = 'id';


	public function init() {
		$this->assertCanAccessController();
	}

	public function getIp() {
		$context = $this->getContext();
		$request = $context->getRequest();

		$id = $request->getVal( self::PARAMETER_ID);

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		if ( empty( $id ) || !is_numeric($id) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			$this->info('no wikiId parameter in request');
			return;
		}

		$wiki = WikiFactory::getWikiByID( $id );
		if ( empty( $wiki ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_NOT_FOUND );
			$this->info("could not get Wiki IP. Wiki id: " . $id);
			return;
		}

		$ip = inet_ntop($wiki->city_founding_ip_bin);

		$this->response->setVal("wiki_ip", $ip);
	}

	/**
	 * Make sure to only allow authorized methods.
	 * @throws WikiaHttpException
	 */
	public function assertCanAccessController() {
		if ( !$this->getContext()->getRequest()->isWikiaInternalRequest() ) {
			throw new ForbiddenException( 'Access to this controller is restricted' );
		}
		if ( $this->getContext()->getRequest()->wasPosted() ) {
			throw new MethodNotAllowedException( 'Only GET allowed' );
		}
	}
}