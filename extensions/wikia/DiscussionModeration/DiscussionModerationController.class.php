<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Wikia\Factory\ServiceFactory;
use function GuzzleHttp\Psr7\build_query;
use function GuzzleHttp\Psr7\parse_query;

class DiscussionModerationController extends WikiaController {

	private const PAGINATION_QUERY_PARAMS = [ 'limit', 'page', 'pivotId' ];

	private $gateway;

	private $baseDomain;

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

	public function getReportedPosts(): void {
		$pagination = [];

		foreach ( self::PAGINATION_QUERY_PARAMS as $paramName ) {
			$pagination[$paramName] = $this->request->getVal( $paramName );
		}

		$viewableOnly = $this->request->getBool( 'viewableOnly', false );
		$containerType = $this->request->getVal( 'containerType', null );

		$user = $this->getContext()->getUser();

		$isAnonOrBlockedUser = $this->isAnonOrBlockedUser( $user );

		if ( $isAnonOrBlockedUser || !$user->isAllowed( 'read' ) || !$user->isAllowed( 'posts:validate' ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$canViewHidden = $user->isAllowed( 'posts:viewhidden' );
		$canViewHiddenInContainer = $containerType == 'WALL' ? $user->isAllowed( 'wallremove' ) : $canViewHidden;

		$reportedPosts = $this->gateway->getReportedPosts(
			$pagination, $viewableOnly, $canViewHidden, $canViewHiddenInContainer, $containerType, $user->getId()
		);

		if ( $reportedPosts ) {
			$this->mapLinks( $reportedPosts );
			$this->addPermissions( $user, $reportedPosts );
			$this->response->setData( $reportedPosts );
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_OK );
		} else {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR );
		}
	}

	private function mapLinks( &$reportedPosts ) {
		foreach ( $reportedPosts['_links'] as $linkName => $target ) {

			if ( array_key_exists( 'href', $target ) ) {
				$uri = new Uri( $target['href'] );
				$reportedPosts['_links'][$linkName]['href'] = $this->buildNewLink( $uri );
			} else {
				$uri = new Uri( $target[0]['href'] );
				$reportedPosts['_links'][$linkName][0]['href'] = $this->buildNewLink( $uri );
			}
		}
	}

	private function buildNewLink( Uri $uri ) {
		$serviceQueryParams = parse_query( $uri->getQuery() );
		$controllerQueryParams = [
			'controller' => 'DiscussionModerationController',
			'method' => 'getReportedPosts',
		];

		foreach ( $serviceQueryParams as $paramName => $value ) {
			$controllerQueryParams[$paramName] = $value;
		}
		return (string)$uri->withScheme( 'https' )
			->withHost( $this->baseDomain )
			->withPath( $this->scriptPath . '/wikia.php' )
			->withQuery( build_query( $controllerQueryParams ) );
	}

	private function addPermissions( User $user, array &$reportedPosts ) {
		foreach ( $reportedPosts['_embedded']['doc:posts'] as &$postData ) {
			$post = ( new PostBuilder() )
				->position( $postData['position'] )
				->author( empty( $postData['creatorId'] ) ? 0 : (int)$postData['creatorId'] )
				->creationDate( $postData['creationDate']['epochSecond'] )
				->isEditable( $postData['isEditable'] )
				->isThreadEditable( $postData['_embedded']['thread'][0]['isEditable'] )
				->build();

			$rights = DiscussionPermissionManager::getRights( $user, $post );

			if ( !empty( $rights ) ) {
				$postData['_embedded']['userData'][0]['permissions'] = $rights;
			}
		}
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
