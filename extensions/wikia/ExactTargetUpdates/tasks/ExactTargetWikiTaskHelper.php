<?php
namespace Wikia\ExactTarget;

class ExactTargetWikiTaskHelper {

	/**
	 * Prepares DataExtension objects data from a city_list record
	 * @param  int $iCityId  A wiki's ID
	 * @return array         An array with city_list DataExtension objects data in a valid format
	 */
	public function prepareWikiDataExtensionForCreate( $iCityId ) {
		$aCustomerKeys = $this->getCustomerKeys();

		/* Get wikidata from master */
		$oWiki = \WikiFactory::getWikiById( $iCityId, true );

		$aWikiData = [
			'city_id' => $oWiki->city_id,
			'city_path' => $oWiki->city_path,
			'city_dbname' => $oWiki->city_dbname,
			'city_sitename' => $oWiki->city_sitename,
			'city_url' => $oWiki->city_url,
			'city_created' => $oWiki->city_created,
			'city_founding_user' => $oWiki->city_founding_user,
			'city_adult' => $oWiki->city_adult,
			'city_public' => $oWiki->city_public,
			'city_title' => $oWiki->city_title,
			'city_founding_email' => $oWiki->city_founding_email,
			'city_lang' => $oWiki->city_lang,
			'city_special' => $oWiki->city_special,
			'city_umbrella' => $oWiki->city_umbrella,
			'city_ip' => $oWiki->city_ip,
			'city_google_analytics' => $oWiki->city_google_analytics,
			'city_google_search' => $oWiki->city_google_search,
			'city_google_maps' => $oWiki->city_google_maps,
			'city_indexed_rev' => $oWiki->city_indexed_rev,
			'city_lastdump_timestamp' => $oWiki->city_lastdump_timestamp,
			'city_factory_timestamp' => $oWiki->city_factory_timestamp,
			'city_useshared' => $oWiki->city_useshared,
			'ad_cat' => $oWiki->ad_cat,
			'city_flags' => $oWiki->city_flags,
			'city_cluster' => $oWiki->city_cluster,
			'city_last_timestamp' => $oWiki->city_last_timestamp,
			'city_founding_ip' => $oWiki->city_founding_ip,
			'city_vertical' => $oWiki->city_vertical,
		];

		$aWikiDataExtension = [
			[
				'CustomerKey' => $aCustomerKeys['city_list'],
				'Properties' => $aWikiData,
			],
		];

		return $aWikiDataExtension;
	}

	/**
	 * Prepares array of params for ExactTarget API for retrieving DataExtension objects from city_list table
	 * @param array $aProperties list of fields to retrieve
	 * @param string $sFilterProperty name of field to filter
	 * @param array $aFilterValues possible values to filter
	 * @return array
	 */
	public function prepareWikiDataExtensionRetrieveParams( $aProperties, $sFilterProperty, $aFilterValues ) {
		/* Get Customer Keys specific for production or development */
		$aCustomerKeys = $this->getCustomerKeys();

		$aApiParams = [
			'DataExtension' => [
				'ObjectType' => "DataExtensionObject[{$aCustomerKeys['city_list']}]",
				'Properties' => $aProperties,
			],
			'SimpleFilterPart' => [
				'Property' => $sFilterProperty,
				'Value' => $aFilterValues
			]
		];

		return $aApiParams;
	}


	/**
	 * Prepares DataExtension objects data for Update from a city_list record
	 * @param  int $iCityId  A wiki's ID
	 * @return array         An array with city_list DataExtension objects data in a valid format
	 */
	public function prepareWikiDataExtensionForUpdate( $iCityId ) {
		$aCustomerKeys = $this->getCustomerKeys();

		$aKeys = [
			'city_id' => $iCityId,
		];

		$aWikiData = $this->getWikiDataArray( $iCityId );
		$aWikiDataExtension = [ 'DataExtension' => [] ];
		$aWikiDataExtension['DataExtension'][] =  [
				'CustomerKey' => $aCustomerKeys['city_list'],
				'Keys' => $aKeys,
				'Properties' => $aWikiData,
		];

		return $aWikiDataExtension;
	}

	public function getWikiDataArray( $iCityId ) {
		/* Get wikidata from master */
		$oWiki = \WikiFactory::getWikiById( $iCityId, true );
		$aWikiData = [
			'city_path' => $oWiki->city_path,
			'city_dbname' => $oWiki->city_dbname,
			'city_sitename' => $oWiki->city_sitename,
			'city_url' => $oWiki->city_url,
			'city_created' => $oWiki->city_created,
			'city_founding_user' => $oWiki->city_founding_user,
			'city_adult' => $oWiki->city_adult,
			'city_public' => $oWiki->city_public,
			'city_title' => $oWiki->city_title,
			'city_founding_email' => $oWiki->city_founding_email,
			'city_lang' => $oWiki->city_lang,
			'city_special' => $oWiki->city_special,
			'city_umbrella' => $oWiki->city_umbrella,
			'city_ip' => $oWiki->city_ip,
			'city_google_analytics' => $oWiki->city_google_analytics,
			'city_google_search' => $oWiki->city_google_search,
			'city_google_maps' => $oWiki->city_google_maps,
			'city_indexed_rev' => $oWiki->city_indexed_rev,
			'city_lastdump_timestamp' => $oWiki->city_lastdump_timestamp,
			'city_factory_timestamp' => $oWiki->city_factory_timestamp,
			'city_useshared' => $oWiki->city_useshared,
			'ad_cat' => $oWiki->ad_cat,
			'city_flags' => $oWiki->city_flags,
			'city_cluster' => $oWiki->city_cluster,
			'city_last_timestamp' => $oWiki->city_last_timestamp,
			'city_founding_ip' => $oWiki->city_founding_ip,
			'city_vertical' => $oWiki->city_vertical,
		];
		return $aWikiData;
	}

