<?php

use \PageHeader\PageTitle;

class PageHeaderController extends WikiaController {

    public function init() {

    }

	public function index() {
        $this->setVal('pageTitle', new PageTitle($this->app));
	}
}
