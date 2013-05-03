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
		//setup all needed assets on 404 page
		/**
		 * @var $out OutputPage
		 */
		$out = $this->request->getVal( 'out', $this->wg->Out );

		$assetManager = AssetsManager::getInstance();

		//add styles that belongs only to 404 page
		$styles = $assetManager->getURL( array( 'wikiamobile_404_scss' ) );

		//this is going to be additional call but at least it won't be loaded on every page
		foreach ( $styles as $s ) {
			$out->addStyle( $s  );
		}

		//this is mainly for tracking
		$scipts = $assetManager->getURL( array( 'wikiamobile_404_js' ) );

		foreach ( $scipts as $s ) {
			$out->addScript( '<script src="' . $s . '"></script>' );
		}

		//suppress rendering stuff that is not to be on 404 page
		WikiaMobileFooterService::setSkipRendering( true );
		WikiaMobilePageHeaderService::setSkipRendering( true );

		/**
		 * @var $wikiaMobileStatsModel WikiaMobileStatsModel
		 */
		$wikiaMobileStatsModel = (new WikiaMobileStatsModel);
		$ret = $wikiaMobileStatsModel->getRandomPopularPage();

		$this->response->setVal( 'title', $this->wg->Out->getTitle() );
		$this->response->setVal( 'link', $ret[0] );
		$this->response->setVal( 'img', $ret[1] );
	}
}