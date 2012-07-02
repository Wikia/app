<?php
class CityVisualization extends WikiaModel {
	const FLAG_NEW = 1;
	const FLAG_HOT = 2;
	const FLAG_PROMOTED = 4;
	const FLAG_BLOCKED = 8;

	const DIRT_REVIEWED_IMAGES_ONLY = 1;
	const DIRT_UNREVIEWED_IMAGES_ONLY = 2;
	const DIRT_ALL_IMAGES = 4;

	const CITY_TAG_ENTERTAINMENT_ID = 129;
	const CITY_TAG_VIDEO_GAMES_ID = 131;
	const CITY_TAG_LIFESTYLE_ID = 127;

	const CITY_VISUALIZATION_MEMC_VERSION = 'v0.07';

	protected static $wikiaListMemcKey = 'wikis_data_for_visualization_wikia_v1.0';
	protected static $comscoreListMemcKey = 'wikis_data_for_visualization_comscore_v1.0';

	public function getList($contLang) {
		return $this->getComscoreList($contLang);
	}

	/**
	 * @desc Returns results from simple join between three tables: city_list, city_visualization, city_tag_map results
	 * @return array
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getWikiaList() {
		$this->wf->ProfileIn(__METHOD__);

		$memKey = $this->wf->SharedMemcKey(self::$wikiaListMemcKey, __METHOD__);
		$wikis = $this->wg->Memc->get($memKey);
		if (!is_array($wikis)) {
			$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
			$tables = array('city_visualization', 'city_list', 'city_tag_map');
			$fields = array(
				'city_visualization.city_id',
				'city_tag_map.tag_id',
				'city_visualization.city_main_image',
				'city_visualization.city_description',
				'city_list.city_title',
				'city_list.city_url',
				'city_visualization.city_flags',
			);
			$conds = array(
				'city_list.city_public' => 1,
				'city_tag_map.tag_id in (' . $db->makeList(array(
					self::CITY_TAG_LIFESTYLE_ID,
					self::CITY_TAG_ENTERTAINMENT_ID,
					self::CITY_TAG_VIDEO_GAMES_ID,
				)) . ')',
			);
			$options = array('ORDER BY' => 'city_tag_map.tag_id');
			$joinConds = array(
				'city_list' => array(
					'join',
					'city_visualization.city_id = city_list.city_id'
				),
				'city_tag_map' => array(
					'join',
					'city_visualization.city_id = city_tag_map.city_id'
				),
			);

			$results = $db->select($tables, $fields, $conds, __METHOD__, $options, $joinConds);
			$wikis = array();
			while ($row = $db->fetchObject($results)) {
				$tagName = $this->getNameFromTagId($row->tag_id);
				if ($tagName !== false) {
					$wikiUrl = $row->city_url . '?redirect=no';

					$wikis[$tagName][] = array(
						'wikiid' => $row->city_id,
						'wikiname' => $row->city_title,
						'wikiurl' => $wikiUrl,
						'wikidesc' => $row->city_description,
						'main_image' => $row->city_main_image,
						'wikinew' => $this->isNewWiki($row->city_flags),
						'wikihot' => $this->isHotWiki($row->city_flags),
					);
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
		$fields = array('city_visualization.city_id','city_flags');
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
		}
	}

	/**
	 * @desc Returns results from simple join between two tables: city_list, city_visualization + comscore categories from HubService
	 * @return array
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getComscoreList($contLang) {
		$this->wf->ProfileIn(__METHOD__);

		$memKey = $this->wf->SharedMemcKey(self::$comscoreListMemcKey, $contLang, __METHOD__);
		$wikis = $this->wg->Memc->get($memKey);
		if (!is_array($wikis)) {
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

	public function purgeWikiDataCache($wikiId, $langCode) {
		$memcKey = $this->getWikiDataCacheKey($wikiId, $langCode);
		$this->wg->Memc->set($memcKey, null);
	}

	public function updateWikiPromoteDataCache($wikiId, $langCode, $data) {
		$memcKey = $this->getWikiPromoteDataCacheKey($wikiId, $langCode);

		$wikiData = array(
			'headline' => $data['city_headline'],
			'description' => $data['city_description'],
			'main_image' => $data['city_main_image'],
			'images' => (array)json_decode($data['city_images'])
		);

		$this->wg->Memc->set($memcKey, $wikiData);
	}


	protected function getWikiPromoteDataCacheKey($wikiId, $langCode) {
		return $this->getVisualizationElementMemcKey('wiki_data_special_promote', $wikiId, $langCode);
	}

	protected function getWikiDataCacheKey($wikiId, $langCode) {
		return $this->getVisualizationElementMemcKey('wiki_data_visualization', $wikiId, $langCode);
	}

	protected function getWikiImagesCacheKey($wikiId, $langCode) {
		return $this->getVisualizationElementMemcKey('wiki_data_visualization_images', $wikiId, $langCode);
	}

	protected function getWikiImageNamesCacheKey($wikiId, $langCode) {
		return $this->getVisualizationElementMemcKey('wiki_data_visualization_image_names', $wikiId, $langCode);
	}

	protected function getVisualizationElementMemcKey($prefix, $wikiId, $langCode) {
		return $this->wf->memcKey($prefix, self::CITY_VISUALIZATION_MEMC_VERSION, $wikiId, $langCode);
	}


	public function getWikiDataForPromote($wikiId, $langCode) {
		$this->wf->ProfileIn(__METHOD__);

		$memcKey = $this->getWikiPromoteDataCacheKey($wikiId, $langCode);
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
				$wikiData['main_image'] = $row->city_main_image;
				$wikiData['images'] = $this->getWikiImageNames($wikiId, $langCode);
			}

			$this->wg->Memc->set($memcKey, $wikiData, 60 * 60 * 24);
		}

		$this->wf->ProfileOut(__METHOD__);

		return $wikiData;
	}

	/**
	 * get wiki data
	 * @param integer $wikiId
	 * @return array $wikiData
	 */
	public function getWikiDataForVisualization($wikiId, $langCode) {
		$this->wf->ProfileIn(__METHOD__);

		$memcKey = $this->getWikiDataCacheKey($wikiId, $langCode);
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
				$wikiData['main_image'] = $row->city_main_image;
				$wikiData['images'] = (array)json_decode($row->city_images);
			}

