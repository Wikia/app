<?php

namespace Wikia\PageHeader;

class PageHeaderController extends \WikiaController {

	public function index() {
		$this->setVal( 'categories', new Categories( $this->app ) );
		$this->setVal( 'counter', new Counter( $this->app ) );
		$this->setVal( 'pageTitle', new PageTitle( $this->app ) );
	}
}
