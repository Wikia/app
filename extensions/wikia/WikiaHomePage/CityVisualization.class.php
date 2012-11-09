<?php
/**
 * City Visualization model for Wikia.com homepage grid
 *
 * @todo refactor, the queries should be part of /includes/wikia/models/WikisModel.class.php
 */
class CityVisualization extends WikiaModel {
	//todo: think of better solution (WikiFactory variable?)
	const GERMAN_CORPORATE_SITE_ID = 111264;
	const ENGLISH_CORPORATE_SITE_ID = 80433;
	const WIKIA_HOME_PAGE_WF_VAR_NAME = 'wgEnableWikiaHomePageExt';

	const CITY_VISUALIZATION_MEMC_VERSION = 'v0.77';
	const WIKI_STANDARD_BATCH_SIZE_MULTIPLIER = 100;

	const PROMOTED_SLOTS = 3;
	const PROMOTED_ARRAY_KEY = 'promoted';
	const DEMOTED_ARRAY_KEY = 'demoted';

	protected $verticalMap = array(
		WikiFactoryHub::CATEGORY_ID_LIFESTYLE => 'lifestyle',
		WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => 'entertainment',
		WikiFactoryHub::CATEGORY_ID_GAMING => 'video games'
	);

	protected $verticalSlotsMap = array(
		WikiFactoryHub::CATEGORY_ID_LIFESTYLE => WikiaHomePageHelper::LIFESTYLE_SLOTS_VAR_NAME,
		WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => WikiaHomePageHelper::ENTERTAINMENT_SLOTS_VAR_NAME,
		WikiFactoryHub::CATEGORY_ID_GAMING => WikiaHomePageHelper::VIDEO_GAMES_SLOTS_VAR_NAME
	);

	protected $batches;

	//todo: increase readability
	//todo: decouple functions possibly extract classes
	//todo: decrease number of parameters in all functions in this file
	public function getList($corpWikiId, $contLang, $dontReadMemc = false) {
		$this->wf->ProfileIn(__METHOD__);
		$memKey = $this->getVisualizationWikisListDataCacheKey($corpWikiId, $contLang);
		$wikis = (!$dontReadMemc) ? $this->wg->Memc->get($memKey) : null;

		if (!$wikis) {
			$promotedWikis = array();

			foreach ($this->verticalMap as $verticalId => $verticalTag) {
				$verticalMemKey = $this->getVisualizationVerticalWikisListDataCacheKey($verticalId, $corpWikiId, $contLang);

				$wikis[$verticalTag] = (!$dontReadMemc) ? $this->wg->Memc->get($verticalMemKey) : null;

				/* @var $helper WikiaHomePageHelper */
				$helper = F::build('WikiaHomePageHelper');
				$numberOfSlots = $helper->getVarFromWikiFactory($corpWikiId, $this->verticalSlotsMap[$verticalId]);

				if (!is_array($wikis[$verticalTag])) {
					$verticalWikis = $this->getWikiListForVertical($contLang, $verticalId);
					$promotedWikis = array_merge($promotedWikis, $verticalWikis[self::PROMOTED_ARRAY_KEY]);

					shuffle($verticalWikis[self::DEMOTED_ARRAY_KEY]);

					$wikis[$verticalTag] = array_slice($verticalWikis[self::DEMOTED_ARRAY_KEY], 0, $numberOfSlots * self::WIKI_STANDARD_BATCH_SIZE_MULTIPLIER);
					$this->wg->Memc->set($verticalMemKey, $wikis[$verticalTag], 1 * 24 * 60 * 60);
				}
			}

			$wikis[self::PROMOTED_ARRAY_KEY] = $promotedWikis;
			unset($promotedWikis);
		}
		$this->generateBatches($corpWikiId, $contLang, $wikis, $dontReadMemc);

		$this->wg->Memc->set($memKey, $wikis, 60 * 60 * 24);
		$this->wf->ProfileOut(__METHOD__);

		return $wikis;
	}

	public function regenerateBatches($corpWikiId, $contLang) {
		$this->getList($corpWikiId, $contLang, true);
	}

