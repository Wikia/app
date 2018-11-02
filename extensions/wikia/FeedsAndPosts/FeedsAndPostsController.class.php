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

	public function getAll() {
		$this->response->setValues( [
			'wikiRecentChanges' => ( new WikiRecentChanges() )->get(),
			'topArticles' => ( new TopArticles() )->get(),
		] );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}
}
