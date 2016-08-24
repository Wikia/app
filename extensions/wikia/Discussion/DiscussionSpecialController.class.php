<?php
/**
 * Class DiscussionSpecialController
 * @desc Special:Discussion controller
 */
class DiscussionSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'Discussion', '', false );
	}

	public function index() {
		$this->getResponse()->setCacheValidity(WikiaResponse::CACHE_LONG);
		$this->getResponse()->redirect( '/d' );
	}

}
