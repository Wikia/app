<?php

class ExactTargetUpdatesHelper {

	/**
	 * Get Customer Keys specific for production or development
	 * CustomerKey is a key that indicates Wikia table reflected by DataExtension
	 */
	public static function getCustomerKeys() {
		global $wgExactTargetDevelopmentMode;

		if ( $wgExactTargetDevelopmentMode ) {
			$aCustomerKeys = [
				'user' => 'user_dev',
				'user_properties' => 'user_properties_dev',
			];
		} else {
			$aCustomerKeys = [
				'user' => 'user',
				'user_properties' => 'user_properties',
			];
		}
		return $aCustomerKeys;
	}
}
