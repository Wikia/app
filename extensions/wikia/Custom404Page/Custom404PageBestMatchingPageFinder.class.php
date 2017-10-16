<?php

class Custom404PageBestMatchingPageFinder {

	// Maximum sensible number of pages returned by Solr that we can parse to find the one match
	const MAX_SOLR_RESULTS = 200;

	private function query( $titleIn, $namespaceId ) {
		global $wgCityId, $wgContLang;

		$titleLowercase = mb_strtolower( $titleIn );
		$titleQ = str_replace( ['"', '\\'], ' ', $titleLowercase );

		$titleKey = 'title_' . $wgContLang->getCode();
		$luceneQuery = sprintf(
			'wid:%d AND ns:%d AND %s:"%s"',
			$wgCityId,
			$namespaceId,
			$titleKey,
			$titleQ
		);

		$config = new Wikia\Search\Config();
		$config->setDirectLuceneQuery( true );
		$config->setLimit( self::MAX_SOLR_RESULTS );
		$config->setRequestedFields( ['titleStrict'] );
		$config->setQuery( $luceneQuery );

		$queryServiceFactory = new Wikia\Search\QueryService\Factory();
		$response = $queryServiceFactory->getFromConfig( $config )->search();
		$results = (array) $response->getResults();

		return [
			'numFound' => $response->getResultsNum(),
			'titles' => array_map( function ( $result ) {
				return $result->getFields()['titleStrict'];
			} , $results )
		];
	}

	/**
	 * Get the title from the suggested titles that matches the best, false for no good match.
	 *
	 * This is string-manipulation only: no database or service connection whatsoever.
	 *
	 * @param $originalTitle   string
	 * @param $suggestedTitles array of strings
	 *
	 * @return string|bool the best matching string or false
	 */
	public function findTheBestMatchingTitleText( $originalTitle, $suggestedTitles ) {

		$originalLowerCase = mb_strtolower( $originalTitle );
		$originalLength = mb_strlen( $originalLowerCase );
		$originalWords = trim( preg_replace( '/\\W+/u', ' ', $originalLowerCase ) );
		$mismatchingCaseTitles = [];
		$matchingPrefixTitles = [];
		$matchingPrefixTitlesIncludingSubPages = [];
		$matchingWithoutSpecialsTitles = [];

		foreach ( $suggestedTitles as $suggestedTitle ) {
			$lowerCase = mb_strtolower( $suggestedTitle );
			$words = trim( preg_replace( '/\\W+/u', ' ', $lowerCase ) );

			if ( $originalLowerCase === $lowerCase ) {
				$mismatchingCaseTitles[] = $suggestedTitle;
			}

			if ( mb_strpos( $lowerCase, $originalLowerCase ) === 0 ) {
				$reminder = mb_strcut( $lowerCase, $originalLength );
				if ( mb_strpos( $reminder, '/' ) === false ) {
					// Don't consider subpages:
					$matchingPrefixTitles[] = $suggestedTitle;
				}
				$matchingPrefixTitlesIncludingSubPages[] = $suggestedTitle;
			}

			if ( $originalWords == $words ) {
				$matchingWithoutSpecialsTitles[] = $suggestedTitle;
			}
		}

		if ( count( $mismatchingCaseTitles ) === 1 ) {
			return $mismatchingCaseTitles[0];
		}

		if ( count( $matchingPrefixTitles ) === 1 ) {
			return $matchingPrefixTitles[0];
		}

		if ( count( $matchingWithoutSpecialsTitles ) === 1 ) {
			return $matchingWithoutSpecialsTitles[0];
		}

		if ( count( $matchingPrefixTitlesIncludingSubPages ) === 1 ) {
			return $matchingPrefixTitlesIncludingSubPages[0];
		}

		return false;
	}

	/**
	 * Given a non-existing Title, get an existing one that matching the title the best.
	 *
	 * If there's no good match, or there's more than one match, return null
	 *
	 * @param Title $title
	 * @return Title|null
	 */
	public function findBestMatchingArticle( Title $title ) {

		$namespaceId = $title->getNamespace();
		$titleText = $title->getPrefixedText();

		if ( $title->isContentPage() && !$title->exists() ) {
			$queryResults = $this->query( $titleText, $namespaceId );

			if ( $queryResults['numFound'] === 0 ) {
				// Strip last (maybe incomplete?) word form the title
				$titleTextStripped = trim( preg_replace( '/\\W*\\w+\\W*$/u', '', $titleText ) );
				if ( !empty( $titleTextStripped ) ) {
					$queryResults = $this->query( $titleTextStripped, $namespaceId );
				}
			}

			if ( $queryResults['numFound'] < self::MAX_SOLR_RESULTS ) {
				$titleText = self::findTheBestMatchingTitleText( $titleText, $queryResults['titles'] );
				if ( $titleText ) {
					$title = Title::newFromText( $titleText );
					if ( $title->exists() ) {
						return $title;
					}
				}
			}

		}

		return null;
	}
}
