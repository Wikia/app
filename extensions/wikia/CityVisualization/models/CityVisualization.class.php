<?php
/**
 * City Visualization model for Wikia.com homepage grid
 *
 * @todo refactor, the queries should be part of /includes/wikia/models/WikisModel.class.php
 */
class CityVisualization extends WikiaModel {
	const CITY_VISUALIZATION_MEMC_VERSION = 'v0.79';
	const CITY_VISUALIZATION_CORPORATE_PAGE_LIST_MEMC_VERSION = 'v1.08';
	const WIKI_STANDARD_BATCH_SIZE_MULTIPLIER = 100;

	const CITY_VISUALIZATION_TABLE_NAME = 'city_visualization';
	const CITY_VISUALIZATION_IMAGES_TABLE_NAME = 'city_visualization_images';

	const PROMOTED_SLOTS = 3;
	const PROMOTED_ARRAY_KEY = 'promoted';
	const DEMOTED_ARRAY_KEY = 'demoted';

	/**
	 * @const String name of variable in city_variables table which enables WikiaHomePage extension
	 */
	const WIKIA_HOME_PAGE_WF_VAR_NAME = 'wgEnableWikiaHomePageExt';
	static $wikiFactoryVarId = null;

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

	/**
	 * @var WikiaHomePageHelper
	 */
	private $helper = null;

	//todo: increase readability
	//todo: decouple functions possibly extract classes
	//todo: decrease number of parameters in all functions in this file
	public function getList($corpWikiId, $contLang, $dontReadMemc = false) {
		wfProfileIn(__METHOD__);
		$memKey = $this->getVisualizationWikisListDataCacheKey($corpWikiId, $contLang);
		$wikis = (!$dontReadMemc) ? $this->wg->Memc->get($memKey) : null;
		
		if (!$wikis) {
			$promotedWikis = array();

			foreach( $this->getVerticalMap() as $verticalId => $verticalTag ) {
				$verticalMemKey = $this->getVisualizationVerticalWikisListDataCacheKey($verticalId, $corpWikiId, $contLang);

				$wikis[$verticalTag] = (!$dontReadMemc) ? $this->wg->Memc->get($verticalMemKey) : null;
				$numberOfSlots = $this->getSlotsNoPerVertical($corpWikiId, $verticalId);
				$wikiListConditioner = new WikiListConditionerForVertical($contLang, $verticalId);
				
				if (!is_array($wikis[$verticalTag])) {
					$verticalWikis = $this->getWikisList($wikiListConditioner);
					$promotedWikis = array_merge($promotedWikis, $verticalWikis[self::PROMOTED_ARRAY_KEY]);

					shuffle($verticalWikis[self::DEMOTED_ARRAY_KEY]);

					$wikis[$verticalTag] = array_slice($verticalWikis[self::DEMOTED_ARRAY_KEY], 0, $numberOfSlots * self::WIKI_STANDARD_BATCH_SIZE_MULTIPLIER);
					$this->wg->Memc->set($verticalMemKey, $wikis[$verticalTag], 1 * 24 * 60 * 60);
				}
			}

			$wikis[self::PROMOTED_ARRAY_KEY] = $promotedWikis;
			unset($promotedWikis);
		}

		$this->wg->Memc->set($memKey, $wikis, 60 * 60 * 24);
		wfProfileOut(__METHOD__);

		return $wikis;
	}

	public function getWikiBatchesFromDb($corpWikiId, $contLang) {
		wfProfileIn(__METHOD__);
		$wikis = $this->getList($corpWikiId, $contLang);
		$batches = $this->generateBatches($corpWikiId, $wikis);
		wfProfileOut(__METHOD__);
		return $batches;
	}

