<?php

class ExactTargetUserTaskHelper {

	/**
	 * Returns array of params for ExactTarget API for creating DataExtension objects
	 * @param array $aDataExtensionsParams
	 * @param string $sCustomerKey
	 * @return array
	 * e.g result params for creating two DataExtenision objects
	 * [
	 *   [
	 *     'DataExtension' => [
	 *       'CustomerKey' => 'user_properties',
	 *       'Properties' => ['key'='value']
	 *     ]
	 *   ]
	 *   [
	 *     'DataExtension' => [
	 *       'CustomerKey' => 'user_properties',
	 *       'Properties' => ['key'='value']
	 *     ]
	 *   ]
	 * ]
	 */
	public function prepareApiCreateParams( $aDataExtensionsParams, $sCustomerKey ) {
		$aApiParams = [];
		foreach ( $aDataExtensionsParams as $aProperties ) {
			$aApiParams[] = [
				'DataExtension' => [
					'CustomerKey' => $sCustomerKey,
					'Properties' => $aProperties
				]
			];
		}
		return $aApiParams;
	}

	/**
	 * Prepares DataExtension params for prepareApiCreateParams method
	 * @param int $iUserId
	 * @param array $aUserProperties array of property name => value pairs
	 * @return array
	 */
	public function prepareUserPropertiesDataExtensionsParams( $iUserId, $aUserProperties ) {
		$aDataExtensionsParams = [];
		foreach ( $aUserProperties as $sProperty => $sValue ) {
			$aDataExtensionsParams[] = [
				'up_user' => $iUserId,
				'up_property' => $sProperty,
				'up_value' => $sValue
			];
		}
		return $aDataExtensionsParams;
	}
}
