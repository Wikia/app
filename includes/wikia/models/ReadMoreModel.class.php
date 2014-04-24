<?php

/**
 * Model used to fetch recommendations data from Solr.
 * Will be used for AB testing new recommendations for Read More module.
 */
class ReadMoreModel extends WikiaModel {

	const MEMC_VER = '1.00';

	private $wikiId;
	private $articleId;

	public function __construct( $wikiId = null, $articleId = null ) {
		global $wgCityId, $wgTitle;

		if ( is_null( $wikiId ) ) {
			$wikiId = $wgCityId;
		}

		if ( is_null( $articleId ) ) {
			$articleId = $wgTitle->getArticleID();
		}

		$this->articleId = $articleId;
		$this->wikiId = $wikiId;
	}

	/**
	 * Get article recommendation for article on given wiki.
	 * Based on NLP recommendation stored in Solr.
	 *
	 * @param null $wikiId
	 * @param null $articleId
	 *
	 * @return array recommendation data with article title, description, url and image
	 */
	public function getRecommendedArticles() {
		$recommendations = WikiaDataAccess::cache(
			$this->getMemcKey(),
			60 * 60 * 24 /* 24 hours */,
			function() {
				$recommendations = [];

				$result = $this->getDataFromSolr();
				$recommendationsKeys = $this->getRecommendationsKeys( $result );
				if ( !empty( $recommendationsKeys ) ) {
					$recommendations = $this->prepareRecommendationsData( $recommendationsKeys );
				}

				return $recommendations;
			}
		);

		return $recommendations;
	}

	/**
	 * Get data from solr for article on given wiki
	 *
	 * @return null|\Wikia\Search\Result
	 */
	private function getDataFromSolr() {
		$service = new SolrDocumentService();
		$service->setWikiId( $this->wikiId );
		$service->setArticleId( $this->articleId );

		$result = $service->getResult();

		return $result;
	}

	/**
	 * Get recommendation keys from data fetched from Solr
	 *
	 * @param \Wikia\Search\Result $solrResult
	 * @return array
	 */
	private function getRecommendationsKeys( $solrResult ) {
		return $solrResult->getVar('recommendations_ss', []);
	}

	/**
	 * Prepare recommendation data with article title, description, url and image
	 *
	 * @param array $keys recommendation keys
	 * @return array
	 */
	private function prepareRecommendationsData( $keys ) {
		$recommendations = [];

		$articleIds = $this->getRecommendedArticleIds( $keys );

		if ( !empty( $articleIds ) ) {
			$recommendations = $this->getRecommendationsData( $articleIds );
		}

		return $recommendations;
	}

	/**
	 * Get list of article ids from recommendation keys
	 *
	 * @param array $keys recommendation keys
	 * @return array
	 */
	private function getRecommendedArticleIds( $keys ) {
		$articleIds = [];

		foreach( $keys as $key ) {
			$recommendationIds = explode( '_', $key );
			if ( empty( $recommendationIds[0] ) ) {
				continue;
			}

			if ( $recommendationIds[0] == $this->wikiId ) {
				$articleIds[$recommendationIds[1]] = $recommendationIds[1];
			}
		}

		return $articleIds;
	}

	/**
	 * Get recommendation data
	 *
	 * @param $articleIds
	 * @return array
	 */
	private function getRecommendationsData( $articleIds ) {
		$recommendations = [];

		$articleService = new ArticleService();

		$titles = Title::newFromIDs( $articleIds );
		$imageServing = new ImageServing( array_keys( $articleIds ), 200, array( 'w' => 2, 'h' => 1 ) );
		$images = $imageServing->getImages( 1 );

		foreach ( $titles as $title ) {
			if ( !empty( $title ) && $title->exists() && !$title->isRedirect() ) {
				$articleId = $title->getArticleID();
				$article = $articleService->setArticleById( $articleId );

				$recommendations[ $articleId ] = [
					'title' => $title->getPrefixedText(),
					'url' => $title->getLocalURL(),
					'text' => $article->getTextSnippet(),
					'image' => isset( $images[ $articleId ] ) ? $images[ $articleId ][0][ 'url' ] : null
				];
			}
		}

		return $recommendations;
	}

	private function getMemcKey() {
		return wfSharedMemcKey(
			'readmorenlp',
			self::MEMC_VER,
			$this->wikiId,
			$this->articleId
		);
	}
}
