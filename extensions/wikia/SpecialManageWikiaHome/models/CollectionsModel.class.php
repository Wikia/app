<?
class CollectionsModel extends WikiaModel {
	const TABLE_NAME = 'wikia_homepage_collections';
	const COLLECTIONS_COUNT = 3;

	public function getList($langCode) {
		$sdb = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

		$fields = ['id', 'sort', 'name', 'sponsor_hero_image', 'sponsor_image', 'sponsor_url', 'enabled'];
		$conds = ['lang_code' => $langCode];
		$options = ['ORDER BY' => 'sort ASC'];

		$results = $sdb->select(self::TABLE_NAME, $fields, $conds, __METHOD__, $options);

		$out = array();
		while ($row = $sdb->fetchRow($results)) {
			$out[] = $row;
		}

		return $out;
	}

	public function saveAll($langCode, $collections) {
		$i = 1;
		foreach ($collections as $collection) {
			$this->save($langCode, $collection, $i++);
		}

		for ($i = $i; $i <= self::COLLECTIONS_COUNT; $i++) {
			$this->delete($langCode, $i);
		}
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