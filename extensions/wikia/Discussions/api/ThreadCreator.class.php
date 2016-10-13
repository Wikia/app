<?php

use Swagger\Client\ApiException;
use Swagger\Client\Discussion\Api\ThreadsApi;
use Swagger\Client\Discussion\Models\PostInput;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;

class ThreadCreator {

	const SERVICE_NAME = "discussion";

	public function create( int $userId, int $siteId, string $body, $title = null ) : bool {
		$postInput = $this->getPostInput( $siteId, $body, $title );
		$api = $this->getThreadsApi( $userId );

		try {
			// Currently only creates thread in "General" category of the Discussion.
			$api->createThread( $siteId, $siteId,  $postInput );
			$success = true;

		} catch ( ApiException  $e ) {
			$this->logError( $siteId, $userId, $body, $e );
			$success = false;
		}

		return $success;
	}

	private function getPostInput( int $siteId, string $body, string $title ) : PostInput {
		return ( new PostInput() )
			->setSiteId( $siteId )
			->setBody( $body )
			->setTitle( $title ?? "" );

	}

	private function getThreadsApi( int $userId ) : ThreadsApi {
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get( ApiProvider::class );
		/** @var \Swagger\Client\Discussion\Api\ThreadsApi $api */
		$api = $apiProvider->getAuthenticatedApi( self::SERVICE_NAME, $userId, ThreadsApi::class );
		$api->getApiClient()->getConfig()->setCurlTimeout( 5 );

		return $api;
	}

	private function logError( int $siteId, int $userId, string $body, Exception $e ) : void {
		Wikia\Logger\WikiaLogger::instance()->warning(
			'DISCUSSIONS Error creating thread',
			[
				'siteId' => $siteId,
				'userId' => $userId,
				'body' => $body,
				'exception' => $e
			]
		);
	}
}
