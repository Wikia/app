<?php

/**
 * WikiaHomePage Helper
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Hyun Lim
 * @author Marcin Maciejewski
 * @author Saipetch Kongkatong
 * @author Sebastian Marzjan
 *
 */

class WikiaHomePageHelper extends WikiaModel {

	const VIDEO_GAMES_SLOTS_VAR_NAME = 'wgWikiaHomePageVideoGamesSlots';
	const ENTERTAINMENT_SLOTS_VAR_NAME = 'wgWikiaHomePageEntertainmentSlots';
	const LIFESTYLE_SLOTS_VAR_NAME = 'wgWikiaHomePageLifestyleSlots';
	const SLOTS_IN_TOTAL = 17;

	const SLOTS_BIG = 2;
	const SLOTS_MEDIUM = 1;
	const SLOTS_SMALL = 14;

	const SLOTS_BIG_ARRAY_KEY = 'bigslots';
	const SLOTS_MEDIUM_ARRAY_KEY = 'mediumslots';
	const SLOTS_SMALL_ARRAY_KEY = 'smallslots';

	const LIMIT_ADMIN_AVATARS = 3;
	const LIMIT_TOP_EDITOR_AVATARS = 7;

	const AVATAR_SIZE = 28;
	const ADMIN_UPLOAD_IMAGE_WIDTH = 320;
	const ADMIN_UPLOAD_IMAGE_HEIGHT = 320;
	const INTERSTITIAL_LARGE_IMAGE_WIDTH = 480;
	const INTERSTITIAL_LARGE_IMAGE_HEIGHT = 320;
	const INTERSTITIAL_SMALL_IMAGE_WIDTH = 115;
	const INTERSTITIAL_SMALL_IMAGE_HEIGHT = 65;

	const WAM_SCORE_ROUND_PRECISION = 2;

	const SLIDER_IMAGES_KEY = 'SliderImagesKey';
	const WIKIA_HOME_PAGE_HELPER_MEMC_VERSION = 'v0.9';

	//images sizes (moved here from WikiaHomePageController to break dependency)
	const REMIX_IMG_SMALL_WIDTH = 155;
	const REMIX_IMG_SMALL_HEIGHT = 100;
	const REMIX_IMG_MEDIUM_WIDTH = 320;
	const REMIX_IMG_MEDIUM_HEIGHT = 210;
	const REMIX_IMG_BIG_WIDTH = 320;
	const REMIX_IMG_BIG_HEIGHT = 320;
	const REMIX_GRID_IMG_SMALL_WIDTH = 160;
	const REMIX_GRID_IMG_SMALL_HEIGHT = 100;
	const REMIX_GRID_IMG_MEDIUM_WIDTH = 330;
	const REMIX_GRID_IMG_MEDIUM_HEIGHT = 210;
	const REMIX_GRID_IMG_BIG_WIDTH = 330;
	const REMIX_GRID_IMG_BIG_HEIGHT = 320;

	// moved from CityVisualization
	const PROMOTED_ARRAY_KEY = 'promoted';
	const DEMOTED_ARRAY_KEY = 'demoted';

	protected function getImageUrl($imageName, $requestedWidth, $requestedHeight) {
		wfProfileIn(__METHOD__);
		$imageUrl = '';

		if (!empty($imageName)) {
			if (strpos($imageName, '%') !== false) {
				$imageName = urldecode($imageName);
			}

			$title = Title::newFromText($imageName, NS_IMAGE);
			$file = wfFindFile($title);

			$imageUrl = ImagesService::overrideThumbnailFormat(
				$this->getImageUrlFromFile($file, $requestedWidth, $requestedHeight),
				ImagesService::EXT_JPG
			);
		}

		wfProfileOut(__METHOD__);
		return $imageUrl;
	}

	protected function getImageUrlFromFile($file, $requestedWidth, $requestedHeight) {
		wfProfileIn(__METHOD__);
		if ($file instanceof File && $file->exists()) {
			$originalWidth = $file->getWidth();
			$originalHeight = $file->getHeight();
		}

		if (!empty($originalHeight) && !empty($originalWidth)) {
			$imageServing = $this->getImageServingForResize($requestedWidth, $requestedHeight, $originalWidth, $originalHeight);
			$imageUrl = $imageServing->getUrl($file, $originalWidth, $originalHeight);
		} else {
			$imageUrl = $this->wg->blankImgUrl;
		}
		wfProfileOut(__METHOD__);
		return $imageUrl;
	}

	protected function getImageServingForResize($requestedWidth, $requestedHeight, $originalWidth, $originalHeight) {
		$params = $this->getImageServingParamsForResize($requestedWidth, $requestedHeight, $originalWidth, $originalHeight);
		return new ImageServing($params[0], $params[1], $params[2]);
	}

	protected function getImageServingParamsForResize($requestedWidth, $requestedHeight, $originalWidth, $originalHeight) {
		$requestedRatio = $requestedWidth / $requestedHeight;
		$originalRatio = $originalWidth / $originalHeight;

		$requestedCropHeight = $requestedHeight;
		$requestedCropWidth = $requestedWidth;

		if ($originalHeight < $requestedHeight && $originalRatio > $requestedRatio) {
			// result should have more 'vertical' orientation, cropping left and right from original image;
			$requestedCropHeight = $originalHeight;
			$requestedCropWidth = ceil($requestedCropHeight * $requestedRatio);
			if ($requestedWidth >= $originalWidth && $requestedCropHeight == $originalHeight && $requestedRatio >= 1) {
				$requestedWidth = $requestedCropWidth;
			}
		}

		if ($originalWidth < $requestedWidth && $originalRatio < $requestedRatio) {
			// result should have more 'horizontal' orientation, cropping top and bottom from original image;
			$requestedWidth = $originalWidth;
			$requestedCropWidth = $originalWidth;
			$requestedCropHeight = ceil($requestedCropWidth / $requestedRatio);
		}

		$imageServingParams = array(
			null,
			ceil(min($originalWidth, $requestedWidth)),
			array(
				'w' => floor($requestedCropWidth),
				'h' => floor($requestedCropHeight)
			)
		);

		return $imageServingParams;
	}

