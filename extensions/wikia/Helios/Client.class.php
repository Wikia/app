<?php
namespace Wikia\Helios;
use Wikia\Util\RequestId;

/**
 * A client for Wikia authentication service.
 *
 * This is a naive implementation.
 */
class Client
{
	protected $baseUri;
	protected $clientId;
	protected $clientSecret;
	
	/**
	 * The constructor.
	 */
	public function __construct( $baseUri, $clientId, $clientSecret )
	{
		$this->baseUri = $baseUri;
		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
	}

	/**
	 * The general method for handling the communication with the service.
	 */
	public function request( $resourceName, $getParams = [], $postData = [], $extraRequestOptions = [] )
	{
		// Crash if we cannot make HTTP requests.
		\Wikia\Util\Assert::true( \MWHttpRequest::canMakeRequests() );

		// Add client_id and client_secret to the GET data.
		$getParams['client_id'] = $this->clientId;
		$getParams['client_secret'] = $this->clientSecret;
		
		// Request URI pre-processing.
		$uri = "{$this->baseUri}{$resourceName}?" . http_build_query($getParams);
		
		// Request options pre-processing.
		$options = [
			'method'          => 'GET',
			'timeout'         => 5,
			'postData'        => $postData,
			'noProxy'         => true,
			'followRedirects' => false,
			'returnInstance'  => true,
			'internalRequest' => true,
		];

		$options = array_merge( $options, $extraRequestOptions );

		// Request execution.
		/** @var \MWHttpRequest $request */
		$request = \Http::request( $options['method'], $uri, $options );
		$status = $request->status;

		// Response handling.
		if ( !$status->isGood() ) {
			throw new ClientException( 'Request failed.', 0, null, $status->getErrorsArray() );
		}

		$output = json_decode( $request->getContent() );
		
		if ( !$output ) {
			throw new ClientException( 'Invalid response.' );
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
			[ 'grant_type'	=> 'password' ],
			$postData,
			[ 'method'	=> 'POST' ]
		);

		return $response;
	}

	/**
	 * A shortcut method for register requests.
	 */
	public function register( $username, $password, $email )
	{
		// Convert the array to URL-encoded query string, so the Content-Type
		// for the POST request is application/x-www-form-urlencoded.
		// It would be multipart/form-data which is not supported
		// by the Helios service.
		$postData = http_build_query([
			'username'	=> $username,
			'password'	=> $password,
			'email'		=> $email
		]);

		return $this->request(
			'register',
			[],
			$postData,
			[ 'method'	=> 'POST' ]
		);
	}

	/**
	 * A shortcut method for info requests
	 */
	public function info( $token )
	{
		return $this->request(
			'info',
			[ 'code' => $token ]
		);
	}

	/**
	 * A shortcut method for refresh token requests.
	 */
	public function refreshToken( $token )
	{
		return $this->request(
			'token',
			[
				'grant_type'	=> 'refresh_token',
				'refresh_token'	=> $token
			]
		);
	}

}
