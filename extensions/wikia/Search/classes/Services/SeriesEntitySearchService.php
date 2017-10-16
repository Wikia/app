<?php

namespace Wikia\Search\Services;

class SeriesEntitySearchService extends EntitySearchService {

	const DEFAULT_NAMESPACE = 0;
	const ARTICLES_LIMIT = 1;
	const MINIMAL_ARTICLE_SCORE = 5;
	const API_URL = 'api/v1/Articles/AsSimpleJson?id=';
	const SERIES_TYPE = 'tv_series';
	const DEFAULT_SLOP = 1;

	private static $ARTICLE_TYPES_SUPPORTED_LANGS = [ 'en', 'de', 'es' ];

	protected function prepareQuery( string $query ) {
		$select = $this->getSelect();

		$phrase = $this->sanitizeQuery( $query );
		$slang = $this->sanitizeQuery( $this->getLang() );
		$preparedQuery = $this->createQuery( $phrase );

		$dismax = $select->getDisMax();
		$dismax->setQueryParser( 'edismax' );

		$select->setQuery( $preparedQuery );
		$limit = $this->getRowLimit();
		$select->setRows( isset( $limit ) ? $limit : static::ARTICLES_LIMIT );

		$namespaces = $this->getNamespace() ? $this->getNamespace() : static::DEFAULT_NAMESPACE;
		$namespaces = is_array( $namespaces ) ? $namespaces : [ $namespaces ];

		$select = $this->getBlacklist()->applyFilters( $select );

		$select->createFilterQuery( 'ns' )->setQuery( '+(ns:(' . implode( ' ', $namespaces ) . '))' );
		$select->createFilterQuery( 'main_page' )->setQuery( '-(is_main_page:true)' );
		if ( in_array( strtolower( $slang ), static::$ARTICLE_TYPES_SUPPORTED_LANGS ) ) {
			$select->createFilterQuery( 'type' )->setQuery( '+(article_type_s:' . static::SERIES_TYPE . ')' );
		}

		$dismax->setQueryFields(
			implode(
				' ',
				[
					'title_em^8',
					'titleStrict',
					$this->withLang( 'title', $slang ),
					$this->withLang( 'redirect_titles_mv', $slang ),
				]
			)
		);
		$dismax->setPhraseFields(
			implode(
				' ',
				[
					'title_em^8',
					'titleStrict^8',
					$this->withLang( 'title', $slang ) . '^2',
					$this->withLang( 'redirect_titles_mv', $slang ) . '^2',
				]
			)
		);

		$dismax->setQueryPhraseSlop( static::DEFAULT_SLOP );
		$dismax->setPhraseSlop( static::DEFAULT_SLOP );

		return $select;
	}

	protected function consumeResponse( $response ) {
		foreach ( $response as $item ) {
			if ( $item['score'] > static::MINIMAL_ARTICLE_SCORE ) {
				return [
					'wikiId' => $item['wid'],
					'articleId' => $item['pageid'],
					'title' => $item['title_' . $this->getLang()],
					'url' => $this->replaceHostUrl( $item['url'] ),
					'quality' => $item['article_quality_i'],
					'contentUrl' => $this->replaceHostUrl(
						'http://' . $item['host'] . '/' . self::API_URL . $item['pageid']
					),
				];
			}
		}

		return null;
	}

	protected function createQuery( $query ) {
		$options = [];
		if ( $this->getQuality() !== null ) {
			$options[] = '+(article_quality_i:[' . $this->getQuality() . ' TO *])';
		}
		if ( $this->getWikiId() !== null ) {
			$options[] = '+(wid:' . $this->getWikiId() . ')';
		}
		$options = !empty( $options ) ? ' AND ' . implode( ' AND ', $options ) : '';

		return '+("' . $query . '")' . $options;
	}

}
