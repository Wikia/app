<?php
namespace Wikia\Gateway;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Wikia\Logger\Loggable;

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
		$query = [];

		foreach ( $userIds as $userId ) {
			$validUserId = intval( $userId );

			if ( $validUserId ) {
				$query[] = "id=$validUserId";
			}
		}

		try {
			$res = $this->httpClient->get( "{$this->baseUrl}/user/bulk", [ 'query' => implode( '&', $query ) ] );
			$body = (string)$res->getBody();

			return json_decode( $body, true );
		} catch ( ServerException $serverException ) {
			$this->error( 'error while fetching attributes for multiple users', [ 'exception' => $serverException ] );
		} catch ( ClientException $clientException ) {
			if ( $clientException->getCode() !== 404 ) {
				$this->error( 'error while fetching attributes for multiple users', [ 'exception' => $clientException ] );
			}
		}

		return [];
	}
}