	public function getWikiBatches($corpWikiId, $contLang, $numberOfBatches) {
		wfProfileIn(__METHOD__);

		$memKey = $this->getVisualizationBatchesCacheKey($corpWikiId, $contLang);
		$batches = $this->wg->Memc->get($memKey);

		if (!is_array($batches) || count($batches) < $numberOfBatches) {
			Wikia::log(__METHOD__, ' not enough batches ', count($batches) . '/' . $numberOfBatches);
			$batches = $this->getWikiBatchesFromDb($corpWikiId, $contLang);
		}

		if (!empty($batches)) {
			$resultingBatches = array_splice($batches, 0, $numberOfBatches);
			$this->wg->Memc->set($memKey, $batches);
		} else {
			$resultingBatches = array();
		}
		//complexity limited by maximum number of elements ( 5 in $resultingBatches, 2 in $resultingBatch, 17 in $batchPromotedDemoted )
		foreach($resultingBatches as &$resultingBatch) {
			foreach($resultingBatch as &$batchPromotedDemoted) {
				foreach($batchPromotedDemoted as &$batch) {
					$batch['wikiname'] = htmlspecialchars($batch['wikiname']);
				}
			}
		}
		
		wfProfileOut(__METHOD__);
		return $resultingBatches;
	}

	//todo: move to hook helper class
	public static function onWikiDataUpdated($cityId) {
		$app = F::app();

		$mdb = wfGetDB(DB_MASTER, array(), $app->wg->ExternalSharedDB);

		$category = HubService::getComscoreCategory($cityId);

		$table = self::CITY_VISUALIZATION_TABLE_NAME;
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
	 * Generate batches from wikilist returned by getWikiList
	 *
	 * @param $corpWikiId int corp wiki Id
	 * @param $wikis array of verticals => array of wikis
	 *
	 * @return array
	 */
	public function generateBatches($corpWikiId, $wikis) {
		wfProfileIn(__METHOD__);

		$verticalMap = $this->getVerticalMap();

		$batches = array();

		$offsets = array(
			'lifestyle' => 0,
			'entertainment' => 0,
			'video games' => 0,
			self::PROMOTED_ARRAY_KEY => 0
		);

		if( isset($wikis[self::PROMOTED_ARRAY_KEY]) ) {
			$promotedWikis = $wikis[self::PROMOTED_ARRAY_KEY];
			unset($wikis[self::PROMOTED_ARRAY_KEY]);
		} else {
			//just to not flood logs with php notices once a failover has been fired
			$promotedWikis = array();
		}

		shuffle($promotedWikis);
		$promotedWikisCount = count($promotedWikis);
		$verticalsCount = count($verticalMap);
		$verticalSlots = $this->getSlotsForVerticals($corpWikiId);

		$wikisCounts = [];
		foreach($verticalMap as $verticalName) {
			$wikisCounts[$verticalName] = count($wikis[$verticalName]);
		}

		for( $i = 0; $i < self::WIKI_STANDARD_BATCH_SIZE_MULTIPLIER; $i++ ) {
			$batch = array();

			$batchPromotedWikis = array_slice($promotedWikis, $offsets[self::PROMOTED_ARRAY_KEY] * self::PROMOTED_SLOTS, self::PROMOTED_SLOTS);
			$batchPromotedWikisCount = count($batchPromotedWikis);

			$tmpVerticalSlots = $this->freeSlotsForPromotedWikis($batchPromotedWikisCount, $verticalSlots);

			if( ($offsets[self::PROMOTED_ARRAY_KEY] + 1) * self::PROMOTED_SLOTS >= $promotedWikisCount ) {
				$offsets[self::PROMOTED_ARRAY_KEY] = 0;
			} else {
				$offsets[self::PROMOTED_ARRAY_KEY]++;
			}

			foreach ($wikis as $verticalName => &$wikilist) {
				if (isset($tmpVerticalSlots[$verticalName])) {
					$batchWikis = array_slice(
						$wikilist,
						$offsets[$verticalName] * $verticalSlots[$verticalName],
						$tmpVerticalSlots[$verticalName]
					);

					$offsets[$verticalName]++;
					if( ($offsets[$verticalName] + 1) * $verticalSlots[$verticalName] > $wikisCounts[$verticalName] ) {
						Wikia::log(__METHOD__, ' offset zeroing ', 'zeroing ' . $verticalName . ' offset from ' . $offsets[$verticalName]);
						$offsets[$verticalName] = 0;
					}

					$batch = array_merge($batch, $batchWikis);
				}
			}

			$batches[] = array(
				self::PROMOTED_ARRAY_KEY => $batchPromotedWikis,
				self::DEMOTED_ARRAY_KEY => $batch,
			);
		}
		
		wfProfileOut(__METHOD__);
		return $batches;
	}

	private function freeSlotsForPromotedWikis($promotedWikisCount, $verticalSlots) {
		// decrease all verticals if promoted wikis number is greater that verticals
		while ($promotedWikisCount >= count($verticalSlots)) {
			foreach($verticalSlots as $verticalName => &$verticalCount) {
				if ($verticalCount > 0) {
					$verticalCount--;
					$promotedWikisCount--;
				}
				if ($verticalCount <= 0) {
					unset($verticalSlots[$verticalName]);
				}
			}
		}
		// decrease random vertical when promoted wikis count is less than verticals
		while ($promotedWikisCount > 0) {
			$verticalsForDecrease = array_rand($verticalSlots, min($promotedWikisCount, count($verticalSlots)));
			if (!is_array($verticalsForDecrease)) {
				$verticalsForDecrease = [$verticalsForDecrease];
			}
			foreach($verticalsForDecrease as $verticalForDecrease) {
				if ($verticalSlots[$verticalForDecrease] > 0) {
					$verticalSlots[$verticalForDecrease]--;
					$promotedWikisCount--;
				}
				if ($verticalSlots[$verticalForDecrease] <= 0) {
					unset($verticalSlots[$verticalForDecrease]);
				}
			}
		}

		return $verticalSlots;
	}

	protected function getWikisList(WikiListConditioner $conditioner) {
		wfProfileIn(__METHOD__);

		$verticalWikis = array(
			self::PROMOTED_ARRAY_KEY => array(),
			self::DEMOTED_ARRAY_KEY => array(),
		);

		$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
		$tables = [self::CITY_VISUALIZATION_TABLE_NAME, 'city_list'];
		$fields = [
			self::CITY_VISUALIZATION_TABLE_NAME . '.city_id',
			self::CITY_VISUALIZATION_TABLE_NAME . '.city_main_image',
			'city_list.city_title',
			'city_list.city_url',
			self::CITY_VISUALIZATION_TABLE_NAME . '.city_flags',
		];
		$joinConds = [
			'city_list' => [
				'join',
				self::CITY_VISUALIZATION_TABLE_NAME . '.city_id = city_list.city_id'
			],
		];
		$conds = $conditioner->getCondition();

		$results = $db->select($tables, $fields, $conds, __METHOD__, array(), $joinConds);

		while( $row = $db->fetchObject($results) ) {
			$wikiData = $this->makeVisualizationWikiData($row);
			$isPromoted = $wikiData['wikipromoted'];

			if ( $conditioner->getPromotionCondition( $isPromoted ) ) {
				$verticalWikis[self::PROMOTED_ARRAY_KEY][] = $wikiData;
			} else {
				$verticalWikis[self::DEMOTED_ARRAY_KEY][] = $wikiData;
			}
		}

		wfProfileOut(__METHOD__);
		return $verticalWikis;
	}
	
	private function makeVisualizationWikiData($row) {
		return [
			'wikiid' => $row->city_id,
			'wikiname' => $row->city_title,
			'wikiurl' => $row->city_url,
			'main_image' => $row->city_main_image,
			'wikinew' => $this->isNewWiki($row->city_flags),
			'wikihot' => $this->isHotWiki($row->city_flags),
			'wikiofficial' => $this->isOfficialWiki($row->city_flags),
			'wikipromoted' => $this->isPromotedWiki($row->city_flags),
		];
	}

	public function saveVisualizationData($wikiId, $data, $langCode) {
		$sdb = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
		$mdb = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

		$table = self::CITY_VISUALIZATION_TABLE_NAME;
		$fields = array(self::CITY_VISUALIZATION_TABLE_NAME . '.city_id', 'city_flags');
		$conds = array(
			self::CITY_VISUALIZATION_TABLE_NAME . '.city_id' => $wikiId,
			'city_lang_code' => $langCode
		);
		$results = $sdb->select(array($table), $fields, $conds, __METHOD__);

		$row = $sdb->fetchObject($results);

		if ($row) {
			//UPDATE
			$cond = array(
				'city_id' => $wikiId,
				'city_lang_code' => $langCode
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
		wfProfileIn(__METHOD__);
		$mdb = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

		$sql = 'update ' . self::CITY_VISUALIZATION_TABLE_NAME . ' set city_flags = (city_flags | ' . $flag . ') where city_id = ' . $wikiId . ' and city_lang_code = "' . $langCode . '"';

		$result = $mdb->query($sql);
		$mdb->commit(__METHOD__);

		wfProfileOut(__METHOD__);
		return $result;
	}

	public function getFlag($wikiId, $langCode) {
		wfProfileIn(__METHOD__);
		$sdb = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$conds = [
			'city_id' => $wikiId,
			'city_lang_code' => $langCode
		];

		$result = $sdb->select(self::CITY_VISUALIZATION_TABLE_NAME, 'city_flags', $conds);

		$row = $sdb->fetchRow($result);

		wfProfileOut(__METHOD__);
		return $row['city_flags'];
	}

	public function removeFlag($wikiId, $langCode, $flag) {
		wfProfileIn(__METHOD__);
		$mdb = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

		$sql = 'update ' . self::CITY_VISUALIZATION_TABLE_NAME . ' set city_flags = (city_flags & ~' . $flag . ') where city_id = ' . $wikiId. ' and city_lang_code = "' . $langCode . '"';;

		$result = $mdb->query($sql);
		$mdb->commit(__METHOD__);

		wfProfileOut(__METHOD__);
		return $result;
	}

	/**
	 * @desc Mapping integer id of a comscore vertical to one of the main names recognized by visualization
	 * @param integer $verticalId tag id from HubService
	 * @return string | bool returns false if the tag id doesn't match one of the main tags
	 */
	private function getVerticalNameId($tagId) {
		$verticalMap = $this->getVerticalMap();
		if (isset($verticalMap[$tagId])) {
			return $verticalMap[$tagId];
		}

		return false;
	}

	/**
	 * @desc Returns an array of comscore ids of verticals
	 *
	 * @return array
	 */
	public function getVerticalsIds() {
		return array_keys($this->getVerticalMap());
	}

	public function purgeVisualizationWikisListCache($corpWikiId, $langCode) {
		$memcKey = $this->getVisualizationBatchesCacheKey($corpWikiId, $langCode);
		$this->wg->Memc->delete($memcKey);
	}

	public function purgeWikiPromoteDataCache($wikiId, $langCode) {
		$memcKey = $this->getWikiPromoteDataCacheKey($wikiId, $langCode);
		$this->wg->Memc->delete($memcKey);
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
		return wfSharedMemcKey('wikis_data_for_visualization', self::CITY_VISUALIZATION_MEMC_VERSION, $corporateWikiId, $langCode, __METHOD__);
	}

	public function getVisualizationBatchesCacheKey($corporateWikiId, $langCode) {
		return wfSharedMemcKey('wikis_batches_for_visualization', self::CITY_VISUALIZATION_MEMC_VERSION, $corporateWikiId, $langCode, __METHOD__);
	}

	public function getVisualizationVerticalWikisListDataCacheKey($verticalId, $corporateWikiId, $langCode) {
		return wfSharedMemcKey('wikis_data_for_visualization_vertical', self::CITY_VISUALIZATION_MEMC_VERSION, $verticalId, $corporateWikiId, $langCode, __METHOD__);
	}

	public function getWikiPromoteDataCacheKey($wikiId, $langCode) {
		return $this->getVisualizationElementMemcKey('wiki_data_special_promote', $wikiId, $langCode);
	}

	public function getSingleVerticalWikiDataCacheKey($wikiId, $langCode) {
		return wfSharedMemcKey('wikis_data_visualization_tagged', self::CITY_VISUALIZATION_MEMC_VERSION, $wikiId, $langCode, __METHOD__);
	}

	public function getWikiDataCacheKey($corporateWikiId, $wikiId, $langCode) {
		return wfSharedMemcKey('single_wiki_data_visualization', self::CITY_VISUALIZATION_MEMC_VERSION, $corporateWikiId, $wikiId, $langCode, __METHOD__);
	}

	public function getWikiImagesCacheKey($wikiId, $langCode) {
		return $this->getVisualizationElementMemcKey('wiki_data_visualization_images', $wikiId, $langCode);
	}

	public function getWikiImageNamesCacheKey($wikiId, $langCode) {
		return $this->getVisualizationElementMemcKey('wiki_data_visualization_image_names', $wikiId, $langCode);
	}

	public function getVisualizationElementMemcKey($prefix, $wikiId, $langCode) {
		return wfMemcKey($prefix, self::CITY_VISUALIZATION_MEMC_VERSION, $wikiId, $langCode);
	}

	public function getCollectionCacheKey($collectionId) {
		return wfSharedMemcKey('single_collection_wikis_data', self::CITY_VISUALIZATION_MEMC_VERSION, $collectionId, __METHOD__);
	}

	/**
	 * Get wiki data for Special:Promote
	 * @param integer $wikiId
	 * @return array $wikiData
	 */
	public function getWikiDataForPromote($wikiId, $langCode) {
		$helper = new WikiGetDataForPromoteHelper();
		return $this->getWikiData($wikiId, $langCode, $helper);
	}

	/**
	 * Get wiki data for Wikia Visualization
	 * @param integer $wikiId
	 * @return array $wikiData
	 */
	public function getWikiDataForVisualization($wikiId, $langCode) {
		$helper = new WikiGetDataForVisualizationHelper();
		return $this->getWikiData($wikiId, $langCode, $helper);
	}

	/**
	 * Get wiki data for Wikia Visualization
	 * @param integer $wikiId
	 * @param integer $wikiId
	 * @return array $wikiData
	 */
	public function getWikiData($wikiId, $langCode, WikiGetDataHelper $dataHelper) {
		wfProfileIn(__METHOD__);

		$memcKey = $dataHelper->getMemcKey($wikiId, $langCode);
		$wikiData = $this->wg->Memc->get($memcKey);

		if (empty($wikiData)) {
			$wikiData = array();
			$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
			$row = $db->selectRow(
				array(self::CITY_VISUALIZATION_TABLE_NAME,'city_list'),
				array(
					'city_title',
					self::CITY_VISUALIZATION_TABLE_NAME . '.city_headline',
					self::CITY_VISUALIZATION_TABLE_NAME . '.city_description',
					self::CITY_VISUALIZATION_TABLE_NAME . '.city_main_image',
					self::CITY_VISUALIZATION_TABLE_NAME . '.city_flags',
					self::CITY_VISUALIZATION_TABLE_NAME . '.city_images',
				),
				array(
					self::CITY_VISUALIZATION_TABLE_NAME . '.city_id' => $wikiId,
					self::CITY_VISUALIZATION_TABLE_NAME . '.city_lang_code' => $langCode
				),
				__METHOD__,
				array(),
				array(
					'city_list' => array(
						'join',
						self::CITY_VISUALIZATION_TABLE_NAME . '.city_id = city_list.city_id'
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

		wfProfileOut(__METHOD__);

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
		wfProfileIn(__METHOD__);

		$memKey = $this->getWikiImagesCacheKey($wikiId, $langCode);
		$wikiImages = $this->wg->Memc->get($memKey);

		if (empty($wikiImages)) {
			$rowAssigner = new WikiImageRowHelper();
			$wikiImages = $this->getWikiImageData($wikiId, $langCode, $rowAssigner, $filter);
			$this->wg->Memc->set($memKey, $wikiImages, 60 * 60 * 24);
		}
		wfProfileOut(__METHOD__);

		return $wikiImages;
	}

	public function getWikiImageNames($wikiId, $langCode, $filter = ImageReviewStatuses::STATE_APPROVED) {
		wfProfileIn(__METHOD__);

		$memKey = $this->getWikiImageNamesCacheKey($wikiId, $langCode);
		$wikiImageNames = $this->wg->Memc->get($memKey);

		if (empty($wikiImageNames)) {
			$rowAssigner = new WikiImageNameRowHelper();
			$wikiImageNames = $this->getWikiImageData($wikiId, $langCode, $rowAssigner, $filter);
			$this->wg->Memc->set($memKey, $wikiImageNames, 60 * 60 * 24);
		}
		wfProfileOut(__METHOD__);

		return $wikiImageNames;
	}

	public function getWikiImageData($wikiId, $langCode, WikiImageRowAssigner $rowAssigner, $filter = ImageReviewStatuses::STATE_APPROVED) {
		wfProfileIn(__METHOD__);

		$wikiImages = array();
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$conditions = $this->getWikiImagesConditions($wikiId, $langCode, $filter);

		$result = $db->select(
			array(self::CITY_VISUALIZATION_IMAGES_TABLE_NAME),
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

		wfProfileOut(__METHOD__);

		return $wikiImages;
	}

	public function saveImagesForReview($cityId, $langCode, $images, $imageReviewStatus = ImageReviewStatuses::STATE_UNREVIEWED) {
		$currentImages = $this->getImagesFromReviewTable($cityId, $langCode);

		$reversedImages = array_flip($images);
		$imagesToModify = array();

		foreach ($currentImages as $image) {
			if (isset($reversedImages[$image->image_name])) {
				$image->last_edited = date('Y-m-d H:i:s');
				$image->image_review_status = $imageReviewStatus;
				$imagesToModify[] = $image;
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

			$title = Title::newFromText($image, NS_FILE);

			$imageData->city_id = $cityId;
			$imageData->page_id = $title->getArticleId();
			$imageData->city_lang_code = $langCode;
			$imageData->image_index = $imageIndex;
			$imageData->image_name = $image;
			$imageData->image_review_status = $imageReviewStatus;
			$imageData->last_edited = date('Y-m-d H:i:s');
			$imageData->review_start = null;
			$imageData->review_end = null;
			$imageData->reviewer_id = null;

			$imagesToAdd [] = $imageData;
		}

		if (!empty($imagesToAdd) || !empty($imagesToModify)) {
			$dbm = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);
			$dbm->begin(__METHOD__);
			foreach ($imagesToAdd as $image) {
				$insertArray = array();

				foreach ($image as $field => $value) {
					$insertArray[$field] = $value;
				}

				$dbm->insert(
					self::CITY_VISUALIZATION_IMAGES_TABLE_NAME,
					$insertArray
				);
			}

			foreach ($imagesToModify as $image) {
				$updateArray = array();

				$image->reviewer_id = null;
				$image->review_start = null;
				$image->review_end = null;

				$oldPageId = $image->page_id;

				$title = Title::newFromText($image->image_name, NS_FILE);
				if($title instanceof Title) {
					$image->page_id = $title->getArticleId();
				}

				foreach ($image as $field => $value) {
					$updateArray[$field] = $value;
				}

				$dbm->update(
					self::CITY_VISUALIZATION_IMAGES_TABLE_NAME,
					$updateArray,
					array(
						'city_id' => $image->city_id,
						'page_id' => $oldPageId,
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
					$title = Title::newFromText($image['name'], NS_FILE);

					$imageData = new stdClass();
					$imageData->city_id = $cityId;
					$imageData->page_id = $title->getArticleId();
					$imageData->city_lang_code = $langCode;
					$imagesToRemove[] = $imageData;
				}
			}
		}

		if (!empty($imagesToRemove)) {
			$dbm = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);
			$dbm->begin(__METHOD__);

			foreach ($imagesToRemove as $image) {
				$removeConds = array();

				foreach ($image as $field => $value) {
					$removeConds[$field] = $value;
				}

				$dbm->delete(
					self::CITY_VISUALIZATION_IMAGES_TABLE_NAME,
					$removeConds
				);
			}

			$dbm->commit(__METHOD__);
		}
	}

	public function removeImageFromReview($cityId, $pageId, $langCode) {
		$dbm = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);
		$dbm->delete(
			self::CITY_VISUALIZATION_IMAGES_TABLE_NAME,
			array(
				'city_id' => $cityId,
				'page_id' => $pageId,
				'city_lang_code' => $langCode
			)
		);
	}

	public function removeImageFromReviewByName($cityId, $imageName, $langCode) {
		$dbm = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);
		$dbm->delete(
			self::CITY_VISUALIZATION_IMAGES_TABLE_NAME,
			array(
				'city_id' => $cityId,
				'image_name' => $imageName,
				'city_lang_code' => $langCode
			)
		);
	}

	protected function getImagesFromReviewTable($cityId, $langCode) {
		wfProfileIn(__METHOD__);

		$wikiImages = array();
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$result = $db->select(
			array(self::CITY_VISUALIZATION_IMAGES_TABLE_NAME),
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

		wfProfileOut(__METHOD__);

		return $wikiImages;
	}

	public function getImageReviewStatus($wikiId, $pageId, WikiImageRowAssigner $rowAssigner) {
		wfProfileIn(__METHOD__);
		$reviewStatus = ImageReviewStatuses::STATE_UNREVIEWED;

		$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
		$conditions['city_id'] = $wikiId;
		$conditions['page_id'] = $pageId;

		$result = $db->select(
			array(self::CITY_VISUALIZATION_IMAGES_TABLE_NAME),
			array(
				'image_review_status',
			),
			$conditions,
			__METHOD__
		);

		while ($row = $result->fetchObject()) {
			$reviewStatus = $rowAssigner->returnParsedWikiImageRow($row);
		}

		wfProfileOut(__METHOD__);
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
		$corporateSites = $this->getVisualizationWikisData();
		return ( isset($corporateSites[$langCode]['wikiId']) ) ? $corporateSites[$langCode]['wikiId'] : false;
	}

	/**
	 * @desc Returns an array of wikis with visualization
	 * @return array
	 */
	public function getVisualizationWikisData() {
		$corporateSites = $this->getCorporateSitesList();
		$this->addLangToCorporateSites($corporateSites);
		return $this->cleanVisualizationWikisArray($corporateSites);
	}

	/**
	 * @desc Returns an array of wikis' ids
	 * @return array
	 */
	public function getVisualizationWikisIds() {
		return array_keys($this->getCorporateSitesList());
	}

	/**
	 * Return true when there is active Corporate Wiki in that language - like www.wikia.com or de.wikia.com
	 *
	 * @param $langCode
	 * @return bool
	 */
	public function isCorporateLang($langCode) {
		$corpWikis = $this->getVisualizationWikisData();
		return isset($corpWikis[$langCode]);
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
				'db' => $wiki['d'],
				'lang' => $lang
			);
		}

		return $results;
	}

	public function getWikisCountForStaffTool($opt) {
	//todo: reuse getWikisForStaffTool
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
		$table = $this->getTablesForStaffTool($opt);
		$fields = array('count( ' . self::CITY_VISUALIZATION_TABLE_NAME . '.city_id ) as count');
		$conds = $this->getConditionsForStaffTool($opt);
		$options = $this->getOptionsForStaffTool($opt);
		$joinConds = $this->getJoinsForStaffTool($opt);

		$results = $db->select($table, $fields, $conds, __METHOD__, $options, $joinConds);
		$row = $results->fetchRow();

		return isset($row['count']) ? $row['count'] : 0;
	}

	public function getWikisForStaffTool($opt) {
	//todo: implement memc and purge it once admin changes data or main image is approved
	//todo: add sql join and instead of headline provide wiki name
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
		$table = $this->getTablesForStaffTool($opt);
		$fields = array(
			self::CITY_VISUALIZATION_TABLE_NAME . '.city_id',
			self::CITY_VISUALIZATION_TABLE_NAME . '.city_vertical',
			'city_list.city_title',
			self::CITY_VISUALIZATION_TABLE_NAME . '.city_flags',
		);
		$conds = $this->getConditionsForStaffTool($opt);
		$options = $this->getOptionsForStaffTool($opt);
		$joinConds = $this->getJoinsForStaffTool($opt);

		$results = $db->select($table, $fields, $conds, __METHOD__, $options, $joinConds);
		$wikis = array();
		while( $row = $db->fetchObject($results) ) {
			$wikis[] = $row;
		}

		return $wikis;
	}

	protected function getJoinsForStaffTool($options) {
		$joinConds = array(
			'city_list' => array(
				'join',
				'city_list.city_id = ' . self::CITY_VISUALIZATION_TABLE_NAME . '.city_id'
			)
		);

		if ( !empty($options->collectionId) ) {
			$joinConds[WikiaCollectionsModel::COLLECTIONS_CV_TABLE] = [
				'join',
				WikiaCollectionsModel::COLLECTIONS_CV_TABLE . '.city_id = ' . self::CITY_VISUALIZATION_TABLE_NAME . '.city_id'
			];
		}

		return $joinConds;
	}

	protected function getConditionsForStaffTool($options) {
		$sqlOptions = array();

		if( isset($options->lang) ) {
			$sqlOptions[self::CITY_VISUALIZATION_TABLE_NAME . '.city_lang_code'] = $options->lang;
		}

		if( !empty($options->wikiHeadline) ) {
			$sqlOptions[] = 'city_list.city_title like "%' . mysql_real_escape_string($options->wikiHeadline) . '%"';
		}

		if ( !empty($options->verticalId) ) {
			$sqlOptions[self::CITY_VISUALIZATION_TABLE_NAME . '.city_vertical'] = $options->verticalId;
		}

		if ( !empty($options->collectionId) ) {
			$sqlOptions[WikiaCollectionsModel::COLLECTIONS_CV_TABLE . '.collection_id'] = $options->collectionId;
		}

		if ( !empty($options->blockedFlag) ) {
			$sqlOptions[] = self::CITY_VISUALIZATION_TABLE_NAME . '.city_flags & ' .WikisModel::FLAG_BLOCKED . ' > 0';
		}

		if ( !empty($options->officialFlag) ) {
			$sqlOptions[] = self::CITY_VISUALIZATION_TABLE_NAME . '.city_flags & ' .WikisModel::FLAG_OFFICIAL . ' > 0';
		}

		if ( !empty($options->promotedFlag) ) {
			$sqlOptions[] = self::CITY_VISUALIZATION_TABLE_NAME . '.city_flags & ' .WikisModel::FLAG_PROMOTED . ' > 0';
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

	protected function getTablesForStaffTool($options) {
		$tables = array(self::CITY_VISUALIZATION_TABLE_NAME,'city_list');
		if ( !empty($options->collectionId) ) {
			$tables[] = WikiaCollectionsModel::COLLECTIONS_CV_TABLE;
		}
		return $tables;
	}

	/**
	 * @desc Gets id of WF variable and then loads and returns list of corporate sites
	 * @return array
	 */
	protected function getCorporateSitesList() {
		$wikiFactoryList = array();
		self::$wikiFactoryVarId = WikiFactory::getVarIdByName(self::WIKIA_HOME_PAGE_WF_VAR_NAME);

		if( is_int(self::$wikiFactoryVarId) ) {
			$wikiFactoryList = WikiaDataAccess::cache(
				wfMemcKey('corporate_pages_list', self::CITY_VISUALIZATION_CORPORATE_PAGE_LIST_MEMC_VERSION, __METHOD__),
				24 * 60 * 60,
				array($this, 'loadCorporateSitesList')
			);
		}

		return $wikiFactoryList;
	}

	/**
	 * @desc Loads list of corporate sites (sites which have $wgEnableWikiaHomePageExt WF variable set to true)
	 * @return array
	 */
	public function loadCorporateSitesList() {
		return WikiFactory::getListOfWikisWithVar(self::$wikiFactoryVarId, 'bool', '=', true);
	}

	/**
	 * @param Array $collectionsList 2d array in example: [$collection1, $collection2, ...] where $collection1 = [$wikiId1, $wikiId2, ..., $wikiId17]
	 * @param String $lang language code
	 */
	public function getCollectionsWikisData(Array $collectionsList) {
		$collectionsWikisData = [];
		$helper = $this->getWikiaHomePageHelper();
		
		foreach($collectionsList as $collection => $collectionsWikis) {
			$collectionsWikisData[$collection] = WikiaDataAccess::cache(
				$this->getCollectionCacheKey($collection),
				6 * 60 * 60,
				function () use ($collection, $collectionsWikis) {
					$wikiListConditioner = new WikiListConditionerForCollection($collectionsWikis);
					return $this->getWikisList($wikiListConditioner); 
				}
			);
		}
		
		$collectionsWikisData = $helper->prepareBatchesForVisualization($collectionsWikisData);
		
		return $collectionsWikisData;
	}

	/**
	 * @return Array An array where the keys are three main hubs ids (integers) and values are string representation of English names
	 */
	public function getVerticalMap() {
		return $this->verticalMap;
	}

	public function getWikiaHomePageHelper() {
		if( is_null($this->helper) ) {
			$this->helper = new WikiaHomePageHelper();
		}
		
		return $this->helper;
	}
	
	public function getSlotsNoPerVertical($corpWikiId, $verticalId) {
		$helper = $this->getWikiaHomePageHelper();
		$numberOfSlots = $helper->getVarFromWikiFactory($corpWikiId, $this->verticalSlotsMap[$verticalId]);
		
		return $numberOfSlots;
	}

	public function getSlotsForVerticals($corpWikiId) {
		$slots = [];

		foreach($this->verticalMap as $verticalId => $verticalName) {
			$slots[$verticalName] = $this->getSlotsNoPerVertical($corpWikiId, $verticalId);
		}

		return $slots;
	}
}
