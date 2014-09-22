<?php

namespace Wikia\Search\Services;

use Wikia\Search\Services\Helpers\OutputFormatter;

class ExactSeriesSearchService extends EntitySearchService {

	const ARTICLES_LIMIT = 1;
	const MINIMAL_ARTICLE_SCORE = 5;
	const API_URL = 'api/v1/Articles/AsSimpleJson?id=';

	public function __construct( $client = null, $helper = null ) {
		$helper = ( $helper == null ) ? new OutputFormatter() : $helper;
		parent::__construct( $client, $helper );
	}

	protected function prepareQuery( $query ) {
		$select = $this->getSelect();

		$phrase = $this->sanitizeQuery( $query );
		$slang = $this->getLang();
		$select->setQuery( '+(tv_series_mv_em:"' . $phrase . '") AND +(lang_s:' . $slang . ')' );
		$select->createFilterQuery( 'no_episodes' )->setQuery( '-(tv_episode_mv_em:*)' );
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
					'url' => $this->getHelper()->replaceHostUrl( $item['url'] ),
					'quality' => $item['article_quality_i'],
					'contentUrl' => $this->getHelper()->replaceHostUrl( 'http://' . $item['host'] . '/' . static::API_URL . $item['pageid'] ),
				];
			}
		}
		return null;
	}

}