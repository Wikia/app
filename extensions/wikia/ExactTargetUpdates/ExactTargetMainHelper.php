<?php

class ExactTargetMainHelper {

	/**
	 * Get Customer Keys specific for production or development
	 * CustomerKey is a key that indicates Wikia table reflected by DataExtension
	 */
	public function getCustomerKeys() {
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

	/**
	 * Checks whether environment allows to do ExactTarget updates
	 * You can't update on DEV and INTERNAL environment,
	 * unless wgExactTargetDevelopmentMode is set to true.
	 */
	public function shouldUpdate() {
		global $wgWikiaEnvironment, $wgExactTargetDevelopmentMode;

		if ( ( $wgWikiaEnvironment != WIKIA_ENV_DEV && $wgWikiaEnvironment != WIKIA_ENV_INTERNAL ) || $wgExactTargetDevelopmentMode === true ) {
			return true;
		}

		return false;
	}
}
