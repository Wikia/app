<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Wikia\Factory\ServiceFactory;
use Wikia\FeedsAndPosts\Discussion\DiscussionGateway;
use Wikia\FeedsAndPosts\Discussion\PermissionsHelper;
use Wikia\FeedsAndPosts\Discussion\QueryParamsHelper;
use Wikia\FeedsAndPosts\Discussion\UserInfoHelper;
use Wikia\FeedsAndPosts\Discussion\LinkHelper;

class DiscussionForumController extends WikiaController {
	/*** @var DiscussionGateway */
	private $gateway;
	/** @var string $baseDomain */
	private $baseDomain;
	/** @var string $scriptPath */
	private $scriptPath;
	/** @var LinkHelper */
	private $linkHelper;

	public function __construct() {
		parent::__construct();

		$discussionsServiceUrl = ServiceFactory::instance()
			->providerFactory()
			->urlProvider()
			->getUrl( 'discussion' );

		$this->gateway = new DiscussionGateway( new Client(), $discussionsServiceUrl, $this->wg->CityId );

		$this->baseDomain = $this->wg->Server;
		$this->scriptPath = $this->wg->ScriptPath;
		$this->linkHelper = new LinkHelper( $this->baseDomain, $this->scriptPath );
	}

	public function init() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	public function getForums() {
		$request = $this->getRequest();
		$user = $this->context->getUser();
		$queryParams = QueryParamsHelper::getQueryParams( $request );
		$queryParams['canViewHidden'] = $user->isAllowed( 'forums:viewhidden' );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->getForums( $user->getId(), $queryParams );

		if ( $statusCode === 200 ) {
			$body['_embedded']['doc:forum'] = UserInfoHelper::applyBadgesMultipleUserInfoLists(
				$body['_embedded']['doc:forum'], 'recentContributors'
			);

			$body = $this->mapForumLinks( $body, $this->getContext() );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function getForum() {
		$request = $this->getRequest();
		$user = $this->context->getUser();
		$forumId = $request->getVal( 'forumId' );
		$queryParams = QueryParamsHelper::getQueryParams( $request, [ 'forumId' ] );
		$queryParams['canViewHidden'] = $user->isAllowed( 'forums:viewhidden' );

		if ( empty( $forumId ) ) {
			$this->response->setCode( 400 );
			$this->response->setVal( 'response_message', 'forumId is required' );

			return;
		}

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->getForum( $forumId, $user->getId(), $queryParams );

		if ( $statusCode === 200 ) {
			$body = $this->addBadgesAndPermissions( $body, $user );
			$body = $this->mapForumLinks( $body, $this->getContext() );
			$body = $this->mapPermalinks( $body, $this->getContext() );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function createForum() {
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_METHOD_NOT_ALLOWED );
			return;
		}

		$user = $this->context->getUser();

		if ( !$user->isAllowed( "forums:create" ) ||
			 $user->isBlocked() ||
			 !$user->isAllowed( 'read' )
		) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$queryParams = [ 'canViewHidden' => $user->isAllowed( 'forums:viewhidden' ) ];
		$payload = $this->getRawInput();

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->createForum( $user->getId(), $queryParams, $payload );

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function moveThreadsIntoForum() {
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_METHOD_NOT_ALLOWED );
			return;
		}

		$user = $this->context->getUser();

		if ( $user->isAnon() || $user->isBlocked() || !$user->isAllowed( 'read' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$forumId = $this->getRequest()->getVal( 'forumId' );

		if ( empty( $forumId ) ) {
			$this->response->setCode( 400 );
			$this->response->setVal( 'response_message', 'forumId is required' );

			return;
		}

		$queryParams = [
			'canMoveThreads' => $user->isAllowed( 'threads:move' ),
			'canSuperEditThreads' => $user->isAllowed( 'threads:superedit' ),
			'canViewHiddenThread' => $user->isAllowed( 'threads:viewhidden' ),
			'canViewHiddenForum' => $user->isAllowed( 'forums:viewhidden' ),
		];

		$payload = $this->getRawInput();

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->moveThreadsIntoForum( $forumId, $user->getId(), $queryParams, $payload );

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function deleteForum() {
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_METHOD_NOT_ALLOWED );
			return;
		}

		$user = $this->context->getUser();

		if (
			!$user->isAllowed( 'forums:delete' ) ||
			$user->isBlocked() ||
			!$user->isAllowed( 'read' )
		) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$forumId = $this->getRequest()->getVal( 'forumId' );

		if ( empty( $forumId ) ) {
			$this->response->setCode( 400 );
			$this->response->setVal( 'response_message', 'forumId is required' );

			return;
		}

		$queryParams = [ 'canViewHidden' => $user->isAllowed( 'forums:viewhidden' ) ];
		$payload = $this->getRawInput();

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->deleteForum( $forumId, $user->getId(), $queryParams, $payload );

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function updateForum() {
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_METHOD_NOT_ALLOWED );
			return;
		}

		$user = $this->context->getUser();

		if (
			!$user->isAllowed( 'forums:edit' ) ||
			$user->isBlocked() ||
			!$user->isAllowed( 'read' )
		) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$forumId = $this->getRequest()->getVal( 'forumId' );

		if ( empty( $forumId ) ) {
			$this->response->setCode( 400 );
			$this->response->setVal( 'response_message', 'forumId is required' );

			return;
		}

		$queryParams = [ 'canViewHidden' => $user->isAllowed( 'forums:viewhidden' ) ];
		$payload = $this->getRawInput();

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->updateForum( $forumId, $user->getId(), $queryParams, $payload );

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function updateForumDisplayOrder() {
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_METHOD_NOT_ALLOWED );
			return;
		}

		$user = $this->context->getUser();

		if (
			!$user->isAllowed( 'forums:displayorder' ) ||
			$user->isBlocked() ||
			!$user->isAllowed( 'read' )
		) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$queryParams = [ 'canViewHidden' => $user->isAllowed( 'forums:viewhidden' ) ];
		$payload = $this->getRawInput();

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->updateForumDisplayOrder( $user->getId(), $queryParams, $payload );

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	private function addBadgesAndPermissions( array $body, User $user ): array {
		$userIds = [];

		foreach ( $body['recentContributors'] ?? [] as $rc ) {
			$userIds[] = (int)$rc['id'];
		}

		foreach ( $body['_embedded']['doc:threads'] ?? [] as $thread ) {
			$userIds[] = (int)$thread['createdBy']['id'];
			if ( isset( $thread['lastEditedBy']['id'] ) ) {
				$userIds[] = (int)$thread['lastEditedBy']['id'];
			}
			if ( isset( $thread['lastDeletedBy']['id'] ) ) {
				$userIds[] = (int)$thread['lastDeletedBy']['id'];
			}

			$userIds[] = (int)$thread['_embedded']['firstPost'][0]['createdBy']['id'];
			if ( isset( $thread['_embedded']['firstPost'][0]['lastEditedBy']['id'] ) ) {
				$userIds[] = (int)$thread['_embedded']['firstPost'][0]['lastEditedBy']['id'];
			}
			if ( isset( $thread['_embedded']['firstPost'][0]['lastDeletedBy']['id'] ) ) {
				$userIds[] = (int)$thread['_embedded']['firstPost'][0]['lastDeletedBy']['id'];
			}
		}

		foreach ( $body['_embedded']['contributors'][0]['userInfo'] ?? [] as $contributor ) {
			$userIds[] = (int)$contributor['id'];
		}

		$usersMap = PermissionsHelper::getUsersMap( $userIds );
		$badgesMap = PermissionsHelper::getBadgesMap( $usersMap );

		$body['recentContributors'] = array_map( function ( $rc ) use ( $badgesMap ) {
			$rc['badgePermission'] = $badgesMap[(int)$rc['id']];

			return $rc;
		}, $body['recentContributors'] ?? [] );

		$body['_embedded']['doc:threads'] = array_map( function ( $thread ) use ( $badgesMap, $user ) {
			$thread['createdBy']['badgePermission'] = $badgesMap[(int)$thread['createdBy']['id']];
			if ( isset( $thread['lastEditedBy']['id'] ) ) {
				$thread['lastEditedBy']['badgePermission'] = $badgesMap[(int)$thread['lastEditedBy']['id']];
			}
			if ( isset( $thread['lastDeletedBy']['id'] ) ) {
				$thread['lastDeletedBy']['badgePermission'] = $badgesMap[(int)$thread['lastDeletedBy']['id']];
			}
			$thread = PermissionsHelper::applyPermissionsForPost( $thread, $thread, $user );

			$thread['_embedded']['firstPost'][0]['createdBy']['badgePermission'] =
				$badgesMap[(int)$thread['_embedded']['firstPost'][0]['createdBy']['id']];

			if ( isset( $thread['_embedded']['firstPost'][0]['lastEditedBy']['id'] ) ) {
				$thread['_embedded']['firstPost'][0]['lastEditedBy']['badgePermission'] =
					$badgesMap[(int)$thread['_embedded']['firstPost'][0]['lastEditedBy']['id']];
			}
			if ( isset( $thread['_embedded']['firstPost'][0]['lastDeletedBy']['id'] ) ) {
				$thread['_embedded']['firstPost'][0]['lastDeletedBy']['badgePermission'] =
					$badgesMap[(int)$thread['_embedded']['firstPost'][0]['lastDeletedBy']['id']];
			}
			$thread['_embedded']['firstPost'][0] = PermissionsHelper::applyPermissionsForPost(
				$thread['_embedded']['firstPost'][0],
				$thread,
				$user
			);

			return $thread;
		}, $body['_embedded']['doc:threads'] ?? [] );

		$body['_embedded']['contributors'][0]['userInfo'] = array_map(
			function ( $contributor ) use ( $badgesMap ) {
				$contributor['badgePermission'] = $badgesMap[(int)$contributor['id']];

				return $contributor;
			},
			$body['_embedded']['contributors'][0]['userInfo'] ?? []
		);

		return $body;
	}

	private function mapForumLinks( array $body, IContextSource $requestContext ): array {
		if ( !isset( $body['_links'] ) ) {
			return $body;
		}
		foreach ( $body['_links'] as &$link ) {
			$uri = new Uri( $link[0]['href'] );
			$link[0]['href'] = $this->linkHelper->buildForumlink( $uri, $requestContext );
		}

		return $body;
	}

	private function mapPermalinks( array $body, IContextSource $requestContext ): array {
		if ( !isset( $body['_embedded']['doc:threads'] ) ) {
			return $body;
		}

		foreach ( $body['_embedded']['doc:threads'] as &$thread ) {
			if ( isset( $thread['_embedded']['firstPost'][0]['_links']['permalink'] ) ) {
				$uri = new Uri( $thread['_embedded']['firstPost'][0]['_links']['permalink'][0]['href'] );
				$thread['_embedded']['firstPost'][0]['_links']['permalink'][0]['href'] =
					$this->linkHelper->buildPermalink( $uri, $requestContext );
			}
		}

		return $body;
	}

	private function getRawInput() {
		return file_get_contents( 'php://input' );
	}
}
