<?php

use GuzzleHttp\Client;
use Wikia\Factory\ServiceFactory;

class DiscussionImagesController extends WikiaController {
	/** @var DiscussionGateway $gateway */
	private $gateway;

	public function __construct() {
		parent::__construct();

		$discussionsServiceUrl = ServiceFactory::instance()
			->providerFactory()
			->urlProvider()
			->getUrl( 'discussion' );

		$this->gateway = new DiscussionGateway( new Client(), $discussionsServiceUrl, $this->wg->CityId );
	}

	public function init() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	public function uploadImage(): void {
		$request = $this->getContext()->getRequest();
		$user = $this->getContext()->getUser();

		if ( !$user->isAllowed( 'posts:create' ) ||
			 $user->isBlocked() ||
			 !$user->isAllowed( 'read' )
		) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$upload = $request->getUpload( 'data' );
		$context = $request->getVal( 'context', '' );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->uploadImage( $user->getId(), $context, $upload );

		$this->response->setData( $body );
		$this->response->setCode( $statusCode );
	}
}
