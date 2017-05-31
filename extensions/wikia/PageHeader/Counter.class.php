<?php

namespace Wikia\PageHeader;

use Forum;
use ForumBoard;
use Title;
use WikiaApp;

class Counter {
	public function __construct( WikiaApp $app ) {
		$title = $app->wg->title;

		if ( $title->isSpecial( 'Videos' ) ) {
			$this->message = $this->getMessageForSpecialVideos();
		} else if ( $title->isSpecial( 'Images' ) ) {
			$this->message = $this->getMessageForSpecialImages();
		} else if ( $title->inNamespace( NS_BLOG_LISTING ) ) {
			$this->message = $this->getMessageForBlogListing( $app );
		} else if ( $title->isSpecial( 'Forum' ) ) {
			$this->message = $this->getMessageForForum();
		} else if ( $title->inNamespace( NS_WIKIA_FORUM_BOARD ) ) {
			$this->message = $this->getMessageForForumBoard( $title );
		}
	}

	private function getMessageForSpecialVideos() {
		$mediaService = ( new \MediaQueryService );
		$count = $mediaService->getTotalVideos();

		return wfMessage( 'page-header-counter-videos', $count )->parse();
	}

	private function getMessageForSpecialImages() {
		$mediaService = ( new \MediaQueryService );
		$count = $mediaService->getTotalImages();

		return wfMessage( 'page-header-counter-images', $count )->parse();
	}

	private function getMessageForBlogListing( WikiaApp $app ) {
		$count = $app->wg->Parser->getOutput()->getProperty('blogPostCount');

		return wfMessage( 'page-header-counter-blog-posts', $count )->parse();
	}

	private function getMessageForForum() {
		$forum = new Forum();
		$count = $forum->getTotalThreads();

		return wfMessage( 'page-header-counter-forum-threads', $count )->parse();
	}

	private function getMessageForForumBoard( Title $title ) {
		$forumBoard = ForumBoard::newFromTitle( $title );
		$count = $forumBoard->getThreadCount();

		return wfMessage( 'page-header-counter-forum-threads', $count )->parse();
	}
}
