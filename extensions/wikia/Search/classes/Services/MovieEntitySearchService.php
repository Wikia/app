<?php

namespace Wikia\Search\Services;

use WikiFactory;

class MovieEntitySearchService extends EntitySearchService {

	const ALLOWED_NAMESPACE = 0;
	const ARTICLES_LIMIT = 1;
	const MINIMAL_MOVIE_SCORE = 1.5;
	const MOVIE_TYPE = 'movie';
	const API_URL = 'api/v1/Articles/AsSimpleJson?id=';
	const WIKIA_URL_REGEXP = '~^(http(s?)://)(([^\.]+)\.wikia\.com)~';
	private static $EXCLUDED_WIKIS = [ 'uncyclopedia.wikia.com' ];

	public function prepareQuery( $query ) {
		$select = $this->getSelect();

		$phrase = $this->sanitizeQuery( $query );
		$slang = $this->sanitizeQuery( $this->getLang() );
		$preparedQuery = $this->createQuery( $phrase );

		$dismax = $select->getDisMax();
		$dismax->setQueryParser('edismax');

		$select->setQuery( $preparedQuery );
		$select->setRows( static::ARTICLES_LIMIT );
		$select->createFilterQuery( 'ns' )->setQuery('+(ns:'. static::ALLOWED_NAMESPACE . ')');
		$select->createFilterQuery( 'type' )->setQuery('+(article_type_s:' . static::MOVIE_TYPE . ')');
		if( !empty( static::$EXCLUDED_WIKIS ) ) {
			$excluded = [];
			foreach( static::$EXCLUDED_WIKIS as $ex ) {
				$excluded[] = "-(host:{$ex})";
			}
			$select->createFilterQuery( 'excl' )->setQuery( implode( ' AND ', $excluded ) );
		}

		$dismax->setQueryFields( implode( ' ', [
			'title_em^10',
			'titleStrict',
			$this->withLang( 'title', $slang ),
			$this->withLang( 'redirect_titles_mv', $slang ),
		] ) );
		$dismax->setPhraseFields( implode( ' ', [
			'titleStrict^8',
			$this->withLang( 'title', $slang ).'^2',
			$this->withLang( 'redirect_titles_mv', $slang ).'^2',
		] ) );

		return $select;
	}

	public function consumeResponse( $response ) {
		foreach( $response as $item ) {
			if ( $item['score'] > static::MINIMAL_MOVIE_SCORE ) {
				return $this->getDataFromItem($item);
			}
		}
		return null;
	}

	protected function createQuery( $query ) {
		$result = '+("'. $query . '")';
		if ( $this->getQuality() !== null ) {
			$result .= ' AND +(article_quality_i:[' . $this->getQuality() . ' TO *])';
		}
		return $result;
	}

	protected function getDataFromItem( $item ) {
		global $wgStagingEnvironment, $wgDevelEnvironment;

		$data = [
			'wikiId' => $item['wid'],
			'articleId' => $item['pageid'],
			'title' => $item['title_'.$this->getLang()],
			'url' => $item['url'],
			'quality' => $item['article_quality_i'],
		];

		$data[ 'contentUrl' ] = 'http://' . $item['host'] . '/' . self::API_URL . $item['pageid'];
		if ( $wgStagingEnvironment || $wgDevelEnvironment ) {
			$data[ 'contentUrl' ] = preg_replace_callback( self::WIKIA_URL_REGEXP, array( $this, 'replaceHost' ), $data[ "contentUrl" ] );
			$data[ 'url' ] = preg_replace_callback( self::WIKIA_URL_REGEXP, array( $this, 'replaceHost' ), $data[ "url" ] );
		}

		return $data;
	}

	protected function replaceHost( $details ) {
		return $details[ 1 ] . WikiFactory::getCurrentStagingHost( $details[ 4 ], $details[ 3 ] );
	}

}