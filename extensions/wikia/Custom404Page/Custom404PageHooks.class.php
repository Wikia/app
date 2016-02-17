<?php

class Custom404PageHooks {
	/**
	 * Attempt to recover a URL that was truncated by an external service (e.g. Wanted -> Wanted!).
	 *
	 * In case a good matching page is found, we'll:
	 *  * display a custom no-article text,
	 *  * set a canonical URL to the suggested URL,
	 *  * serve HTTP 200 (instead of 404),
	 *  * set the robots policy to noindex,follow
	 *
	 * If more than one, or none matching pages where found, allow the standard MediaWiki behavior.
	 *
	 * @param Article $article
	 *
	 * @return bool
	 */
	static public function onBeforeDisplayNoArticleText( Article $article ) {

		$title = $article->getTitle();

		if ( $article->getOldID() || !$title || !$title->isContentPage() ) {
			// MW will treat those cases specially, don't try to direct users to other pages
			return true;
		}

		$pageFinder = new Custom404PageBestMatchingPageFinder();
		$bestMatchingTitle = $pageFinder->findBestMatchingArticle( $title );

		if ( empty( $bestMatchingTitle ) ) {
			// Just the regular 404 MediaWiki page
			return true;
		}

		// Display the custom 404 page
		$text = wfMessage( 'custom404page-noarticletext-alternative-found' )
			->params( $bestMatchingTitle->getPrefixedText() )
			->text();
		$text = '<div class="noarticletext">' . PHP_EOL . $text . PHP_EOL . '</div>';

		$wgOut = $article->getContext()->getOutput();
		$wgOut->addWikiText( $text );
		$wgOut->setStatusCode( 200 );
		$wgOut->setRobotPolicy( 'noindex,follow' );

		return false;
	}
}
