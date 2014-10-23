<?php
namespace Wikia\ExactTarget;

class ExactTargetWikiTaskHelper {

	public function prepareDataExtensionsForCreate( $iCityId ) {
		$aWikiDataExtension = $this->prepareWikiDataExtensionForCreate( $iCityId );
		$aCityCatMappingDataExtension = $this->prepareCityCatMappingDataExtensionForCreate( $iCityId );

		$aDataExtensionsForCreate = [
			'DataExtension' => [],
		];

		$aDataExtensionsForCreate['DataExtension'] = array_merge( $aDataExtensionsForCreate['DataExtension'], $aWikiDataExtension, $aCityCatMappingDataExtension );

		return $aDataExtensionsForCreate;
	}

	public function prepareWikiDataExtensionForCreate( $iCityId ) {
		$aCustomerKeys = $this->getCustomerKeys();

		/* Get wikidata from master */
		$oWiki = \WikiFactory::getWikiById( $iCityId, true );

		$aWikiData = [
			'city_id' => $oWiki->city_id,
			'city_url' => $oWiki->city_url,
			'city_created' => $oWiki->city_created,
			'city_founding_user' => $oWiki->city_founding_user,
			'city_description' => $oWiki->city_description,
			'city_title' => $oWiki->city_title,
			'city_lang' => $oWiki->city_lang,
			'city_cluster' => $oWiki->city_cluster,
			'city_vertical' => $oWiki->city_vertical,
		];

		$aWikiDataExtension = [
			[
				'CustomerKey' => $aCustomerKeys['city_list'],
				'Properties' => $aWikiData,
			]
		];

		return $aWikiDataExtension;
	}

	public function prepareWikiDataExtensionForUpdate( $iCityId ) {
		$aCustomerKeys = $this->getCustomerKeys();

		$aKeys = [
			'city_id' => $iCityId,
		];
		
		/* Get wikidata from master */
		$oWiki = \WikiFactory::getWikiById( $iCityId, true );
		$aWikiData = [
			'city_url' => $oWiki->city_url,
			'city_created' => $oWiki->city_created,
			'city_founding_user' => $oWiki->city_founding_user,
			'city_description' => $oWiki->city_description,
			'city_title' => $oWiki->city_title,
			'city_lang' => $oWiki->city_lang,
			'city_cluster' => $oWiki->city_cluster,
			'city_vertical' => $oWiki->city_vertical,
		];

		$aWikiDataExtension = [
			'DataExtension' => [
				[
					'CustomerKey' => $aCustomerKeys['city_list'],
					'Keys' => $aKeys,
					'Properties' => $aWikiData,
				],
			],
		];

		return $aWikiDataExtension;
	}

	public function prepareCityCatMappingDataExtensionForCreate( $iCityId ) {
		$aCityCatMappingDataExtension = [];

		$aCustomerKeys = $this->getCustomerKeys();

		$oWikiFactoryHub = new WikiFactoryHub();
		$aCategories = $oWikiFactoryHub->getWikiCategories( $iCityId );
		foreach( $aCategories as $aCategory ) {
			$aCityCatMappingDataExtension[] = [
				'CustomerKey' => $aCustomerKeys['city_cat_mapping'],
				'Properties' => [
					'city_id' => $iCityId,
					'cat_id' => $aCategory['cat_id'],
				],
			];
		}

		return $aCityCatMappingDataExtension;
	}

	public function prepareCityCatMappingDataExtensionForRetrieve( $iCityId ) {
		$aCustomerKeys = $this->getCustomerKeys();

		$aCityCatMappingDataForRetrieve = [
			'DataExtension' => [
				'CustomerKey' => $aCustomerKeys['city_cat_mapping'],
				'Properties' => [ 'city_id', 'cat_id' ],
			],
			'SimpleFilterPart' => [
				'Value' => $iCityId,
				'Property' => 'city_id',
			],
		];

		return $aCityCatMappingDataForRetrieve;
	}

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
		global $wgExactTargetDevelopmentMode;

		if ( $wgExactTargetDevelopmentMode ) {
			$aCustomerKeys = [
				'city_list' => 'city_list_dev',
				'city_cat_mapping' => 'city_cat_mapping_dev',
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
