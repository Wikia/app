<?php

use Wikia\FeedsAndPosts\RecentChanges;
use Wikia\FeedsAndPosts\TopArticles;

class FeedsAndPostsController extends WikiaController {
	public function getRecentChanges() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setValues( ( new RecentChanges() )->get() );
	}

	public function getTopArticles() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setValues( ( new TopArticles() )->get() );
	}

	public function getAll() {
		$this->response->setValues( [
			'recentChanges' => ( new RecentChanges() )->get(),
			'topArticles' => ( new TopArticles() )->get(),
		] );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}
}
