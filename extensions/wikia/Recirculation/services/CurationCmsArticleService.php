<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Wikia\Factory\ServiceFactory;
use Wikia\Logger\WikiaLogger;
use function GuzzleHttp\Psr7\build_query;

class CurationCmsArticleService implements FandomArticleService {
	const FAILED_TO_CALL_CURATION_CMS = "Failed to call curation-cms";
	const FANDOM_SITE_NAME = 'Fandom';

	const REQUEST_TIMEOUT_SECONDS = 2.0;
	const EXTRA_POSTS_TO_FETCH = 20;

	private const FANDOM_BASE_URL = 'https://www.fandom.com';

	/** @var string */
	private $baseUrl;

	public function __construct() {
		$urlProvider = ServiceFactory::instance()->providerFactory()->urlProvider();
		$this->baseUrl = 'http://' . $urlProvider->getUrl( 'curation-cms' ) . '/stories/feed/articles';
	}

	/**
	 * @param $limit
	 * @return ResponseInterface
	 * @throws WikiaException
	 */
	private function doApiRequest( int $limit ): ResponseInterface {
		$client = new Client( [
			'base_uri' => $this->baseUrl,
			'timeout' => static::REQUEST_TIMEOUT_SECONDS,
		] );

		$params = [
			'limit' => $limit + static::EXTRA_POSTS_TO_FETCH,
		];

		try {
			return $client->get( '', [
				'query' => build_query( $params, PHP_QUERY_RFC1738 ),
			] );
		}
		catch ( ClientException $e ) {
			WikiaLogger::instance()->error( self::FAILED_TO_CALL_CURATION_CMS, [
				'error_message' => $e->getMessage(),
				'status_code' => $e->getCode(),
			] );

			throw new WikiaException( self::FAILED_TO_CALL_CURATION_CMS, 500, $e );
		}
	}

	private static function getThumbnail( array $imageData ): string {
		if ( isset( $imageData['key'], $imageData['width'], $imageData['height'] ) ) {
			if ( VignetteRequest::isVignetteUrl( $imageData['url'] ) ) {
				return VignetteRequest::fromUrl( $imageData['url'] )
					->width( $imageData['width'] )
					->height( $imageData['height'] )
					->url();
			}
		}

		return $imageData['url'] ?? false;
	}

	public function getTrendingFandomArticles( int $limit ): array {
		$response = $this->doApiRequest( $limit );
		$data = json_decode( $response->getBody(), true );
		$posts = [];

		if ( isset( $data['feed'] ) ) {
			foreach ( $data['feed'] as $post ) {
				$id = $post['id'] ?? false;
				$headline = $post['headline'] ?? false;
				// IW-2588: Hotfix to prevent showcase URLs from polluting the production cache
				$articlePath = isset( $post['sourceUrl'] ) ? parse_url( $post['sourceUrl'], PHP_URL_PATH ) : false;
				$thumbnail = isset( $post['image'] ) ? self::getThumbnail( $post['image'] ) : false;

				if ( $id && $articlePath && $headline && $thumbnail ) {
					$posts[$id] = [
						'title' => $headline,
						'url' => self::FANDOM_BASE_URL . $articlePath,
						'thumbnail' => $thumbnail,
						'site_name' => static::FANDOM_SITE_NAME,
					];
				}

				if ( count( $posts ) >= $limit ) {
					break;
				}
			}
		}

		return array_values( $posts );
	}
}
