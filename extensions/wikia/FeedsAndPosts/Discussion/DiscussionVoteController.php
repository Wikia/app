<?php

use GuzzleHttp\Client;
use Wikia\Factory\ServiceFactory;
use Wikia\FeedsAndPosts\Discussion\DiscussionGateway;

class DiscussionVoteController extends \WikiaController {
	/*** @var DiscussionGateway */
	private $gateway;

	public function __construct() {
		parent::__construct();

		$discussionsServiceUrl = ServiceFactory::instance()->providerFactory()->urlProvider()->getUrl( 'discussion' );

		$this->gateway = new DiscussionGateway(
			new Client(),
			$discussionsServiceUrl,
			$this->wg->CityId
		);
	}

	public function init() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	public function upVotePost(): void {
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_METHOD_NOT_ALLOWED );
			return;
		}

		$user = $this->getContext()->getUser();

		if ( !$user->isAllowed( "posts:vote" ) || $user->isBlocked() || !$user->isAllowed( 'read' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$postId = $this->request->getVal( 'postId' );
		$traceHeaders = $this->getUserTraceHeaders( $this->getContext()->getRequest() );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->upVotePost( $postId, $user->getId(), $traceHeaders );

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function downVotePost(): void {
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_METHOD_NOT_ALLOWED );
			return;
		}

		$user = $this->getContext()->getUser();

		if ( !$user->isAllowed( "posts:vote" ) || $user->isBlocked() || !$user->isAllowed( 'read' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$postId = $this->request->getVal( 'postId' );
		$traceHeaders = $this->getUserTraceHeaders( $this->getContext()->getRequest() );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->downVotePost( $postId, $user->getId(), $traceHeaders );

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	private function getUserTraceHeaders( \WebRequest $request ): array {
		return [
			'X-Original-User-Agent' => $request->getHeader( 'user-agent' ) ?? '',
			'Fastly-Client-IP' => $request->getHeader( 'Fastly-Client-IP' ) ?? '',
			'X-GeoIP-City' => $request->getHeader( 'X-GeoIP-City' ) ?? '',
			'X-GeoIP-Region' => $request->getHeader( 'X-GeoIP-Region' ) ?? '',
			'X-GeoIP-Country-Name' => $request->getHeader( 'X-GeoIP-Country-Name' ) ?? '',
			'X-Wikia-WikiaAppsID' => $request->getHeader( 'X-Wikia-WikiaAppsID' ) ?? '',
		];
	}
}
