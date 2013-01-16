<?php
/**
 * @author Sean Colombo
 * @author Kyle Florence
 * @author Władysław Bodzek
 */

class AbTesting extends WikiaObject {

	const VARNISH_CACHE_TIME = 900; // 15 minutes - depends on Resource Loader settings for non-versioned requests
	const CACHE_TTL = 3600;
	const SECONDS_IN_HOUR = 3600;
	const VERSION = 2;

	static protected $initialized = false;

	function __construct() {
		parent::__construct();

		if ( !self::$initialized ) {
			// Nirvana singleton, please use F::build
			F::setInstance( __CLASS__, $this );
			self::$initialized = true;
		}
	}

	// Keeping the response size (assets minification) and the number of external requests low (aggregation)
	public function onWikiaMobileAssetsPackages( Array &$jsHeadPackages, Array &$jsBodyPackages, Array &$scssPackages ) {
		array_unshift( $jsHeadPackages, 'abtesting' );
		return true;
	}

	public function onOasisSkinAssetGroupsBlocking( &$jsAssetGroups ) {
		array_unshift( $jsAssetGroups, 'abtesting' );
		return true;
	}

	public function onWikiaSkinTopModules( &$scriptModules, $skin ) {
		if ( $this->app->checkSkin( 'oasis', $skin ) ) {
			array_unshift( $scriptModules, 'wikia.ext.abtesting' );
		}
		return true;
	}

	protected function getMemcKey() {
		return $this->wf->sharedMemcKey('abtesting','config',self::VERSION);
	}

	public function getTimestampForUTCDate( $date ) {
		return strtotime($date);
	}

	protected function generateConfigScript( $data ) {
		$config = array();

		foreach ($data as $exp) {
			$expName = $this->normalizeName($exp['name']);

			$config[$expName] = array(
				'id' => intval($exp['id']),
				'name' => $expName,
				'versions' => array(),
			);
			$versions = &$config[$expName]['versions'];
			foreach ($exp['versions'] as $ver) {
				$version = array(
					'startTime' => $this->getTimestampForUTCDate($ver['start_time']),
					'endTime' => $this->getTimestampForUTCDate($ver['end_time']),
					'gaSlot' => $ver['ga_slot'],
					'groups' => array(),
				);
				$groups = &$version['groups'];
				foreach ($ver['group_ranges'] as $grn) {
					$group = $exp['groups'][$grn['group_id']];
					$groupName = $this->normalizeName($group['name']);
					$groups[$groupName] = array(
						'id' => intval($group['id']),
						'name' => $groupName,
						'ranges' => $this->parseRanges($grn['ranges']),
					);
				}
				$versions[] = $version;
			}
		}

		$expConfig = array(
			'experiments' => $config
		);

		return sprintf("Wikia.AbTestConfig = %s;\n",json_encode($expConfig));
	}

	protected function getConfig() {
		$dataClass = new AbTestingData();
		$memcKey = $this->getMemcKey();
//		$data = $this->wg->memc->get($memcKey);
		if ( empty( $data ) ) {
			$data = array(
				'modifiedTime' => $this->getTimestampForUTCDate($dataClass->getModifiedTime()),
				'script' => $this->generateConfigScript($dataClass->getCurrent()),
			);
			$this->wg->memc->set($memcKey,$data,self::CACHE_TTL);
		}
		return $data;
	}

	public function getConfigScript() {
		$data = $this->getConfig();
		return $data['script'];
	}

	public function getConfigModifiedTime() {
		$data = $this->getConfig();
		return $data['modifiedTime'];
	}

	public function invalidateCache() {
		$this->wg->memc->delete($this->getMemcKey());
	}

	/**
	 * Given a string of ranges, returns an array of range hashes. For example:
	 * "0-10,15-25" => array(
	 *     array( "min" => 0, "max" => 10 ),
	 *     array( "min" => 15, "max" => 25 )
	 * )
	 */
	public function parseRanges( $ranges, $failOnError = false ) {
		$rangesArray = array();

		if ( strlen( $ranges ) ) {
			$min = $max = 0;
			foreach ( explode( ',', $ranges ) as $i => $range ) {
				$hasError = false;
				if ( preg_match( '/^(\d+)-(\d+)$/', $range, $matches ) ) {
					$min = intval( $matches[1] );
					$max = intval( $matches[2] );
				} elseif ( preg_match( '/^(\d+)$/', $range, $matches ) ) {
					$min = $max = intval( $matches[1] );
				} else {
					$hasError = true;
				}
				if ( $min < 0 || $min > 99 ) $hasError = true;
				if ( $max < 0 || $max > 99 ) $hasError = true;
				if ( $min > $max ) $hasError = true;

				if ( $hasError ) {
					if ( $failOnError ) {
						return false;
					}
					break;
				}

				$rangesArray[] = array(
					'min' => $min,
					'max' => $max
				);
			}
		}

		return $rangesArray;
	}

	/**
	 * Normalizes the names of experiments and treatment groups into an
	 * uppercased string with spaces replaced by underscores.
	 */
	public function normalizeName( $name ) {
		$name = str_replace( ' ', '_', $name );
		$name = strtoupper( preg_replace( '/[^a-z0-9_]/i', '', $name ) );

		return $name;
	}

}
