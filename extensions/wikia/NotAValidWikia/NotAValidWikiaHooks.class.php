<?php

class NotAValidWikiaHooks {
	/**
	 * @param Title $title
	 * @param Article $article
	 * @return boolean
	 */
	public static function onArticleFromTitle( &$title, &$article ) {
		global $wgNotAValidWikia;

		// http://community.wikia.com/wiki/Community_Central:Not_a_valid_community -> Community_Central:Not_a_valid_community
		$notAValidWikiaParts = explode( '/', $wgNotAValidWikia );  // assign explode result to a var as array_pop requires a reference
		$notAValidWikiaArticleName = array_pop( $notAValidWikiaParts );

		if ( $title instanceof Title && $title->getPrefixedDBkey() === $notAValidWikiaArticleName && !$title->isTalkPage() ) {
			$article = new NotAValidWikiaArticle( $title );
		}

		return true;
	}
}
