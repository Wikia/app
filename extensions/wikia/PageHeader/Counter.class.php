<?php

namespace Wikia\PageHeader;

use Forum;
use MediaQueryService;
use ParserOptions;
use RequestContext;

class Counter {
	/**
	 * @var string
	 */
	public $text;

	public function __construct() {
		$app = \F::app();
		$title = RequestContext::getMain()->getTitle();

		if ( $title->isSpecial( 'Videos' ) ) {
			$this->text = $this->getTextForSpecialVideos();
		} else if ( $title->isSpecial( 'Images' ) ) {
			$this->text = $this->getTextForSpecialImages();
		} else if ( defined( 'NS_BLOG_LISTING' ) && $title->inNamespace( NS_BLOG_LISTING ) ) {
			$this->text = $this->getTextForBlogListing();
		} else if ( $app->wg->enableForumExt && $title->isSpecial( 'Forum' ) ) {
			$this->text = $this->getTextForForum();
		}
	}

	public function isNotEmpty() {
		return !empty( $this->text );
	}

	private function getTextForSpecialVideos() {
		$mediaService = ( new MediaQueryService );
		$count = $mediaService->getTotalVideos();

		return wfMessage( 'page-header-counter-videos', $count )->escaped();
	}

	private function getTextForSpecialImages() {
		$mediaService = ( new MediaQueryService );
		$count = $mediaService->getTotalImages();

		return wfMessage( 'page-header-counter-images', $count )->escaped();
	}

	private function getTextForBlogListing() {
		$count = RequestContext::getMain()
			->getWikiPage()
			->getParserOutput( new ParserOptions() )
			// It's set in Blogs/BlogTemplate.php
			->getProperty( 'blogPostCount' );

		return wfMessage( 'page-header-counter-blog-posts', $count )->escaped();
	}

	private function getTextForForum() {
		$forum = new Forum();
		$count = $forum->getTotalThreads();
		$countActive = $forum->getTotalActiveThreads();
		$text = wfMessage( 'page-header-counter-forum-threads', $count )->escaped();

		if ( $countActive > 0 ) {
			$text .= ' | ' . wfMessage( 'page-header-counter-forum-active-threads', $countActive )->escaped();
		}

		return $text;
	}
}
