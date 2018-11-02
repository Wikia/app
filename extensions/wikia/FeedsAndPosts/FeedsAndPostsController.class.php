<?php

use Wikia\FeedsAndPosts\WikiRecentChanges;
use Wikia\FeedsAndPosts\TopArticles;

class FeedsAndPostsController extends WikiaController {
	public function getWikiRecentChanges() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setValues( ( new WikiRecentChanges() )->get() );
	}

	public function getTopArticles() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setValues( ( new TopArticles() )->get() );
	}
}
