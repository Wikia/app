<?php

class NotAValidWikiaArticle extends Article {
	public function view() {
		global $wgRequest, $wgOut;

		$wgOut->setPageTitle( $this->getTitle()->getText() );

		// Construct the search query from the from param
		// (which is the domain we're redirected from)
		$fromDomain = $wgRequest->getVal( 'from' );

		// Extract the interesting part from the domain
		$interestingPart = preg_replace(
			'/^(www\.)?(.*?)(\.co|\.com|\.me|\.net|\.org)?(\.[a-z]+)$/',
			'\2',
			$fromDomain
		);

		// Replace any non-alpha part with space
		$searchQuery = trim( preg_replace( '/\W+/', ' ', $interestingPart ) );

		// Pass to the message
		$wgOut->addWikiMsg( 'not-a-valid-wikia', $searchQuery );

		// Don't index this page
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
	}
}
