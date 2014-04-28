<?php
class ReadMoreController extends WikiaController {
	const MIN_SPOTLIGHTS_NUMBER = 3;

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
		$articleId = $request->getInt( 'articleId', 0 );
		$this->setVal( 'recommendations', self::getReadMoreResponseFromModel( null, $articleId ) );
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
			if ( count( $recommendations ) >= self::MIN_SPOTLIGHTS_NUMBER ) {
				$vars['launchReadMoreABTest'] = true;
			}
		}

		return true;
	}
}
