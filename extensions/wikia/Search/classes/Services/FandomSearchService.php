<?php

namespace Wikia\Search\Services;

class FandomSearchService extends EntitySearchService {
	const RESULTS_COUNT = 6;

	protected function getCore() {
		return 'fandom';
	}

	protected function prepareQuery( string $phrase ) {
		$select = $this->getSelect();

		// escape query text properly to prevent HTTP 500 errors
		$queryText = 'title:%P1% excerpt_t:%P1% content_t:%P1%';
		$params = [ $phrase ];

		$select->setQuery( $queryText, $params );
		$select->clearFields()->addFields( [ 'title', 'url', 'image_s', 'excerpt_t', 'vertical_s' ] );
		$select->setRows( static::RESULTS_COUNT );

		return $select;
	}

	protected function consumeResponse( $response ) {
		$results = [];
		foreach ( $response as $item ) {
			$results[] = [
				'title' => $item['title'],
				'excerpt' => $item['excerpt_t'],
				'vertical' => $item['vertical_s'],
				'image' => $item['image_s'],
				'url' => $item['url']
			];
		}

		return $results;
	}

}
