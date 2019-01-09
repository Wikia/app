<?php

class ParselyService implements FandomArticleService {

	const REQUEST_TIMEOUT_SECONDS = 2;
	const EXTRA_POSTS_TO_FETCH = 10;

	/** @var string $baseUrl */
	private $baseUrl;
	/** @var string $apiKey */
	private $apiKey;
	/** @var string $apiSecret*/
	private $apiSecret;

	public function __construct( string $baseUrl, string $apiKey, string $apiSecret ) {
		$this->baseUrl = $baseUrl;
		$this->apiKey = $apiKey;
		$this->apiSecret = $apiSecret;
	}

	public function getTrendingFandomArticles( int $limit ): array {
		$response = $this->getParselyResponse( 'analytics/posts', [
			'limit' => $limit + static::EXTRA_POSTS_TO_FETCH,
			'section' => 'articles',
			'pub_date_start' => '30d'
		] );

		$posts = [];

		if ( isset( $response['data'] ) ) {
			foreach ( $response['data'] as $postData ) {
				$metadata = json_decode( $postData['metadata'], true );

				if ( isset( $metadata['postID'] ) ) {
					$posts[$metadata['postID']] = [
						'title' => $postData['title'],
						'url' => $postData['url'],
						'thumbnail' => $postData['image_url'],
					];
				}

				if ( count( $posts ) >= $limit ) {
					break;
				}
			}
		}

		return array_values( $posts );
	}

	private function getParselyResponse( string $path, array $query ): array {
		$query += [
			'apikey' => $this->apiKey,
			'secret' => $this->apiSecret
		];

		// force deterministic ordering of parameters, for easy testing
		ksort( $query );

		$url = $this->baseUrl . $path . '?' . http_build_query( $query );
		$response = ExternalHttp::get( $url, static::REQUEST_TIMEOUT_SECONDS );

		if ( $response ) {
			return json_decode( $response, true ) ?? [];
		}

		return [];
	}
}
