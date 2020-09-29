<?php

use GuzzleHttp\Client;
use Wikia\Factory\ServiceFactory;
use Wikia\FeedsAndPosts\Discussion\DiscussionGateway;
use Wikia\FeedsAndPosts\Discussion\UserInfoHelper;

class DiscussionPollController extends \WikiaController {

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

	public function castVote(): void {
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_METHOD_NOT_ALLOWED );
			return;
		}

		$user = $this->getContext()->getUser();

		if ( !$user->isAllowed( 'polls:vote' ) || $user->isBlocked() || !$user->isAllowed( 'read' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$pollId = $this->request->getVal( 'pollId' );
		$answerIds = $this->request->getArray( 'answerIds' );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->castPollVote( $pollId, $answerIds, $user->getId() );

		$this->response->setCode( $statusCode == 204 ? 200 : $statusCode );
		$this->response->setData( $body );
	}

	public function getVoters(): void {
		$pollId = $this->request->getVal( 'pollId' );
		$answerId = $this->request->getVal( 'answerId' );

		if ( empty( $pollId ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			$this->response->setVal( 'reason', 'pollId is required query param' );

			return;
		}

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->getPollVoters( $pollId, $answerId );

		if ( isset( $body['users'] ) ) {
			$body['users'] = UserInfoHelper::applyBadges( $body['users'] );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}
}
