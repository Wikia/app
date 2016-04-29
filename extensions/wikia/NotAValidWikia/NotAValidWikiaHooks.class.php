<?php

class NotAValidWikiaHooks {
	/**
	 * @param Title $title
	 * @param Article $article
	 * @return boolean
	 */
	public static function onArticleFromTitle( &$title, &$article ) {
		if ( $title instanceof Title && $title->getDBkey() === 'Not_a_valid_Wikia' ) {
			$article = new NotAValidWikiaArticle( $title );
		}

		return true;
	}
}
