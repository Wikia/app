<?php

class ExactTargetUpdatesHelper {

	/**
	 * Returns an array of keys of ET tables used for development
	 * if a $wgExactTargetDevelopmentMode is set to true.
	 * Returns an array of production names otherwise.
	 * @return array  An array of keys of ET tables
	 */
	public static function getCustomerKeys() {
		global $wgExactTargetDevelopmentMode;

		if ( $wgExactTargetDevelopmentMode ) {
			$aCustomerKeys = [
				'user' => 'user_dev',
				'user_properties' => 'user_properties_dev',
				'city_list' => 'city_list_dev',
				'city_cat_mapping' => 'city_cat_mapping_dev',
			];
		} else {
			$aCustomerKeys = [
				'user' => 'user',
				'user_properties' => 'user_properties',
				'city_list' => 'city_list',
				'city_cat_mapping' => 'city_cat_mapping',
			];
		}
		return $aCustomerKeys;
	}

	/**
	 * Returns an array where WF vars names are keys.
	 * Change of these vars should trigger an ET's city_list table update.
	 * @return array  An array with vars names as keys
	 */
	public static function getWfVarsTriggeringUpdate() {
		$aWfVarsTriggeringUpdate = [
			'wgServer' => true,
			'wgSitename' => true,
			'wgLanguageCode' => true,
			'wgDBcluster' => true,
		];
		return $aWfVarsTriggeringUpdate;
	}
}
