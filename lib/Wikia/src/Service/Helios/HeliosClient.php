<?php
namespace Wikia\Service\Helios;

use Wikia\CircuitBreaker\ServiceCircuitBreaker;
use Wikia\Tracer\WikiaTracer;
use Wikia\Util\GlobalStateWrapper;
use Wikia\Service\Constants;
use \Wikia\Util\Assert;

/**
 * A client for Wikia authentication service.
 *
 * This is a naive implementation.
 */
class HeliosClient {
	const SCHWARTZ_HEADER_NAME = 'THE-SCHWARTZ';
	const USERNAME = 'username';
	const PASSWORD = 'password'; //NOSONAR
	const EMAIL = 'email';
	const METHOD = 'method';
	const HEADERS = 'headers';
	const METHOD_POST = 'POST';
	const METHOD_DELETE = 'DELETE';


	// Timeout (in seconds) of the Helios HTTP requests.
	const HELIOS_REQUEST_TIMEOUT_SEC = 2;

	// Maximum number of Helios HTTP connection attempts.
	const HELIOS_REQUEST_TRIES = 2;

	// Delay for Helios HTTP connection retries.
	const HELIOS_REQUEST_RETRY_DELAY_SEC = 1;

	protected $baseUri;
	protected $status;
	protected $responseHeaders;
	protected $schwartzToken;

	/** @var ServiceCircuitBreaker */
	protected $circuitBreaker;

	/**
	 *
	 * @param string $baseUri
	 * @param string $schwartzToken
	 * @param ServiceCircuitBreaker $circuitBreaker
	 */
	public function __construct( string $baseUri, string $schwartzToken, ServiceCircuitBreaker $circuitBreaker ) {
		$this->baseUri = $baseUri;
		$this->schwartzToken = $schwartzToken;
		$this->circuitBreaker = $circuitBreaker;
	}

	/**
	 * Returns the status of the last request.
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Returns one of the response headers with a default values as a fallback
	 *
	 * Because some headers can appear more than once the, this method returns
	 * an array of the values.
	 *
	 * @param $header Header name
	 * @param string $default value returned in case of missing header
	 * @return array
	 */
	public function getResponseHeader( $header, $default = [''] ) {
		$header = strtolower( $header );
		if ( is_array( $this->responseHeaders ) && array_key_exists( $header, $this->responseHeaders ) ) {
			return $this->responseHeaders[$header];
		}
		return $default;
	}

	/**
	 * The general method for handling the communication with the service.
	 *
	 * @param       $resourceName
	 * @param array $getParams
	 * @param array $postData
	 * @param array $extraRequestOptions
	 *
	 * @return mixed|null
	 * @throws ClientException
	 * @throws \Wikia\Util\AssertionException
	 */
	public function request( $resourceName, $getParams = [], $postData = [], $extraRequestOptions = [] ) {
		// Crash if we cannot make HTTP requests.
		Assert::true( \MWHttpRequest::canMakeRequests() );
		// reset the response data as client can be used to make multiple requests
		$this->status = null;
		$this->responseHeaders = null;

		if ( !$this->circuitBreaker->operationAllowed() ) {
			throw new ClientException( "circuit breaker open" );
		}

		// Request URI pre-processing.
		$uri = "{$this->baseUri}{$resourceName}?" . http_build_query( $getParams );

		// Appending the request remote IP for client to be able to
		// identify the source of the remote request.
		if ( isset( $extraRequestOptions[ self::HEADERS ] ) ) {
			$headers = $extraRequestOptions[ self::HEADERS ];
			unset( $extraRequestOptions[ self::HEADERS ] );
		} else {
			$headers = [];
		}

		global $wgRequest;
		$headers['X-Forwarded-For'] = $wgRequest->getIP();

		// adding internal headers
		WikiaTracer::instance()->setRequestHeaders( $headers, true );

		// Request options pre-processing.
		$options = [
			self::METHOD      => 'GET',
			'timeout'         => self::HELIOS_REQUEST_TIMEOUT_SEC,
			'postData'        => http_build_query( $postData ),
			'noProxy'         => true,
			'followRedirects' => false,
			'returnInstance'  => true,
			'internalRequest' => true,
			self::HEADERS     => $headers,
		];

		$options = array_merge( $options, $extraRequestOptions );

		/*
		 * MediaWiki's MWHttpRequest class heavily relies on Messaging API
		 * (wfMessage()) which happens to rely on the value of $wgLang.
		 * $wgLang is set after $wgUser. On per-request authentication with
		 * an access token we use MWHttpRequest before wgUser is created so
		 * we need $wgLang to be present. With GlobalStateWrapper we can set
		 * the global variable in the local, function's scope, so it is the
		 * same as the already existing $wgContLang.
		 */
		global $wgContLang;
		$wrapper = new GlobalStateWrapper( [ 'wgLang' => $wgContLang ] );

		/*
		 * We have self::HELIOS_REQUEST_RETRIES tries to receive an HTTP response from Helios.
		 * One thing to keep in mind is that Helios address resolution is done by AuthModule
		 * using Consul at the beginning of the request, so the retry will hit the same
		 * Helios instance.
		 */
		$retryCnt = 1;
		while ( true ) {

			// Request execution.
			/** @var \MWHttpRequest $request */
			$request = $wrapper->wrap( function () use ( $options, $uri ) {
				return \Http::request( $options[ self::METHOD ], $uri, $options );
			} );

			/*
			 * $request->getStatus returns 200 when we failed to make http connection, so
			 * we use the internal status object to check for http connection errors.
			 * The general idea here is that we will make extra requests if we fail
			 * to receive an HTTP response from Helios.
			 */

			if ( $retryCnt >= self::HELIOS_REQUEST_TRIES ||
				( !$request->status->hasMessage( 'http-timed-out' ) &&
					!$request->status->hasMessage( 'http-curl-error' ) )
			) {
				break;
			}
			$retryCnt += 1;
			sleep( self::HELIOS_REQUEST_RETRY_DELAY_SEC );
		}
		$this->status = $request->getStatus();
		$this->responseHeaders = $request->getResponseHeaders();
		$this->circuitBreaker->setOperationStatus( $this->status < 500 );

		return $this->processResponseOutput( $request );
	}

