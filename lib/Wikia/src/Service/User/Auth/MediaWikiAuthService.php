<?php

namespace Wikia\Service\User\Auth;

use Wikia\Service\Helios\ClientException;
use Wikia\Service\Helios\HeliosClient;
use Wikia\Logger\Loggable;

class MediaWikiAuthService implements AuthService {
	use Loggable;

	private $heliosClient;

	/**
	 * @Inject({Wikia\Service\Helios\HeliosClient::class})
	 */
	public function __construct( HeliosClient $client ) {
		$this->heliosClient = $client;
	}

	/**
	 * @param HeliosClient $client
	 */
	public function setHeliosClient( HeliosClient $client ) {
		$this->heliosClient = $client;
	}

	public function authenticate( $username, $password ): AuthResult {
		$this->info( 'HELIOS_LOGIN authenticate', [ 'method' => __METHOD__, 'username' => $username ] );

		$result = false;
		$authMethod = AuthResult::AUTH_TYPE_FAILED;
		$status = \WikiaResponse::RESPONSE_CODE_ERROR;

		try {
			list( $status, $loginInfo ) = $this->heliosClient->login( $username, $password );
			if ( !empty( $loginInfo->error ) ) {
				if ( $loginInfo->error === 'access_denied' ) {
					$this->info(
						'HELIOS_LOGIN authentication_failed',
						[ 'response' => $loginInfo, 'username' => $username, 'method' => __METHOD__ ]
					);
				} else {
					throw new ClientException( 'Response error: ' . $loginInfo->error, 0, null, [ 'response' => $loginInfo ] );
				}
			}

			$result = !empty( $loginInfo->access_token );
			$authMethod = isset( $loginInfo->auth_method ) ? $loginInfo->auth_method : AuthResult::AUTH_TYPE_NORMAL_PW;
		} catch ( ClientException $e ) {
			$this->error(
				'HELIOS_LOGIN authentication_error',
				[ 'exception' => $e, 'response' => $e->getResponse(), 'username' => $username, 'method' => __METHOD__ ]
			);
			$result = false;
			$status = \WikiaResponse::RESPONSE_CODE_SERVICE_UNAVAILABLE;
		}

		return AuthResult::create( $result )
			->authType( $authMethod )
			->status( $status )
			->accessToken( $result ? $loginInfo->access_token : '' )
			->build();
	}
}