	/**
	 * Prepares DataExtension objects data for Delete from a city_list record
	 * @param  int $iCityId  A wiki's ID
	 * @return array         An array with city_list DataExtension objects data in a valid format
	 */
	public function prepareWikiDataExtensionForDelete( $iCityId ) {
		$aCustomerKeys = $this->getCustomerKeys();

		$aKeys = [
			'city_id' => $iCityId,
		];

		$aWikiDataExtension = [
			'DataExtension' => [
				[
					'CustomerKey' => $aCustomerKeys['city_list'],
					'Keys' => $aKeys,
				],
			],
		];

		return $aWikiDataExtension;
	}

	/**
	 * Prepares DataExtension objects data from a city_cat_mapping record
	 * @param  int $iCityId  A wiki's ID
	 * @return array         An array with city_cat_mapping DataExtension objects data in a valid format
	 */
	public function prepareCityCatMappingDataExtensionForCreate( $iCityId ) {
		$aCityCatMappingDataExtension = [];

		$aCustomerKeys = $this->getCustomerKeys();

		$oWikiFactoryHub = new \WikiFactoryHub();
		$aCategories = $oWikiFactoryHub->getWikiCategories( $iCityId );
		$aCityCatMappingDataExtension['DataExtension'] = [];

		foreach( $aCategories as $aCategory ) {
			$aCityCatMappingDataExtension['DataExtension'][] = [
				'CustomerKey' => $aCustomerKeys['city_cat_mapping'],
				'Properties' => [
					'city_id' => $iCityId,
					'cat_id' => $aCategory['cat_id'],
				],
			];
		}

		return $aCityCatMappingDataExtension;
	}

	/**
	 * Prepares DataExtension objects data for Retrieve from a city_cat_mapping record
	 * @param  int $iCityId  A wiki's ID
	 * @return array         An array with city_cat_mapping DataExtension objects data in a valid format
	 */
	public function prepareCityCatMappingDataExtensionForRetrieve( $iCityId ) {
		$aCustomerKeys = $this->getCustomerKeys();

		$aCityCatMappingDataForRetrieve = [
			'DataExtension' => [
				'ObjectType' => "DataExtensionObject[{$aCustomerKeys['city_cat_mapping']}]",
				'Properties' => [ 'city_id', 'cat_id' ],
			],
			'SimpleFilterPart' => [
				'Property' => 'city_id',
				'Value' => $iCityId,
			],
		];

		return $aCityCatMappingDataForRetrieve;
	}

	/**
	 * Prepares DataExtension objects data for Delete from a city_cat_mapping record
	 * @param  int $iCityId  A wiki's ID
	 * @return array         An array with city_cat_mapping DataExtension objects data in a valid format
	 */
	public function prepareCityCatMappingDataExtensionForDelete( $oResults ) {
		$aCityCatMappingDataForDelete = [
			'DataExtension' => [],
		];
		$aCustomerKeys = $this->getCustomerKeys();

		/* An ugly hack caused by ExactTarget's API inconsistency */
		$aOldCategories = [];
		if ( is_array( $oResults->Results ) ) {
			foreach ( $oResults->Results as $oResult ) {
				$oCityId = $oResult->Properties->Property[0];
				$oCatId = $oResult->Properties->Property[1];
				$aOldCategories[] = [
					'city_id' => $oCityId->Value,
					'cat_id' => $oCatId->Value,
				];
			}
		} elseif ( is_object( $oResults->Results ) ) {
			$aProperty = $oResults->Results->Properties->Property;
			$aOldCategories[] = [
				'city_id' => $aProperty[0]->Value,
				'cat_id' => $aProperty[1]->Value,
			];
		}

		foreach ( $aOldCategories as $aCategory ) {
			$aCityCatMappingDataForDelete['DataExtension'][] = [
				'CustomerKey' => $aCustomerKeys['city_cat_mapping'],
				'Keys' => [
					'city_id' => $aCategory['city_id'],
					'cat_id' => $aCategory['cat_id'],
				],
			];
		}

		return $aCityCatMappingDataForDelete;
	}

	/**
	 * Get Customer Keys specific for production or development
	 * CustomerKey is a key that indicates Wikia table reflected by DataExtension
	 */
	private function getCustomerKeys() {
		global $wgDevelEnvironment;

		if ( $wgDevelEnvironment ) {
			$aCustomerKeys = [
				'city_list' => 'city-list',
				'city_cat_mapping' => 'city-cat-mapping',
			];
		} else {
			$aCustomerKeys = [
				'city_list' => 'city_list',
				'city_cat_mapping' => 'city_cat_mapping',
			];
		}
		return $aCustomerKeys;
	}
}
