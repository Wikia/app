<?php
namespace Wikia\ExactTarget;

class ExactTargetUserDataVerificationTask extends ExactTargetTask {

	/**
	 * Retrieves data from ExactTarget and compares it with data in Wikia database
	 * @return string
	 * return 'OK' if data is equal (except comparing user_touched)
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
		$aDiffWikiaDB = array_diff( $oExactTargetUserData, $oWikiaUserData );

		if ( count( $aDiffWikiaDB ) == 1 && isset( $aDiffWikiaDB['user_touched'] ) ) {
			// Lets continue to the end of function as it's acceptable user_touched field is only difference
		} elseif ( count( $aDiffWikiaDB ) > 0 ) {
			// There are unacceptable differences. Prepare diff and throw exception
			$aDiffExactTarget = array_diff( $oWikiaUserData, $oExactTargetUserData );
			$sDiffRes = [];
			$sDiffRes[] = "--- Expected (Wikia DB)";
			$sDiffRes[] = "+++ Actual (ExactTarget)";
			foreach ( $aDiffExactTarget as $key => $val ) {
				$sDiffRes[] = "- '$key' => '{$aDiffExactTarget[$key]}'";
				$sDiffRes[] = "+ '$key' => '{$aDiffWikiaDB[$key]}'";
			}
			$this->debug( __METHOD__ . ' ' . json_encode( $sDiffRes ) );
			throw new \Exception( __METHOD__ . " Verification failed, User record in ExactTarget doesn't match record in Wikia database.");
		}
		$this->info( 'Verification passed. User record in ExactTarget match record in Wikia database' );
		return 'OK';
	}


	/**
	 * Retrieves data from ExactTarget and compares it with data in Wikia database
	 * @return string
	 * return 'OK' if data is equal (except comparing user_touched)
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
		$aDiffWikiaDB = array_diff( $oExactTargetUserProperties, $oWikiaUserPropertiesData );

		if ( count( $aDiffWikiaDB ) > 0 ) {
			// Prepare diff and throw exception
			$aDiffExactTarget = array_diff( $oWikiaUserPropertiesData, $oExactTargetUserProperties );
			$sDiffRes = [];
			$sDiffRes[] = "--- Expected (Wikia DB)";
			$sDiffRes[] = "+++ Actual (ExactTarget)";
			foreach ( $aDiffExactTarget as $key => $val ) {
				$sDiffRes[] = "- '$key' => '{$aDiffExactTarget[$key]}'";
				$sDiffRes[] = "+ '$key' => '{$aDiffWikiaDB[$key]}'";
			}
			$this->debug( __METHOD__ . ' ' . json_encode( $sDiffRes ) );
			throw new \Exception( __METHOD__ . " Verification failed, User record in ExactTarget doesn't match record in Wikia database.");
		}
		$this->info( 'Verification passed. User properties record in ExactTarget match record in Wikia database' );
		return 'OK';
	}

	/**
	 * A simple getter for an object of ExactTargetUserHooksHelper class
	 * @return ExactTargetUserHooksHelper
	 */
	protected function getUserHooksHelper() {
		return new ExactTargetUserHooksHelper();
	}
}
