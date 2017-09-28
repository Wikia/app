<?php
/**
 * City Visualization model for Wikia.com homepage grid
 *
 * @todo refactor, the queries should be part of /includes/wikia/models/WikisModel.class.php
 */
class CityVisualization extends WikiaModel {
	const CITY_VISUALIZATION_MEMC_VERSION = 'v0.80';
	const WIKI_STANDARD_BATCH_SIZE_MULTIPLIER = 100;

	const CITY_VISUALIZATION_TABLE_NAME = 'city_visualization';
	const CITY_VISUALIZATION_IMAGES_TABLE_NAME = 'city_visualization_images';

	const MEMC_IMAGE_NAMES_EXPIRATION_TIME = 86400; // 60 * 60 * 24

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

	/**
	 * @var WikiaHomePageHelper
	 */
	private $helper = null;

	//todo: increase readability
	//todo: decouple functions possibly extract classes
	//todo: decrease number of parameters in all functions in this file
	private function getList($corpWikiId, $contLang, $dontReadMemc = false) {
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
			'main_image' => PromoImage::fromPathname($row->city_main_image)->ensureCityIdIsSet($row->city_id)->getPathname(),
			'wikiofficial' => $this->isOfficialWiki($row->city_flags),
			'wikipromoted' => $this->isPromotedWiki($row->city_flags),
		];
	}

	private function getVisualizationWikisListDataCacheKey($corporateWikiId, $langCode) {
		return wfSharedMemcKey('wikis_data_for_visualization', self::CITY_VISUALIZATION_MEMC_VERSION, $corporateWikiId, $langCode, __METHOD__);
	}

	private function getVisualizationVerticalWikisListDataCacheKey($verticalId, $corporateWikiId, $langCode) {
		return wfSharedMemcKey('wikis_data_for_visualization_vertical', self::CITY_VISUALIZATION_MEMC_VERSION, $verticalId, $corporateWikiId, $langCode, __METHOD__);
	}

	public function getWikiPromoteDataCacheKey($wikiId, $langCode) {
		return $this->getVisualizationElementMemcKey('wiki_data_special_promote', $wikiId, $langCode);
	}

	public function getWikiDataCacheKey($corporateWikiId, $wikiId, $langCode) {
		return wfSharedMemcKey('single_wiki_data_visualization', self::CITY_VISUALIZATION_MEMC_VERSION, $corporateWikiId, $wikiId, $langCode, __METHOD__);
	}

	public function getWikiImageNamesCacheKey($wikiId, $langCode, $filter) {
		return $this->getVisualizationElementMemcKey("wiki_data_visualization_image_names:filter{$filter}", $wikiId, $langCode);
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
	private function getWikiData($wikiId, $langCode, WikiGetDataHelper $dataHelper) {
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

	private function notCachedGetWikiImageNames($wikiId, $langCode, $filter = ImageReviewStatuses::STATE_APPROVED) {
		wfProfileIn(__METHOD__);

		$wikiImageNames = array();
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
		$conditions = $this->getWikiImagesConditions($wikiId, $langCode, $filter);

		$result = $db->select(
			array(self::CITY_VISUALIZATION_IMAGES_TABLE_NAME),
			array(
				'image_name',
				'image_index'
			),
			$conditions,
			__METHOD__
		);

		while ($row = $result->fetchObject()) {
			$parsed = WikiImageRowHelper::parseWikiImageRow($row);
			$promoImage = PromoImage::fromPathname($parsed->name);
			//skip invalid promo image names
			if ($promoImage->isValid()) {
				$wikiImageNames[$parsed->index] = $promoImage->getPathname();
			}
		}

		wfProfileOut(__METHOD__);
		return $wikiImageNames;
	}

	public function getWikiImageNames($wikiId, $langCode, $filter = ImageReviewStatuses::STATE_APPROVED) {
		wfProfileIn(__METHOD__);

		$memKey = $this->getWikiImageNamesCacheKey($wikiId, $langCode, $filter);
		$wikiImageNames = $this->wg->Memc->get($memKey);

		if (empty($wikiImageNames)) {
			$wikiImageNames = $this->notCachedGetWikiImageNames($wikiId, $langCode, $filter);
			$this->wg->Memc->set($memKey, $wikiImageNames, self::MEMC_IMAGE_NAMES_EXPIRATION_TIME);
		}
		wfProfileOut(__METHOD__);

		return $wikiImageNames;
	}

	private static function isOfficialWiki($wikiFlags) {
		return (($wikiFlags & WikisModel::FLAG_OFFICIAL) == WikisModel::FLAG_OFFICIAL);
	}

	private static function isPromotedWiki($wikiFlags) {
		return (($wikiFlags & WikisModel::FLAG_PROMOTED) == WikisModel::FLAG_PROMOTED);
	}

	/**
	 * Given the language code returns ID of a corresponding corporate wiki
	 *
	 * @param string $langCode
	 * @return int|false
	 *
	 * @deprecated use WikiaCorporateModel::getCorporateWikiIdByLang instead
	 */
	public function getTargetWikiId($langCode) {
		return (new WikiaCorporateModel)->getCorporateWikiIdByLang($langCode);
	}

	/**
	 * @return Array An array where the keys are three main hubs ids (integers) and values are string representation of English names
	 */
	private function getVerticalMap() {
		return $this->verticalMap;
	}

	private function getWikiaHomePageHelper() {
		if( is_null($this->helper) ) {
			$this->helper = new WikiaHomePageHelper();
		}
		
		return $this->helper;
	}
	
	private function getSlotsNoPerVertical($corpWikiId, $verticalId) {
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
