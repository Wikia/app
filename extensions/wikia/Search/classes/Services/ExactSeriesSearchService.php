<?php

namespace Wikia\Search\Services;

class ExactSeriesSearchService extends EntitySearchService {

	const ARTICLES_LIMIT = 1;
	const MINIMAL_ARTICLE_SCORE = 5;
	const API_URL = 'api/v1/Articles/AsSimpleJson?id=';
	const EXACT_MATCH_FIELD = "tv_series_mv_em";

	protected function prepareQuery( $query ) {
		$select = $this->getSelect();

		$phrase = $this->sanitizeQuery( $query );
		$select->setQuery( static::EXACT_MATCH_FIELD . ':"' . $phrase . '"' );
		$select->setRows( static::ARTICLES_LIMIT );

		return $select;
	}

	protected function consumeResponse( $response ) {
		foreach ( $response as $item ) {
			if ( $item[ 'score' ] > static::MINIMAL_ARTICLE_SCORE ) {
				return [
					'wikiId' => $item[ 'wid' ],
					'articleId' => $item[ 'pageid' ],
					'title' => $item[ 'title_' . $this->getLang() ],
					'url' => $this->replaceHostUrl( $item[ 'url' ] ),
					'quality' => $item[ 'article_quality_i' ],
					'contentUrl' => $this->replaceHostUrl( 'http://' . $item[ 'host' ] . '/' . self::API_URL . $item[ 'pageid' ] ),
				];
			}
		}
		return null;
	}

}