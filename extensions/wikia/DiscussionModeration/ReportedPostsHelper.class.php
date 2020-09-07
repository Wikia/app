<?php


use GuzzleHttp\Psr7\Uri;
use function GuzzleHttp\Psr7\build_query;
use function GuzzleHttp\Psr7\parse_query;

class ReportedPostsHelper {
	/** @var string */
	private $baseDomain;
	/** @var string */
	private $scriptPath;

	public function __construct( string $baseDomain, string $scriptPath ) {
		$this->baseDomain = $baseDomain;
		$this->scriptPath = $scriptPath;
	}

	public function addPermissions( User $user, array &$reportedPosts ) {
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

	public function mapLinks( &$reportedPosts ) {
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

		return $this->baseDomain . $this->scriptPath . '/wikia.php' . build_query( $controllerQueryParams );
	}
}