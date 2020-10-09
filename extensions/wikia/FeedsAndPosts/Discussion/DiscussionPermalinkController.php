<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Wikia\Factory\ServiceFactory;
use Wikia\FeedsAndPosts\Discussion\PermissionsHelper;
use function GuzzleHttp\Psr7\build_query;
use function GuzzleHttp\Psr7\parse_query;
use Wikia\FeedsAndPosts\Discussion\DiscussionGateway;

class DiscussionPermalinkController extends WikiaController {
	/*** @var DiscussionGateway */
	private $gateway;
	/** @var string $baseDomain */
	private $baseDomain;
	/** @var string $scriptPath */
	private $scriptPath;

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
	}

	public function init() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	public function getThreadByPostId(): void {
		$request = $this->getRequest();
		$user = $this->context->getUser();
		$postId = $request->getVal( 'postId' );
		$queryParams = $this->getQueryParams( $request );
		$queryParams['canViewHidden'] = $user->isAllowed( 'threads:viewhidden' );

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

		$post = ( new PostBuilder() )
			->position( 1 )
			->author( isset( $body['createdBy']['id'] ) && !empty( $body['createdBy']['id'] )
				? (int)$body['createdBy']['id'] : 0 )
			->creationDate( $body['creationDate']['epochSecond'] )
			->isEditable( $body['isEditable'] )
			->isThreadEditable( $body['isEditable'] )
			->build();

		$rights = [];
		Hooks::run( 'UserPermissionsRequired', [ $user, $post, &$rights ] );

		if ( !empty( $rights ) ) {
			$body['_embedded']['userData'][0]['permissions'] = $rights;
		}

		foreach ( $body['_embedded']['doc:posts'] as &$postData ) {
			$post = ( new PostBuilder() )
				->position( $postData['position'] )
				->author( empty( $postData['creatorId'] ) ? 0 : (int)$postData['creatorId'] )
				->creationDate( $postData['creationDate']['epochSecond'] )
				->isEditable( $postData['isEditable'] )
				->isThreadEditable( $body['isEditable'] )
				->build();

			$rights = [];
			Hooks::run( 'UserPermissionsRequired', [ $user, $post, &$rights ] );

			if ( !empty( $rights ) ) {
				$postData['_embedded']['userData'][0]['permissions'] = $rights;
			}
		}

		$post = ( new PostBuilder() )
			->position( 1 )
			->author( empty( $body['_embedded']['firstPost'][0]['creatorId'] )
				? 0 : (int)$body['_embedded']['firstPost'][0]['creatorId'] )
			->creationDate( $body['_embedded']['firstPost'][0]['creationDate']['epochSecond'] )
			->isEditable( $body['_embedded']['firstPost'][0]['isEditable'] )
			->isThreadEditable( $body['isEditable'] )
			->build();

		$rights = [];
		Hooks::run( 'UserPermissionsRequired', [ $user, $post, &$rights ] );

		if ( !empty( $rights ) ) {
			$body['_embedded']['firstPost'][0]['_embedded']['userData'][0]['permissions'] = $rights;
		}

		return $body;
	}

	public function mapLinks( array &$body, IContextSource $requestContext ) {
		foreach ( $body['_embedded']['doc:posts'] as &$post ) {
			if ( isset( $post['_links']['permalink'][0]['href'] ) ) {
				$uri = new Uri( $post['_links']['permalink'][0]['href'] );
				$post['_links']['permalink'][0]['href'] = $this->buildNewLink( $uri, $requestContext );
			}
		}

		if ( isset( $body['_embedded']['firstPost'][0]['_links']['permalink'][0]['href'] ) ) {
			$uri = new Uri( $body['_embedded']['firstPost'][0]['_links']['permalink'][0]['href'] );
			$body['_embedded']['firstPost'][0]['_links']['permalink'][0]['href'] = $this->buildNewLink( $uri, $requestContext );
		}

		return $body;
	}

	private function buildNewLink( Uri $uri, IContextSource $requestContext ) {
		$urlParts = explode( "/", $uri->getPath() );
		$postId = end( $urlParts );

		$controllerQueryParams = [
			'controller' => 'DiscussionPermalinkController',
			'method' => 'getThreadByPostId',
			'postId' => $postId
		];

		foreach ( parse_query( $uri->getQuery() ) as $paramName => $value ) {
			$controllerQueryParams[$paramName] = $value;
		}

		return $this->baseDomain . $this->scriptPath . '/wikia.php?' . build_query( $controllerQueryParams );
	}

	private function getQueryParams( \WikiaRequest $request ): array {
		$queryParams = $request->getParams();
		unset( $queryParams['method'] );
		unset( $queryParams['controller'] );
		unset( $queryParams['format'] );
		unset( $queryParams['postId'] );

		return $queryParams;
	}
}
