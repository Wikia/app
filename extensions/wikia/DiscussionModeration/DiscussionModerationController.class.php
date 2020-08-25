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

		$reportedPosts =
			$this->gateway->getReportedPosts( $pagination, $viewableOnly, $canViewHidden,
				$canViewHiddenInContainer, $containerType, $user->getId() );

		if ( !empty( $reportedPosts ) ) {
			$this->reportedPostsHelper->mapLinks( $reportedPosts );
			$this->reportedPostsHelper->addPermissions( $user, $reportedPosts );
			$this->response->setData( $reportedPosts );
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_OK );
		} else {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR );
		}
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
}

class_alias( DiscussionModerationController::class, 'FeedsReportedPageController' );
