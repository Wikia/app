<?php

namespace Wikia\Search\Services;

use WikiFactory;

class EpisodeEntitySearchService extends EntitySearchService {

	const ALLOWED_NAMESPACE = 0;
	const ARTICLES_LIMIT = 1;
	const MINIMAL_ARTICLE_SCORE = 0.5;
	const API_URL = 'api/v1/Articles/AsSimpleJson?id=';
	const WIKIA_URL_REGEXP = '~^(http(s?)://)(([^\.]+)\.wikia\.com)~';
	const EPISODE_TYPE = 'tv_episode';

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
		$select->createFilterQuery( 'type' )->setQuery('+(article_type_s:' . static::EPISODE_TYPE . ')');

		$dismax->setQueryFields( implode( ' ', [
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
			if ( $item['score'] > static::MINIMAL_ARTICLE_SCORE ) {
				return $this->getDataFromItem($item);
			}
		}
		return null;
	}

	protected function createQuery($query) {
		$options = [];
		if ( $this->getQuality() !== null ) {
			$options[] = '+(article_quality_i:[' . $this->getQuality() . ' TO *])';
		}
		if ( $this->getWikiId() !== null ) {
			$options[] = '+(wid:' . $this->getWikiId() . ')';
		}
		$options = !empty( $options ) ? ' AND ' . implode( ' AND ', $options ) : '';
		return '+("'. $query . '")' . $options;
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