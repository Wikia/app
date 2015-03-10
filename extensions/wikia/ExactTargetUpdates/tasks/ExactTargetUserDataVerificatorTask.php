<?php
namespace Wikia\ExactTarget;

class ExactTargetUserDataVerificatorTask extends ExactTargetTask {

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
		$this->info( __METHOD__ . 'ExactTarget user data record: ' . json_encode( $oExactTargetUserData ) );

		// Fetch data from Wikia DB
		$oWikiaUser = \User::newFromId( $iUserId );
		$oUserHooksHelper = $this->getUserHooksHelper();
		$oWikiaUserData = $oUserHooksHelper->prepareUserParams( $oWikiaUser );
		$this->info( __METHOD__ . 'Wikia DB user data record: ' . json_encode( $oWikiaUserData ) );

		// Compare results
		$aDiffWikiaDB = array_diff( $oExactTargetUserData, $oWikiaUserData );

		if ( count( $aDiffWikiaDB ) == 1 && isset( $aDiffWikiaDB['user_touched'] ) ) {
			// Return OK status if user_touched field is only difference
			return 'OK';
		} elseif ( count( $aDiffWikiaDB ) > 0 ) {
			// Prepare diff and throw exception
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
