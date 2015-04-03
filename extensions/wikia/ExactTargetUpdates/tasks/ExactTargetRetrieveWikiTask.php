<?php
namespace Wikia\ExactTarget;

class ExactTargetRetrieveWikiTask extends ExactTargetTask {

	/**
	 * Retrieve wiki data from ExactTarget by wiki id
	 * @param int $iWikiId
	 * @return array|null
	 * @throws \Exception
	 */
	public function retrieveWikiDataById( $iWikiId ) {
		$aProperties = [
			'city_path',
			'city_dbname',
			'city_sitename',
			'city_url',
			'city_created',
			'city_founding_user',
			'city_adult',
			'city_public',
			'city_title',
			'city_founding_email',
			'city_lang',
			'city_special',
			'city_umbrella',
			'city_ip',
			'city_google_analytics',
			'city_google_search',
			'city_google_maps',
			'city_indexed_rev',
			'city_lastdump_timestamp',
			'city_factory_timestamp',
			'city_useshared',
			'ad_cat',
			'city_flags',
			'city_cluster',
			'city_last_timestamp',
			'city_founding_ip',
			'city_vertical'
		];

		$oHelper = $this->getWikiHelper();
		$aApiParams = $oHelper->prepareWikiDataExtensionRetrieveParams( $aProperties, 'city_id', [ $iWikiId ] );

		$oApiDataExtension = $this->getApiDataExtension();
		$oWikiResult = $oApiDataExtension->retrieveRequest( $aApiParams );

		if ( isset( $oWikiResult->OverallStatus ) && $oWikiResult->OverallStatus !== 'OK' ) {
			throw new \Exception( $oWikiResult->OverallStatus );
		}

		if ( !empty( $oWikiResult->Results->Properties->Property ) ) {
			$aProperties = $oWikiResult->Results->Properties->Property;
			$aExactTargetWikiData = [];
			foreach ( $aProperties as $value ) {
				$aExactTargetWikiData[$value->Name] = $value->Value;
			}

			$this->formatDates( $aExactTargetWikiData );

			return $aExactTargetWikiData;
		}

		return null;
	}

	/**
	 * Change dates format of city_created and city_last_timestamp fields retrieved from ExactTarget
	 * to Y-m-d H:i:s that is format consistent with Wikia DB
	 * @param $aExactTargetWikiData
	 */
	protected function formatDates( &$aExactTargetWikiData ) {
		$sWikiaDateFormat = "Y-m-d H:i:s";

		$oDateTime = new \DateTime( $aExactTargetWikiData['city_created'] );
		$aExactTargetWikiData['city_created'] = $oDateTime->format( $sWikiaDateFormat );

		$oDateTime->modify( $aExactTargetWikiData['city_last_timestamp'] );
		$aExactTargetWikiData['city_last_timestamp'] = $oDateTime->format( $sWikiaDateFormat );
	}

}
