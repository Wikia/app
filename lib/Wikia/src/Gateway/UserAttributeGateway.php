<?php
namespace Wikia\Gateway;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Wikia\Logger\Loggable;
use function GuzzleHttp\Psr7\build_query;

class UserAttributeGateway {
	use Loggable;

	/** @var string $baseUrl */
	private $baseUrl;
	/** @var Client $httpClient */
	private $httpClient;

	public function __construct( string $baseUrl, Client $httpClient ) {
		$this->baseUrl = $baseUrl;
		$this->httpClient = $httpClient;
	}

	public function getAllAttributesForMultipleUsers( array $userIds ): array {
		try {
			$res = $this->httpClient->get( "{$this->baseUrl}/user/bulk", [
				RequestOptions::QUERY => build_query( [ 'id' => $userIds ], PHP_QUERY_RFC1738 )
			] );
			$body = (string)$res->getBody();

			return json_decode( $body, true );
		} catch ( ClientException $clientException ) {
			if ( $clientException->getCode() !== 404 ) {
				$this->error( 'error while fetching attributes for multiple users', [ 'exception' => $clientException ] );
			}
		} catch ( GuzzleException $serverException ) {
			$this->error( 'error while fetching attributes for multiple users', [ 'exception' => $serverException ] );
		}

		return [];
	}
}
