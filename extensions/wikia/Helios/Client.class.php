<?php
namespace Wikia\Helios;

/**
 * Class Client
 *
 * The Helios Client for Wikia's MediaWiki-based application.
 */
class Client
{
    /**
     * @var
     */
    protected $sBaseUri;

    /**
     * @var
     */
    protected $sClientId;

    /**
     * @var
     */
    protected $sClientSecret;

    /**
     * @param $sBaseUri
     * @param $sClientId
     * @param $sClientSecret
     */
    public function __construct( $sBaseUri, $sClientId, $sClientSecret )
    {
        $this->sBaseUri = $sBaseUri;
        $this->sClientId = $sClientId;
        $this->sClientSecret = $sClientSecret;
    }

    /**
     * @param $sResource
     * @param array $aGetData
     * @param array $aPostData
     * @param array $aCustomOptions
     * @return mixed|string
     * @throws ClientException
     * @throws \Wikia\Util\AssertionException
     */
    public function request( $sResource, $aGetData = [], $aPostData = [], $aCustomOptions = [] )
    {
        // Crash as soon as we know we are unable to make HTTP requests.
        \Wikia\Util\Assert::true( \MWHttpRequest::canMakeRequests() );

        // Request URI pre-processing.
        $sUri = "{$this->sBaseUri}{$sResource}?client_id={$this->sClientId}&client_secret={$this->sClientSecret}&";
        $sUri .= http_build_query($aGetData);

        // Request options pre-processing.
        $aDefaultOptions = [
            'method'            => 'GET',
            'timeout'           => 5,
            'postData'          => $aPostData,
            'noProxy'           => true,
            'followRedirects'   => false,
            'returnInstance'    => true
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
     * @param $sUsername
     * @param $sPassword
     * @return mixed|string
     * @throws ClientException
     */
    public function login( $sUsername, $sPassword )
    {
        return $this->request(
            'token',
            [ 'grant_type' => 'password', 'username' => $sUsername, 'password' => $sPassword ],
            [],
            [ 'method' => 'GET' ]
        );
    }

    /**
     * @param $sToken
     * @return mixed|string
     * @throws ClientException
     */
    public function info( $sToken )
    {
        return $this->request(
            'info',
            [],
            [ 'code' => $sToken ],
            []
        );
    }

    /**
     * @param $sToken
     * @return mixed|string
     * @throws ClientException
     */
    public function refreshToken( $sToken )
    {
        return $this->request(
            'token',
            [],
            [ 'grant_type' => 'refresh_token', 'refresh_token' => $sToken ],
            []
        );
    }
}

/**
 * Class ClientException
 *
 * The basic exception class for exceptions raised by the Helios Client.
 */
class ClientException extends \Exception
{

}