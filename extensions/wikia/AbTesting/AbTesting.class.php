<?php
/**
 * @author Sean Colombo
 * @author Kyle Florence
 * @author Władysław Bodzek
 */

class AbTesting extends WikiaObject {

	const VARNISH_CACHE_TIME = 600; // 10 minutes - depends on Resource Loader settings for non-versioned requests
	const CACHE_TTL = 3600;
	const SECONDS_IN_HOUR = 3600;
	const VERSION = 1;

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

	public function onWikiaSkinTopModules( &$scriptModules, $skin ) {
		if ( $this->app->checkSkin( 'oasis', $skin ) ) {
			array_unshift( $scriptModules, 'wikia.ext.abtesting' );
		}
		return true;
	}

	protected function getMemcKey() {
		return $this->wf->sharedMemcKey('abtesting','config');
	}

	public function getTimestampForUTCDate( $date ) {
		return strtotime($date);
	}

	protected function generateConfigScript( $data ) {
		$config = array();

		foreach ($data as $exp) {
			$expName = $this->normalizeName($exp['name']);

			$config[$expName] = array(
				'id' => $exp['id'],
				'name' => $expName,
				'versions' => array(),
			);
			$versions = &$config[$expName]['versions'];
			foreach ($exp['versions'] as $ver) {
				$version = array(
					'startTime' => $this->getTimestampForUTCDate($ver['start_time']),
					'endTime' => $this->getTimestampForUTCDate($ver['end_time']),
					'gaSlot' => $ver['ga_slot'],
					'treatmentGroups' => array(),
				);
				$treatmentGroups = &$version['treatmentGroups'];
				foreach ($ver['group_ranges'] as $grn) {
					$group = $exp['groups'][$grn['group_id']];
					$groupName = $this->normalizeName($group['name']);
					$treatmentGroups[$groupName] = array(
						'id' => $group['id'],
						'name' => $groupName,
						'ranges' => $this->parseRanges($grn['ranges']),
						'isControl' => $group['id'] === $ver['control_group_id'],
					);
				}
				$versions[] = $version;
			}
		}

		$expConfig = array(
			'experiments' => $config
		);

		return sprintf("Wikia.AbTest = %s;\n",json_encode($expConfig));
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
			foreach ( explode( ',', $ranges ) as $i => $range ) {
				if ( !preg_match( '/^(\d+)-(\d+)$/', $range, $matches ) ) {
					if ( $failOnError ) {
						return false;
					}
					break;
				}

				$rangesArray[] = array(
					'min' => intval( $matches[ 1 ] ),
					'max' => intval( $matches[ 2 ] )
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
