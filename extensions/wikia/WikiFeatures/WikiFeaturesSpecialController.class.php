<?php

/**
 * Wiki Features Special Page
 * @author Hyun
 * @author Owen
 * @author Saipetch
 */
class WikiFeaturesSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		wfLoadExtensionMessages('WikiFeatures');
		parent::__construct('WikiFeatures', '', false);
	}
	
	public function init() {
		
	}
	
	public function index() {
		$this->response->addAsset('extensions/wikia/WikiFeatures/css/WikiFeatures.scss');
		$this->response->addAsset('extensions/wikia/WikiFeatures/js/WikiFeatures.js');
		//$this->wg->Out->addScriptFile($this->wg->ExtensionsPath . '/wikia/WikiFeatures/js/WikiFeatures.js');
	}

	/**
	 * @desc enable/disable feature
	 * @requestParam string enabled [true/false/0/1]
	 * @requestParam string feature	(extension variable)
	 * @responseParam string result [OK/error]
	 * @responseParam string error (error message)
	 */
	public function toggleFeature() {
		$enabled = $this->getVal('enabled', null);
		$feature = $this->getVal('feature', null);
		
		// check user permission
		if(!$this->wg->User->isAllowed( 'wikifeatures' )) {
			$this->setVal('result', 'error');
			$this->setVal('error', $this->wf->Msg('wikifeatures-error-permission'));
			return;
		}

		// validate feature
		if (is_null($enabled) || !$feature || !isset($this->wg->{str_replace('wg', '', $feature)})) {
			$this->setVal('result', 'error');
			$this->setVal('error', $this->wf->Msg('wikifeatures-error-invalid-parameter'));
			return;
		}
		
		$logMsg = "set extension option: $feature = $enabled.";
		$log = WF::build( 'LogPage', array( 'wikifeatures' ) );
		$log->addEntry( 'wikifeatures', SpecialPage::getTitleFor( 'WikiFeatures'), $logMsg, array() );
		
		$enabled = (bool) $enabled;
		WikiFactory::setVarByName($feature, $this->wg->CityId, $enabled, "WikiFeatures");
		
		// clear cache for active wikis
		$this->wg->Memc->delete($this->getMemcKeyNumActiveWikis($feature));
			
		$this->setVal('result', 'OK');
	}
	
	/**
	 * @desc get a list of features
	 * @requestParam string $type [normal/labs]
	 * @responseParam array $list
	 */
	public function getFeatureList() {
		$type = $this->getVal('type', null);
		
		$this->wf->ProfileIn( __METHOD__ );
		
		$list = array();
		if (array_key_exists($type, $this->wg->WikiFeatures)) {
			if ($type=='labs') {
				$list = $this->getFeatureLabs($this->wg->WikiFeatures[$type]);
			} else {
				$list = $this->getFeatureNormal($this->wg->WikiFeatures[$type]);
			}
		}
		$this->wf->ProfileOut( __METHOD__ );
		
		$this->setVal('list', $list);
	}
	
	/**
	 * @desc get a list of regular features
	 * @param string $features
	 * @return array $list 
	 */
	protected function getFeatureNormal($features) {
		foreach ($features as $feature) {
			$list[] = array(
				'name' => $feature, 
				'enabled' => $this->app->getGlobal($feature)
			);
		}
		return $list;
	}
	
	/**
	 * @desc get a list of labs features
	 * @param string $features
	 * @return array $list 
	 */
	protected function getFeatureLabs($features) {
		foreach ($features as $feature) {
			$list[] = array(
				'name' => $feature, 
				'enabled' => $this->app->getGlobal($feature), 
				'rating' => $this->getRating($feature), 
				'active' => $this->getNumActiveWikis($feature),
			);
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

			$num = ($result) ? $result->cnt : 0 ;
			$this->wg->Memc->set($memKey, $num, 3600*24);
		}
		
		$this->wf->ProfileOut( __METHOD__ );
		
		return $num;
	}
	
	/**
	 * @desc get memcache key of the number of active wikis for specified feature
	 * @param string $feature
	 * @return string 
	 */
	protected function getMemcKeyNumActiveWikis($feature) {
		return $this->wf->SharedMemcKey('wikifeatures', 'active_wikis', $feature);
	}
	
	protected function getRating($feature) {
		$rating = 0;
		
		return $rating;
	}
	
}
