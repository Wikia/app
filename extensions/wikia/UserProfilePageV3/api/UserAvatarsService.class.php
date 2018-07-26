<?php

use Swagger\Client\ApiException;
use Swagger\Client\User\Avatars\Api\UserAvatarsApi;
use Wikia\Factory\ServiceFactory;

/**
 * A simple wrapper for user avatars service API
 *
 * @author macbre
 * @see PLATFORM-1334
 */
class UserAvatarsService {

	use \Wikia\Logger\Loggable;

	const SERVICE_NAME = 'user-avatar';

	private $mUserId;

	/**
	 * @param int $userId
	 */
	function __construct( $userId ) {
		$this->mUserId = $userId;
	}

	/**
	 * Remove the avatar for the current user
	 *
	 * @return bool the operation result
	 */
	function remove() {
		wfProfileIn( __METHOD__ );

		try {
			$response = $this->getApiClient()->deleteUserAvatar( $this->mUserId );
			wfDebug( __METHOD__ . ': resp - ' . json_encode( $response ) . "\n" );

			$this->info( 'Avatar removed' );
		}
		catch ( ApiException $e ) {
			wfDebug( __METHOD__ . ': error - ' . $e->getMessage() . "\n" );

			$this->error( 'Avatar remove failed', [
				'exception' => $e,
				'response' => $e->getResponseBody()
			] );

			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Get Swagger-generated API client authenticated for the current user
	 *
	 * @return UserAvatarsApi
	 */
	private function getApiClient() {
		$apiProvider = ServiceFactory::instance()->providerFactory()->apiProvider();
		return $apiProvider->getAuthenticatedApi( self::SERVICE_NAME, $this->mUserId, UserAvatarsApi::class );
	}

	protected function getLoggerContext() {
		return [
			'class' => __CLASS__,
			'userId' => $this->mUserId
		];
	}
}
