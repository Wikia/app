<?php

use GuzzleHttp\Client;
use Wikia\Factory\ServiceFactory;

class DiscussionModerationController extends WikiaController {

	private const PAGINATION_QUERY_PARAMS = [ 'limit', 'page', 'pivotId' ];

	private $gateway;

	private $baseDomain;

	private $scriptPath;

	private $reportedPostsHelper;

	public function __construct() {
		parent::__construct();

		$discussionsServiceUrl = ServiceFactory::instance()->providerFactory()->urlProvider()->getUrl( 'discussion' );

		$this->gateway = new DiscussionGateway(
			new Client(),
			$discussionsServiceUrl,
			$this->wg->CityId
		);

		$this->baseDomain = $this->wg->Server;
		$this->scriptPath = $this->wg->ScriptPath;

		$this->reportedPostsHelper = new ReportedPostsHelper($this->baseDomain, $this->scriptPath );
	}

	public function init() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	public function getReportedPosts(): void {
		$pagination = [];

		foreach ( self::PAGINATION_QUERY_PARAMS as $paramName ) {
			$pagination[$paramName] = $this->request->getVal( $paramName );
		}

		$viewableOnly = $this->request->getBool( 'viewableOnly', false );
		$containerType = $this->request->getVal( 'containerType', null );

		$user = $this->getContext()->getUser();

		$isAnonOrBlockedUser = $this->isAnonOrBlockedUser( $user );

		if ( $isAnonOrBlockedUser || !$user->isAllowed( 'read' ) ||
			 !$user->isAllowed( 'posts:validate' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );

			return;
		}

		$canViewHidden = $user->isAllowed( 'posts:viewhidden' );
		$canViewHiddenInContainer =
			$containerType == 'WALL' ? $user->isAllowed( 'wallremove' ) : $canViewHidden;

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->getReportedPosts( $pagination, $viewableOnly, $canViewHidden,
				$canViewHiddenInContainer, $containerType, $user->getId() );

		$this->response->setCode( $statusCode );

		if ( $statusCode != WikiaResponse::RESPONSE_CODE_OK ) {
			$this->response->setData( $body );

			return;
		}

		$this->reportedPostsHelper->mapLinks( $body );
		$this->reportedPostsHelper->addPermissions( $user, $body );
		$this->response->setData( $body );
	}

	public function getReportDetails(): void {
		$postId = $this->getVal( 'postId', 0 );

		$user = $this->getContext()->getUser();

		if ( !$user->isAllowed( 'posts:report' ) || $user->isBlocked() || !$user->isAllowed( 'read' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		[ 'statusCode' => $statusCode, 'body' => $body ] = $this->gateway->getReportDetails( $postId, $user->getId() );

		$this->response->setCode( $statusCode );

		if ( $statusCode != WikiaResponse::RESPONSE_CODE_OK ) {
			$this->response->setData( $body );

			return;
		}

		$body['userInfo'] = ReportDetailsHelper::applyBadgePermission( $body['userInfo'] );

		$this->response->setData( $body );
	}

	public function getPostListReports(): void {
		$postIds = $this->request->getArray( 'postId', [] );
		$user = $this->getContext()->getUser();

		if ( !$user->isAllowed( 'posts:validate' ) || $user->isBlocked() || !$user->isAllowed( 'read' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		[ 'statusCode' => $statusCode, 'body' => $body ] = $this->gateway->getPostListReports( $postIds, $user->getId() );

		$this->response->setCode( $statusCode );

		if ( $statusCode != WikiaResponse::RESPONSE_CODE_OK ) {
			$this->response->setData( $body );

			return;
		}

		$body['posts'] = ReportDetailsHelper::applyBadgePermissionToList( $body['posts'] );

		$this->response->setData( $body );
	}

	public function reportPost(): void {
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode(WikiaResponse::RESPONSE_CODE_METHOD_NOT_ALLOWED );
			return;
		}

		$postId = $this->getVal( 'postId', 0 );
		$user = $this->getContext()->getUser();

		if ( !$user->isAllowed( 'posts:report' ) || $user->isBlocked() || !$user->isAllowed( 'read' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$userTraceHeaders = $this->getUserTraceHeaders( $this->getContext()->getRequest() );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->createPostReport( $postId, $user->getId(), $userTraceHeaders );

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function validatePostReport(): void {
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_METHOD_NOT_ALLOWED );
			return;
		}

		$postId = $this->getVal( 'postId', 0 );
		$user = $this->getContext()->getUser();

		if ( !$user->isAllowed( 'posts:validate' ) || $user->isBlocked() || !$user->isAllowed( 'read' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->validatePostReport( $postId, $user->getId() );

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function bulkApprove(): void {
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_METHOD_NOT_ALLOWED );
			return;
		}

		$reporterId = $this->getVal( 'reporterId', 0 );
		$user = $this->getContext()->getUser();

		if ( !$user->isAllowed( 'posts:validate' ) || $user->isBlocked() || !$user->isAllowed( 'read' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->bulkApprove( $reporterId, $user->getId() );

		$this->response->setCode( $statusCode == 204 ? 200 : $statusCode );
		$this->response->setData( $body );
	}

	/**
	 * Check if the given user is an registered - non blocked user.
	 * @param User $user
	 * @return bool
	 */
	private function isAnonOrBlockedUser( User $user ): bool {
		// Only allow reporting for registered, non-blocked users
		if ( $user->isAnon() || $user->isBlocked() ) {
			return true;
		}

		return false;
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

class_alias( DiscussionModerationController::class, 'FeedsReportedPageController' );
