<?php

class ExactTargetUpdatesHelper {

	/**
	 * Customer Keys for different enviroments
	 * (public name of tables in ExactTarget).
	 * @var array $aCustomerKeys
	 */
	private $aCustomerKeys;

	/**
	 * WikiFactory variables which change should trigger
	 * sending an update to ExactTarget.
	 * @var array $aWikiFactoryVarsToUpdate
	 */
	private $aWfVarsTriggeringUpdate;

	function __construct() {
		$this->setCustomerKeys();
		$this->setWfVarsTriggeringUpdate();
	}

	private function setCustomerKeys() {
		global $wgExactTargetDevelopmentMode;

		if ( $wgExactTargetDevelopmentMode ) {
			$this->aCustomerKeys = [
				'user' => 'user_dev',
				'user_properties' => 'user_properties_dev',
				'city_list' => 'city_list_dev',
				'city_cat_mapping' => 'city_cat_mapping_dev',
			];
		} else {
			$this->aCustomerKeys = [
				'user' => 'user',
				'user_properties' => 'user_properties',
				'city_list' => 'city_list',
				'city_cat_mapping' => 'city_cat_mapping',
			];
		}
	}

	public function getCustomerKeys() {
		return $this->aCustomerKeys;
	}

	private function setWfVarsTriggeringUpdate() {
		$this->aWfVarsTriggeringUpdate = [
			'wgServer',
			'wgSitename',
		];
	}

	public function getWfVarsTriggeringUpdate() {
		return $this->aWfVarsTriggeringUpdate;
	}
}