	public function prepareBatchesForVisualization($batches) {
		wfProfileIn(__METHOD__);

		$processedBatches = array();
		foreach ($batches as $batch) {
			$processedBatch = array(
				self::SLOTS_BIG_ARRAY_KEY => array(),
				self::SLOTS_MEDIUM_ARRAY_KEY => array(),
				self::SLOTS_SMALL_ARRAY_KEY => array()
			);

			if (!empty($batch[self::PROMOTED_ARRAY_KEY])) {
				//if there are any promoted wikis they should go firstly to big&medium slots
				$promotedBatch = $batch[self::PROMOTED_ARRAY_KEY];
			} else {
				$promotedBatch = [];
			}


			if (empty($batch[self::DEMOTED_ARRAY_KEY])) {
				continue;
			} else {
				shuffle($batch[self::DEMOTED_ARRAY_KEY]);
			}

			$biggerSlotsWikis = array_slice($promotedBatch, 0, self::SLOTS_BIG + self::SLOTS_MEDIUM);
			$promotedCount = count($biggerSlotsWikis);
			if ($promotedCount < self::SLOTS_BIG + self::SLOTS_MEDIUM) {
				$biggerSlotsWikis = array_merge(
					$biggerSlotsWikis,
					array_splice(
						$batch[self::DEMOTED_ARRAY_KEY],
						0,
						self::SLOTS_BIG + self::SLOTS_MEDIUM - $promotedCount
					)
				);
			}
			shuffle($biggerSlotsWikis);
			$processedBatch[self::SLOTS_BIG_ARRAY_KEY] = array_splice($biggerSlotsWikis, 0, self::SLOTS_BIG);
			$processedBatch[self::SLOTS_MEDIUM_ARRAY_KEY] = array_splice($biggerSlotsWikis, 0, self::SLOTS_MEDIUM);
			$processedBatch[self::SLOTS_SMALL_ARRAY_KEY] = $batch[self::DEMOTED_ARRAY_KEY];

			$processedBatch = $this->prepareWikisForVisualization($processedBatch);
			$processedBatches[] = $processedBatch;
		}

		wfProfileOut(__METHOD__);
		return $processedBatches;
	}

	private function prepareWikisForVisualization($batch) {
		foreach($batch as $slotName => &$wikis) {
			$size = $this->getProcessedWikisImgSizes($slotName);
			foreach($wikis as &$wiki) {
				if (!empty($wiki['image'])) {
					$wiki['main_image'] = $wiki['image'];
				}
				$wiki['image'] = ImagesService::overrideThumbnailFormat(
					$this->getImageUrl($wiki['main_image'], $size->width, $size->height),
					ImagesService::EXT_JPG
				);
				unset($wiki['main_image']);
			}
		}
		return $batch;
	}

	/**
	 * @desc Depends on given slots limit recognize which size it should return
	 * @param integer $limit one of constants of this class reprezenting amount of slots
	 * @return StdClass with width&height fields
	 */
	protected function getProcessedWikisImgSizes($slotName) {
		$result = new StdClass;
		switch ($slotName) {
			case self::SLOTS_SMALL_ARRAY_KEY:
				$result->width = $this->getRemixSmallImgWidth();
				$result->height = $this->getRemixSmallImgHeight();
				break;
			case self::SLOTS_MEDIUM_ARRAY_KEY:
				$result->width = $this->getRemixMediumImgWidth();
				$result->height = $this->getRemixMediumImgHeight();
				break;
			case self::SLOTS_BIG_ARRAY_KEY:
			default:
				$result->width = $this->getRemixBigImgWidth();
				$result->height = $this->getRemixBigImgHeight();
				break;
		}

		return $result;
	}

	protected function getRemixBigImgHeight() {
		if (!empty($this->wg->OasisGrid)) {
			return self::REMIX_GRID_IMG_BIG_HEIGHT;
		} else {
			return self::REMIX_IMG_BIG_HEIGHT;
		}
	}

	protected function getRemixBigImgWidth() {
		if (!empty($this->wg->OasisGrid)) {
			return self::REMIX_GRID_IMG_BIG_WIDTH;
		} else {
			return self::REMIX_IMG_BIG_WIDTH;
		}
	}

	protected function getRemixMediumImgHeight() {
		if (!empty($this->wg->OasisGrid)) {
			return self::REMIX_GRID_IMG_MEDIUM_HEIGHT;
		} else {
			return self::REMIX_IMG_MEDIUM_HEIGHT;
		}
	}

	protected function getRemixMediumImgWidth() {
		if (!empty($this->wg->OasisGrid)) {
			return self::REMIX_GRID_IMG_BIG_WIDTH;
		} else {
			return self::REMIX_IMG_BIG_WIDTH;
		}
	}

	protected function getRemixSmallImgHeight() {
		if (!empty($this->wg->OasisGrid)) {
			return self::REMIX_GRID_IMG_SMALL_HEIGHT;
		} else {
			return self::REMIX_IMG_SMALL_HEIGHT;
		}
	}

	protected function getRemixSmallImgWidth() {
		if (!empty($this->wg->OasisGrid)) {
			return self::REMIX_GRID_IMG_SMALL_WIDTH;
		} else {
			return self::REMIX_IMG_SMALL_WIDTH;
		}
	}
}