	public function getWikiBatches($corpWikiId, $contLang, $numberOfBatches) {
		$this->wf->ProfileIn(__METHOD__);

		$memKey = $this->getVisualizationBatchesCacheKey($corpWikiId, $contLang);

		$batches = $this->wg->Memc->get($memKey);

		if (!is_array($batches) || count($batches) < $numberOfBatches) {
			Wikia::log(__METHOD__, ' not enough batches ', count($batches) . '/' . $numberOfBatches);
			$this->regenerateBatches($corpWikiId, $contLang);
			$batches = $this->wg->Memc->get($memKey);
			Wikia::log(__METHOD__, ' not enough batches ', count($batches) . '/' . $numberOfBatches);
		}

		if (!empty($batches)) {
			$resultingBatches = array_splice($batches, 0, $numberOfBatches);
			$this->wg->Memc->set($memKey, $batches);
		} elseif(!empty($this->batches)) {
			$resultingBatches = array_splice($this->batches, 0, $numberOfBatches);
			Wikia::log(__METHOD__, ' splicing batches from internal cache ', count($resultingBatches) . '/' . $numberOfBatches);
		} else {
			$resultingBatches = array();
		}
		//complexity limited by maximum number of elements ( 5 in $resultingBatches, 2 in $resultingBatch, 17 in $batchPromotedDemoted )
		foreach($resultingBatches as &$resultingBatch) {
			foreach($resultingBatch as &$batchPromotedDemoted) {
				foreach($batchPromotedDemoted as &$batch) {
					$batch['wikiname'] = htmlspecialchars($batch['wikiname']);
					$batch['wikidesc'] = htmlspecialchars($batch['wikidesc']);
				}
			}
		}
		$this->wf->ProfileOut(__METHOD__);

		return $resultingBatches;
	}

	//todo: move to hook helper class
	public static function onWikiDataUpdated($cityId) {
		$app = F::app();

		$mdb = $app->wf->GetDB(DB_MASTER, array(), $app->wg->ExternalSharedDB);

		$category = HubService::getComscoreCategory($cityId);

		$table = 'city_visualization';
		$data = array(
			'city_vertical' => $category->cat_id
		);
		$cond = array(
			'city_id' => $cityId,
		);

		$mdb->update($table, $data, $cond, __METHOD__);

		return true;
	}

	/**
	 * @param $wikis array of verticals => array of wikis
	 * @desc Generates batches for visualization
	 */
	public function generateBatches($corpWikiId, $contLang, $wikis, $dontReadMemc = false) {
		$this->wf->ProfileIn(__METHOD__);

		$reverseMap = array_flip($this->verticalMap);
		$helper = F::build('WikiaHomePageHelper'); /* @var $helper WikiaHomePageHelper */
		$memKey = $this->getVisualizationBatchesCacheKey($corpWikiId, $contLang);
		$batches = (!$dontReadMemc) ? $this->wg->Memc->get($memKey) : null;

		if (!is_array($batches)) {
			$batches = array();

			$offsets = array(
				'lifestyle' => 0,
				'entertainment' => 0,
				'video games' => 0,
				self::PROMOTED_ARRAY_KEY => 0
			);

			if( isset($wikis[self::PROMOTED_ARRAY_KEY]) ) {
				$promotedWikis = $wikis[self::PROMOTED_ARRAY_KEY];
			} else {
				//just to not flood logs with php notices once a failover has been fired
				$promotedWikis = array();
			}

			$batchPromotedOffset = 0;
			shuffle($promotedWikis);
			$verticalsCount = count($this->verticalMap);
			unset($wikis[self::PROMOTED_ARRAY_KEY]);

			for( $i = 0; $i < self::WIKI_STANDARD_BATCH_SIZE_MULTIPLIER; $i++ ) {
				$batch = array();

				$batchPromotedWikis = array_slice($promotedWikis, $batchPromotedOffset * self::PROMOTED_SLOTS, self::PROMOTED_SLOTS);
				$removePerVertical = floor( count($batchPromotedWikis) / $verticalsCount );

				if( ($batchPromotedOffset + 1) * self::PROMOTED_SLOTS >= count($promotedWikis) ) {
					$batchPromotedOffset = 0;
				} else {
					$batchPromotedOffset++;
				}

				foreach ($wikis as $verticalName => &$wikilist) {
					$verticalId = $reverseMap[$verticalName];

					$numberOfSlotsForVertical = $helper->getVarFromWikiFactory($corpWikiId, $this->verticalSlotsMap[$verticalId]);
					$batchWikis = array_slice($wikilist, $offsets[$verticalName] * $numberOfSlotsForVertical, ($numberOfSlotsForVertical - $removePerVertical) );

					$offsets[$verticalName]++;
					if( ($offsets[$verticalName] + 1) * $numberOfSlotsForVertical > count($wikilist) ) {
						Wikia::log(__METHOD__, ' offset zeroing ', 'zeroing ' . $verticalName . ' offset from ' . $offsets[$verticalName]);
						$offsets[$verticalName] = 0;
					}

					$batch = array_merge($batch, $batchWikis);
				}

				$batches[] = array(
					self::PROMOTED_ARRAY_KEY => $batchPromotedWikis,
					self::DEMOTED_ARRAY_KEY => $batch,
				);
			}
			$this->wg->Memc->set($memKey, $batches);
		}

		$this->batches = $batches;
		$this->wf->ProfileOut(__METHOD__);
		return $batches;
	}

