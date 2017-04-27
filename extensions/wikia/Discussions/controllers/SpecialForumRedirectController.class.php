<?php

class SpecialForumRedirectController extends WikiaSpecialPageController {

	const DISCUSSIONS_LINK = '/d/f';

	public function __construct() {
		parent::__construct( 'Forum', '', false );
	}

	public function index() {
		$this->response->redirect( self::DISCUSSIONS_LINK );
	}
}