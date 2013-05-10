<?php
class WikiaCollectionsModel extends WikiaModel {
	const TABLE_NAME = 'wikia_homepage_collections';
	const COLLECTIONS_CV_TABLE = 'wikia_homepage_collections_city_visualization';
	const COLLECTIONS_COUNT = 3;
	const COLLECTIONS_MEMC_VERSION = '0.1';

	private function getCollectionsListCacheKey($langCode) {
		return $this->wf->SharedMemcKey('collections_list', self::COLLECTIONS_MEMC_VERSION, $langCode, __METHOD__);
	}
	
	private function getListFromDb($langCode) {
		$sdb = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

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
		$list = $this->getList($langCode);
		foreach ($list as &$collection) {
			if (!empty($collection['sponsor_hero_image'])) {
				$collection['sponsor_hero_image'] = ImagesService::getLocalFileThumbUrlAndSizes($collection['sponsor_hero_image']);
			}
			if (!empty($collection['sponsor_image'])) {
				$collection['sponsor_image'] = ImagesService::getLocalFileThumbUrlAndSizes($collection['sponsor_image']);
			}

			$collection['wikis'] = $this->getWikisFromCollection($collection['id']);
		}

		return $list;
	}

	public function saveAll($langCode, $collections) {
		$i = 1;
		foreach ($collections as $collection) {
			$this->save($langCode, $collection, $i++);
		}

		for ($i = $i; $i <= self::COLLECTIONS_COUNT; $i++) {
			$this->delete($langCode, $i);
		}
		$this->wg->Memc->delete( $this->getCollectionsListCacheKey($langCode) );
	}

	public function save($langCode, $collection, $sortIndex) {
		$mdb = $this->wf->GetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);
		$sdb = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$conds = [
			'lang_code' => $langCode,
			'sort' => $sortIndex
		];

		$updateData = [
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

		// purging cached list
		$this->wg->Memc->delete( $this->getCollectionsListCacheKey($langCode) );
		
		$mdb->commit();
	}

	public function delete($langCode, $sortIndex) {
		$mdb = $this->wf->GetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

		$conds = [
			'lang_code' => $langCode,
			'sort' => $sortIndex
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
		if ( !$this->checkWikiCollectionExists($collectionId, $cityId) ) {
			$db = $this->wf->getDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

			$insertData = [
				'collection_id' => $collectionId,
				'city_id' => $cityId
			];

			$db->insert(self::COLLECTIONS_CV_TABLE, $insertData);

			$db->commit();
		}
	}

	/**
	 * Remove wiki (wiki id) from selected collection
	 *
	 * @param $cityId
	 * @param $collectionId
	 */
	public function removeWikiFromCollection($collectionId, $cityId) {
		$db = $this->wf->getDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);

		$conds = [
			'collection_id' => $collectionId,
			'city_id' => $cityId
		];

		$result = $db->delete(self::COLLECTIONS_CV_TABLE, $conds);

		$db->commit();
	}

	/**
	 * Get all wikis belonging to selected collection
	 *
	 * @param $collectionId
	 */
	public function getWikisFromCollection($collectionId) {
		// TODO add cache'ing
		$db = $this->wf->getDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

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
	 * Get all wikis from all collections in selected language
	 *
	 * @param $langCode
	 */
	public function getCollectionWikisByLang($langCode) {
		$db = $this->wf->getDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$tables = [
			'whc'	=> self::TABLE_NAME,
			'whccv' => self::COLLECTIONS_CV_TABLE
		];

		$fields = [
			'whccv.city_id',
			'whccv.collection_id'
		];

		$conds = [
			'whc.lang_code' => $langCode
		];

		$joinConds = array(
			'whc' => array(
				'left join',
				'whc.id = whccv.collection_id'
			)
		);

		$results = $db->select($tables, $fields, $conds, __METHOD__, [], $joinConds);

		$out = [];

		while( $row = $db->fetchRow($results) ) {
			$out[] = $row;
		}

		return $out;
	}

	public function getCollectionsByCityId($cityId) {
		$db = $this->wf->getDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

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
		$db = $this->wf->getDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$conds = [
			'collection_id' => $collectionId,
			'city_id' => $cityId
		];

		$result = $db->selectRow(self::COLLECTIONS_CV_TABLE, 'city_id', $conds);

		return (bool)$result;
	}
}