	protected function getWikiListForVertical($contLang, $verticalId) {
		$this->wf->ProfileIn(__METHOD__);

		$verticalWikis = array(
			self::PROMOTED_ARRAY_KEY => array(),
			self::DEMOTED_ARRAY_KEY => array(),
		);

		$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
		$tables = array('city_visualization', 'city_list');
		$fields = array(
			'city_visualization.city_id',
			'city_visualization.city_vertical',
			'city_visualization.city_main_image',
			'city_visualization.city_description',
			'city_visualization.city_headline',
			'city_list.city_title',
			'city_list.city_url',
			'city_visualization.city_flags',
		);
		$conds = array(
			'city_list.city_public' => 1,
			'city_visualization.city_main_image is not null',
			'city_visualization.city_lang_code' => $contLang,
			'city_visualization.city_vertical' => $verticalId,
			'(city_visualization.city_flags & ' . WikisModel::FLAG_BLOCKED . ') != ' . WikisModel::FLAG_BLOCKED,
		);
		$joinConds = array(
			'city_list' => array(
				'join',
				'city_visualization.city_id = city_list.city_id'
			),
		);

		$results = $db->select($tables, $fields, $conds, __METHOD__, array(), $joinConds);

		while( $row = $db->fetchObject($results) ) {
			$isPromoted = $this->isPromotedWiki($row->city_flags);
			$isBlocked = $this->isBlockedWiki($row->city_flags);

			$wikiData = array(
				'wikiid' => $row->city_id,
				'wikiname' => $row->city_title,
				'wikiheadline' => $row->city_headline,
				'wikiurl' => $row->city_url . '?redirect=no',
				'wikidesc' => $row->city_description,
				'main_image' => $row->city_main_image,
				'wikinew' => $this->isNewWiki($row->city_flags),
				'wikihot' => $this->isHotWiki($row->city_flags),
				'wikiofficial' => $this->isOfficialWiki($row->city_flags),
				'wikipromoted' => $isPromoted,
				'wikiblocked' => $isBlocked,
			);

			if( !$isBlocked && !$isPromoted ) {
				$verticalWikis[self::DEMOTED_ARRAY_KEY][] = $wikiData;
			} else if( $isPromoted && !$isBlocked ) {
				$verticalWikis[self::PROMOTED_ARRAY_KEY][] = $wikiData;
			}
		}

		$this->wf->ProfileOut(__METHOD__);
		return $verticalWikis;
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

		if ($row) {
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
			wfRunHooks('CityVisualization::wikiDataInserted', array($wikiId));
		}
		$mdb->commit();
	}


	public function setFlag($wikiId, $langCode, $flag) {
		$this->wf->ProfileIn(__METHOD__);
		$mdb = $this->wf->GetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

		$sql = 'update city_visualization set city_flags = (city_flags | ' . $flag . ') where city_id = ' . $wikiId . ' and city_lang_code = "' . $langCode . '"';

		$result = $mdb->query($sql);
		$mdb->commit(__METHOD__);

		$this->wf->ProfileOut(__METHOD__);
		return $result;
	}

	public function removeFlag($wikiId, $langCode, $flag) {
		$this->wf->ProfileIn(__METHOD__);
		$mdb = $this->wf->GetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

		$sql = 'update city_visualization set city_flags = (city_flags & ~' . $flag . ') where city_id = ' . $wikiId. ' and city_lang_code = "' . $langCode . '"';;

		$result = $mdb->query($sql);
		$mdb->commit(__METHOD__);

		$this->wf->ProfileOut(__METHOD__);
		return $result;
	}

	/**
	 * @desc Mapping integer id of a comscore vertical to one of the main names recognized by visualization
	 * @param integer $verticalId tag id from HubService
	 * @return string | bool returns false if the tag id doesn't match one of the main tags
	 */
	private function getVerticalNameId($tagId) {
		if (isset($this->verticalMap[$tagId])) {
			return $this->verticalMap[$tagId];
		}

		return false;
	}

	/**
	 * @desc Returns an array of comscore ids of verticals
	 *
	 * @return array
	 */
	public function getVerticalsIds() {
		return array_keys($this->verticalMap);
	}

	public function purgeVisualizationWikisListCache($corpWikiId, $langCode) {
		$memcKey = $this->getVisualizationBatchesCacheKey($corpWikiId, $langCode);
		$this->wg->Memc->set($memcKey, null);
	}

