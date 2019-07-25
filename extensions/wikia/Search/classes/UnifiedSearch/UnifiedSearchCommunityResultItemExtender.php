<?php

namespace Wikia\Search\UnifiedSearch;

class UnifiedSearchCommunityResultItemExtender {
	const MAX_WORD_COUNT_EXACT_MATCH = 40;
	const MAX_WORD_COUNT_XWIKI_RESULT = 60;

	public static function extendCommunityResult(
		UnifiedSearchResultItem $result, $pos, string $query, $descWordLimit = self::MAX_WORD_COUNT_EXACT_MATCH
	): UnifiedSearchResultItem {
		$imageURL = $result['image'] ?? null;

		if ( empty( $imageURL ) ) {
			// display placeholder image if no thumbnail
			$imageURL = \F::app()->wg->ExtensionsPath . '/wikia/Search/images/fandom_image_placeholder.jpg';
			$thumbTracking = "no-thumb";
		}

		$wikiaSearchHelper = new \WikiaSearchHelper();

		$lang = $wikiaSearchHelper->getLangForSearchResults();
		$centralUrl = $wikiaSearchHelper->getCentralUrlFromGlobalTitle( $lang );
		$globalSearchUrl = $wikiaSearchHelper->getGlobalSearchUrl( $centralUrl ) . '?' . http_build_query( [
				'search' => $query,
				'resultsLang' => $lang,
			] );

		return $result->extended( [
			'imageURL' => $imageURL,
			'descriptionWordLimit' => $descWordLimit,
			'pos' => $pos,
			'viewMoreWikisLink' => $globalSearchUrl,
			'thumbTracking' => $thumbTracking ?? null,
		] );
	}
}
