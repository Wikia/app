<?php
namespace Wikia\Search\Services;

use Wikia\Search\QueryService\Factory;
use Wikia\Search\Query\Select;

class TvSearchService {

	const WIKI_LIMIT = 1;
	const MINIMAL_WIKIA_SCORE = 2;
	const MINIMAL_WIKIA_ARTICLES = 50;
	const MINIMAL_ARTICLE_SCORE = 0.5;

	/** @var \Solarium_Client client */
	private $client;
	private $provided;
	private $config;

	public function __construct( $client = null, $config = null ) {
		if ( $client !== null ) {
			$this->provided = $client;
		}
		if ( $config !== null ) {
			$this->config = $config;
		} else {
			$this->config = (new Factory())->getSolariumClientConfig();
		}
		$this->setClient( $client, $config );
	}

	public function queryXWiki( $query, $lang ) {
		$result = [];
		$this->setClient();
		$select = $this->prepareXWikiQuery( $query, $lang );
		$response = $this->querySolr( $select );
		foreach( $response as $doc ) {
			if ( ( $doc['id'] && $doc['url'] )
				&& $doc['score'] > static::MINIMAL_WIKIA_SCORE
				&& $doc['articles_i'] > static::MINIMAL_WIKIA_ARTICLES ) {
				$result[] = [ 'id' => $doc['id'], 'url' => $doc['url'] ];
			}
		}
		return $result;
	}

	public function queryMain( $query, $wikiId, $lang, $minQuality = null ) {
		$select = $this->prepareArticlesQuery( $query, $wikiId, $lang, $minQuality );
		$response = $this->querySolr( $select );
		foreach( $response as $item ) {
			if ( $item['score'] > static::MINIMAL_ARTICLE_SCORE ) {
				return $this->getDataFromItem( $item, $lang );
			}
		}
		return null;
	}

	protected function setClient( $client = null, $config = null, $core = null ) {
		if ( $client === null ) {
			if ( $this->provided ) {
				$this->client = $this->provided;
			} else {
				if ( $config === null ) {
					$config = $this->config;
				}
				if ( $core !== null ) {
					$config['adapteroptions']['core'] = $core;
				}
				$this->client = new \Solarium_Client( $config );
			}
		} else {
			$this->client = $client;
		}
	}

	protected function prepareXWikiQuery( $query, $lang ) {
		$select = $this->getXWikiSelect();

		$noyearphrase = preg_replace( '|\(\d{4}\)|', '', $query );
		$phrase = $this->sanitizeQuery( $query );

		$dismax = $select->getDisMax();
		$dismax->setQueryParser('edismax');

		$select->setQuery( '+("'.$phrase.'") AND +(lang_s:'.$lang.')' );
		$select->setRows( static::WIKI_LIMIT );
		$select->createFilterQuery( 'A&F' )->setQuery('-(hostname_s:*fanon.wikia.com) AND -(hostname_s:*answers.wikia.com)');

		$dismax->setQueryFields( 'series_mv_tm^10 description_txt categories_txt top_categories_txt top_articles_txt '.
			'sitename_txt^4 domains_txt' );
		$dismax->setPhraseFields( 'series_mv_tm^10 sitename_txt^5' );

		$domain = strtolower( preg_replace( '|[\W-]+|', '', $this->sanitizeQuery( $noyearphrase ) ) );
		$dismax->setBoostQuery( 'domains_txt:"www.' . $domain . '.wikia.com"^10 '.
			'domains_txt:"' . $domain . '.wikia.com"^10' );
		$dismax->setBoostFunctions( 'wam_i^2' );

		return $select;
	}

	protected function getXWikiSelect() {
		$this->setClient( null, null, 'xwiki' );
		return $this->client->createSelect();
	}

	protected function sanitizeQuery( $query ) {
		$select = new Select( $query );
		return $select->getSolrQuery( 10 );
	}

	protected function querySolr( $select ) {
		return $this->client->select( $select );
	}

	protected function prepareArticlesQuery( $query, $wikiId, $lang, $minQuality = null ) {
		$select = $this->getArticleSelect();

		$phrase = $this->sanitizeQuery( $query );
		$preparedQuery = $this->prepareQuery( $phrase, $wikiId, $minQuality );

		$dismax = $select->getDisMax();
		$dismax->setQueryParser('edismax');

		$select->setQuery( $preparedQuery );
		$select->setRows( 1 );
		$select->createFilterQuery( 'ns' )->setQuery('+(ns:0)');
		$select->createFilterQuery( 'type' )->setQuery('+(article_type_s:tv_episode)');

		$dismax->setQueryFields( implode( ' ', [
			'titleStrict',
			$this->withLang( 'title', $lang ),
			$this->withLang( 'redirect_titles_mv', $lang ),
		] ) );
		$dismax->setPhraseFields( implode( ' ', [
			'titleStrict^8',
			$this->withLang( 'title', $lang ).'^2',
			$this->withLang( 'redirect_titles_mv', $lang ).'^2',
		] ) );

		return $select;
	}

	protected function getArticleSelect() {
		$this->setClient();
		return $this->client->createSelect();
	}

	protected function prepareQuery( $query, $wikiId, $minQuality ) {
		$quality = '';
		if ( !empty( $minQuality ) ) {
			$quality = ' AND +(article_quality_i:[' . $minQuality . ' TO *])';
		}
		return '+("'. $query . '") AND +(wid:' . $wikiId . ')' . $quality;
	}

	protected function withLang( $field, $lang ) {
		return $field.'_'.$lang;
	}

	protected function getDataFromItem( $item, $lang ) {
		return [
			'articleId' => $item['pageid'],
			'title' => $item['title_'.$lang],
			'url' => $item['url'],
			'quality' => $item['article_quality_i'],
		];
	}
}
