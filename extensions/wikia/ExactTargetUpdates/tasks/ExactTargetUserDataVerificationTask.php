<?php
namespace Wikia\ExactTarget;

class ExactTargetUserDataVerificationTask extends ExactTargetTask {

	use ExactTargetDataComparison;

	/**
	 * Retrieves data from ExactTarget and compares it with data in Wikia database
	 * @return bool
	 * return true if data is equal (except comparing user_touched)
	 * if data isn't equal throws exception with result diff
	 */
	public function verifyUserData( $iUserId ) {
		// Fetch data from ExactTarget
		$oRetriveveUserHelperTask = $this->getRetrieveUserHelper();
		$oExactTargetUserData = $oRetriveveUserHelperTask->retrieveUserDataById( $iUserId );
		$this->info( __METHOD__ . ' ExactTarget user data record: ' . json_encode( $oExactTargetUserData ) );

		// Fetch data from Wikia DB
		$oWikiaUser = \User::newFromId( $iUserId );
		$oUserHooksHelper = $this->getUserHooksHelper();
		$oWikiaUserData = $oUserHooksHelper->prepareUserParams( $oWikiaUser );
		$this->info( __METHOD__ . ' Wikia DB user data record: ' . json_encode( $oWikiaUserData ) );

		// Compare results
		$bResult = $this->compareResults( $oExactTargetUserData, $oWikiaUserData, __METHOD__, 'user_touched' );

		return $bResult;
	}


	/**
	 * Retrieves data from ExactTarget and compares it with data in Wikia database
	 * @return bool
	 * return true if data is equal (except comparing user_touched)
	 * if data isn't equal throws exception with result diff
	 */
	public function verifyUserPropertiesData( $iUserId ) {
		// Fetch data from ExactTarget
		$oRetriveveUserHelperTask = $this->getRetrieveUserHelper();
		$oExactTargetUserProperties = $oRetriveveUserHelperTask->retrieveUserPropertiesByUserId( $iUserId );
		$this->info( __METHOD__ . ' ExactTarget user_properties data record: ' . json_encode( $oExactTargetUserProperties ) );

		// Fetch data from Wikia DB
		$oWikiaUser = \User::newFromId( $iUserId );
		$oUserHooksHelper = $this->getUserHooksHelper();
		$oWikiaUserPropertiesData = $oUserHooksHelper->prepareUserPropertiesParams( $oWikiaUser );
		$this->info( __METHOD__ . ' Wikia DB user data record: ' . json_encode( $oWikiaUserPropertiesData ) );

		// Compare results
		$bResult = $this->compareResults( $oExactTargetUserProperties, $oWikiaUserPropertiesData, __METHOD__ );

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
