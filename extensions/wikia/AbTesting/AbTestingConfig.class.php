<?php

/**
 * AbTestingConfig serves as config provider that uses caching
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
class AbTestingConfig {

	const VERSION = 5;

	const MAX_MEMCACHED_TTL = 300;

	const PROP_MODIFIED_TIME = 'modifiedTime';
	const PROP_SCRIPT = 'script';
	const PROP_EXTERNAL_DATA = 'externalData';
	const PROP_EXPERIMENTS = 'experiments';

	protected $wg;

	protected $data;

	protected function __construct() {
		$this->wg = F::app()->wg;
	}

	public function getModifiedTime() {
		$this->load();
		return $this->data[self::PROP_MODIFIED_TIME];
	}

	public function getScript() {
		$this->load();
		return $this->data[self::PROP_SCRIPT];
	}

	public function getExperiments() {
		$this->load();
		return $this->data[self::PROP_EXPERIMENTS];
	}

	public function getExternalData( $requests ) {
		$this->load();
		$externalData = $this->data[self::PROP_EXTERNAL_DATA];
		$res = array();
		foreach ($requests as $key => $ids) {
			list( $expName, $versionId, $groupId ) = $ids;
			if ( !empty($externalData[$expName][$versionId][$groupId]) ) {
				$res[$key] = $externalData[$expName][$versionId][$groupId];
			}
		}
		return $res;
	}

	protected function getMemcKey() {
		return wfSharedMemcKey('abtesting','config',self::VERSION);
	}

	protected function load() {
		if ( is_null($this->data) ) {
			$memcKey = $this->getMemcKey();
			$this->data = $this->wg->Memc->get($memcKey);
			if ( empty( $this->data ) ) {
				$this->loadFromDatabase();
			}
		}
	}

	protected function loadFromDatabase() {
		$memcKey = $this->getMemcKey();
		$dataSource = new AbTestingData();
		$maxStaleCache = AbTesting::getMaxStaleCache();

		$lastModified = $dataSource->getLastEffectiveChangeTime($maxStaleCache);
		$lastModified = $lastModified
			? AbTesting::getTimestampForUTCDate($lastModified) : null;

		// find time of next config change
		$nextModification = $dataSource->getNextEffectiveChangeTime($maxStaleCache);
		$nextModification = $nextModification
			? AbTesting::getTimestampForUTCDate($nextModification) : null;

		// calculate proper TTL
		$ttl = self::MAX_MEMCACHED_TTL;
		if ( $nextModification ) {
			$ttl = max( time(), $nextModification ) + 1;
		}

		$this->populateData( $dataSource->getCurrent( /* use_master */ true ), $lastModified );
		$this->wg->Memc->set($memcKey,$this->data,$ttl);
	}

	protected function populateData( $rawData, $lastModified ) {
		$config = array();
		$external = array();

		foreach ($rawData as $exp) {
			$expName = AbTesting::normalizeName($exp['name']);

			$config[$expName] = array(
				'id' => intval($exp['id']),
				'name' => $expName,
				'versions' => array(),
			);
			$versions = &$config[$expName]['versions'];
			foreach ($exp['versions'] as $ver) {
				$versionId = intval($ver['id']);
				$version = array(
					'id' => $versionId,
					'startTime' => AbTesting::getTimestampForUTCDate($ver['start_time']),
					'endTime' => AbTesting::getTimestampForUTCDate($ver['end_time']),
					'gaSlot' => $ver['ga_slot'],
					'flags' => AbTesting::getFlagsInObject( $ver['flags'] ),
					'external' => false,
					'groups' => array(),
				);
				$groups = &$version['groups'];
				foreach ($ver['group_ranges'] as $grn) {
					$groupId = intval($grn['group_id']);
					$group = $exp['groups'][$groupId];
					$groupName = AbTesting::normalizeName($group['name']);
					$groups[$groupName] = array(
						'id' => intval($group['id']),
						'name' => $groupName,
						'ranges' => AbTesting::parseRanges($grn['ranges']),
					);
					if ( !empty($grn['styles']) ) {
						$version['external'] = true;
						$external[$expName][$versionId][$groupId]['styles'] = $grn['styles'];
					}
					if ( !empty($grn['scripts']) ) {
						$version['external'] = true;
						$external[$expName][$versionId][$groupId]['scripts'] = $grn['scripts'];
					}
				}
				$versions[] = $version;
			}
		}

		$script = sprintf("Wikia.AbTestConfig = %s;\n",
			json_encode(array(
				'experiments' => $config
			))
		);

		$this->data = array(
			self::PROP_MODIFIED_TIME => $lastModified,
			self::PROP_SCRIPT => $script,
			self::PROP_EXTERNAL_DATA => $external,
			self::PROP_EXPERIMENTS => $config,
		);
	}

	public function invalidateCache() {
		$this->loadFromDatabase();
	}



	public static function getInstance() {
		static $instance;
		if ( empty($instance) ) {
			$instance = new self;
		}
		return $instance;
	}

}