<?php
class ReadMoreController extends WikiaController {
	/**
	 * JSON response with recommended wikis based on NLP recommendations stored in Solr
	 */
	public function getReadMoreArticles() {
		$recommendations = [];

		$request = $this->wg->request;

		$cityId 	= $request->getInt( 'cityId', 0 );
		$articleId 	= $request->getInt( 'articleId', 0 );

		if ( $cityId && $articleId ) {
			$recommendationsModel = new ReadMoreModel();
			$recommendations = $recommendationsModel->getRecommendedArticles( $cityId, $articleId );
		}

		$this->setVal( 'recommendations', json_encode( $recommendations ) );
	}
}
