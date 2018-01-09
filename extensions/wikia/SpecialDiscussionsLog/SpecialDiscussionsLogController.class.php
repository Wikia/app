<?php

/**
 * Discussion user log page
 */
class SpecialDiscussionsLogController extends WikiaSpecialPageController {
	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function __construct() {
		parent::__construct( 'DiscussionsLog', '', false );
	}

	public function index() {
		$urlHost = parse_url( $this->wg->title->getFullURL(), PHP_URL_HOST );
		$this->wg->Out->redirect( 'https://' . $urlHost . '/d/log' );
	}
}