	protected function processResponseOutput( \MWHttpRequest $request ) {
		if ( $request->getStatus() == Constants::HTTP_STATUS_NO_CONTENT ) {
			return null;
		}

		$response = $request->getContent();
		$output = json_decode( $response );

		if ( !$output ) {
			$data = [];
			$data['response'] = $response;
			$data['status_code'] = $request->getStatus();
			if ( !$request->status->isOK() ) {
				$data['status_errors'] = $request->status->getErrorsArray();
			}
			throw new ClientException ( 'Invalid Helios response.', 0, null, $data );
		}

		return $output;
	}

	/**
	 * A shortcut method for login requests.
	 *
	 * @param $username
	 * @param $password
	 *
	 * @return array
	 */
	public function login( $username, $password ) {
		// Convert the array to URL-encoded query string, so the Content-Type
		// for the POST request is application/x-www-form-urlencoded.
		// It would be multipart/form-data which is not supported
		// by the Helios service.
		$postData = [
			self::USERNAME => $username,
			self::PASSWORD => $password,
		];

		$response = $this->request(
			'token',
			[],
			$postData,
			[ self::METHOD => self::METHOD_POST ]
		);

		return [ $this->status, $response ];
	}

	/**
	 * A shortcut method to remove all tokens for user in helios
	 *
	 * @param $userId int for remove user tokens
	 *
	 * @internal param $username
	 * @return null
	 */
	public function forceLogout( $userId ) {
		return $this->request(
			sprintf( 'users/%s/tokens', $userId ),
			[],
			[],
			[
				self::METHOD  => self::METHOD_DELETE,
				self::HEADERS => [ self::SCHWARTZ_HEADER_NAME => $this->schwartzToken ],
			]
		);
	}

	/**
	 * A shortcut method for info requests
	 *
	 * @param $token
	 * @return mixed|null
	 */
	private function _info( $token ) {
		// @todo - rename to info once PLATFORM-4490 is resolved, remove $request param from the caller
		return $this->request(
			'info',
			[
				'code' => $token,
				'noblockcheck' => 1,
			]
		);
	}

