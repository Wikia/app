<?php

namespace Wikia\Search\Services;

class EpisodeEntitySearchService extends EntitySearchService {

	const DEFAULT_NAMESPACE = 0;
	const ARTICLES_LIMIT = 1;
	const MINIMAL_ARTICLE_SCORE = 0.8;
	const API_URL = 'api/v1/Articles/AsSimpleJson?id=';
	const EPISODE_TYPE = 'tv_episode';
	const DEFAULT_SLOP = 1;
	const EXACT_MATCH_FIELD = "tv_episode_mv_em";

	private static $ARTICLE_TYPES_SUPPORTED_LANGS = [ 'en', 'de', 'es' ];

	protected $series;

	public function getSeries() {
		return $this->series;
	}

	public function setSeries( $series ) {
		$this->series = $series;

		return $this;
	}

	protected function prepareQuery( string $query ) {
		$select = $this->getSelect();

		$phrase = $this->sanitizeQuery( $query );
		$slang = $this->sanitizeQuery( $this->getLang() );
		$preparedQuery = $this->createQuery( $phrase );

		$dismax = $select->getDisMax();
		$dismax->setQueryParser( 'edismax' );

		$select->setQuery( $preparedQuery );
		$select->setRows( static::ARTICLES_LIMIT );

		$namespaces = $this->getNamespace() ? $this->getNamespace() : static::DEFAULT_NAMESPACE;
		$namespaces = is_array( $namespaces ) ? $namespaces : [ $namespaces ];

		$select = $this->getBlacklist()->applyFilters( $select );

		$select->createFilterQuery( 'ns' )->setQuery( '+(ns:(' . implode( ' ', $namespaces ) . '))' );
		if ( in_array( strtolower( $slang ), static::$ARTICLE_TYPES_SUPPORTED_LANGS ) ) {
			$select->createFilterQuery( 'type' )->setQuery(
				'+(article_type_s:' . static::EPISODE_TYPE . ' OR ' . static::EXACT_MATCH_FIELD . ':*)'
			);
		}

		$dismax->setQueryFields(
			implode(
				' ',
				[
					'title_em^8',
					'titleStrict',
					$this->withLang( 'title', $slang ),
					$this->withLang( 'redirect_titles_mv', $slang ),
					static::EXACT_MATCH_FIELD . "^10",
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
					static::EXACT_MATCH_FIELD . "^10",
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
		$seriesQuery = '';
		if ( $this->getSeries() !== null ) {
			$seriesQuery = ' (tv_series_mv_em:"' . $this->sanitizeQuery( $this->getSeries() ) . '"^0.1)';
		}

		return '+(("' . $query . '")' . $seriesQuery . ')' . $options;
	}

}
