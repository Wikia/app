<?php

class Custom404PageHooks {

	/**
	 * The canonical URL to set
	 *
	 * This is set in BeforeDisplayNoArticleText hook and read in WikiaCanonicalHref hook,
	 * so the order of executing the hooks is critical for this to work.
	 *
	 * @var string
	 */
	static private $canonicalUrlOverride;

	/**
	 * Attempt to recover a URL that was truncated by an external service (e.g. Wanted -> Wanted!).
	 *
	 * In case a good matching page is found, we'll:
	 *  * display a custom no-article text,
	 *  * set a canonical URL
	 *  * serve HTTP 200 (instead of 404)
	 *  * set the robots policy to noindex,follow
	 *
	 * If more than one, or none matching pages where found, allow the standard MediaWiki behavior.
	 *
	 * @param Article $article
	 *
	 * @return bool
	 */
	static public function onBeforeDisplayNoArticleText( Article $article ) {

		$originalTitle = $article->getTitle();
		$pageFinder = new Custom404PageBestMatchingPageFinder();

		$bestMatchingTitle = $pageFinder->findBestMatchingArticle( $originalTitle );

		if ( empty( $bestMatchingTitle ) ) {
			// Just the regular 404 MediaWiki page
			return true;
		}

		// Display the custom 404 page
		$suggestedTitle = $bestMatchingTitle->getPrefixedText();

		$text = "Just go to [[$suggestedTitle]], will'ya?";
		$text = "<div class='noarticletext'>\n$text\n</div>";
		$wgOut = $article->getContext()->getOutput();
		$wgOut->addWikiText( $text );
		$wgOut->setStatusCode( 200 );
		$wgOut->setRobotPolicy( 'noindex,follow' );

		self::$canonicalUrlOverride = Title::newFromText( $suggestedTitle )->getFullURL();

		return false;
	}

	static public function onWikiaCanonicalHref( &$canonicalUrl ) {
		if ( self::$canonicalUrlOverride ) {
			$canonicalUrl = self::$canonicalUrlOverride;
		}
		return true;
	}
}
