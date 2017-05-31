<?php

namespace Wikia\PageHeader;

class Counter {
	public function __construct(\Title $title) {
		if ( $title->isSpecial( 'Videos' ) ) {
			$mediaService = ( new \MediaQueryService );
			$this->message = wfMessage( 'page-header-counter-videos', $mediaService->getTotalVideos() )->parse();
		}
	}
}
