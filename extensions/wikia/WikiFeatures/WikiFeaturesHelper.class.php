<?php

/**
 * Wiki Features Helper
 * @author Hyun
 * @author Owen
 * @author Saipetch
 */
class WikiFeaturesHelper extends WikiaModel {

	protected static $instance = NULL;
	
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
		if (is_array($this->wg->WikiFeatures['normal'])) {
			foreach ($this->wg->WikiFeatures['normal'] as $feature) {
				$list[] = array(
					'name' => $feature, 
					'enabled' => $this->app->getGlobal($feature)
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
		if (is_array($this->wg->WikiFeatures['labs'])) {
			foreach ($this->wg->WikiFeatures['labs'] as $feature) {
				$list[] = array(
					'name' => $feature, 
					'enabled' => $this->app->getGlobal($feature), 
					'rating' => $this->getRating($feature), 
					'active' => $this->getNumActiveWikis($feature),
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
		$this->wf->ProfileIn( __METHOD__ );
		
		$memKey = $this->getMemcKeyNumActiveWikis($feature);
		$num = $this->wg->Memc->get($memKey);
		if (is_null($num)) {
			$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

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
		
		$this->wf->ProfileOut( __METHOD__ );
		
		return intval($num);
	}
	
	/**
	 * @desc get memcache key of the number of active wikis for specified feature
	 * @param string $feature
	 * @return string 
	 */
	public function getMemcKeyNumActiveWikis($feature) {
		return $this->wf->SharedMemcKey('wikifeatures', 'active_wikis', $feature);
	}
	
	protected function getRating($feature) {
		$rating = 0;
		
		return $rating;
	}
	
}
