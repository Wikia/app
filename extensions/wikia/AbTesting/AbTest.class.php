<?php
/**
 * @author Piotr Bablok pbablok@wikia-inc.com
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
class AbTest {

	/** @var array */
	protected static $activeExperiments = null;

	/**
	 * Get experiment specification received in X-Page-Variant HTTP header
	 * (it comes from page_variant cookie)
	 *
	 * @return array
	 */
	protected static function getVariantExperiments() {
		$list = !empty( $_SERVER['HTTP_X_PAGE_VARIANT'] ) ? $_SERVER['HTTP_X_PAGE_VARIANT'] : '';
		$list = urldecode($list);
		$list = explode(',',$list);
		$res = array();
		foreach ( $list as $exp ) {
			$expSpec = explode('=',$exp);
			if ( count($expSpec) == 2 && !empty($expSpec[0]) && !empty($expSpec[1]) ) {
				$res[ $expSpec[0] ] = $expSpec[1];
			}
		}
		return $res;
	}

	/**
	 * Populate the list of active experiments
	 */
	protected static function load() {
		if ( !is_null( self::$activeExperiments ) ) {
			return;
		}

		$activeExperiments = array();
		$allExperiments = AbTestingConfig::getInstance()->getExperiments();
		$time = time();
		$variantExperiments = self::getVariantExperiments();
		foreach ($allExperiments as $expName => $exp) {
			// skip experiments that are not mentioned in X-Page-Variant
			if ( !array_key_exists($expName,$variantExperiments) ) {
				continue;
			}
			// find the active version
			$currentVersion = null;
			foreach ($exp['versions'] as $version) {
				if ( $time >= $version['startTime'] && $time < $version['endTime'] ) {
					$currentVersion = $version;
					break;
				}
			}
			// check if the specified group exists
			$groupName = $variantExperiments[$expName];
			if ( $currentVersion && array_key_exists( $groupName, $currentVersion['groups'] ) ) {
				$activeExperiments[$expName] = $groupName;
			}
		}

		self::$activeExperiments = $activeExperiments;
	}

	/**
	 * Get list of active experiments as an array
	 *   array(
	 *     experimentName => groupName
	 *   )
	 *
	 * @return array
	 */
	public static function getExperiments() {
		self::load();
		return self::$activeExperiments;
	}

	/**
	 * Get a group the currently executed request should stick for the specified experiment.
	 * Returns null if no group is selected.
	 *
	 * @param $exp string Experiment name
	 * @return string|null Active group name or null otherwise
	 */
	public static function getGroup( $exp ) {
		self::load();
		return array_key_exists( $exp, self::$activeExperiments )
			? self::$activeExperiments[$exp]
			: null;
	}

}