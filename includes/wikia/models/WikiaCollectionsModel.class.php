<?php
class WikiaCollectionsModel extends WikiaModel {
	const TABLE_NAME = 'wikia_homepage_collections';
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
}