	/**
	 * A shortcut method for info requests
	 *
	 * PLATFORM-4490 - validate Helios responses and retry in case of mismatches
	 * this method is a wrapper for the _info call, remove it once the issue is resolved
	 *
	 * @param $token
	 * @param WebRequest $request The HTTP request data as an object
	 * @return mixed|null
	 */
	public function info( $token, $request ) {
		$tries = 3;
		$currentCtx = \Wikia\Tracer\WikiaTracer::instance()->getContext();
		$sessionUserId = $request->getSessionData( 'helios_user_id' );
		while ( true ) {
			$tokenInfo = $this->_info( $token );
			if ( empty( $tokenInfo->user_id ) ) {
				return $tokenInfo;
			}
			$responseBeacon = $this->getResponseHeader( 'x-client-beacon-id' )[0];

			$wasUserIdMismatch = !$sessionUserId || $sessionUserId != $tokenInfo->user_id;
			$wasBeaconIdMismatch = isset( $currentCtx['client_beacon_id'] ) && $currentCtx['client_beacon_id'] != $responseBeacon;

			// check if Helios returned non-matching user_id. Sometimes it means user logged into a different account
			// so we compare beacons as well just to be sure there was a mismatch
			if ( $wasUserIdMismatch && $wasBeaconIdMismatch ) {
				// report an issue with the token mismatch
				\Wikia\Logger\WikiaLogger::instance()->error(
					'Helios beacon mismatch',
					[
						'sessionUserId' => $sessionUserId,
						'heliosResponse' => [
							'userId' => $tokenInfo->user_id,
							'accessToken' => $tokenInfo->access_token,
							'beacon' => $responseBeacon,
							'servedBy' => $this->getResponseHeader( 'x-served-by' )[0],
							'timestamp' => $this->getResponseHeader( 'x-backend-timestamp' )[0],
						],
					]
				);

				$tries--;
				if ( !$tries ) {
					// something is seriously wrong
					throw new ClientException( "Persistent Helios beacon mismatch" );
				}
			} else {
				// correct Helios response, store user id for future checks
				$request->setSessionData( 'helios_user_id', $tokenInfo->user_id );
				return $tokenInfo;
			}
		}
	}

	/**
	 * A shortcut method for token invalidation requests.
	 *
	 * @param $token  string - a token to be invalidated
	 * @param $userId integer - the current user id
	 *
	 * @return string - json encoded response
	 */
	public function invalidateToken( $token, $userId ) {
		return $this->request(
			sprintf( 'token/%s', $token ),
			[],
			[],
			[ self::METHOD  => self::METHOD_DELETE,
			  self::HEADERS => [ Constants::HELIOS_AUTH_HEADER => $userId ] ]
		);
	}

	/**
	 * Generate a token for a user.
	 * Warning: Assumes the user is already authenticated.
	 *
	 * @param $userId integer - the current user id
	 *
	 * @return array - JSON string deserialized into an associative array
	 */
	public function generateToken( $userId ) {
		return $this->request(
			sprintf( 'users/%s/tokens', $userId ),
			[],
			[],
			[ self::METHOD => self::METHOD_POST ]
		);
	}

	/**
	 * A shortcut method for register requests.
	 *
	 * @param $username
	 * @param $password
	 * @param $email
	 * @param $birthdate
	 * @param $langCode
	 *
	 * @return mixed|null
	 */
	public function register( $username, $password, $email, $birthdate, $langCode ) {
		// Convert the array to URL-encoded query string, so the Content-Type
		// for the POST request is application/x-www-form-urlencoded.
		// It would be multipart/form-data which is not supported
		// by the Helios service.
		$postData = [
			self::USERNAME => $username,
			self::PASSWORD => $password,
			'email'        => $email,
			'birthdate'    => $birthdate,
			'langCode'     => $langCode,
		];

		return $this->request(
			'users',
			[],
			$postData,
			[ self::METHOD => self::METHOD_POST ]
		);
	}

	public function setPassword( $userId, $password ) {
		$postData = [
			self::PASSWORD => $password,
		];

		return $this->request(
			sprintf( 'users/%s/password', $userId ),
			[],
			$postData,
			[ self::METHOD => 'PUT', self::HEADERS => [ Constants::HELIOS_AUTH_HEADER => $userId ] ]
		);
	}

	public function validatePassword( $password, $name, $email ) {
		$postData = [
			self::PASSWORD => $password,
			self::USERNAME => $name,
			self::EMAIL => $email,
		];

		return $this->request(
			'password/validation',
			[],
			$postData,
			[ self::METHOD => self::METHOD_POST ]
		);
	}

	public function deletePassword( $userId ) {
		return $this->request(
			sprintf( 'users/%s/password', $userId ),
			[],
			[],
			[ self::METHOD => self::METHOD_DELETE, self::HEADERS => [ Constants::HELIOS_AUTH_HEADER => $userId ] ]
		);
	}
}
