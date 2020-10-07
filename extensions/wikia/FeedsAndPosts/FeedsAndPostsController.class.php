<?php

use Wikia\FeedsAndPosts\ArticleData;
use Wikia\FeedsAndPosts\ArticleTags;
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
			'rights' => $this->getContext()->getUser()->getRights(),
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

		$popularTags = (new ArticleTags())->getPopularTags();

		if ( $title->exists() ) {
			$images = ArticleData::getImages( $title->getArticleID() );

			$this->response->setValues( [
				'title' => $title->getText(),
				'exists' => $title->exists(),
				'thumbnail' => $images[0] ?? null,
				'content_images' => count( $images ) > 1 ? array_slice( $images, 1 ) : [],
				'snippet' => ArticleData::getTextSnippet( $title ),
				'relativeUrl' => $title->getLocalURL(),
				'popularTags' => $popularTags
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
			'popularTags' => $popularTags
		]);
	}

	public function getPopularTags() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
		$this->response->setVal( 'tags', ( new ArticleTags() )->getPopularTags() );
	}

	public function searchForTags() {
		$query = $this->request->getVal( 'query', '' );
		if ( strlen( $query ) < 3 ) {
			throw new BadRequestException( 'query param query query must be at least 3 characters' );
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_LONG );
		$this->response->setVal( 'tags', ( new ArticleTags() )->searchTags( $query ) );
	}
}
