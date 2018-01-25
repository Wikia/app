<?php

/**
 * Discussion user log page
 */
class SpecialDiscussionsLogController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct( 'DiscussionsLog', '', false );
	}

	public function index() {
		$this->wg->Out->redirect( $this->wg->Server . '/d/log' );
	}
}
