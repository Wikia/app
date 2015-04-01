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
		$this->compareResults( $oExactTargetUserData, $oWikiaUserData, __METHOD__, 'user_touched' );

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
		$this->compareResults( $oExactTargetUserProperties, $oWikiaUserPropertiesData, __METHOD__ );

		return 'OK';
	}

	/**
	 * Compare results
	 * @param array $aExactTargetData Array with results from ExactTarget
	 * @param array$aWikiaData Array with results from Wikia DB
	 * @param string $sCallerName name of function that called this one, needed for logs
	 * @param string $sIgnoredProperty Name of property that doesn't have to be equal
	 * @return bool true if equal
	 * @throws \Exception when results are not equals
	 */
	protected function compareResults( $aExactTargetData, $aWikiaData, $sCallerName, $sIgnoredProperty = '' ) {
		// Compare results
		$aDiffWikiaDB = array_diff( $aExactTargetData, $aWikiaData );

		if ( !empty( $sIgnoredProperty ) && count( $aDiffWikiaDB ) == 1 && isset( $aDiffWikiaDB[$sIgnoredProperty] ) ) {
			// Lets continue to the end of function as it's acceptable that $sIgnoredProperty is the only difference
		} elseif ( count( $aDiffWikiaDB ) > 0 ) {
			// There are unacceptable differences. Prepare diff and throw exception
			$aDiffExactTarget = array_diff( $aWikiaData, $aExactTargetData );
			$sDiffRes = [];
			$sDiffRes[] = "--- Expected (Wikia DB)";
			$sDiffRes[] = "+++ Actual (ExactTarget)";
			foreach ( $aDiffExactTarget as $key => $val ) {
				$sDiffRes[] = "- '$key' => '{$aDiffExactTarget[$key]}'";
				$sDiffRes[] = "+ '$key' => '{$aDiffWikiaDB[$key]}'";
			}
			$this->debug( $sCallerName . ' ' . json_encode( $sDiffRes ) );
			throw new \Exception( $sCallerName . " Verification failed, Record in ExactTarget doesn't match record in Wikia database.");
		}
		$this->info( 'Verification passed. Record in ExactTarget match record in Wikia database' );
		return true;
	}

	/**
	 * A simple getter for an object of ExactTargetUserHooksHelper class
	 * @return ExactTargetUserHooksHelper
	 */
	protected function getUserHooksHelper() {
		return new ExactTargetUserHooksHelper();
	}
}
