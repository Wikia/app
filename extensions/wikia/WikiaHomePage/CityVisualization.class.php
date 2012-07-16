<?php
class CityVisualization extends WikiaModel {
	const FLAG_NEW = 1;
	const FLAG_HOT = 2;
	const FLAG_PROMOTED = 4;
	const FLAG_BLOCKED = 8;

	const CITY_TAG_ENTERTAINMENT_ID = 129;
	const CITY_TAG_VIDEO_GAMES_ID = 131;
	const CITY_TAG_LIFESTYLE_ID = 127;

	const CITY_VISUALIZATION_MEMC_VERSION = 'v0.29';

	public function getList($corpWikiId, $contLang) {
		$this->wf->ProfileIn(__METHOD__);

		$memKey = $this->getVisualizationWikisListDataCacheKey($corpWikiId, $contLang);
		$wikis = $this->wg->Memc->get($memKey);

		if( !is_array($wikis) ) {
			$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
			$tables = array('city_visualization', 'city_list');
			$fields = array(
				'city_visualization.city_id',
				'city_visualization.city_main_image',
				'city_visualization.city_description',
				'city_visualization.city_headline',
				'city_list.city_url',
				'city_visualization.city_flags',
			);
			$conds = array(
				'city_list.city_public' => 1,
				'city_visualization.city_lang_code' => $contLang
			);
			$joinConds = array(
				'city_list' => array(
					'join',
					'city_visualization.city_id = city_list.city_id'
				),
			);

			$results = $db->select($tables, $fields, $conds, __METHOD__, array(), $joinConds);

			$tmpWikis = array();
			while ($row = $db->fetchObject($results)) {
				$wikiUrl = $row->city_url . '?redirect=no';

				$tmpWikis[] = array(
					'wikiid' => $row->city_id,
					'wikiname' => $row->city_headline,
					'wikiurl' => $wikiUrl,
					'wikidesc' => $row->city_description,
					'main_image' => $row->city_main_image,
					'wikinew' => $this->isNewWiki($row->city_flags),
					'wikihot' => $this->isHotWiki($row->city_flags),
				);
			}

			$wikis = array();
			if (!empty($tmpWikis)) {
				foreach ($tmpWikis as $wiki) {
					$wikiId = $wiki['wikiid'];
					$hubInfo = HubService::getComscoreCategory($wikiId);
					$tagName = $this->getNameFromComscoreCatName($hubInfo->cat_name);
					if ($tagName !== false) {
						$wikis[$tagName][] = array(
							'wikiid' => $wikiId,
							'wikiname' => $wiki['wikiname'],
							'wikiurl' => $wiki['wikiurl'],
							'wikidesc' => $wiki['wikidesc'],
							'main_image' => $wiki['main_image'],
							'wikinew' => $wiki['wikinew'],
							'wikihot' => $wiki['wikihot'],
						);
					}
				}
			}

			$this->wg->Memc->set($memKey, $wikis, 60 * 60 * 24);
		}

		$this->wf->ProfileOut(__METHOD__);
		return $wikis;
	}

	public function saveVisualizationData($wikiId, $data, $langCode) {
		$sdb = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
		$mdb = $this->wf->GetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

		$table = 'city_visualization';
		$fields = array('city_visualization.city_id', 'city_flags');
		$conds = array(
			'city_visualization.city_id' => $wikiId,
			'city_lang_code' => $langCode
		);
		$results = $sdb->select(array($table), $fields, $conds, __METHOD__);

		$row = $sdb->fetchObject($results);

		if( $row ) {
			//UPDATE
			$cond = array(
				'city_id' => $wikiId,
				'city_lang_code' => $this->wg->contLang->getCode()
			);
			$mdb->update($table, $data, $cond, __METHOD__);
			$data['city_flags'] = $row->city_flags;
		} else {
			//INSERT
			$data['city_id'] = $wikiId;
			$mdb->Insert($table, $data, __METHOD__);
			$data['city_flags'] = null;
		}
		$mdb->commit();
	}

