<?php
namespace Wikia\Search\Services;

use Wikia\Search\QueryService\Factory;
use Wikia\Search\Query\Select;

class TvSearchService {

	const WIKI_LIMIT = 1;
	const MINIMAL_WIKIA_SCORE = 2;
	const MINIMAL_WIKIA_ARTICLES = 50;
	const MINIMAL_ARTICLE_SCORE = 0.5;
	const ARTICLE_TYPE = 'tv_episode';
	const ALLOWED_NAMESPACE = 0;
	const ARTICLES_LIMIT = 1;
	const WORDS_QUERY_LIMIT = 10;

	private static $EXCLUDED_WIKIS = [ '*fanon.wikia.com', '*answers.wikia.com' ];
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
			if ( ( $doc['id'] && $doc['url'] ) && $doc['score'] > static::MINIMAL_WIKIA_SCORE ) {
				$result[] = [ 'id' => $doc['id'], 'wikiHost' => $doc['url'] ];
			}
		}
		return $result;
	}

	public function queryMain( $query, $lang, $wikiId = null, $minQuality = null ) {
		$select = $this->prepareArticlesQuery( $query, $lang, $wikiId, $minQuality );
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
		$slang = $this->sanitizeQuery( $lang );

		$dismax = $select->getDisMax();
		$dismax->setQueryParser('edismax');

		$select->setQuery( '+("'.$phrase.'") AND +(lang_s:' . $slang . ')' );
		$select->setRows( static::WIKI_LIMIT );
		foreach( static::$EXCLUDED_WIKIS as $ex ) {
			$excluded[] = "-(hostname_s:{$ex})";
		}
		$select->createFilterQuery( 'A&F' )->setQuery( implode( ' AND ', $excluded ) );
		$select->createFilterQuery( 'articles' )->setQuery('articles_i:[' . static::MINIMAL_WIKIA_ARTICLES . ' TO *]');

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
		return $select->getSolrQuery( static::WORDS_QUERY_LIMIT );
	}

	protected function querySolr( $select ) {
		return $this->client->select( $select );
	}

	protected function prepareArticlesQuery( $query, $lang, $wikiId = null, $minQuality = null ) {
		$select = $this->getArticleSelect();

		$phrase = $this->sanitizeQuery( $query );
		$slang = $this->sanitizeQuery( $lang );
		$preparedQuery = $this->prepareQuery( $phrase, $wikiId, $minQuality );

		$dismax = $select->getDisMax();
		$dismax->setQueryParser('edismax');

		$select->setQuery( $preparedQuery );
		$select->setRows( static::ARTICLES_LIMIT );
		$select->createFilterQuery( 'ns' )->setQuery('+(ns:'. static::ALLOWED_NAMESPACE . ')');
		$select->createFilterQuery( 'type' )->setQuery('+(article_type_s:' . static::ARTICLE_TYPE . ')');

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

	protected function getArticleSelect() {
		$this->setClient();
		return $this->client->createSelect();
	}

	protected function prepareQuery( $query, $wikiId = null, $minQuality = null ) {
		$options = [];
		if ( !empty( $minQuality ) ) {
			$options[] = '+(article_quality_i:[' . $minQuality . ' TO *])';
		}
		if ( !empty( $wikiId ) ) {
			$options[] = '+(wid:' . $wikiId . ')';
		}
		return '+("'. $query . '")' . implode( ' AND ', $options );
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
			'wikiId' => $item['wid'],
			'wikiHost' => $item['host']
		];
	}
}
