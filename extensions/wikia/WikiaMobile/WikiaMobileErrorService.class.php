<?php
	/**
	 * WikiaMobileErrorService
	 * handles displying various errors to a user
	 *
	 * @author Jakub Olek <jakubolek(at)wikia-inc.com>
	 */
class WikiaMobileErrorService extends WikiaService {
	/**
	 * Page Not Found
	 *
	 * Get 20 most recent edited page
	 * get 5 images per page
	 *
	 * display random image on 404 page
	 * example:
	 *
	 * Open non existent page on any wiki
	 *
	 */
	function pageNotFound(){
		$ret = F::build('WikiaMobileStatsModel')->getRandomPopularPage();
		$this->response->setVal( 'title', $this->wg->Out->getHTMLTitle() );
		$this->response->setVal( 'link', $ret[0] );
		$this->response->setVal( 'img', $ret[1] );
	}
}