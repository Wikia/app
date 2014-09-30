<?php

class ExactTargetUpdatesHelper {

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
