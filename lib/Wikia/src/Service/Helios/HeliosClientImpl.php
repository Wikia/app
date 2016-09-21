<?php
namespace Wikia\Service\Helios;

use Wikia\Tracer\WikiaTracer;
use Wikia\Util\GlobalStateWrapper;
use Wikia\Service\Constants;

/**
 * @Injectable(lazy=true)
 * A client for Wikia authentication service.
 *
 * This is a naive implementation.
 */
class HeliosClientImpl implements HeliosClient
{
	const BASE_URI = "helios_base_uri";
	const SCHWARTZ_TOKEN = "schwartz_token";
	const SCHWARTZ_HEADER_NAME = 'THE-SCHWARTZ';
	protected $baseUri;
	protected $status;
	protected $schwartzToken;

	/**
	 * @Inject({
	 *   Wikia\Service\Helios\HeliosClientImpl::BASE_URI,
	 *   Wikia\Service\Helios\HeliosClientImpl::SCHWARTZ_TOKEN})
	 * The constructor.
	 * @param string $baseUri
	 */
	public function __construct( $baseUri, $schwartzToken ) {
		$this->baseUri = $baseUri;
		$this->schwartzToken = $schwartzToken;
	}

	/**
	 * Returns the status of the last request.
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * The general method for handling the communication with the service.
	 */
	public function request( $resourceName, $getParams = [], $postData = [], $extraRequestOptions = [] )
	{
		// Crash if we cannot make HTTP requests.
		\Wikia\Util\Assert::true( \MWHttpRequest::canMakeRequests() );

		// Request URI pre-processing.
		$uri = "{$this->baseUri}{$resourceName}?" . http_build_query($getParams);

		// Appending the request remote IP for client to be able to
		// identify the source of the remote request.
		if ( isset( $extraRequestOptions['headers'] ) ) {
			$headers = $extraRequestOptions['headers'];
			unset( $extraRequestOptions['headers'] );
		} else {
			$headers = [];
		}

		global $wgRequest;
		$headers['X-Forwarded-For'] = $wgRequest->getIP();

		// adding internal headers
		WikiaTracer::instance()->setRequestHeaders( $headers, true );

		// Request options pre-processing.
		$options = [
			'method'          => 'GET',
			'timeout'         => 5,
			'postData'        => $postData,
			'noProxy'         => true,
			'followRedirects' => false,
			'returnInstance'  => true,
			'internalRequest' => true,
			'headers'         => $headers,
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

		// Request execution.
		/** @var \MWHttpRequest $request */
		$request = $wrapper->wrap( function() use ( $options, $uri ) {
			return \Http::request( $options['method'], $uri, $options );
		} );

		$this->status = $request->getStatus();
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
			$data[ "response" ] = $response;
			$data["status_code"] = $request->getStatus();
			throw new ClientException ( 'Invalid Helios response.', 0, null, $data );
		}

		return $output;
	}

	/**
	 * A shortcut method for login requests.
	 *
	 * @throws ClientException
	 */
	public function login( $username, $password )
	{
		// Convert the array to URL-encoded query string, so the Content-Type
		// for the POST request is application/x-www-form-urlencoded.
		// It would be multipart/form-data which is not supported
		// by the Helios service.
		$postData = http_build_query([
			'username'	=> $username,
			'password'	=> $password
		]);

		$response = $this->request(
			'token',
			[],
			$postData,
			[ 'method'	=> 'POST' ]
		);

		return [$this->status, $response];
	}

	/**
	 * A shortcut method to remove all tokens for user in helios
	 *
	 * @param $userId int for remove user tokens
	 * @internal param $username
	 * @return null
	 */
	public function forceLogout( $userId ) {
		return $this->request(
			sprintf( 'users/%s/tokens', $userId ),
			[ ],
			[ ],
			[
				'method' => 'DELETE',
				'headers' => [ self::SCHWARTZ_HEADER_NAME => $this->schwartzToken ]
			]
		);
	}

	/**
	 * A shortcut method for info requests
	 */
	public function info( $token )
	{
		return $this->request(
			'info',
			[
				'code' => $token,
				'noblockcheck' => 1,
			]
		);
	}

	/**
	 * A shortcut method for token invalidation requests.
	 *
	 * @param $token string - a token to be invalidated
	 * @param $userId integer - the current user id
	 *
	 * @return string - json encoded response
	 */
	public function invalidateToken( $token, $userId )
	{
		return $this->request(
			sprintf('token/%s', $token),
			[],
			[],
			[ 'method' => 'DELETE',
				'headers' => array( Constants::HELIOS_AUTH_HEADER => $userId ) ]
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
	public function generateToken( $userId )
	{
		return $this->request(
			sprintf('users/%s/tokens', $userId),
			[],
			[],
			[ 'method' => 'POST' ]
		);
	}

	/**
	* A shortcut method for register requests.
	*/
	public function register( $username, $password, $email, $birthdate, $langCode )
	{
			// Convert the array to URL-encoded query string, so the Content-Type
			// for the POST request is application/x-www-form-urlencoded.
			// It would be multipart/form-data which is not supported
			// by the Helios service.
			$postData = http_build_query( [
				'username'  => $username,
				'password'  => $password,
				'email'     => $email,
				'birthdate' => $birthdate,
				'langCode'  => $langCode,
			] );

			return $this->request(
				'users',
				[],
				$postData,
				[ 'method'	=> 'POST' ]
			);
	}

}
