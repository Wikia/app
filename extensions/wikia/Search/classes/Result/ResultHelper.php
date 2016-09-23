<?php
namespace Wikia\Search\Result;

use Wikia\Search\MediaWikiService, Wikia\Search\Utilities, CommunityDataService, ImagesService, WikiaSearchController, PromoImage;

class ResultHelper
{
	const MAX_WORD_COUNT_EXACT_MATCH = 16;
	const MAX_WORD_COUNT_XWIKI_RESULT = 60;

	/**
	 * +     * Extends search result with additional data from outside search index, like description and image
	 * +     *
	 * +     * @param $result
	 * +     * @param $pos
	 * +     * @param $descWordLimit
	 * +     * @return array
	 * +     */
	public static function extendResult($result, $pos, $descWordLimit)
	{
		$commData = new CommunityDataService($result['id']);
		$imageURL = ImagesService::getImageSrc(
			$result['id'],
			$commData->getCommunityImageId(),
			WikiaSearchController::CROSS_WIKI_PROMO_THUMBNAIL_WIDTH,
			WikiaSearchController::CROSS_WIKI_PROMO_THUMBNAIL_HEIGHT)['src'];

		$thumbTracking = "thumb";
		//Fallback: if Curated Mainpage is inaccessible, try to use Special:Promote
		//TODO: Remove after DAT-3642 is done
		if (empty($imageURL)) {
			$imageFileName = PromoImage::fromPathname($result['image_s'])->ensureCityIdIsSet($result['id'])->getPathname();
			$imageURL = ImagesService::getImageSrcByTitle(
				(new \CityVisualization)->getTargetWikiId($result['lang_s']),
				$imageFileName,
				WikiaSearchController::CROSS_WIKI_PROMO_THUMBNAIL_WIDTH,
				WikiaSearchController::CROSS_WIKI_PROMO_THUMBNAIL_HEIGHT);
		}//TODO: end

		if (empty($imageURL)) {
			// display placeholder image if no thumbnail
			$imageURL = \F::app()->wg->ExtensionsPath . '/wikia/Search/images/wiki_image_placeholder.png';
			$thumbTracking = "no-thumb";
		}

		$description = $result->limitTextLength($commData->getCommunityDescription(), $descWordLimit);
		$description = !empty($description)
			? $description
			: $result->getText(Utilities::field('description'), $descWordLimit);

		$service = new MediaWikiService();

		return [
			'isOnWikiMatch' => isset($result['onWikiMatch']) && $result['onWikiMatch'],
			'imageURL' => $imageURL,
			'description' => $description,
			'pagesMsg' => $service->shortnumForMsg($result['articles_i'] ?: 0, 'wikiasearch2-pages'),
			'imgMsg' => $service->shortnumForMsg($result['images_i'] ?: 0, 'wikiasearch2-images'),
			'videoMsg' => $service->shortnumForMsg($result['videos_i'] ?: 0, 'wikiasearch2-videos'),
			'title' => ($sn = $result->getText('sitename_txt')) ? $sn : $result->getText('headline_txt'),
			'url' => $result->getText('url'),
			'hub' => $result->getHub(),
			'pos' => $pos,
			'thumbTracking' => $thumbTracking
		];
	}
}
