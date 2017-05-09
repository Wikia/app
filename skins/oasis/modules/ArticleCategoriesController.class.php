<?php
/**
 * Renders categories box below the article
 *
 * @author Maciej Brencz
 */

class ArticleCategoriesController extends WikiaService {

	public function index() {
		wfProfileIn( __METHOD__ );

		$categoryLinks = $this->request->getVal( 'categoryLinks', $this->wg->User->getSkin()->getCategories() );

		// MW1.19 always returns non empty $catlinks
		if ( strpos( $categoryLinks, ' catlinks-allhidden\'></div>' ) !== false ) {
			$categoryLinks = '';
		}

		$this->response->setVal( 'categoryLinks', $categoryLinks );

		wfProfileOut( __METHOD__ );
	}
}
