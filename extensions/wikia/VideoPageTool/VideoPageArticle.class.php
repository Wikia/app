<?php
/**
 * Class VideoPageArticle
 *
 * This is a fake article object so we can fool MediaWiki into showing our custom VideoPage content in place of
 * a normal article page call
 */

class VideoPageArticle extends Article {

	public function __construct( $title ) {
		wfProfileIn(__METHOD__);

		parent::__construct($title);

		// This fake page object is necessary to complete the deceit
		$this->mPage = new VideoPagePage($title);

		wfProfileOut(__METHOD__);
	}

	/**
	 * @desc Render hubs page
	 */
	public function view() {
		wfProfileIn(__METHOD__);

		// Get all the MW stuff out of the way first
		parent::view();

		//render hub page
		$app = F::app();
		$app->wg->Out->clearHTML();
		$app->wg->Out->addHTML( $app->sendRequest('VideoPageController', 'index') );
		wfProfileOut(__METHOD__);
	}
}
