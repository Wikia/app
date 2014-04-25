<?php
class ReadMoreController extends WikiaController {
	const MIN_SPOTLIGHTS_NUMBER = 3;

	/**
	 * JSON response with recommended wikis based on NLP recommendations stored in Solr
	 */

	static private function getReadMoreResponseFromModel( $wikiId = null, $articleId = null ) {
		$recommendationsModel = new ReadMoreModel();
		$recommendations = $recommendationsModel->getRecommendedArticles( $wikiId, $articleId );

		return $recommendations;
	}

	public function getReadMoreArticles() {
		$this->response->setFormat( 'json' );
		$request = $this->wg->request;
		$articleId = $request->getInt( 'articleId', 0 );
		$this->setVal( 'recommendations', self::getReadMoreResponseFromModel( null, $articleId ) );
	}

	static public function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		$recommendations = self::getReadMoreResponseFromModel();
		if ( count( $recommendations ) >= self::MIN_SPOTLIGHTS_NUMBER ){
			$launchReadMoreABTest = true;
		} else {
			$launchReadMoreABTest = false;
		}
		$vars['launchReadMoreABTest'] = $launchReadMoreABTest;

		return true;
	}
}
