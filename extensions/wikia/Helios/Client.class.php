<?php
namespace Wikia\Helios;

/**
 * A client for Wikia authentication service.
 *
 * This is a naive implementation.
 */
class Client
{
	protected $sBaseUri;
	protected $sClientId;
	protected $sClientSecret;
	
	/**
	 * The constructor.
	 */
	public function __construct( $sBaseUri, $sClientId, $sClientSecret )
	{
		$this->sBaseUri = $sBaseUri;
		$this->sClientId = $sClientId;
		$this->sClientSecret = $sClientSecret;
	}

	/**
	 * The general method for handling the communication with the service.
	 */
	public function request( $sResource, $aGetData = [], $aPostData = [], $aCustomOptions = [] )
	{
		// Crash if we cannot make HTTP requests.
		\Wikia\Util\Assert::true( \MWHttpRequest::canMakeRequests() );
		
		// Request URI pre-processing.
		$sUri = "{$this->sBaseUri}{$sResource}?client_id={$this->sClientId}&client_secret={$this->sClientSecret}&";
		$sUri .= http_build_query($aGetData);
		
		// Request options pre-processing.
		$aDefaultOptions = [
			'method'		=> 'GET',
			'timeout'		=> 5,
			'postData'		=> $aPostData,
			'noProxy'		=> true,
			'followRedirects'	=> false,
			'returnInstance'	=> true
		];

		$aOptions = array_merge( $aDefaultOptions, $aCustomOptions );

		// Request execution.
		$oRequest = \MWHttpRequest::factory( $sUri, $aOptions );
		$oStatus = $oRequest->execute();

		// Response handling.
		if ( !$oStatus->isGood() ) {
			throw new ClientException('Request failed.');
		}

		$sOutput = json_decode( $oRequest->getContent() );
		
		if ( !$sOutput ) {
			throw new ClientException('Invalid response.');
		}

		return $sOutput;
	}

	/**
	 * A shortcut method for login requests.
	 */
	public function login( $sUsername, $sPassword )
	{
		return $this->request(
			'token',
			[ 'grant_type'	=> 'password' ],
			[
				'username'	=> $sUsername,
				'password'	=> $sPassword
			],
			[ 'method'	=> 'POST' ]
		);
	}

	/**
	 * A shortcut method for info requests
	 */
	public function info( $sToken )
	{
		return $this->request(
			'info',
			[ 'code' => $sToken ]
		);
	}

	/**
	 * A shortcut method for refresh token requests.
	 */
	public function refreshToken( $sToken )
	{
		return $this->request(
			'token',
			[
				'grant_type'	=> 'refresh_token',
				'refresh_token'	=> $sToken
			]
		);
	}

}

/**
 * An exception class for the client.
 */
class ClientException extends \Exception
{
	use \Wikia\Logger\Loggable;

	public function __construct( $message = null, $code = 0, Exception $previous = null ) {
		parent::__construct( $message, $code, $previous );
		$this->error( 'HELIOS_CLIENT' , [ 'exception' => $this ] );
	}
}
