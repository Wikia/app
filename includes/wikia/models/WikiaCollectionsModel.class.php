<?php
class WikiaCollectionsModel extends WikiaModel {
	const TABLE_NAME = 'wikia_homepage_collections';
	const COLLECTIONS_CV_TABLE = 'wikia_homepage_collections_city_visualization';
	const COLLECTIONS_COUNT = 3;
	const COLLECTIONS_MEMC_VERSION = '0.1';

	private function getCollectionsListCacheKey($langCode) {
		return wfSharedMemcKey('collections_list', self::COLLECTIONS_MEMC_VERSION, $langCode, __METHOD__);
	}
	
	private function getCollectionsListVisualizationCacheKey($langCode) {
		return wfSharedMemcKey('collections_list_visualization', self::COLLECTIONS_MEMC_VERSION, $langCode, __METHOD__);
	}
	
	private function getWikiInCollectionCacheKey($cityId) {
		return wfSharedMemcKey('wiki_in_collection', self::COLLECTIONS_MEMC_VERSION, $cityId, __METHOD__);
	}

	private function clearCache($langCode) {
		$this->wg->Memc->delete( $this->getCollectionsListCacheKey($langCode) );
		$this->wg->Memc->delete( $this->getCollectionsListVisualizationCacheKey($langCode) );

		$visualization = new CityVisualization();
		$corporateModel = new WikiaCorporateModel();
		foreach($this->getList($langCode) as $collection) {
			$this->wg->Memc->delete($visualization->getCollectionCacheKey($collection['id']));

			$title = GlobalTitle::newMainPage($corporateModel->getCorporateWikiIdByLang($langCode));
			$title->purgeSquid();
			Wikia::log(__METHOD__, '', 'Purged memcached for collection #' . $collection['id']);
		}
	}
	
	private function clearWikiCache($cityId) {
		$this->wg->Memc->delete( $this->getWikiInCollectionCacheKey($cityId) );
	}
	
	private function getListFromDb($langCode, $useMaster = false) {
		$sdb = wfGetDB($useMaster ? DB_MASTER : DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$fields = ['id', 'sort', 'name', 'sponsor_hero_image', 'sponsor_image', 'sponsor_url', 'enabled'];
		$conds = ['lang_code' => $langCode];
		$options = ['ORDER BY' => 'sort ASC'];

		$results = $sdb->select(self::TABLE_NAME, $fields, $conds, __METHOD__, $options);

		$out = array();
		while( $row = $sdb->fetchRow($results) ) {
			$out[] = $row;
		}

		return $out;
	}
	
	public function getList($langCode) {
		return WikiaDataAccess::cache(
			$this->getCollectionsListCacheKey($langCode),
			6 * 60 * 60,
			function() use ($langCode) {
				return $this->getListFromDb($langCode);
			}
		);
	}

	public function getListForVisualization($langCode) {
		return WikiaDataAccess::cache(
			$this->getCollectionsListVisualizationCacheKey($langCode),
			6 * 60 * 60,
			function() use ($langCode) {
				$list = $this->getList($langCode);
				foreach ($list as &$collection) {
					if (!empty($collection['sponsor_hero_image'])) {
						$collection['sponsor_hero_image'] = ImagesService::getLocalFileThumbUrlAndSizes($collection['sponsor_hero_image'], ImagesService::EXT_JPG);
					}
					if (!empty($collection['sponsor_image'])) {
						$collection['sponsor_image'] = ImagesService::getLocalFileThumbUrlAndSizes($collection['sponsor_image'], ImagesService::EXT_JPG);
					}

					$collection['wikis'] = $this->getWikisFromCollection($collection['id']);
				}

				return $list;
			}
		);
	}

	public function saveAll($langCode, $collections) {
		$i = 1;

		$collectionsToChange = [];
		$actualCollections = $this->getList($langCode);

		// update and save new collections
		foreach ($collections as $collection) {
			$this->save($langCode, $collection, $i++);

			if (isset($actualCollections[$i - 1]) && $actualCollections[$i - 1]['id'] != $collection['id']){
				$collectionsToChange[$actualCollections[$i - 1]['id']] = true;
			}
			unset($collectionsToChange[$collection['id']]);
		}

		// delete not used slots
		for ($i = $i; $i <= self::COLLECTIONS_COUNT; $i++) {
			$this->delete($langCode, $i);
		}

		// delete collections that were on used slots
		foreach ($collectionsToChange as $collectionId => $tmp) {
			$this->deleteById($collectionId);
		}

		$this->clearCache($langCode);
	}

	protected function save($langCode, $collection, $sortIndex) {
		$mdb = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);
		$sdb = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		if ($collection['id']) {
			$conds = ['id' => $collection['id']];
		} else {
			$conds = [
				'lang_code' => $langCode,
				'sort' => $sortIndex
			];
		}

		$updateData = [
			'sort' => $sortIndex,
			'name' => $collection['name'],
			'enabled' => $collection['enabled'],
			'sponsor_hero_image' => isset($collection['sponsor_hero_image']) ? $collection['sponsor_hero_image'] : null,
			'sponsor_image' => isset($collection['sponsor_image']) ? $collection['sponsor_image'] : null,
			'sponsor_url' => isset($collection['sponsor_url']) ? $collection['sponsor_url'] : null,
		];

		$result = $sdb->selectField(self::TABLE_NAME, 'count(1)', $conds, __METHOD__);

		if ($result) {
			$mdb->update(self::TABLE_NAME, $updateData, $conds, __METHOD__);
		} else {
			$insertData = array_merge($updateData, $conds);
			$mdb->insert(self::TABLE_NAME, $insertData, __METHOD__);
		}

		$mdb->commit();
	}

