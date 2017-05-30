<?php

use \PageHeader\PageTitle;

class PageHeaderController extends WikiaController {

    public function init() {

    }

	public function index() {
        $this->setVal('title', new PageTitle($this->app));
	}
}
