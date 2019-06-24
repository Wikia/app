<?php

/**
 * Wiki Features Helper
 * @author Hyun
 * @author Owen
 * @author Saipetch
 */
class WikiFeaturesHelper extends WikiaModel {

	protected static $instance = NULL;

	// no need to add feature to $release_date if not require "new" flag
	public static $release_date = array (
		'wgEnableChat' => '2011-08-01',
		'wgEnableForumExt' => '2012-11-29',
	);

	/**
	 * @static
	 * @return WikiFeaturesHelper
	 */
	public static function getInstance() {
		if (self::$instance === NULL) {
			$class = __CLASS__;
			self::$instance = new $class();
		}
		return self::$instance;
	}

	/**
	 * @desc get a list of regular features
	 * @return array $list
	 */
	public function getFeatureNormal() {
		$list = array();

		if (isset($this->wg->WikiFeatures['normal']) && is_array($this->wg->WikiFeatures['normal'])) {
			//allow adding features in runtime
			Hooks::run( 'WikiFeatures::onGetFeatureNormal' );

			foreach ($this->wg->WikiFeatures['normal'] as $feature) {
				$list[] = array(
					'name' => $feature,
					'enabled' => $this->getFeatureEnabled($feature),
					'imageExtension' => '.png'
				);
			}
		}
		return $list;
	}

	/**
	 * @desc get a list of labs features
	 * @return array $list
	 */
	public function getFeatureLabs() {
		$list = array();
		if (isset($this->wg->WikiFeatures['labs']) && is_array($this->wg->WikiFeatures['labs'])) {
			//allow adding features in runtime
			Hooks::run( 'WikiFeatures::onGetFeatureLabs' );

			foreach ($this->wg->WikiFeatures['labs'] as $feature) {
				$list[] = array(
					'name' => $feature,
					'enabled' => $this->getFeatureEnabled($feature),
					'new' => self::isNew($feature),
					'active' => $this->wg->Lang->formatNum( $this->getNumActiveWikis( $feature ) ),
					'imageExtension' => '.png'
				);
			}
		}
		return $list;
	}

	/**
	 * @desc get number of active wikis for specified feature
	 * @param string $feature
	 * @return int $num
	 */
	protected function getNumActiveWikis($feature) {
		wfProfileIn( __METHOD__ );

		$memKey = $this->getMemcKeyNumActiveWikis($feature);
		$num = $this->wg->Memc->get($memKey);
		if ( !is_numeric($num) ) {
			$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

			$result = $db->selectRow(
				array('city_variables_pool', 'city_variables'),
				'count(distinct cv_city_id) as cnt',
				array('cv_name' => $feature),
				__METHOD__,
				array(),
				array(
					'city_variables' => array(
						'LEFT JOIN',
						array('cv_id=cv_variable_id', 'cv_value' => serialize(true))
					)
				)
			);

			$num = ($result) ? intval($result->cnt) : 0 ;
			$this->wg->Memc->set($memKey, $num, 3600*24);
		}

		wfProfileOut( __METHOD__ );

		return intval($num);
	}

	/**
	 * @desc get memcache key of the number of active wikis for specified feature
	 * @param string $feature
	 * @return string
	 */
	public function getMemcKeyNumActiveWikis($feature) {
		return wfSharedMemcKey('wikifeatures', 'active_wikis', $feature);
	}

	protected function getFeatureEnabled($feature) {
		if ($this->app->getGlobal($feature)) {
			return true;
		}
		return false;
	}

	/**
	 * @desc checks if this is new or not (new if release_date <= 14 days). Note: return false if not in the $release_date.
	 * @param string $feature
	 * @return boolean
	 */
	protected static function isNew($feature) {
		$result = false;
		if (isset(self::$release_date[$feature])) {
			$release = strtotime(self::$release_date[$feature]);
			if ($release && floor((time()-$release)/86400) < 15) {
					$result = true;
			}
		}

		return $result;
	}

}
