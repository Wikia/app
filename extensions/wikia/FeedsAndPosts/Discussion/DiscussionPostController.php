<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Wikia\Factory\ServiceFactory;
use Wikia\FeedsAndPosts\Discussion\DiscussionGateway;
use Wikia\FeedsAndPosts\Discussion\PermissionsHelper;
use Wikia\FeedsAndPosts\Discussion\QueryParamsHelper;
use Wikia\FeedsAndPosts\Discussion\LinkHelper;
use Wikia\FeedsAndPosts\Discussion\TraceHeadersHelper;

class DiscussionPostController extends WikiaController {
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

	public function update() {
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_METHOD_NOT_ALLOWED );
			return;
		}

		$request = $this->getRequest();
		$user = $this->context->getUser();
		$postId = $request->getVal( 'postId' );

		if ( $user->isAnon() || $user->isBlocked() || !$user->isAllowed( 'posts:edit' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$queryParams = [
			'canSuperEditPosts' => $user->isAllowed( 'posts:superedit' ) ? 'true' : 'false',
			'canViewHiddenThread' => $user->isAllowed( 'threads:viewhidden' ) ? 'true' : 'false',
			'canViewHiddenPost' => $user->isAllowed( 'posts:viewhidden' ) ? 'true' : 'false',
		];

		$payload = $this->getRawInput();

		$traceHeaders = TraceHeadersHelper::getUserTraceHeaders( $this->getContext()->getRequest() );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->updatePost( $user->getId(), $postId, $payload, $queryParams, $traceHeaders );

		if ( $statusCode === 200 ) {
			$body = $this->addBadgesAndPermissions( $body, $user );
			$body = $this->mapPermalinks( $body, $this->getContext() );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function create() {
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_METHOD_NOT_ALLOWED );
			return;
		}

		$user = $this->context->getUser();

		if ( $user->isBlocked() || !$user->isAllowed( 'posts:create' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$queryParams = [
			'canSuperEditPosts' => $user->isAllowed( 'posts:superedit' ) ? 'true' : 'false',
			'canViewHiddenThread' => $user->isAllowed( 'threads:viewhidden' ) ? 'true' : 'false',
			'canViewHiddenPost' => $user->isAllowed( 'posts:viewhidden' ) ? 'true' : 'false',
		];

		$payload = $this->getRawInput();

		$traceHeaders = TraceHeadersHelper::getUserTraceHeaders( $this->getContext()->getRequest() );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->createPost( $user->getId(), $payload, $queryParams, $traceHeaders );

		if ( $statusCode === 201 ) {
			$body = $this->addBadgesAndPermissions( $body, $user );
			$body = $this->mapPermalinks( $body, $this->getContext() );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function delete() {
		$request = $this->getRequest();
		$user = $this->context->getUser();
		$postId = $request->getVal( 'postId' );

		if ( $user->isAnon() || $user->isBlocked() || !$user->isAllowed( 'posts:delete' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$queryParams = [
			'canViewHiddenPost' => $user->isAllowed( 'posts:viewhidden' ) ? 'true' : 'false',
		];

		$traceHeaders = TraceHeadersHelper::getUserTraceHeaders( $this->getContext()->getRequest() );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->deletePost( $user->getId(), $postId, $queryParams, $traceHeaders );

		if ( $statusCode === 200 ) {
			$body = $this->addBadgesAndPermissions( $body, $user );
			$body = $this->mapPermalinks( $body, $this->getContext() );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function undelete() {
		$request = $this->getRequest();
		$user = $this->context->getUser();
		$postId = $request->getVal( 'postId' );

		if ( $user->isAnon() || $user->isBlocked() || !$user->isAllowed( 'posts:delete' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$queryParams = [
			'canViewHiddenPost' => $user->isAllowed( 'posts:viewhidden' ) ? 'true' : 'false',
		];

		$traceHeaders = TraceHeadersHelper::getUserTraceHeaders( $this->getContext()->getRequest() );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->undeletePost( $user->getId(), $postId, $queryParams, $traceHeaders );

		if ( $statusCode === 200 ) {
			$body = $this->addBadgesAndPermissions( $body, $user );
			$body = $this->mapPermalinks( $body, $this->getContext() );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function getPost() {
		$request = $this->getRequest();
		$user = $this->context->getUser();
		$postId = $request->getVal( 'postId' );

		$queryParams = QueryParamsHelper::getQueryParams( $request, [ 'postId' ] );
		$queryParams['canViewHiddenPost'] = $user->isAllowed( 'posts:viewhidden' ) ? 'true' : 'false';

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->getPost( $user->getId(), $postId, $queryParams );

		if ( $statusCode === 200 ) {
			$body = $this->addBadgesAndPermissions( $body, $user );
			$body = $this->mapPermalinks( $body, $this->getContext() );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function getPosts() {
		$request = $this->getRequest();
		$user = $this->context->getUser();

		$reported = $request->getBool( 'reported' );
		$containerType = $request->getVal( 'containerType' );

		if ( $reported && ( $user->isBlocked() || !$user->isAllowed( 'posts:validate' ) ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$queryParams = QueryParamsHelper::getQueryParams( $request, [ 'reported' ] );
		$queryParams['canViewHiddenPosts'] = $user->isAllowed( 'posts:viewhidden' ) ? 'true' : 'false';

		$canViewHidden = $user->isAllowed( 'posts:viewhidden' );
		$canViewHiddenInContainer = $containerType == 'WALL' ? $user->isAllowed( 'wallremove' ) : $canViewHidden;
		$queryParams['canViewHiddenPostsInContainer'] = $canViewHiddenInContainer ? 'true' : 'false';

		$queryParams['reported'] = $reported ? 'true' : 'false';

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->getPosts( $user->getId(), $queryParams );

		if ( $statusCode === 200 ) {
			$body = $this->addBadgesAndPermissionsForPosts( $body, $user );
			$body = $this->mapPostsLinks( $body, $this->getContext() );
			$body = $this->mapPermalinks( $body, $this->getContext() );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	private function addBadgesAndPermissions( array $body, User $user, array $badgesMap = [] ): array {
		if ( empty( $badgesMap ) ) {
			$userIds = $this->collectUserIds( $body );
			$badgesMap = PermissionsHelper::getBadgesMap( $userIds );
		}

		if ( isset( $body['createdBy'] ) ) {
			$body['createdBy']['badgePermission'] = $badgesMap[(int)$body['createdBy']['id']];
		}
		if ( isset( $body['lastEditedBy'] ) ) {
			$body['lastEditedBy']['badgePermission'] = $badgesMap[(int)$body['lastEditedBy']['id']];
		}
		if ( isset( $body['lastDeletedBy'] ) ) {
			$body['lastDeletedBy']['badgePermission'] = $badgesMap[(int)$body['lastDeletedBy']['id']];
		}
		if ( isset( $body['threadCreatedBy'] ) ) {
			$body['threadCreatedBy']['badgePermission'] = $badgesMap[(int)$body['threadCreatedBy']['id']];
		}
		if ( isset( $body['_embedded']['thread'][0]['firstPost']['createdBy'] ) ) {
			$body['_embedded']['thread'][0]['firstPost']['createdBy']['badgePermission'] =
				$badgesMap[(int)$body['_embedded']['thread'][0]['firstPost']['createdBy']['id']];
		}
		if ( isset( $body['_embedded']['thread'][0]['firstPost']['lastEditedBy'] ) ) {
			$body['_embedded']['thread'][0]['firstPost']['lastEditedBy']['badgePermission'] =
				$badgesMap[(int)$body['_embedded']['thread'][0]['firstPost']['lastEditedBy']['id']];
		}
		if ( isset( $body['_embedded']['thread'][0]['firstPost']['lastDeletedBy'] ) ) {
			$body['_embedded']['thread'][0]['firstPost']['lastDeletedBy']['badgePermission'] =
				$badgesMap[(int)$body['_embedded']['thread'][0]['firstPost']['lastDeletedBy']['id']];
		}

		$body = PermissionsHelper::applyPermissionsForPost( $body, $body, $user );

		return $body;
	}

	private function addBadgesAndPermissionsForPosts( array $body, User $user ): array {
		$userIds = $this->collectUserIds( $body );
		$badgesMap = PermissionsHelper::getBadgesMap( $userIds );

		if ( isset( $body['_embedded']['doc:posts'] ) ) {
			$body['_embedded']['doc:posts'] = array_map( function ( $post ) use ( $body, $badgesMap, $user ) {
				return $this->addBadgesAndPermissions( $post, $user, $badgesMap );
			}, $body['_embedded']['doc:posts'] ?? [] );
		}

		if ( isset( $body['_embedded']['contributors'][0] ) ) {
			$body['_embedded']['contributors'][0]['userInfo'] = array_map( function ( $userInfo ) use ( $body,
				$badgesMap,
				$user ) {
				if ( isset( $userInfo['id'] ) ) {
					$userInfo['badgePermission'] = $badgesMap[(int)$userInfo['id']];
				}
				return $userInfo;
			}, $body['_embedded']['contributors'][0]['userInfo'] ?? [] );
		}

		return $body;
	}

	private function collectUserIds( array $body ) {
		$userIds = [];

		if ( isset( $body['createdBy']['id'] ) ) {
			$userIds[] = (int)$body['createdBy']['id'];
		}
		if ( isset( $body['lastEditedBy']['id'] ) ) {
			$userIds[] = (int)$body['lastEditedBy']['id'];
		}
		if ( isset( $body['lastDeletedBy']['id'] ) ) {
			$userIds[] = (int)$body['lastDeletedBy']['id'];
		}

		if ( isset( $body['_embedded']['doc:posts'] ) ) {
			foreach ( $body['_embedded']['doc:posts'] as $post ) {
				if ( isset( $post['createdBy']['id'] ) ) {
					$userIds[] = (int)$post['createdBy']['id'];
				}
				if ( isset( $post['lastEditedBy']['id'] ) ) {
					$userIds[] = (int)$post['lastEditedBy']['id'];
				}
				if ( isset( $post['lastDeletedBy']['id'] ) ) {
					$userIds[] = (int)$post['lastDeletedBy']['id'];
				}
				if ( isset( $post['threadCreatedBy']['id'] ) ) {
					$userIds[] = (int)$post['threadCreatedBy']['id'];
				}
				if ( isset( $post['_embedded']['thread'][0]['firstPost']['createdBy']['id'] ) ) {
					$userIds[] = (int)$post['_embedded']['thread'][0]['firstPost']['createdBy']['id'];
				}
				if ( isset( $post['_embedded']['thread'][0]['firstPost']['lastEditedBy']['id'] ) ) {
					$userIds[] = (int)$post['_embedded']['thread'][0]['firstPost']['lastEditedBy']['id'];
				}
				if ( isset( $post['_embedded']['thread'][0]['firstPost']['lastDeletedBy']['id'] ) ) {
					$userIds[] = (int)$post['_embedded']['thread'][0]['firstPost']['lastDeletedBy']['id'];
				}
			}
		}

		if ( isset( $body['_embedded']['contributors'][0] ) ) {
			foreach ( $body['_embedded']['contributors'][0]['userInfo'] as $userInfo ) {
				$userIds[] = (int)$userInfo['id'];
			}
		}

		return $userIds;
	}

	private function mapPostsLinks( array $body, IContextSource $requestContext ): array {
		if ( isset( $body['_links'] ) ) {
			foreach ( $body['_links'] as &$link ) {
				$uri = new Uri( $link[0]['href'] );
				$link[0]['href'] = $this->linkHelper->buildPostsLink( $uri, $requestContext );
			}
		}

		return $body;
	}

	private function mapPermalinks( array $body, IContextSource $requestContext ): array {
		if ( isset( $body['_links']['permalink'][0] ) ) {
			$uri = new Uri( $body['_links']['permalink'][0]['href'] );
			$body['_links']['permalink'][0]['href'] =
				$this->linkHelper->buildPermalink( $uri, $requestContext );
		}

		if ( isset( $body['_embedded']['doc:posts'] ) ) {
			foreach ( $body['_embedded']['doc:posts'] as &$post ) {
				$uri = new Uri( $post['_links']['permalink'][0]['href'] );
				$post['_links']['permalink'][0]['href'] =
					$this->linkHelper->buildPermalink( $uri, $requestContext );
			}
		}

		return $body;
	}

	private function getRawInput() {
		return file_get_contents( 'php://input' );
	}
}
