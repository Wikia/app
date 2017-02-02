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
		$notAValidWikiaArticleName = array_pop( explode( '/', $wgNotAValidWikia ) );

		if ( $title instanceof Title && $title->getPrefixedDBkey() === $notAValidWikiaArticleName && !$title->isTalkPage() ) {
			$article = new NotAValidWikiaArticle( $title );
		}

		return true;
	}
}
