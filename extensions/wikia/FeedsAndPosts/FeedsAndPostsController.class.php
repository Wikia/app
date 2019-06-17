<?php

use Wikia\FeedsAndPosts\ArticleData;
use Wikia\FeedsAndPosts\RecentChanges;
use Wikia\FeedsAndPosts\ThemeSettings;
use Wikia\FeedsAndPosts\TopArticles;
use Wikia\FeedsAndPosts\WikiDetails;
use Wikia\FeedsAndPosts\WikiVariables;

class FeedsAndPostsController extends WikiaApiController {
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
			'wikiDetails' => ( new WikiDetails() )->get(),
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

	public function getArticleData() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$articleTitle = $this->getRequiredParam( 'title' );

		$title = Title::newFromText( $articleTitle );

		if ( !$title ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		if ( $title->exists() ) {
			$images = ArticleData::getImages( $title->getArticleID() );

			$this->response->setValues( [
				'title' => $title->getText(),
				'exists' => $title->exists(),
				'thumbnail' => $images[0] ?? null,
				'content_images' => count( $images ) > 1 ? array_slice( $images, 1 ) : [],
				'snippet' => ArticleData::getTextSnippet( $title ),
				'relativeUrl' => $title->getLocalURL(),
			] );

			return;
		}

		$this->response->setValues( [
			'title' => $title->getText(),
			'exists' => $title->exists(),
			'thumbnail' => null,
			'content_images' => [],
			'snippet' => null,
			'relativeUrl' => $title->getLocalURL(),
		]);
	}
}
