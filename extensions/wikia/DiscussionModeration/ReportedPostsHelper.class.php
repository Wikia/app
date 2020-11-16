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
		if ( !isset( $reportedPosts['_embedded']['doc:posts'] ) ) {
			return;
		}

		foreach ( $reportedPosts['_embedded']['doc:posts'] as &$postData ) {
			$post = ( new PostBuilder() )
				->position( $postData['position'] )
				->author( empty( $postData['creatorId'] ) ? 0 : (int)$postData['creatorId'] )
				->creationDate( $postData['creationDate']['epochSecond'] )
				->isEditable( $postData['isEditable'] )
				->isThreadEditable( $postData['_embedded']['thread'][0]['isEditable'] )
				->build();

			$rights = [];
			Hooks::run( 'UserPermissionsRequired', [ $user, $post, &$rights ] );

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

		if ( isset( $reportedPosts['_embedded']['doc:posts'] ) ) {
			foreach ( $reportedPosts['_embedded']['doc:posts'] as &$post ) {
				if ( isset( $post['_links']['permalink'][0]['href'] ) ) {
					$uri = new Uri( $post['_links']['permalink'][0]['href'] );
					$post['_links']['permalink'][0]['href'] = $this->buildPermalink( $uri );
				}
				if ( isset( $post['_links']['up'][0]['href'] ) ) {
					$uri = new Uri( $post['_links']['up'][0]['href'] );
					$post['_links']['up'][0]['href'] = $this->buildThreadLink( $uri );
				}
				if ( isset( $post['_links']['self']['href'] ) ) {
					$uri = new Uri( $post['_links']['self']['href'] );
					$post['_links']['self']['href'] = $this->buildPostLink( $uri );
				}
			}
		}
	}

	private function buildNewLink( Uri $uri ) {
		$serviceQueryParams = parse_query( $uri->getQuery() );
		$controllerQueryParams = [
			'controller' => 'DiscussionModeration',
			'method' => 'getReportedPosts',
		];

		foreach ( $serviceQueryParams as $paramName => $value ) {
			$controllerQueryParams[$paramName] = $value;
		}

		return $this->toHttps(
			$this->baseDomain . $this->scriptPath . '/wikia.php?' . build_query( $controllerQueryParams )
		);
	}

	private function buildPermalink( Uri $uri ) {
		$urlParts = explode( "/", $uri->getPath() );
		$postId = end( $urlParts );

		$controllerQueryParams = [
			'controller' => 'DiscussionPermalink',
			'method' => 'getThreadByPostId',
			'postId' => $postId
		];

		foreach ( parse_query( $uri->getQuery() ) as $paramName => $value ) {
			$controllerQueryParams[$paramName] = $value;
		}

		return $this->toHttps(
			$this->baseDomain . $this->scriptPath . '/wikia.php?' . build_query( $controllerQueryParams )
		);
	}

	private function buildThreadLink( Uri $uri ) {
		$urlParts = explode( "/", $uri->getPath() );
		$threadId = end( $urlParts );

		$controllerQueryParams = [
			'controller' => 'DiscussionThread',
			'method' => 'getThread',
			'threadId' => $threadId
		];

		foreach ( parse_query( $uri->getQuery() ) as $paramName => $value ) {
			$controllerQueryParams[$paramName] = $value;
		}

		return $this->toHttps(
			$this->baseDomain . $this->scriptPath . '/wikia.php?' . build_query( $controllerQueryParams )
		);
	}

	private function buildPostLink( Uri $uri ) {
		$urlParts = explode( "/", $uri->getPath() );
		$postId = end( $urlParts );

		$controllerQueryParams = [
			'controller' => 'DiscussionPost',
			'method' => 'getPost',
			'postId' => $postId
		];

		foreach ( parse_query( $uri->getQuery() ) as $paramName => $value ) {
			$controllerQueryParams[$paramName] = $value;
		}

		return $this->toHttps(
			$this->baseDomain . $this->scriptPath . '/wikia.php?' . build_query( $controllerQueryParams )
		);
	}

	private function toHttps( $url ) {
		return preg_replace( "/^http:/i", "https:", $url );
	}

	public function applyBadges( array &$body ) {
		$posts = $body['_embedded']['doc:posts'] ?? [];
		$contributors = $body['_embedded']['contributors'][0]['userInfo'] ?? [];
		$userIds = [];

		foreach ( $posts as $post ) {
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

		foreach ( $contributors as $contributor ) {
			$userIds[] = (int)$contributor['id'];
		}

		$badgesMap = $this->getBadgesMap( $userIds );

		foreach ( $posts as &$post ) {
			if ( isset( $post['createdBy']['id'] ) ) {
				$badge = $badgesMap[(int)$post['createdBy']['id']] ?? '';
				$post['createdBy']['badgePermission'] = $badge;
			}
			if ( isset( $post['lastEditedBy']['id'] ) ) {
				$badge = $badgesMap[(int)$post['lastEditedBy']['id']] ?? '';
				$post['lastEditedBy']['badgePermission'] = $badge;
			}
			if ( isset( $post['lastDeletedBy']['id'] ) ) {
				$badge = $badgesMap[(int)$post['lastDeletedBy']['id']] ?? '';
				$post['lastDeletedBy']['badgePermission'] = $badge;
			}
			if ( isset( $post['threadCreatedBy']['id'] ) ) {
				$badge = $badgesMap[(int)$post['threadCreatedBy']['id']] ?? '';
				$post['threadCreatedBy']['badgePermission'] = $badge;
			}

			if ( isset( $post['_embedded']['thread'][0]['firstPost']['createdBy']['id'] ) ) {
				$badge = $badgesMap[(int)$post['_embedded']['thread'][0]['firstPost']['createdBy']['id']] ?? '';
				$post['_embedded']['thread'][0]['firstPost']['createdBy']['badgePermission'] = $badge;
			}

			if ( isset( $post['_embedded']['thread'][0]['firstPost']['lastEditedBy']['id'] ) ) {
				$badge = $badgesMap[(int)$post['_embedded']['thread'][0]['firstPost']['lastEditedBy']['id']] ?? '';
				$post['_embedded']['thread'][0]['firstPost']['lastEditedBy']['badgePermission'] = $badge;
			}

			if ( isset( $post['_embedded']['thread'][0]['firstPost']['lastDeletedBy']['id'] ) ) {
				$badge = $badgesMap[(int)$post['_embedded']['thread'][0]['firstPost']['lastDeletedBy']['id']] ?? '';
				$post['_embedded']['thread'][0]['firstPost']['lastDeletedBy']['badgePermission'] = $badge;
			}
		}

		foreach ( $contributors as &$contributor ) {
			$contributor['badgePermission'] = $badgesMap[(int)$contributor['id']] ?? '';
		}

		if ( isset( $body['_embedded']['doc:posts'] ) ) {
			$body['_embedded']['doc:posts'] = $posts;
		}

		if ( isset( $body['_embedded']['contributors'][0]['userInfo'] ) ) {
			$body['_embedded']['contributors'][0]['userInfo'] = $contributors;
		}
	}

	/**
	 * @param array $userIds
	 * @return array
	 * @throws FatalError
	 * @throws MWException
	 */
	private function getBadgesMap( array $userIds ): array {
		$badges = [];
		\Hooks::run( 'BadgePermissionsRequired', [ $userIds, &$badges ] );
		return $badges;
	}
}