	public function purgeWikiPromoteDataCache($wikiId, $langCode) {
		$memcKey = $this->getWikiPromoteDataCacheKey($wikiId, $langCode);
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
		return $this->wf->SharedMemcKey('wikis_data_for_visualization', self::CITY_VISUALIZATION_MEMC_VERSION, $corporateWikiId, $langCode, __METHOD__);
	}

	public function getVisualizationBatchesCacheKey($corporateWikiId, $langCode) {
		return $this->wf->SharedMemcKey('wikis_batches_for_visualization', self::CITY_VISUALIZATION_MEMC_VERSION, $corporateWikiId, $langCode, __METHOD__);
	}

	public function getVisualizationVerticalWikisListDataCacheKey($verticalId, $corporateWikiId, $langCode) {
		return $this->wf->SharedMemcKey('wikis_data_for_visualization_vertical', self::CITY_VISUALIZATION_MEMC_VERSION, $verticalId, $corporateWikiId, $langCode, __METHOD__);
	}

	public function getWikiPromoteDataCacheKey($wikiId, $langCode) {
		return $this->getVisualizationElementMemcKey('wiki_data_special_promote', $wikiId, $langCode);
	}

	public function getSingleVerticalWikiDataCacheKey($wikiId, $langCode) {
		return $this->wf->SharedMemcKey('wikis_data_visualization_tagged', self::CITY_VISUALIZATION_MEMC_VERSION, $wikiId, $langCode, __METHOD__);
	}

	public function getWikiDataCacheKey($corporateWikiId, $wikiId, $langCode) {
		return $this->wf->SharedMemcKey('single_wiki_data_visualization', self::CITY_VISUALIZATION_MEMC_VERSION, $corporateWikiId, $wikiId, $langCode, __METHOD__);
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
				array('city_visualization','city_list'),
				array(
					'city_title',
					'city_visualization.city_headline',
					'city_visualization.city_description',
					'city_visualization.city_main_image',
					'city_visualization.city_flags',
					'city_visualization.city_images',
				),
				array(
					'city_visualization.city_id' => $wikiId,
					'city_visualization.city_lang_code' => $langCode
				),
				__METHOD__,
				array(),
				array(
					'city_list' => array(
						'join',
						'city_visualization.city_id = city_list.city_id'
					)
				)
			);

