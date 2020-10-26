<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Wikia\Factory\ServiceFactory;
use Wikia\FeedsAndPosts\Discussion\PermissionsHelper;
use Wikia\FeedsAndPosts\Discussion\LinkHelper;
use Wikia\FeedsAndPosts\Discussion\DiscussionGateway;
use Wikia\FeedsAndPosts\Discussion\QueryParamsHelper;

class DiscussionPermalinkController extends WikiaController {
	/*** @var DiscussionGateway */
	private $gateway;
	/** @var string $baseDomain */
	private $baseDomain;
	/** @var string $scriptPath */
	private $scriptPath;
	/*** @var LinkHelper */
	private $linkHelper;

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
		$this->linkHelper = new LinkHelper( $this->baseDomain, $this->scriptPath );

	}

	public function init() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	public function getThreadByPostId(): void {
		$request = $this->getRequest();
		$user = $this->context->getUser();
		$postId = $request->getVal( 'postId' );

		$queryParams = QueryParamsHelper::getQueryParams( $request, [ 'postId' ] );
		$queryParams['canViewHidden'] = $user->isAllowed( 'threads:viewhidden' ) ? 'true' : 'false';

		[ 'statusCode' => $statusCode, 'body' => $body ] =
			$this->gateway->getThreadByPostId( $postId, $user->getId(), $queryParams );

		if ( $statusCode == 200 ) {
			$userIds = $this->collectUserIds( $body );
			$usersMap = PermissionsHelper::getUsersMap( $userIds );
			$badgesMap = PermissionsHelper::getBadgesMap( $usersMap );
			$body = $this->applyBadges( $body, $badgesMap );
			$body = $this->addPermissions( $body, $user );
			$body = $this->mapLinks( $body, $this->getContext() );
		}

		$this->response->setCode( $statusCode );
		$this->response->setData( $body );
	}

	private function collectUserIds( array $body ) {
		$userIds = [ (int)$body['requesterId'] ];

		if ( isset( $body['createdBy']['id'] ) ) {
			$userIds[] = (int)$body['createdBy']['id'];
		}
		if ( isset( $body['lastEditedBy']['id'] ) ) {
			$userIds[] = (int)$body['lastEditedBy']['id'];
		}
		if ( isset( $body['lastDeletedBy']['id'] ) ) {
			$userIds[] = (int)$body['lastDeletedBy']['id'];
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

		return $userIds;
	}

	private function applyBadges( array $body, array $badges ): array {
		if ( isset( $body['createdBy']['id'] ) ) {
			$body['createdBy']['badgePermission'] = $badges[(int)$body['createdBy']['id']] ?? "";
		}
		if ( isset( $body['lastEditedBy']['id'] ) ) {
			$body['lastEditedBy']['badgePermission'] = $badges[(int)$body['lastEditedBy']['id']] ?? "";
		}
		if ( isset( $body['lastDeletedBy']['id'] ) ) {
			$body['lastDeletedBy']['badgePermission'] = $badges[(int)$body['lastDeletedBy']['id']] ?? "";
		}

		if ( isset( $body['_embedded']['firstPost'][0]['createdBy']['id'] ) ) {
			$body['_embedded']['firstPost'][0]['createdBy']['badgePermission']
				= $badges[(int)$body['_embedded']['firstPost'][0]['createdBy']['id']] ?? "";
		}
		if ( isset( $body['_embedded']['firstPost'][0]['lastEditedBy']['id'] ) ) {
			$body['_embedded']['firstPost'][0]['lastEditedBy']['badgePermission']
				= $badges[(int)$body['_embedded']['firstPost'][0]['lastEditedBy']['id']] ?? "";
		}
		if ( isset( $body['_embedded']['firstPost'][0]['lastDeletedBy']['id'] ) ) {
			$body['_embedded']['firstPost'][0]['lastDeletedBy']['badgePermission']
				= $badges[(int)$body['_embedded']['firstPost'][0]['lastDeletedBy']['id']] ?? "";
		}

		foreach ( $body['_embedded']['doc:posts'] ?? [] as $k => $postData ) {
			if ( isset( $postData['createdBy']['id'] ) ) {
				$body['_embedded']['doc:posts'][$k]['createdBy']['badgePermission']
					= $badges[(int)$postData['createdBy']['id']] ?? "";
			}
			if ( isset( $postData['lastEditedBy']['id'] ) ) {
				$body['_embedded']['doc:posts'][$k]['lastEditedBy']['badgePermission']
					= $badges[(int)$postData['lastEditedBy']['id']] ?? "";
			}
			if ( isset( $postData['lastDeletedBy']['id'] ) ) {
				$body['_embedded']['doc:posts'][$k]['lastDeletedBy']
					= $badges[(int)$postData['lastDeletedBy']['id']] ?? "";
			}
		}

		return $body;
	}

	private function addPermissions( array &$body, User $user ) {
		$body = PermissionsHelper::applyPermissionsForPost( $body, $body, $user );

		foreach ( $body['_embedded']['doc:posts'] as &$postData ) {
			$postData = PermissionsHelper::applyPermissionsForPost( $postData, $body, $user );
		}

		$body['_embedded']['firstPost'][0] = PermissionsHelper::applyPermissionsForPost(
			$body['_embedded']['firstPost'][0],
			$body,
			$user
		);

		return $body;
	}

	private function mapLinks( array &$body, IContextSource $requestContext ) {
		foreach ( $body['_embedded']['doc:posts'] as &$post ) {
			if ( isset( $post['_links']['permalink'][0]['href'] ) ) {
				$uri = new Uri( $post['_links']['permalink'][0]['href'] );
				$post['_links']['permalink'][0]['href'] =
					$this->linkHelper->buildPermalink( $uri, $requestContext );
			}
		}

		if ( isset( $body['_embedded']['firstPost'][0]['_links']['permalink'][0]['href'] ) ) {
			$uri = new Uri( $body['_embedded']['firstPost'][0]['_links']['permalink'][0]['href'] );
			$body['_embedded']['firstPost'][0]['_links']['permalink'][0]['href'] =
				$this->linkHelper->buildPermalink( $uri, $requestContext );
		}

		return $body;
	}
}
