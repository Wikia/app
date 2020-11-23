<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Wikia\Factory\ServiceFactory;
use Wikia\FeedsAndPosts\Discussion\DiscussionGateway;
use Wikia\FeedsAndPosts\Discussion\PermissionsHelper;
use Wikia\FeedsAndPosts\Discussion\QueryParamsHelper;
use Wikia\FeedsAndPosts\Discussion\LinkHelper;
use Wikia\FeedsAndPosts\Discussion\TraceHeadersHelper;

class DiscussionThreadController extends WikiaController {
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

	public function lock() {
		$request = $this->getRequest();
		$user = $this->context->getUser();

		if ( $user->isBlocked() || !$user->isAllowed( 'threads:lock' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$threadId = $request->getVal( 'threadId' );
		$canViewHidden = $user->isAllowed( 'threads:viewhidden' ) ? 'true' : 'false';

		$traceHeaders = TraceHeadersHelper::getUserTraceHeaders( $this->getContext()->getRequest() );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->lockThread( $user->getId(), $threadId, $canViewHidden, $traceHeaders );

		$this->response->setCode( $statusCode );
	}

	public function unlock() {
		$request = $this->getRequest();
		$user = $this->context->getUser();

		if ( $user->isBlocked() || !$user->isAllowed( 'threads:lock' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$threadId = $request->getVal( 'threadId' );
		$canViewHidden = $user->isAllowed( 'threads:viewhidden' ) ? 'true' : 'false';

		$traceHeaders = TraceHeadersHelper::getUserTraceHeaders( $this->getContext()->getRequest() );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->unlockThread( $user->getId(), $threadId, $canViewHidden, $traceHeaders );

		$this->response->setCode( $statusCode );
	}

	public function update() {
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_METHOD_NOT_ALLOWED );
			return;
		}

		$request = $this->getRequest();
		$user = $this->context->getUser();
		$threadId = $request->getVal( 'threadId' );

		if ( $user->isAnon() || $user->isBlocked() || !$user->isAllowed( 'threads:edit' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$queryParams = [
			'canMoveThreads' => $user->isAllowed( 'threads:move' ) ? 'true' : 'false',
			'canSuperEditThreads' => $user->isAllowed( 'threads:superedit' ) ? 'true' : 'false',
			'canSuperEditPosts' => $user->isAllowed( 'posts:superedit' ) ? 'true' : 'false',
			'canViewHiddenThread' => $user->isAllowed( 'threads:viewhidden' ) ? 'true' : 'false',
			'canViewHiddenForum' => $user->isAllowed( 'forums:viewhidden' ) ? 'true' : 'false',
			'canViewHiddenPost' => $user->isAllowed( 'posts:viewhidden' ) ? 'true' : 'false',
		];

		$payload = $this->getRawInput();

		$traceHeaders = TraceHeadersHelper::getUserTraceHeaders( $this->getContext()->getRequest() );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->updateThread( $user->getId(), $threadId, $payload, $queryParams, $traceHeaders );

		if ( $statusCode === 200 ) {
			$body = $this->addBadgesAndPermissions( $body, $user );
			$body = $this->mapThreadLinks( $body, $this->getContext() );
			$body = $this->mapPermalinks( $body, $this->getContext() );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function delete() {
		$request = $this->getRequest();
		$user = $this->context->getUser();
		$threadId = $request->getVal( 'threadId' );

		if ( $user->isAnon() || $user->isBlocked() || !$user->isAllowed( 'threads:delete' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$queryParams = [
			'canViewHiddenPost' => $user->isAllowed( 'posts:viewhidden' ) ? 'true' : 'false',
		];

		$traceHeaders = TraceHeadersHelper::getUserTraceHeaders( $this->getContext()->getRequest() );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->deleteThread( $user->getId(), $threadId, $queryParams, $traceHeaders );

		if ( $statusCode === 200 ) {
			$body = $this->addBadgesAndPermissions( $body, $user );
			$body = $this->mapThreadLinks( $body, $this->getContext() );
			$body = $this->mapPermalinks( $body, $this->getContext() );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function undelete() {
		$request = $this->getRequest();
		$user = $this->context->getUser();
		$threadId = $request->getVal( 'threadId' );

		if ( $user->isAnon() || $user->isBlocked() || !$user->isAllowed( 'threads:delete' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$queryParams = [
			'canViewHiddenPost' => $user->isAllowed( 'posts:viewhidden' ) ? 'true' : 'false',
		];

		$traceHeaders = TraceHeadersHelper::getUserTraceHeaders( $this->getContext()->getRequest() );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->undeleteThread( $user->getId(), $threadId, $queryParams, $traceHeaders );

		if ( $statusCode === 200 ) {
			$body = $this->addBadgesAndPermissions( $body, $user );
			$body = $this->mapThreadLinks( $body, $this->getContext() );
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

		$request = $this->getRequest();
		$user = $this->context->getUser();
		$forumId = $request->getVal( 'forumId' );

		if ( $user->isBlocked() || !$user->isAllowed( 'threads:create' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$queryParams = [
			'canViewHiddenForum' => $user->isAllowed( 'forums:viewhidden' ) ? 'true' : 'false',
			'canViewHiddenPost' => $user->isAllowed( 'posts:viewhidden' ) ? 'true' : 'false',
		];

		$payload = $this->getRawInput();

		$traceHeaders = TraceHeadersHelper::getUserTraceHeaders( $this->getContext()->getRequest() );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->createThread( $user->getId(), $forumId, $payload, $queryParams, $traceHeaders );

		if ( $statusCode === 201 ) {
			$body = $this->addBadgesAndPermissions( $body, $user );
			$body = $this->mapThreadLinks( $body, $this->getContext() );
			$body = $this->mapPermalinks( $body, $this->getContext() );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function getThread() {
		$request = $this->getRequest();
		$user = $this->context->getUser();
		$threadId = $request->getVal( 'threadId' );

		$queryParams = QueryParamsHelper::getQueryParams( $request, [ 'threadId' ] );
		$queryParams['canViewHiddenThread'] = $user->isAllowed( 'threads:viewhidden' ) ? 'true' : 'false';

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->getThread( $user->getId(), $threadId, $queryParams );

		if ( $statusCode === 200 ) {
			$body = $this->addBadgesAndPermissions( $body, $user );
			$body = $this->mapThreadLinks( $body, $this->getContext() );
			$body = $this->mapPermalinks( $body, $this->getContext() );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function getThreads() {
		$request = $this->getRequest();
		$user = $this->context->getUser();

		$queryParams = QueryParamsHelper::getQueryParams( $request );
		$queryParams['canViewHiddenThread'] = $user->isAllowed( 'threads:viewhidden' ) ? 'true' : 'false';

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->getThreads( $user->getId(), $queryParams );

		if ( $statusCode === 200 ) {
			$body = $this->addBadgesAndPermissionsForThreads( $body, $user );
			$body = $this->mapThreadsLinks( $body, $this->getContext() );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	private function addBadgesAndPermissions( array $body, User $user, array $badgesMap = [] ): array {
		if ( empty( $badgesMap ) ) {
			$userIds = $this->collectUserIds( $body );
			$badgesMap = PermissionsHelper::getBadgesMap( $userIds );
		}

		$body['createdBy']['badgePermission'] = $badgesMap[(int)$body['createdBy']['id']];
		if ( isset( $body['lastEditedBy']['id'] ) ) {
			$body['lastEditedBy']['badgePermission'] = $badgesMap[(int)$body['lastEditedBy']['id']];
		}
		if ( isset( $body['lastDeletedBy']['id'] ) ) {
			$body['lastDeletedBy']['badgePermission'] = $badgesMap[(int)$body['lastDeletedBy']['id']];
		}
		$body = PermissionsHelper::applyPermissionsForPost( $body, $body, $user );

		if ( isset( $body['_embedded']['doc:posts'] ) ) {
			$body['_embedded']['doc:posts'] = array_map( function ( $post ) use ( $body, $badgesMap, $user ) {
				$post['createdBy']['badgePermission'] = $badgesMap[(int)$post['createdBy']['id']];
				if ( isset( $post['lastEditedBy']['id'] ) ) {
					$post['lastEditedBy']['badgePermission'] = $badgesMap[(int)$post['lastEditedBy']['id']];
				}
				if ( isset( $post['lastDeletedBy']['id'] ) ) {
					$post['lastDeletedBy']['badgePermission'] = $badgesMap[(int)$post['lastDeletedBy']['id']];
				}
				$post = PermissionsHelper::applyPermissionsForPost( $post, $body, $user );
				return $post;
			}, $body['_embedded']['doc:posts'] ?? [] );
		}

		if ( isset( $body['_embedded']['firstPost'][0] ) ) {
			$body['_embedded']['firstPost'][0]['createdBy']['badgePermission'] =
				$badgesMap[(int)$body['_embedded']['firstPost'][0]['createdBy']['id']];

			if ( isset( $body['_embedded']['firstPost'][0]['lastEditedBy']['id'] ) ) {
				$body['_embedded']['firstPost'][0]['lastEditedBy']['badgePermission'] =
					$badgesMap[(int)$body['_embedded']['firstPost'][0]['lastEditedBy']['id']];
			}
			if ( isset( $body['_embedded']['firstPost'][0]['lastDeletedBy']['id'] ) ) {
				$body['_embedded']['firstPost'][0]['lastDeletedBy']['badgePermission'] =
					$badgesMap[(int)$body['_embedded']['firstPost'][0]['lastDeletedBy']['id']];
			}
			$body['_embedded']['firstPost'][0] = PermissionsHelper::applyPermissionsForPost(
				$body['_embedded']['firstPost'][0],
				$body,
				$user
			);
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

	private function addBadgesAndPermissionsForThreads( array $body, User $user ): array {
		$userIds = $this->collectUserIds( $body );
		$badgesMap = PermissionsHelper::getBadgesMap( $userIds );

		if ( isset( $body['_embedded']['threads'] ) ) {
			$body['_embedded']['threads'] = array_map( function ( $thread ) use ( $body, $badgesMap, $user ) {
				return $this->addBadgesAndPermissions( $thread, $user, $badgesMap );
			}, $body['_embedded']['threads'] ?? [] );
		}

		if ( isset( $body['_embedded']['forums'] ) ) {
			$body['_embedded']['forums'] = array_map( function ( $forum ) use ( $body, $badgesMap, $user ) {
				if ( isset( $forum['recentContributors'] ) ) {
					$forum['recentContributors'] = array_map( function ( $contributor ) use ( $body, $badgesMap, $user
					) {
						if ( isset( $contributor['id'] ) ) {
							$contributor['badgePermission'] = $badgesMap[(int)$contributor['id']];
						}
						return $contributor;
					}, $forum['recentContributors'] ?? [] );
				}
				return $forum;
			}, $body['_embedded']['forums'] ?? [] );
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
			foreach ( $body['_embedded']['doc:posts'] ?? [] as $post ) {
				if ( isset( $post['createdBy']['id'] ) ) {
					$userIds[] = (int)$post['createdBy']['id'];
				}
				if ( isset( $post['lastEditedBy']['id'] ) ) {
					$userIds[] = (int)$post['lastEditedBy']['id'];
				}
				if ( isset( $post['lastDeletedBy']['id'] ) ) {
					$userIds[] = (int)$post['lastDeletedBy']['id'];
				}
			}
		}

		if ( isset( $body['_embedded']['firstPost'][0]['createdBy']['id'] ) ) {
			$userIds[] = (int)$body['_embedded']['firstPost'][0]['createdBy']['id'];
		}
		if ( isset( $body['_embedded']['firstPost'][0]['lastEditedBy']['id'] ) ) {
			$userIds[] = (int)$body['_embedded']['firstPost'][0]['lastEditedBy']['id'];
		}
		if ( isset( $body['_embedded']['firstPost'][0]['lastDeletedBy']['id'] ) ) {
			$userIds[] = (int)$body['_embedded']['firstPost'][0]['lastDeletedBy']['id'];
		}

		if ( isset( $body['_embedded']['threads'] ) ) {
			foreach ( $body['_embedded']['threads'] ?? [] as $thread ) {
				if ( isset( $thread['createdBy']['id'] ) ) {
					$userIds[] = (int)$thread['createdBy']['id'];
				}
				if ( isset( $thread['lastEditedBy']['id'] ) ) {
					$userIds[] = (int)$thread['lastEditedBy']['id'];
				}
				if ( isset( $thread['lastDeletedBy']['id'] ) ) {
					$userIds[] = (int)$thread['lastDeletedBy']['id'];
				}
			}
		}

		if ( isset( $body['_embedded']['forums'] ) ) {
			foreach ( $body['_embedded']['forums'] ?? [] as $forum ) {
				if ( isset( $forum['recentContributors'] ) ) {
					foreach ( $forum['recentContributors'] as $contributor ) {
						$userIds[] = $contributor['id'];
					}
				}
			}
		}

		if ( isset( $body['_embedded']['contributors'][0] ) ) {
			foreach ( $body['_embedded']['contributors'][0]['userInfo'] as $info ) {
				$userIds[] = $info['id'];
			}
		}

		return $userIds;
	}

	private function mapThreadLinks( array $body, IContextSource $requestContext ): array {
		if ( isset( $body['_links'] ) ) {
			foreach ( $body['_links'] as &$link ) {
				$uri = new Uri( $link[0]['href'] );
				$link[0]['href'] = $this->linkHelper->buildThreadLink( $uri, $requestContext );
			}
		}

		return $body;
	}

	private function mapPermalinks( array $body, IContextSource $requestContext ): array {
		if ( isset( $body['_embedded']['doc:posts'] ) ) {
			foreach ( $body['_embedded']['doc:posts'] as &$post ) {
				if ( isset( $post['_links']['permalink'] ) ) {
					$uri = new Uri( $post['_links']['permalink'][0]['href'] );
					$post['_links']['permalink'][0]['href'] =
						$this->linkHelper->buildPermalink( $uri, $requestContext );
				}
			}
		}

		if ( isset( $body['_embedded']['firstPost'][0]['_links']['permalink'] ) ) {
			$uri = new Uri( $body['_embedded']['firstPost'][0]['_links']['permalink'][0]['href'] );
			$body['_embedded']['firstPost'][0]['_links']['permalink'][0]['href'] =
				$this->linkHelper->buildPermalink( $uri, $requestContext );
		}

		return $body;
	}

	private function mapThreadsLinks( array $body, IContextSource $requestContext ): array {
		if ( isset( $body['_links'] ) ) {
			foreach ( $body['_links'] as &$link ) {
				$uri = new Uri( $link[0]['href'] );
				$link[0]['href'] = $this->linkHelper->buildThreadsLink( $uri, $requestContext );
			}
		}

		return $body;
	}

	private function getRawInput() {
		return file_get_contents( 'php://input' );
	}
}
