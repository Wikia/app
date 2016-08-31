<?php
/**
 * Class SpecialDiscussionsNavigationController
 * @desc Special:DiscussionsNavigation controller
 */
class SpecialDiscussionsNavigationController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'DiscussionsNavigation', '', false );
	}

	public function index() {
		$this->wg->out->setArticleBodyOnly( true );
		$this->wg->out->setSquidMaxage( WikiaResponse::CACHE_LONG );
		$this->getResponse()->redirect( '/d' );
	}

}
