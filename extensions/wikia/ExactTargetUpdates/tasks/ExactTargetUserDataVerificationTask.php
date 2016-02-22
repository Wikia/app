<?php
namespace Wikia\ExactTarget;

class ExactTargetUserDataVerificationTask extends ExactTargetTask {

	use ExactTargetDataComparisonHelper;

	/**
	 * Retrieves data from ExactTarget and compares it with data in Wikia database
	 * @return bool
	 * return true if data is equal (except comparing user_touched)
	 * if data isn't equal throws exception with result diff
	 */
	public function verifyUserPropertiesData( $iUserId ) {
		// Fetch data from ExactTarget
		$oRetrieveUserTask = $this->getRetrieveUserTask();
		$aExactTargetUserProperties = $oRetrieveUserTask->retrieveUserPropertiesByUserId( $iUserId );
		$this->info( __METHOD__ . ' ExactTarget user_properties data record: ' . json_encode( $aExactTargetUserProperties ) );

		// Fetch data from Wikia DB
		$oWikiaUser = \User::newFromId( $iUserId );
		$oUserHooksHelper = $this->getUserHooksHelper();
		$aWikiaUserPropertiesData = $oUserHooksHelper->prepareUserPropertiesParams( $oWikiaUser );
		$this->info( __METHOD__ . ' Wikia DB user data record: ' . json_encode( $aWikiaUserPropertiesData ) );

		// Compare results
		$bResult = $this->compareResults( $aExactTargetUserProperties, $aWikiaUserPropertiesData, __METHOD__ );

		return $bResult;
	}

	/**
	 * A simple getter for an object of ExactTargetUserHooksHelper class
	 * @return ExactTargetUserHooksHelper
	 */
	protected function getUserHooksHelper() {
		return new ExactTargetUserHooksHelper();
	}
}