	/**
	 * @desc Mapping integer id of a tag to one of the main names recognized by visualization
	 * @param integer $tagId tag id from city_tag table
	 * @return string | bool returns false if the tag id doesn't match one of the main tags
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function getNameFromTagId($tagId) {
		$mapArr = array(
			self::CITY_TAG_LIFESTYLE_ID => 'lifestyle',
			self::CITY_TAG_ENTERTAINMENT_ID => 'entertainment',
			self::CITY_TAG_VIDEO_GAMES_ID => 'video games',
		);

		if (isset($mapArr[$tagId])) {
			return $mapArr[$tagId];
		}

		return false;
	}

	/**
	 * @desc Mapping HubsService results (hubs names) to new names recognized by visualization
	 * @param string $catName tag name from HubsService::getComscoreCategory results
	 * @return string | bool returns false if the comscore category name doesn't match one of the main tags
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function getNameFromComscoreCatName($catName) {
		$catName = strtolower($catName);
		$mapArr = array(
			'lifestyle' => 'lifestyle',
			'entertainment' => 'entertainment',
			'gaming' => 'video games',
		);

		if (isset($mapArr[$catName])) {
			return $mapArr[$catName];
		}

		return false;
	}

	public function purgeVisualizationWikisListCache($corpWikiId, $langCode) {
		$memcKey = $this->getVisualizationWikisListDataCacheKey($corpWikiId, $langCode);
		$this->wg->Memc->set($memcKey, null);
	}

	public function updateWikiPromoteDataCache($wikiId, $langCode, $data) {
		$memcKey = $this->getWikiPromoteDataCacheKey($wikiId, $langCode);

		$cityImages = (!empty($data['city_images'])) ? (array)json_decode($data['city_images']) : array();
		$wikiData = array(
			'headline' => $data['city_headline'],
			'description' => $data['city_description'],
			'main_image' => $data['city_main_image'],
			'images' => $cityImages
		);

		$this->wg->Memc->set($memcKey, $wikiData);
	}

	public function getVisualizationWikisListDataCacheKey($corporateWikiId, $langCode) {
		return $this->wf->SharedMemcKey('wikis_data_for_visualization_comscore', self::CITY_VISUALIZATION_MEMC_VERSION, $corporateWikiId, $langCode, __METHOD__);
	}

	public function getWikiPromoteDataCacheKey($wikiId, $langCode) {
		return $this->getVisualizationElementMemcKey('wiki_data_special_promote', $wikiId, $langCode);
	}

	public function getWikiDataCacheKey($corporateWikiId, $wikiId, $langCode) {
		return $this->wf->SharedMemcKey('wikis_data_visualization', self::CITY_VISUALIZATION_MEMC_VERSION, $corporateWikiId, $wikiId, $langCode, __METHOD__);
	}

	public function getWikiImagesCacheKey($wikiId, $langCode) {
		return $this->getVisualizationElementMemcKey('wiki_data_visualization_images', $wikiId, $langCode);
	}

	public function getWikiImageNamesCacheKey($wikiId, $langCode) {
		return $this->getVisualizationElementMemcKey('wiki_data_visualization_image_names', $wikiId, $langCode);
	}

	public function getVisualizationElementMemcKey($prefix, $wikiId, $langCode) {
		return $this->wf->memcKey($prefix, self::CITY_VISUALIZATION_MEMC_VERSION, $wikiId, $langCode);
	}

	/**
	 * Get wiki data for Special:Promote
	 * @param integer $wikiId
	 * @return array $wikiData
	 */
	public function getWikiDataForPromote($wikiId, $langCode) {
		$helper = F::build('WikiGetDataForPromoteHelper');
		return $this->getWikiData($wikiId, $langCode, $helper);
	}

	/**
	 * Get wiki data for Wikia Visualization
	 * @param integer $wikiId
	 * @return array $wikiData
	 */
	public function getWikiDataForVisualization($wikiId, $langCode) {
		$helper = F::build('WikiGetDataForVisualizationHelper');
		return $this->getWikiData($wikiId, $langCode, $helper);
	}

	/**
	 * Get wiki data for Wikia Visualization
	 * @param integer $wikiId
	 * @param integer $wikiId
	 * @return array $wikiData
	 */
	public function getWikiData($wikiId, $langCode, WikiGetDataHelper $dataHelper) {
		$this->wf->ProfileIn(__METHOD__);

		$memcKey = $dataHelper->getMemcKey($wikiId, $langCode);
		$wikiData = $this->wg->Memc->get($memcKey);

		if (empty($wikiData)) {
			$wikiData = array();
			$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
			$row = $db->selectRow(
				array('city_visualization'),
				array(
					'city_headline',
					'city_description',
					'city_main_image',
					'city_flags',
					'city_images',
				),
				array(
					'city_id' => $wikiId,
					'city_lang_code' => $langCode
				),
				__METHOD__
			);

			if ($row) {
				$wikiData['headline'] = $row->city_headline;
				$wikiData['description'] = $row->city_description;
				$wikiData['flags'] = $row->city_flags;
				$wikiData['images'] = $dataHelper->getImages($wikiId, $langCode, $row);
				$wikiData['main_image'] = $dataHelper->getMainImage($wikiId, $langCode, $row, &$wikiData);
			}

			$this->wg->Memc->set($memcKey, $wikiData, 60 * 60 * 24);
		}

		$this->wf->ProfileOut(__METHOD__);

		return $wikiData;
	}

