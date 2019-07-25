<?php

namespace Wikia\Search\UnifiedSearch;

use CommunityDataService, ImagesService, PromoImage;

class UnifiedSearchCommunityResultItemExtender {
	const MAX_WORD_COUNT_EXACT_MATCH = 40;
	const MAX_WORD_COUNT_XWIKI_RESULT = 60;

	public static function extendCommunityResult(
		UnifiedSearchResultItem $result, string $pos, int $descWordLimit, array $imageSizes, string $query
	) {

		$commData = new CommunityDataService( $result['id'] );

		$imageURL = $result['image'] ?? null;

		if ( null === $imageURL ) {
			$imageURL =
				ImagesService::getImageSrc( $result['id'], $commData->getCommunityImageId(), $imageSizes['width'],
					$imageSizes['height'] )['src'];
		}

		$thumbTracking = "thumb";
		//Fallback: if Curated Mainpage is inaccessible, try to use Special:Promote
		//TODO: Remove after DAT-3642 is done
		if ( null === $imageURL ) {
			$imageFileName =
				PromoImage::fromPathname( $result['image_s'] )->ensureCityIdIsSet( $result['id'] )->getPathname();
			$imageURL =
				ImagesService::getImageSrcByTitle( ( new \WikiaCorporateModel )->getCorporateWikiIdByLang( $result['lang_s'] ),
					$imageFileName, $imageSizes['width'], $imageSizes['height'] );
		}//TODO: end

		if ( empty( $imageURL ) ) {
			// display placeholder image if no thumbnail
			$imageURL = \F::app()->wg->ExtensionsPath . '/wikia/Search/images/fandom_image_placeholder.jpg';
			$thumbTracking = "no-thumb";
		}

		$description = $result['description'] ?? null;

		$wikiaSearchHelper = new \WikiaSearchHelper();

		$lang = $wikiaSearchHelper->getLangForSearchResults();
		$centralUrl = $wikiaSearchHelper->getCentralUrlFromGlobalTitle( $lang );
		$globalSearchUrl = $wikiaSearchHelper->getGlobalSearchUrl( $centralUrl ) . '?' . http_build_query( [
					'search' => $query,
					'resultsLang' => $lang,
				] );

		return [
			'isOnWikiMatch' => isset( $result['onWikiMatch'] ) && $result['onWikiMatch'],
			'exactWikiMatch' => $result['exactWikiMatch'] ?? true,
			'imageURL' => $imageURL,
			'description' => $description,
			'descriptionWordLimit' => $descWordLimit,
			'pagesCount' => $result['pageCount'] ?? 0,
			'imagesCount' => $result['imageCount'] ?? 0,
			'videosCount' => $result['videoCount'] ?? 0,
			'title' => $result['title'] ?? self::getTitle( $result ),
			'url' => $result['url'],
			'hub' => $result['hub'],
			'pos' => $pos,
			'thumbTracking' => $thumbTracking,
			'viewMoreWikisLink' => $globalSearchUrl,
		];
	}

	private static function getTitle( $result ) {
		$sn = $result->getText( 'sitename_txt' );

		return $sn ?? $result->getText( 'headline_txt' );
	}
}
