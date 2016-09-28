<?php

namespace Wikia\Search\Services;

class FandomSearchService extends EntitySearchService {
	const RESULTS_COUNT = 6;

	protected function getCore() {
		return 'fandom';
	}

	protected function prepareQuery( $query ) {
		$select = $this->getSelect();

		$phrase = $this->sanitizeQuery( $query );
		$select->setQuery( 'title:' . $phrase . ' excerpt_t:' . $phrase . ' content_t:' . $phrase );
		$select->clearFields()->addFields( [ 'title', 'url', 'image_s', 'excerpt_t', 'vertical_s' ] );
		$select->setRows( static::RESULTS_COUNT );

		return $select;
	}

	protected function consumeResponse( $response ) {
		$results = [ ];
		foreach ( $response as $item ) {
			$results[] = [
				'title' => $item[ 'title' ],
				'excerpt' => $item[ 'excerpt_t' ],
				'vertical' => $item[ 'vertical_s' ],
				'image' => $item[ 'image_s' ],
				'url' => $item[ 'url' ]
			];
		}

		return $results;
	}

}
