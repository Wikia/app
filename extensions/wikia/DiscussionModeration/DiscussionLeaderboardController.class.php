<?php

use GuzzleHttp\Client;
use Wikia\Factory\ServiceFactory;

class DiscussionLeaderboardController extends WikiaController {
	/** @var DiscussionServiceGateway $gateway */
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

	public function getPosts(): void {
		$user = $this->getContext()->getUser();

		if (
			!$user->isAllowed( 'leaderboard:view' ) ||
			$user->isBlocked() ||
			!$user->isAllowed( 'read' )
		) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$days = $this->request->getInt( 'days', 30 );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->getPostsLeaderboard( $user->getId(), $days );

		$body = LeaderboardHelper::applyBadges( $body );

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function getModeratorActions(): void {
		$user = $this->getContext()->getUser();

		if (
			!$user->isAllowed( 'leaderboard:view' ) ||
			$user->isBlocked() ||
			!$user->isAllowed( 'read' )
		) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$days = $this->request->getInt( 'days', 30 );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->getModeratorLeaderboard( $user->getId(), $days );

		$body = LeaderboardHelper::applyBadges( $body );

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function getReports(): void {
		$user = $this->getContext()->getUser();

		if (
			!$user->isAllowed( 'posts:validate' ) ||
			$user->isBlocked() ||
			!$user->isAllowed( 'read' )
		) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$days = $this->request->getInt( 'days', 30 );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->getReportsLeaderboard( $user->getId(), $days );

		$body = LeaderboardHelper::applyBadges( $body );

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}
}
