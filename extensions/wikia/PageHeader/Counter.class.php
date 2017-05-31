<?php

namespace Wikia\PageHeader;

use WikiaApp;

class Counter {
	public function __construct( WikiaApp $app ) {
		$title = $app->wg->title;

		if ( $title->isSpecial( 'Videos' ) ) {
			$this->message = $this->getMessageForVideos();
		} else if ( $title->inNamespace( NS_BLOG_LISTING ) ) {
			$this->message = $this->getMessageForBlogPosts( $app );
		}
	}

	private function getMessageForVideos() {
		$mediaService = ( new \MediaQueryService );
		$count = $mediaService->getTotalVideos();

		return wfMessage( 'page-header-counter-videos', $count )->parse();
	}

	private function getMessageForBlogPosts( WikiaApp $app ) {
		$count = $app->wg->Parser->getOutput()->getProperty('blogPostCount');

		return wfMessage( 'page-header-counter-blog-posts', $count )->parse();
	}
}