	public function delete($langCode, $sortIndex) {
		$mdb = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

		$conds = [
			'lang_code' => $langCode,
			'sort' => $sortIndex
		];

		$mdb->delete(self::TABLE_NAME, $conds, __METHOD__);

		$mdb->commit();
		$this->clearCache($langCode);
	}

	protected function deleteById($id) {
		$mdb = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

		$conds = [
			'id' => $id
		];

		$mdb->delete(self::TABLE_NAME, $conds, __METHOD__);

		$mdb->commit();
	}

	/**
	 * Add wiki (wiki id) to selected collection
	 *
	 * @param $cityId
	 * @param $collectionId
	 */
	public function addWikiToCollection($collectionId, $cityId) {
		$collection = $this->getById($collectionId);
		$cityVisualization = new CityVisualization();
		$wikiData = $cityVisualization->getWikiDataForVisualization($cityId, $collection['lang_code']);

		if(empty($wikiData['main_image'])) {
			$status = [
				'value' => false,
				'message' => wfMessage('manage-wikia-home-collections-add-failure-image', $wikiData['name'])->text()
			];
		} else if ( !$this->checkWikiCollectionExists($collectionId, $cityId) ) {
			$db = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

			$insertData = [
				'collection_id' => $collectionId,
				'city_id' => $cityId
			];

			$db->insert(self::COLLECTIONS_CV_TABLE, $insertData);

			$db->commit();

			$this->clearCache($collection['lang_code']);
			$this->clearWikiCache($cityId);

			$status = [
				'value' => true,
				'message' => wfMessage('manage-wikia-home-collections-add-success')->plain()
			];
		} else {
			$status = [
				'value' => false,
				'message' => wfMessage('manage-wikia-home-collections-add-failure-already-exists')->plain()
			];
		}
		return $status;
	}

	/**
	 * Remove wiki (wiki id) from selected collection
	 *
	 * @param $cityId
	 * @param $collectionId
	 */
	public function removeWikiFromCollection($collectionId, $cityId) {
		$db = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

		$conds = [
			'collection_id' => $collectionId,
			'city_id' => $cityId
		];

		$db->delete(self::COLLECTIONS_CV_TABLE, $conds);

		$db->commit();

		$collection = $this->getById($collectionId);
		$this->clearCache($collection['lang_code']);
		$this->clearWikiCache($cityId);

		return [
			'value' => true,
			'message' => wfMessage('manage-wikia-home-collections-remove-success')->plain()
		];
	}

	/**
	 * Get all wikis belonging to selected collection
	 *
	 * @param $collectionId
	 */
	public function getWikisFromCollection($collectionId) {
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$fields = [
			'city_id',
			'collection_id'
		];

		$conds = [
			'collection_id' => $collectionId
		];

		$results = $db->select(self::COLLECTIONS_CV_TABLE, $fields, $conds);

		$out = [];

		while( $row = $db->fetchRow($results) ) {
			$out[] = $row['city_id'];
		}

		return $out;
	}

	/**
	 * Get number of wikis assigned to specified collection
	 *
	 * @param $collectionId
	 */
	public function getCountWikisFromCollection($collectionId, $useMaster = false) {
		$dbType = (!$useMaster) ? DB_SLAVE : DB_MASTER;
		$db = wfGetDB($dbType, array(), $this->wg->ExternalSharedDB);
		return $db->selectField(self::COLLECTIONS_CV_TABLE, 'count(city_id)', ['collection_id' => $collectionId]);
	}

	public function getCollectionsByCityId($cityId) {
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$fields = [
			'collection_id'
		];

		$conds = [
			'city_id' => $cityId
		];

		$results = $db->select(self::COLLECTIONS_CV_TABLE, $fields, $conds);

		$out = [];

		while( $row = $db->fetchRow($results) ) {
			$out[] = $row['collection_id'];
		}

		return $out;
	}

	private function checkWikiCollectionExists($collectionId, $cityId) {
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$conds = [
			'collection_id' => $collectionId,
			'city_id' => $cityId
		];

		$result = $db->selectRow(self::COLLECTIONS_CV_TABLE, 'city_id', $conds);

		return (bool)$result;
	}

	public function getById($id) {
		$sdb = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$fields = ['id', 'sort', 'name', 'sponsor_hero_image', 'sponsor_image', 'sponsor_url', 'enabled', 'lang_code'];
		$conds = ['id' => $id];

		$results = $sdb->select(self::TABLE_NAME, $fields, $conds, __METHOD__);

		return $sdb->fetchRow($results);
	}

	public function isWikiInCollection($cityId) {
		return WikiaDataAccess::cache(
			$this->getWikiInCollectionCacheKey($cityId),
			6 * 60 * 60,
			function() use ($cityId) {
				return $this->getWikiInCollectionFromDb($cityId);
			}
		);
	}
	
	private function getWikiInCollectionFromDb($cityId) {
		$sdb = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$conds = [
			'city_id' => $cityId
		];

		$result = $sdb->selectRow(self::COLLECTIONS_CV_TABLE, 'city_id', $conds);

		return (bool)$result;
	}
}