	protected function getWikiImagesConditions($wikiId, $langCode, $filter) {
		$conditions = array();

		$conditions ['city_id'] = $wikiId;
		$conditions ['city_lang_code'] = $langCode;

		switch ($filter) {
			case ImageReviewStatuses::STATE_APPROVED:
				$conditions ['image_review_status'] = ImageReviewStatuses::STATE_APPROVED;
				break;
			case ImageReviewStatuses::STATE_UNREVIEWED:
				$conditions ['image_review_status'] = ImageReviewStatuses::STATE_UNREVIEWED;
				break;
			default:
				break;
		}

		return $conditions;
	}

	public function getWikiImages($wikiId, $langCode, $filter = ImageReviewStatuses::STATE_APPROVED) {
		$this->wf->ProfileIn(__METHOD__);

		$memKey = $this->getWikiImagesCacheKey($wikiId, $langCode);
		$wikiImages = $this->wg->Memc->get($memKey);

		if (empty($wikiImages)) {
			$rowAssigner = F::build('WikiImageRowHelper');
			$wikiImages = $this->getWikiImageData($wikiId, $langCode, $rowAssigner, $filter);
			$this->wg->Memc->set($memKey, $wikiImages, 60 * 60 * 24);
		}
		$this->wf->ProfileOut(__METHOD__);

		return $wikiImages;
	}

	public function getWikiImageNames($wikiId, $langCode, $filter = ImageReviewStatuses::STATE_APPROVED) {
		$this->wf->ProfileIn(__METHOD__);

		$memKey = $this->getWikiImageNamesCacheKey($wikiId, $langCode);
		$wikiImageNames = $this->wg->Memc->get($memKey);

		if (empty($wikiImageNames)) {
			$rowAssigner = F::build('WikiImageNameRowHelper');
			$wikiImageNames = $this->getWikiImageData($wikiId, $langCode, $rowAssigner, $filter);
			$this->wg->Memc->set($memKey, $wikiImageNames, 60 * 60 * 24);
		}
		$this->wf->ProfileOut(__METHOD__);

		return $wikiImageNames;
	}

	public function getWikiImageData($wikiId, $langCode, WikiImageRowAssigner $rowAssigner, $filter = ImageReviewStatuses::STATE_APPROVED) {
		$this->wf->ProfileIn(__METHOD__);

		$wikiImages = array();
		$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$conditions = $this->getWikiImagesConditions($wikiId, $langCode, $filter);

		$result = $db->select(
			array('city_visualization_images'),
			array(
				'image_name',
				'image_index',
				'image_review_status',
			),
			$conditions,
			__METHOD__
		);

		while ($row = $result->fetchObject()) {
			$wikiImages[$row->image_index] = $rowAssigner->returnParsedWikiImageRow($row);
		}

		$this->wf->ProfileOut(__METHOD__);

		return $wikiImages;
	}

