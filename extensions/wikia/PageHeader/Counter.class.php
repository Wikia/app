<?php

namespace Wikia\PageHeader;

use Forum;
use MediaQueryService;
use ParserOptions;
use RequestContext;

class Counter {
	public function __construct() {
		$title = RequestContext::getMain()->getTitle();

		if ( $title->isSpecial( 'Videos' ) ) {
			$this->message = $this->getMessageForSpecialVideos();
		} else if ( $title->isSpecial( 'Images' ) ) {
			$this->message = $this->getMessageForSpecialImages();
		} else if ( defined( 'NS_BLOG_LISTING' ) && $title->inNamespace( NS_BLOG_LISTING ) ) {
			$this->message = $this->getMessageForBlogListing();
		} else if ( $title->isSpecial( 'Forum' ) ) {
			$this->message = $this->getMessageForForum();
		}
	}

	private function getMessageForSpecialVideos() {
		$mediaService = ( new MediaQueryService );
		$count = $mediaService->getTotalVideos();

		return wfMessage( 'page-header-counter-videos', $count )->parse();
	}

	private function getMessageForSpecialImages() {
		$mediaService = ( new MediaQueryService );
		$count = $mediaService->getTotalImages();

		return wfMessage( 'page-header-counter-images', $count )->parse();
	}

	private function getMessageForBlogListing() {
		$count = RequestContext::getMain()
			->getWikiPage()
			->getParserOutput( new ParserOptions() )
			// It's set in Blogs/BlogTemplate.php
			->getProperty( 'blogPostCount' );

		return wfMessage( 'page-header-counter-blog-posts', $count )->parse();
	}

	private function getMessageForForum() {
		$forum = new Forum();
		$count = $forum->getTotalThreads();
		$countActive = $forum->getTotalActiveThreads();

		if ( $countActive > 0 ) {
			return wfMessage( 'page-header-counter-forum-threads-with-active', $count, $countActive )->parse();
		} else {
			return wfMessage( 'page-header-counter-forum-threads', $count )->parse();
		}
	}
}