			$this->wg->Memc->set($memcKey, $wikiData, 60 * 60 * 24);
		}

		$this->wf->ProfileOut(__METHOD__);

		return $wikiData;
	}


	protected function getWikiImagesConditions($wikiId, $filter) {
		$conditions = array();

		$conditions ['city_id'] = $wikiId;
		switch ($filter) {
			case self::DIRT_REVIEWED_IMAGES_ONLY:
				$conditions ['image_review_status'] = AdminUploadReviewHelper::STATE_APPROVED;
				break;
			case self::DIRT_UNREVIEWED_IMAGES_ONLY:
				$conditions ['image_review_status'] = AdminUploadReviewHelper::STATE_UNREVIEWED;
				break;
			default:
				break;
		}
		return $conditions;
	}

	public function getWikiImages($wikiId, $langCode, $filter = self::DIRT_REVIEWED_IMAGES_ONLY) {
		$this->wf->ProfileIn(__METHOD__);

		$memKey = $this->getWikiImagesCacheKey($wikiId, $langCode);
		$wikiImages = $this->wg->Memc->get($memKey);

		if (empty($wikiImages)) {
			$rowAssigner = F::build('wikiImageRowHelper');
			$wikiImages = $this->getWikiImageData($wikiId, $langCode, $rowAssigner, $filter);
			$this->wg->Memc->set($memKey, $wikiImages, 60 * 60 * 24);
		}
		$this->wf->ProfileOut(__METHOD__);

		return $wikiImages;
	}

	public function getWikiImageNames($wikiId, $langCode, $filter = self::DIRT_REVIEWED_IMAGES_ONLY) {
		$this->wf->ProfileIn(__METHOD__);

		$memKey = $this->getWikiImageNamesCacheKey($wikiId, $langCode);
		$wikiImageNames = $this->wg->Memc->get($memKey);

		if (empty($wikiImageNames)) {
			$rowAssigner = F::build('wikiImageNameRowHelper');
			$wikiImageNames = $this->getWikiImageData($wikiId, $langCode, $rowAssigner, $filter);
			$this->wg->Memc->set($memKey, $wikiImageNames, 60 * 60 * 24);
		}
		$this->wf->ProfileOut(__METHOD__);

		return $wikiImageNames;
	}

	public function getWikiImageData($wikiId, $langCode, wikiImageRowAssigner $rowAssigner, $filter = self::DIRT_REVIEWED_IMAGES_ONLY) {
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
			$wikiImages[$row->image_index] = $rowAssigner->returnParsesWikiImageRow($row);
		}

		$this->wf->ProfileOut(__METHOD__);

		return $wikiImages;
	}

	public function saveImagesForReview($cityId, $langCode, $files) {
		/* TODO: implement body! */
		/*
		if($files['mainImage']['modified']) {

		}

		*/
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

interface wikiImageRowAssigner {
	public function returnParsesWikiImageRow($row);
}

class wikiImageNameRowHelper implements wikiImageRowAssigner {
	public function returnParsesWikiImageRow($row) {
		return $row->image_name;
	}
}

class wikiImageRowHelper implements wikiImageRowAssigner {
	public function returnParsesWikiImageRow($row) {
		return array(
			'image_name' => $row->image_name,
			'image_index' => $row->image_index,
			'image_reviewed' => $row->image_reviewed
		);
	}
}