			if ($row) {
				$wikiData['name'] = $row->city_title;
				$wikiData['headline'] = $row->city_headline;
				$wikiData['description'] = $row->city_description;
				$wikiData['flags'] = $row->city_flags;
				$wikiData['images'] = $dataHelper->getImages($wikiId, $langCode, $row);
				$wikiData['main_image'] = $dataHelper->getMainImage($wikiId, $langCode, $row, $wikiData);
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
			if (preg_match('/Wikia-Visualization-Add-([0-9])\.png/', $image, $matches)) {
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

		foreach ($corporateWikis as $corporateWikiWikis) {
			foreach ($corporateWikiWikis as $wiki) {
				foreach ($wiki as $image) {
					$title = F::build('Title', array($image['name'], NS_FILE), 'newFromText');

					$imageData = new stdClass();
					$imageData->city_id = $cityId;
					$imageData->page_id = $title->getArticleId();
					$imageData->city_lang_code = $langCode;
					$imagesToRemove[] = $imageData;
				}
			}
		}

		if (!empty($imagesToRemove)) {
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
		return (($wikiFlags & WikisModel::FLAG_NEW) == WikisModel::FLAG_NEW);
	}

	public static function isHotWiki($wikiFlags) {
		return (($wikiFlags & WikisModel::FLAG_HOT) == WikisModel::FLAG_HOT);
	}

	public static function isOfficialWiki($wikiFlags) {
		return (($wikiFlags & WikisModel::FLAG_OFFICIAL) == WikisModel::FLAG_OFFICIAL);
	}

	public static function isPromotedWiki($wikiFlags) {
		return (($wikiFlags & WikisModel::FLAG_PROMOTED) == WikisModel::FLAG_PROMOTED);
	}

	public static function isBlockedWiki($wikiFlags) {
		return (($wikiFlags & WikisModel::FLAG_BLOCKED) == WikisModel::FLAG_BLOCKED);
	}

	public function getTargetWikiId($langCode) {
		switch ($langCode) {
			case 'de':
				$wikiId = self::GERMAN_CORPORATE_SITE_ID;
				break;

			case 'en':
			default:
				$wikiId = self::ENGLISH_CORPORATE_SITE_ID;
		}
		return $wikiId;
	}

	/**
	 * @desc Returns an array of wikis with visualization
	 * @return array
	 */
	public function getVisualizationWikisData() {
		$corporateSites = WikiaDataAccess::cache(
			$this->getCorporatePagesListKey(),
			24 * 60 * 60,
			array($this, 'loadCorporateSitesList')
		);
		$this->addLangToCorporateSites($corporateSites);
		return $this->cleanVisualizationWikisArray($corporateSites);
	}

	/**
	 * @desc Loads list of corporate sites (sites which have $wgEnableWikiaHomePageExt WF variable set to true)
	 * @return array
	 */
	public function loadCorporateSitesList() {
		$wikiFactoryList = array();
		$wikiFactoryVarId = WikiFactory::getVarIdByName(self::WIKIA_HOME_PAGE_WF_VAR_NAME);

		if( is_int($wikiFactoryVarId) ) {
			$wikiFactoryList = WikiFactory::getListOfWikisWithVar($wikiFactoryVarId, 'bool', '=', true);
		}

		return $wikiFactoryList;
	}

	/**
	 * @param Array $sites reference to an array with lists from WikiFactory::getListOfWikisWithVar()
	 */
	protected function addLangToCorporateSites(&$sites) {
		foreach($sites as $wikiId => $wiki) {
			$lang = WikiFactory::getVarByName('wgLanguageCode', $wikiId);
			$lang = unserialize($lang->cv_value);

			if( !empty($lang) ) {
				$sites[$wikiId]['lang'] = $lang;
			}
		}
	}

	/**
	 * @param Array $sites lists of wikis from WikiFactory::getListOfWikisWithVar()
	 * @return array
	 */
	protected function cleanVisualizationWikisArray($sites) {
		$results = array();

		foreach($sites as $wikiId => $wiki) {
			$lang = $wiki['lang'];
			$results[$lang] = array(
				'wikiId' => $wikiId,
				'wikiTitle' => $wiki['t'],
				'url' => $wiki['u'],
				'lang' => $lang
			);
		}

		return $results;
	}

	public function getCorporatePagesListKey() {
		return $this->wf->MemcKey('corporate_pages_list', 'v1.03', __METHOD__);
	}

	public function getWikisCountForStaffTool($opt) {
	//todo: reuse getWikisForStaffTool
		$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
		$table = array('city_visualization','city_list');
		$fields = array('count( city_visualization.city_id ) as count');
		$conds = $this->getConditionsForStaffTool($opt);
		$options = $this->getOptionsForStaffTool($opt);
		$joinConds = array(
			'city_list' => array(
				'join',
				'city_list.city_id = city_visualization.city_id'
			)
		);
		$results = $db->select($table, $fields, $conds, __METHOD__, $options, $joinConds);
		$row = $results->fetchRow();

		return isset($row['count']) ? $row['count'] : 0;
	}

	public function getWikisForStaffTool($opt) {
	//todo: implement memc and purge it once admin changes data or main image is approved
	//todo: add sql join and instead of headline provide wiki name
		$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
		$table = array('city_visualization','city_list');
		$fields = array(
			'city_visualization.city_id',
			'city_visualization.city_vertical',
			'city_list.city_title',
			'city_visualization.city_flags',
		);
		$conds = $this->getConditionsForStaffTool($opt);
		$options = $this->getOptionsForStaffTool($opt);
		$joinConds = array(
			'city_list' => array(
				'join',
				'city_list.city_id = city_visualization.city_id'
			)
		);

		$results = $db->select($table, $fields, $conds, __METHOD__, $options, $joinConds);
		$wikis = array();
		while( $row = $db->fetchObject($results) ) {
			$category = HubService::getComscoreCategory($row->city_id);
			$row->city_vertical = $category->cat_name;
			$wikis[] = $row;
		}

		return $wikis;
	}

	protected function getConditionsForStaffTool($options) {
		$sqlOptions = array();

		if( isset($options->lang) ) {
			$sqlOptions['city_visualization.city_lang_code'] = $options->lang;
		}

		if( !empty($options->wikiHeadline) ) {
			$sqlOptions[] = 'city_list.city_title like "%' . mysql_real_escape_string($options->wikiHeadline) . '%"';
		}

		return $sqlOptions;
	}

	protected function getOptionsForStaffTool($options) {
		$sqlOptions = array();

		if( isset($options->offset) ) {
			$sqlOptions['OFFSET'] = $options->offset;
		}

		if( isset($options->limit) ) {
			$sqlOptions['LIMIT'] = $options->limit;
		}

		return $sqlOptions;
	}

}
