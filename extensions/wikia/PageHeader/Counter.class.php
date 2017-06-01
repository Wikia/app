<?php

namespace Wikia\PageHeader;

use Forum;
use MediaQueryService;
use RequestContext;
use WikiaApp;

class Counter {
	public function __construct( WikiaApp $app ) {
		$title = RequestContext::getMain()->getTitle();

		if ( $title->isSpecial( 'Videos' ) ) {
			$this->message = $this->getMessageForSpecialVideos();
		} else if ( $title->isSpecial( 'Images' ) ) {
			$this->message = $this->getMessageForSpecialImages();
		} else if ( defined( 'NS_BLOG_LISTING' ) && $title->inNamespace( NS_BLOG_LISTING ) ) {
			$this->message = $this->getMessageForBlogListing( $app );
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

	private function getMessageForBlogListing( WikiaApp $app ) {
		$count = $app->wg->Parser->getOutput()->getProperty( 'blogPostCount' );

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
