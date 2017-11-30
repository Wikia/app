<?php

namespace Wikia\Search\Services;

use Wikia\Logger\WikiaLogger;
use Wikia\Service\Gateway\KubernetesUrlProvider;

class ESFandomSearchService extends AbstractSearchService {

	const LOG_QUERY_MARKER = 'query';
	const LOG_RESPONSE_MARKER = 'response';
	const LOG_ERROR_MARKER = 'error';

	const STORIES_TITLE_KEY = 'title';
	const STORIES_EXCERPT_KEY = 'excerpt';
	const STORIES_VERTICAL_KEY = 'vertical';
	const STORIES_IMAGE_URL_KEY = 'image';
	const STORIES_URL_KEY = 'url';
	const STORIES_COUNT_MAX = 6;
	const STORIES_SEARCH_TEMPLATE = 'fandom_stories';

	const MATCHES_ITEM_KEY = '_source';
	const MATCHES_TITLE_KEY = 'title';
	const MATCHES_EXCERPT_KEY = 'excerpt';
	const MATCHES_VERTICAL_KEY = 'vertical';
	const MATCHES_IMAGE_URL_KEY = 'image_url';
	const MATCHES_URL_KEY = 'url';


	protected function getFandomSearchServiceUrl() {
		global $wgWikiaEnvironment, $wgWikiaDatacenter;

		return ( new KubernetesUrlProvider( $wgWikiaEnvironment, $wgWikiaDatacenter ) )
			->getUrl( 'fandom-search-service' );
	}

	protected function prepareQuery( string $query ) {
		return urlencode( $query );
	}

	protected function select( $query ) {

		$serviceUrl = $this->getFandomSearchServiceUrl();

		$response = \Http::post(
			"http://$serviceUrl/fandom/search",
			[
				'noProxy' => true,
				'postData' => "queryTerms=$query&template=" . ESFandomSearchService::STORIES_SEARCH_TEMPLATE,
				'headers' => [
					'Content-Type' => 'application/x-www-form-urlencoded',
				],
			]
		);
		if ( $response !== false ) {
			$decodedResponse = json_decode( $response, true );
			if ( json_last_error() !== JSON_ERROR_NONE ) {
				WikiaLogger::instance()->error(
					" Fandom Stories Search: error decoding response",
					[
						ESFandomSearchService::LOG_QUERY_MARKER => $query,
						ESFandomSearchService::LOG_RESPONSE_MARKER => $response,
						ESFandomSearchService::LOG_ERROR_MARKER => json_last_error(),
					]
				);
			} else {
				if ( isset( $decodedResponse['hits']['hits'] ) ) {
					return $decodedResponse['hits']['hits'];
				} else {
					WikiaLogger::instance()->error(
						" Fandom Stories Search: invalid response",
						[
							ESFandomSearchService::LOG_QUERY_MARKER => $query,
							ESFandomSearchService::LOG_RESPONSE_MARKER => $response
						]
					);
				}
			}
		} else {
			WikiaLogger::instance()->error(
				" Fandom Stories Search: empty response",
				[
					ESFandomSearchService::LOG_QUERY_MARKER => $query,
				]
			);
		}

		// Must return an array of results or an empty array - don't return any errors here
		return [];
	}

	protected function consumeResponse( $response ) {
		$results = [];

		foreach ( $response as $match ) {
			if ( isset( $match[ESFandomSearchService::MATCHES_ITEM_KEY] ) &&
				isset( $match[ESFandomSearchService::MATCHES_ITEM_KEY][ESFandomSearchService::MATCHES_TITLE_KEY] ) &&
				isset( $match[ESFandomSearchService::MATCHES_ITEM_KEY][ESFandomSearchService::MATCHES_URL_KEY] )
			) {

				$source = $match[ESFandomSearchService::MATCHES_ITEM_KEY];

				$results[] = [
					ESFandomSearchService::STORIES_TITLE_KEY =>
						html_entity_decode( $source[ESFandomSearchService::MATCHES_TITLE_KEY] ),
					ESFandomSearchService::STORIES_EXCERPT_KEY =>
						isset( $source[ESFandomSearchService::MATCHES_EXCERPT_KEY] )
							? html_entity_decode( $source[ESFandomSearchService::MATCHES_EXCERPT_KEY] )
							: '',
					ESFandomSearchService::STORIES_VERTICAL_KEY =>
						isset( $source[ESFandomSearchService::MATCHES_VERTICAL_KEY] )
							? html_entity_decode( $source[ESFandomSearchService::MATCHES_VERTICAL_KEY] )
							: '',
					ESFandomSearchService::STORIES_IMAGE_URL_KEY =>
						isset( $source[ESFandomSearchService::MATCHES_IMAGE_URL_KEY] )
							? html_entity_decode( $source[ESFandomSearchService::MATCHES_IMAGE_URL_KEY] )
							: '',
					ESFandomSearchService::STORIES_URL_KEY =>
						html_entity_decode( $source[ESFandomSearchService::MATCHES_URL_KEY] ),
				];
				if ( count( $results ) >= ESFandomSearchService::STORIES_COUNT_MAX ) {
					break;
				}
			}
		}

		return $results;
	}

}
