<?php

namespace Wikia\PageHeader;

class PageHeaderController extends \WikiaController {

	public function index() {
		$this->setVal( 'pageTitle', new PageTitle( $this->app ) );
		$this->setVal( 'tally', new Tally( $this->app ) );
	}
}
