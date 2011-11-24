<?php
/**
 * WikiaMobile Article categories Service
 * 
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileArticleCategoriesService extends WikiaService {
				
	public function index() {
		$categoryLinks = $this->request->getVal( 'categoryLinks', '' );
		
		//MW1.16 always returns non empty $catlinks
		//TODO: remove since we're on 1.17+?
		if (strpos($this->catlinks, ' catlinks-allhidden\'></div>') !== false) {
			$categoryLinks = '';
		}
		
		$this->response->setVal( 'categoryLinks', $categoryLinks );
	}
}