	public function saveImagesForReview($cityId, $langCode, $images) {
		$currentImages = $this->getImagesFromReviewTable($cityId, $langCode);

		$reversedImages = array_flip($images);
		$imagesToModify = array();

		foreach ($currentImages as $image) {
			if (isset($reversedImages[$image->image_name])) {
				$image->last_edited = date('Y-m-d H:i:s');
				$image->image_review_status = 0;
				$imagesToModify [] = $image;
				unset($reversedImages[$image->image_name]);
			}
		}

		$newImages = array_flip($reversedImages);

		$imagesToAdd = array();
		foreach ($newImages as $image) {
			$imageData = new stdClass();

			$imageIndex = 0;
			$matches = array();
			if (preg_match('/Wikia-Visualization-Add-([0-9])\.jpg/', $image, $matches)) {
				$imageIndex = intval($matches[1]);
			}

			$title = F::build('Title', array($image, NS_FILE), 'newFromText');

			$imageData->city_id = $cityId;
			$imageData->page_id = $title->getArticleId();
			$imageData->city_lang_code = $langCode;
			$imageData->image_index = $imageIndex;
			$imageData->image_name = $image;
			$imageData->image_review_status = 0;
			$imageData->last_edited = date('Y-m-d H:i:s');
			$imageData->review_start = null;
			$imageData->review_end = null;
			$imageData->reviewer_id = null;

			$imagesToAdd [] = $imageData;
		}

		if (!empty($imagesToAdd) || !empty($imagesToModify)) {
			$dbm = $this->wf->GetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);
			$dbm->begin(__METHOD__);
			foreach ($imagesToAdd as $image) {
				$insertArray = array();

				foreach ($image as $field => $value) {
					$insertArray[$field] = $value;
				}

				$dbm->insert(
					'city_visualization_images',
					$insertArray
				);
			}

			foreach ($imagesToModify as $image) {
				$updateArray = array();

				$image->reviewer_id = null;
				foreach ($image as $field => $value) {
					$updateArray[$field] = $value;
				}

				$dbm->update(
					'city_visualization_images',
					$updateArray,
					array(
						'city_id' => $image->city_id,
						'page_id' => $image->page_id,
						'city_lang_code' => $image->city_lang_code,
					)
				);
			}
			$dbm->commit(__METHOD__);
		}
	}

	public function deleteImagesFromReview($cityId, $langCode, $corporateWikis) {
		$imagesToRemove = array();

		foreach( $corporateWikis as $corporateWikiWikis ) {
			foreach( $corporateWikiWikis as $wiki ) {
				foreach( $wiki as $image ) {
					$title = F::build('Title', array($image['name'], NS_FILE), 'newFromText');

					$imageData = new stdClass();
					$imageData->city_id = $cityId;
					$imageData->page_id = $title->getArticleId();
					$imageData->city_lang_code = $langCode;
					$imagesToRemove[] = $imageData;
				}
			}
		}

		if( !empty($imagesToRemove) ) {
			$dbm = $this->wf->GetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);
			$dbm->begin(__METHOD__);

			foreach ($imagesToRemove as $image) {
				$removeConds = array();

				foreach ($image as $field => $value) {
					$removeConds[$field] = $value;
				}

				$dbm->delete(
					'city_visualization_images',
					$removeConds
				);
			}

			$dbm->commit(__METHOD__);
		}
	}

	public function removeImageFromReview($cityId, $pageId, $langCode) {
		$dbm = $this->wf->GetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);
		$dbm->delete(
			'city_visualization_images',
			array(
				'city_id' => $cityId,
				'page_id' => $pageId,
				'city_lang_code' => $langCode
			)
		);
	}

	protected function getImagesFromReviewTable($cityId, $langCode) {
		$this->wf->ProfileIn(__METHOD__);

		$wikiImages = array();
		$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$result = $db->select(
			array('city_visualization_images'),
			array('*'),
			array(
				'city_id' => $cityId,
				'city_lang_code' => $langCode
			),
			__METHOD__
		);

		while ($row = $result->fetchObject()) {
			$wikiImages [] = $row;
		}

		$this->wf->ProfileOut(__METHOD__);

		return $wikiImages;
	}

	public function getImageReviewStatus($wikiId, $pageId, WikiImageRowAssigner $rowAssigner) {
		$this->wf->ProfileIn(__METHOD__);
		$reviewStatus = ImageReviewStatuses::STATE_UNREVIEWED;

		$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
		$conditions['city_id'] = $wikiId;
		$conditions['page_id'] = $pageId;

		$result = $db->select(
			array('city_visualization_images'),
			array(
				'image_review_status',
			),
			$conditions,
			__METHOD__
		);

		while ($row = $result->fetchObject()) {
			$reviewStatus = $rowAssigner->returnParsedWikiImageRow($row);
		}

		$this->wf->ProfileOut(__METHOD__);
		return $reviewStatus;
	}

	public static function isNewWiki($wikiFlags) {
		return (($wikiFlags & self::FLAG_NEW) == self::FLAG_NEW);
	}

	public static function isHotWiki($wikiFlags) {
		return (($wikiFlags & self::FLAG_HOT) == self::FLAG_HOT);
	}

	public static function isPromotedWiki($wikiFlags) {
		return (($wikiFlags & self::FLAG_PROMOTED) == self::FLAG_PROMOTED);
	}

	public static function isBlockedWiki($wikiFlags) {
		return (($wikiFlags & self::FLAG_BLOCKED) == self::FLAG_BLOCKED);
	}
}
