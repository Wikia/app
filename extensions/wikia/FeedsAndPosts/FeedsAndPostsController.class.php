<?php

use Wikia\FeedsAndPosts\RecentChanges;
use Wikia\FeedsAndPosts\ThemeSettings;
use Wikia\FeedsAndPosts\TopArticles;
use Wikia\FeedsAndPosts\WikiVariables;

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
				'theme' => ( new ThemeSettings() )->get(),
				'wikiVariables' => ( new WikiVariables() )->get(),
		] );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	public function getThemeSettings() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setValues( ( new ThemeSettings() )->get() );
	}

	public function getWikiVariables() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setValues( ( new WikiVariables() )->get() );
	}
}
