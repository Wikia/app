<?php
class ReadMoreController extends WikiaController {
	const SPOTLIGHTS_NUMBER = 3;
	const TYPE_RANDOM = 1;
	const TYPE_MOST_RELATED = 2;

	/**
	 * Gets a response from ReadMoreModel with the recommended articles.
	 * Based on the NLP recommendations stored in Solr.
	 *
	 * @param int $wikiId       if not set -> null, current wiki's ID is used
	 * @param int $articleId    if not set -> null, current article's ID is used
	 *
	 * @return array
	 */
	static private function getReadMoreResponseFromModel( $wikiId = null, $articleId = null ) {
		$recommendationsModel = new ReadMoreModel( $wikiId, $articleId );
		$recommendations = $recommendationsModel->getRecommendedArticles();

		return $recommendations;
	}

	/**
	 * Sends a JSON response with the NLP recommendations for the requested article.
	 */
	public function getReadMoreArticles() {
		$this->response->setFormat( 'json' );
		$request = $this->wg->request;
		$articleId = $request->getInt( 'articleId', null );
		$type = $request->getInt( 'type', self::TYPE_RANDOM );
		$recommendations = self::getReadMoreResponseFromModel( null, $articleId );
		$recommendations = $this->getRecommendations( $type, self::SPOTLIGHTS_NUMBER, $recommendations );
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
	private function getRecommendations( $type, $number, $recommendations ) {
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
			$recommendations = self::getReadMoreResponseFromModel( null, $articleId );
			if ( count( $recommendations ) >= self::SPOTLIGHTS_NUMBER ) {
				$vars['launchReadMoreABTest'] = true;
			}
		}

		return true;
	}
}
