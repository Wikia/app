<?php
namespace Wikia\Search\Result;

use Wikia\Search\MediaWikiService, Wikia\Search\Utilities, CommunityDataService, ImagesService, PromoImage;

class ResultHelper {
	const MAX_WORD_COUNT_EXACT_MATCH = 40;
	const MAX_WORD_COUNT_XWIKI_RESULT = 60;

	/**
	 * Extends search result with additional data from outside search index, like description and image
	 *
	 * @param $result
	 * @param $pos
	 * @param $descWordLimit
	 * @param $imageSizes
	 * @param query
	 *
	 * @return array
	 */
	public static function extendResult( $result, $pos, $descWordLimit, $imageSizes, $query = null ) {

		$commData = new CommunityDataService( $result['id'] );
		$imageURL = ImagesService::getImageSrc(
			$result['id'],
			$commData->getCommunityImageId(),
			$imageSizes['width'],
			$imageSizes['height']
		)['src'];

		$thumbTracking = "thumb";
		//Fallback: if Curated Mainpage is inaccessible, try to use Special:Promote
		//TODO: Remove after DAT-3642 is done
		if ( empty( $imageURL ) ) {
			$imageFileName =
				PromoImage::fromPathname( $result['image_s'] )->ensureCityIdIsSet( $result['id'] )->getPathname();
			$imageURL = ImagesService::getImageSrcByTitle(
				( new \WikiaCorporateModel )->getCorporateWikiIdByLang( $result['lang_s'] ),
				$imageFileName,
				$imageSizes['width'],
				$imageSizes['height']
			);
		}//TODO: end

		if ( empty( $imageURL ) ) {
			// display placeholder image if no thumbnail
			$imageURL = \F::app()->wg->ExtensionsPath . '/wikia/Search/images/fandom_image_placeholder.jpg';
			$thumbTracking = "no-thumb";
		}

		$description = $commData->getCommunityDescription();
		$description = !empty( $description ) ? $description : $result->getText( Utilities::field( 'description' ) );

		$wikiaSearchHelper = new \WikiaSearchHelper();

		$globalSearchUrl = '';
		if ( $query ) {
			$lang = $wikiaSearchHelper->getLangForSearchResults();
			$centralUrl = $wikiaSearchHelper->getCentralUrlFromGlobalTitle( $lang );
			$globalSearchUrl = $wikiaSearchHelper->getGlobalSearchUrl( $centralUrl ) . '?' . http_build_query(
					[
						'search' => $query,
						'resultsLang' => $lang,
					]
				);
		}

		return [
			'isOnWikiMatch' => isset( $result['onWikiMatch'] ) && $result['onWikiMatch'],
			'imageURL' => $imageURL,
			'description' => $description,
			'descriptionWordLimit' => $descWordLimit,
			'pagesCount' => $result['articles_i'] ?: 0,
			'imagesCount' => $result['images_i'] ?: 0,
			'videosCount' => $result['videos_i'] ?: 0,
			'title' => ( $sn = $result->getText( 'sitename_txt' ) ) ? $sn : $result->getText( 'headline_txt' ),
			'url' => $result->getText( 'url' ),
			'hub' => $result->getHub(),
			'pos' => $pos,
			'thumbTracking' => $thumbTracking,
			'viewMoreWikisLink' => $globalSearchUrl
		];
	}
}
