<?php

/**
 * Utility functions for the Contest extension.
 *
 * @since 0.1
 *
 * @file ContestUtils.php
 * @ingroup Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ContestUtils {

	/**
	 * Gets the content of the article with the provided page name,
	 * or an empty string when there is no such article.
	 *
	 * @since 0.1
	 *
	 * @param string $pageName
	 *
	 * @return string
	 */
	public static function getArticleContent( $pageName ) {
		$title = Title::newFromText( $pageName );

		if ( is_null( $title ) ) {
			return '';
		}

		$article = new Article( $title, 0 );
		return $article->fetchContent();
	}

	/**
	 * Gets the content of the article with the provided page name,
	 * or an empty string when there is no such article.
	 *
	 * @since 0.1
	 *
	 * @param string $pageName
	 *
	 * @return string
	 */
	public static function getParsedArticleContent( $pageName ) {
		$title = Title::newFromText( $pageName );

		if ( is_null( $title ) ) {
			return '';
		}

		$article = new Article( $title, 0 );

		global $wgParser, $wgContestEmailParse;

		$wgContestEmailParse = true;

		$text = $wgParser->parse(
			$article->fetchContent(),
			$article->getTitle(),
			$article->getParserOptions()
		)->getText();

		$wgContestEmailParse = false;

		return $text;
	}

}
