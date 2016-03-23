<?php

class CommunityPageSpecialController extends WikiaSpecialPageController {
	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function __construct() {
		parent::__construct( 'Community', '', /* $listed = */ false );
	}

	public function index() {
		$this->foo = 'hello world';
	}

}