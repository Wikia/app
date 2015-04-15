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
	public function verifyUsersData( array $aUsersIds ) {
		$bSummaryResult = true;
		// Fetch data from ExactTarget
		$oRetrieveUserTask = $this->getRetrieveUserTask();
		$aExactTargetUsersData = $oRetrieveUserTask->retrieveUsersDataByIds( $aUsersIds );
		$aUsersIdsFlipped = array_flip( $aUsersIds );
		foreach ( $aExactTargetUsersData as $aExactTargetUserData ) {
			$this->info( __METHOD__ . ' ExactTarget user data record: ' . json_encode( $aExactTargetUserData ) );

			// Fetch data from Wikia DB
			$oWikiaUser = \User::newFromId( $aExactTargetUserData['user_id'] );
			$oUserHooksHelper = $this->getUserHooksHelper();
			$aWikiaUserData = $oUserHooksHelper->prepareUserParams( $oWikiaUser );
			$this->info( __METHOD__ . ' Wikia DB user data record: ' . json_encode( $aWikiaUserData ) );

			// Compare results
			$bResult = $this->compareResults( $aExactTargetUserData, $aWikiaUserData, __METHOD__, 'user_touched' );

			// Mark verification process as failed if any record fails
			if ( $bResult === false ) {
				$bSummaryResult = $bResult;
			}

			// Remove UserId from array to track unchecked users
			unset ( $aUsersIdsFlipped[$aExactTargetUserData['user_id']] );
		}

		// Log error if unchecked users found
		if ( !empty( $aUsersIdsFlipped ) ) {
			$this->error( __METHOD__ . ' Following user ids not retrieved from ET: ' . json_encode( array_keys( $aUsersIdsFlipped ) ) );
		}

		return $bSummaryResult;
	}


	/**
	 * Retrieves data from ExactTarget and compares it with data in Wikia database
	 * @return bool
	 * return true if data is equal (except comparing user_touched)
	 * if data isn't equal throws exception with result diff
	 */
	public function verifyUserPropertiesData( $iUserId ) {
		// Fetch data from ExactTarget
		$oRetrieveUserTask = $this->getRetrieveUserTask();
		$oExactTargetUserProperties = $oRetrieveUserTask->retrieveUserPropertiesByUserId( $iUserId );
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
