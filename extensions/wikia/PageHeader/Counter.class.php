<?php

namespace Wikia\PageHeader;

class Counter {
	public function __construct( \Title $title ) {
		if ( $title->isSpecial( 'Videos' ) ) {
			$this->message = $this->getMessageForVideo();
		}
	}

	private function getMessageForVideo() {
		$mediaService = ( new \MediaQueryService );

		return wfMessage( 'page-header-counter-videos', $mediaService->getTotalVideos() )->parse();
	}
}
