<?php
class ReadMoreController extends WikiaController {
	const SPOTLIGHTS_NUMBER = 3;
	const TYPE_RANDOM = 1;
	const TYPE_MOST_RELATED = 2;
	const CACHE_DURATION = 900; /* 15min */

	/**
	 * Gets a response from ReadMoreModel with the recommended articles.
	 * Based on the NLP recommendations stored in Solr.
	 *
	 * @param int $wikiId       if not set -> null, current wiki's ID is used
	 * @param int $articleId    if not set -> null, current article's ID is used
	 *
	 * @return array
	 */
	static private function getReadMoreResponseFromModel( $articleId = null ) {
		$recommendationsModel = new ReadMoreModel( $articleId );
		$recommendations = $recommendationsModel->getRecommendedArticles();

		return $recommendations;
	}

	/**
	 * Sends a JSON response with the NLP recommendations for the requested article.
	 */
	public function getReadMoreArticles() {
		$request = $this->wg->request;

		$articleId = $request->getInt( 'articleId', null );
		$type = $request->getInt( 'type', self::TYPE_RANDOM );

		$recommendations = self::getReadMoreResponseFromModel( $articleId );
		$recommendations = $this->prepareRecommendations( $type, self::SPOTLIGHTS_NUMBER, $recommendations );

		$this->response->setFormat( 'json' );
		$this->response->setCacheValidity( self::CACHE_DURATION );
		$this->setVal( 'recommendations', $recommendations );
	}

	/**
	 * Get number of recommendations by type.
	 *
	 * @param int $type 		most related or random
	 * @param int $number 		number of recommendations
	 * @param $recommendations
	 * @return array
	 */
	private function prepareRecommendations( $type, $number, $recommendations ) {
		if ( $type == self::TYPE_RANDOM ) {
			shuffle($recommendations);
		}

		$recommendations = array_slice( $recommendations, 0, $number );

		return $recommendations;
	}

	/**
	 * This hook checks if the article has enough NLP recommendations.
	 * If yes, raises the flag for usage in JavaScript.
	 *
	 * @param array &$vars
	 */
	static public function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		global $wgTitle;

		$articleId = $wgTitle->getArticleID();
		if ( $articleId ) {
			$recommendations = self::getReadMoreResponseFromModel( $articleId );
			if ( count( $recommendations ) >= self::SPOTLIGHTS_NUMBER ) {
				$vars['launchReadMoreABTest'] = true;
			}
		}

		return true;
	}
}
