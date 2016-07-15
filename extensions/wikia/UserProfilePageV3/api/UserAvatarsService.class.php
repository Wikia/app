<?php

use Swagger\Client\ApiException;
use Swagger\Client\User\Avatars\Api\UserAvatarsApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;

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
	 * Upload a given file as an avatar for the current user
	 *
	 * Assumes the file to be in a PNG format
	 *
	 * @param string $filePath
	 * @return int UPLOAD_* error code
	 */
	function upload( $filePath ) {
		wfProfileIn( __METHOD__ );

		try {
			$response = $this->getApiClient()->putUserAvatar( $this->mUserId, $filePath );
			wfDebug( __METHOD__ . ': resp - ' . json_encode( $response ) . "\n" );
			wfDebug( __METHOD__ . ": <{$response->imageUrl}>\n" );

			$this->info( 'Avatar uploaded', [
				'guid' => $response->imageUrl
			] );
		}
		catch ( ApiException $e ) {
			wfDebug( __METHOD__ . ': error - ' . $e->getMessage() . "\n" );

			$this->error( 'Avatar upload failed', [
				'exception' => $e,
				'response' => $e->getResponseBody()
			] );

			wfProfileOut( __METHOD__ );
			return UPLOAD_ERR_CANT_WRITE;
		}

		wfProfileOut( __METHOD__ );
		return UPLOAD_ERR_OK;
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
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get(ApiProvider::class);
		return $apiProvider->getAuthenticatedApi( self::SERVICE_NAME, $this->mUserId, UserAvatarsApi::class );
	}

	protected function getLoggerContext() {
		return [
			'class' => __CLASS__,
			'userId' => $this->mUserId
		];
	}
}
