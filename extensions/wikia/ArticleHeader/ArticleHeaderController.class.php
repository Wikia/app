<?php

use \ArticleHeader\PageTitle;

class ArticleHeaderController extends WikiaController {

    public function init() {

    }

	public function index() {
        $this->setVal('title', new PageTitle($this->app));
	}
}
