<?php

namespace Wikia\Search\Services;

class ExactSeriesSearchService extends EntitySearchService {

	const ARTICLES_LIMIT = 1;
	const MINIMAL_ARTICLE_SCORE = 5;
	const API_URL = 'api/v1/Articles/AsSimpleJson?id=';
	const EXACT_MATCH_FIELD = "tv_series_mv_em";

	protected function prepareQuery( string $query ) {
		$select = $this->getSelect();

		$phrase = $this->sanitizeQuery( $query );
		$slang = $this->getLang();
		$select->setQuery( "+(" . static::EXACT_MATCH_FIELD . ':"' . $phrase . '") AND +(lang:' . $slang . ')' );
		$select->createFilterQuery( 'no_episodes' )->setQuery( '-(tv_episode_mv_em:*)' );
		$select->addSort( 'article_quality_i', 'desc' );
		$select->setRows( static::ARTICLES_LIMIT );

		return $select;
	}

	protected function consumeResponse( $response ) {
		foreach ( $response as $item ) {
			if ( $item['score'] > static::MINIMAL_ARTICLE_SCORE ) {
				return [
					'wikiId' => $item['wid'],
					'articleId' => $item['pageid'],
					'title' => $item['titleStrict'],
					'url' => $this->replaceHostUrl( $item['url'] ),
					'quality' => $item['article_quality_i'],
					'contentUrl' => $this->replaceHostUrl(
						'http://' . $item['host'] . '/' . static::API_URL . $item['pageid']
					),
				];
			}
		}

		return null;
	}

}
