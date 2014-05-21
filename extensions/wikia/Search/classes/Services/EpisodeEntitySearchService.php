<?php

namespace Wikia\Search\Services;

class EpisodeEntitySearchService extends EntitySearchService {

	const DEFAULT_NAMESPACE = 0;
	const ARTICLES_LIMIT = 1;
	const MINIMAL_ARTICLE_SCORE = 0.5;
	const API_URL = 'api/v1/Articles/AsSimpleJson?id=';
	const EPISODE_TYPE = 'tv_episode';

	protected function prepareQuery( $query ) {
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
		$select->createFilterQuery( 'ns' )->setQuery( '+(ns:(' . implode( ' ', $namespaces ) . '))' );
		$select->createFilterQuery( 'type' )->setQuery( '+(article_type_s:' . static::EPISODE_TYPE . ')' );

		$dismax->setQueryFields( implode( ' ', [
			'titleStrict',
			$this->withLang( 'title', $slang ),
			$this->withLang( 'redirect_titles_mv', $slang ),
		] ) );
		$dismax->setPhraseFields( implode( ' ', [
			'titleStrict^8',
			$this->withLang( 'title', $slang ) . '^2',
			$this->withLang( 'redirect_titles_mv', $slang ) . '^2',
		] ) );

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

	protected function createQuery( $query ) {
		$options = [ ];
		if ( $this->getQuality() !== null ) {
			$options[ ] = '+(article_quality_i:[' . $this->getQuality() . ' TO *])';
		}
		if ( $this->getWikiId() !== null ) {
			$options[ ] = '+(wid:' . $this->getWikiId() . ')';
		}
		$options = !empty( $options ) ? ' AND ' . implode( ' AND ', $options ) : '';
		return '+("' . $query . '")' . $options;
	}

}