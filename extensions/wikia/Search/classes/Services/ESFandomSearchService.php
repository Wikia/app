<?php

namespace Wikia\Search\Services;

class ESFandomSearchService extends AbstractSearchService {
	const RESULTS_COUNT = 6;

	protected function prepareQuery( $phrase ) {
		return urlencode( $phrase );
	}

	protected function select( $query ) {
		global $wgConsulServiceTag, $wgConsulUrl;

		$consulUrl =
			( new \Wikia\Service\Gateway\ConsulUrlProvider( $wgConsulUrl,
				$wgConsulServiceTag ) )->getUrl( 'fandom-search' );

		$response = \Http::post( "http://$consulUrl/fandom", array(
			'noProxy' => true,
			'postData' => "queryTerms=$query",
			'headers' => [
				'Content-Type' => 'application/x-www-form-urlencoded',
			],
		) );
		if ( $response !== false ) {
			$decodedResponse = json_decode( $response, true );
			if ( json_last_error() !== JSON_ERROR_NONE ) {
				\WikiaLogger::instance()->error( " Fandom Stories Search: error decoding response", [
					'query' => $query,
					'response' => $response,
					'error' => json_last_error(),
				] );
			} else {
				if ( isset( $decodedResponse['hits']['hits'] ) ) {
					return $decodedResponse['hits']['hits'];
				} else {
					\WikiaLogger::instance()->error( " Fandom Stories Search: invalid response", [
						'query' => $query,
						'response' => $response
					] );
				}
			}
		} else {
			\WikiaLogger::instance()->error( " Fandom Stories Search: empty response", [
				'query' => $query,
			] );
		}

		// Must return an array of results or an empty array - don't return any errors here
		return [];
	}

	protected function consumeResponse( $response ) {
		$results = [];

		foreach ( $response as $item ) {
			if ( isset( $item['_source'] ) ) {
				$source = $item['_source'];

				$results[] = [
					'title' => html_entity_decode( $source['title'] ),
					'excerpt' => isset( $source['excerpt'] )
						? html_entity_decode( $source['excerpt'] ) : '',
					'vertical' => html_entity_decode( $source['vertical'] ),
					'image' => html_entity_decode( $source['image_url'] ),
					'url' => html_entity_decode( $source['url'] ),
				];
				if ( count( $results ) >= ESFandomSearchService::RESULTS_COUNT ) {
					break;
				}
			}
		}

		return $results;
	}

}
