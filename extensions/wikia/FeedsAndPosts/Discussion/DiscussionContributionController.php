<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Wikia\Factory\ServiceFactory;
use Wikia\FeedsAndPosts\Discussion\DiscussionGateway;
use Wikia\FeedsAndPosts\Discussion\PermissionsHelper;
use Wikia\FeedsAndPosts\Discussion\LinkHelper;
use Wikia\FeedsAndPosts\Discussion\QueryParamsHelper;

class DiscussionContributionController extends WikiaController {
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

	public function getPosts() {
		$request = $this->getRequest();
		$user = $this->context->getUser();

		$contributorId = $request->getVal( 'userId' );

		$containerType = $request->getVal( 'containerType' );
		$canViewHidden = $user->isAllowed( 'posts:viewhidden' );
		$canViewHiddenInContainer = $containerType == 'WALL' ? $user->isAllowed( 'wallremove' ) : $canViewHidden;

		$queryParams = QueryParamsHelper::getQueryParams( $request );
		$queryParams['canViewHiddenPosts'] = $canViewHidden ? 'true' : 'false';
		$queryParams['canViewHiddenPostsInContainer'] = $canViewHiddenInContainer ? 'true' : 'false';

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->getContributions( $user->getId(), $contributorId, $queryParams );

		if ( $statusCode === 200 ) {
			$body = $this->addBadgesAndPermissions( $body, $user );
			$body = $this->mapPermalinks( $body, $this->getContext() );
			$body = $this->mapContributionLinks( $body, $this->getContext() );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	public function deleteAll() {
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_METHOD_NOT_ALLOWED );
			return;
		}

		$request = $this->getRequest();
		$user = $this->context->getUser();
		$contributorId = $request->getVal( 'userId' );

		if ( $user->isAnon() || $user->isBlocked() || !$user->isAllowed( 'posts:deleteall' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$traceHeaders = TraceHeadersHelper::getUserTraceHeaders( $this->getContext()->getRequest() );

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->deleteAllContributions( $user->getId(), $contributorId, $traceHeaders );

		if ( $statusCode === 200 ) {
			$body = $this->addBadgesAndPermissions( $body, $user );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	private function addBadgesAndPermissions( array $body, User $user ): array {
		$userIds = $this->collectUserIds( $body );
		$badgesMap = PermissionsHelper::getBadgesMap( $userIds );

		if ( isset( $body['createdBy'] ) ) {
			$body['createdBy']['badgePermission'] = $badgesMap[(int)$body['createdBy']['id']];
		}
		if ( isset( $body['lastEditedBy'] ) ) {
			$body['lastEditedBy']['badgePermission'] = $badgesMap[(int)$body['lastEditedBy']['id']];
		}
		if ( isset( $body['lastDeletedBy'] ) ) {
			$body['lastDeletedBy']['badgePermission'] = $badgesMap[(int)$body['lastDeletedBy']['id']];
		}
		if ( isset( $body['deletedBy'] ) ) {
			$body['deletedBy']['badgePermission'] = $badgesMap[(int)$body['deletedBy']['id']];
		}

		if ( isset( $body['_embedded']['doc:posts'] ) ) {
			$body['_embedded']['doc:posts'] = array_map( function ( $post ) use ( $body, $badgesMap, $user ) {
				if ( isset( $post['createdBy'] ) ) {
					$post['createdBy']['badgePermission'] = $badgesMap[(int)$post['createdBy']['id']];
				}
				if ( isset( $post['lastEditedBy'] ) ) {
					$post['lastEditedBy']['badgePermission'] = $badgesMap[(int)$post['lastEditedBy']['id']];
				}
				if ( isset( $post['lastDeletedBy'] ) ) {
					$post['lastDeletedBy']['badgePermission'] = $badgesMap[(int)$post['lastDeletedBy']['id']];
				}
				if ( isset( $post['threadCreatedBy'] ) ) {
					$post['threadCreatedBy']['badgePermission'] = $badgesMap[(int)$post['threadCreatedBy']['id']];
				}
				if ( isset( $post['_embedded']['thread'][0]['firstPost']['createdBy'] ) ) {
					$post['_embedded']['thread'][0]['firstPost']['createdBy']['badgePermission'] =
						$badgesMap[(int)$post['_embedded']['thread'][0]['firstPost']['createdBy']['id']];
				}
				if ( isset( $post['_embedded']['thread'][0]['firstPost']['lastEditedBy'] ) ) {
					$post['_embedded']['thread'][0]['firstPost']['lastEditedBy']['badgePermission'] =
						$badgesMap[(int)$post['_embedded']['thread'][0]['firstPost']['lastEditedBy']['id']];
				}
				if ( isset( $post['_embedded']['thread'][0]['firstPost']['lastDeletedBy'] ) ) {
					$post['_embedded']['thread'][0]['firstPost']['lastDeletedBy']['badgePermission'] =
						$badgesMap[(int)$post['_embedded']['thread'][0]['firstPost']['lastDeletedBy']['id']];
				}

				$post = PermissionsHelper::applyPermissionsForPost( $post, $post, $user );
				return $post;
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
		if ( isset( $body['deletedBy']['id'] ) ) {
			$userIds[] = (int)$body['deletedBy']['id'];
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

	private function mapContributionLinks( array $body, IContextSource $requestContext ): array {
		if ( isset( $body['_links'] ) ) {
			foreach ( $body['_links'] as &$link ) {
				$uri = new Uri( $link[0]['href'] );
				$link[0]['href'] = $this->linkHelper->buildContributionLink( $uri, $requestContext );
			}
		}

		return $body;
	}

	private function mapPermalinks( array $body, IContextSource $requestContext ): array {
		if ( isset( $body['_embedded']['doc:posts'] ) ) {
			foreach ( $body['_embedded']['doc:posts'] as &$post ) {
				$uri = new Uri( $post['_links']['permalink'][0]['href'] );
				$post['_links']['permalink'][0]['href'] =
					$this->linkHelper->buildPermalink( $uri, $requestContext );
			}
		}

		return $body;
	}
}
