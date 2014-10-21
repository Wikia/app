<?php
namespace Wikia\ExactTarget\Tasks;

use Wikia\ExactTarget\Api\ExactTargetApiDataExtension;
use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetUpdateUserTask extends BaseTask {

	/**
	 * Task for updating user data in ExactTarget
	 * @param array $aUserData Selected fields from Wikia user table
	 */
	public function updateUserData( $aUserData ) {
		$oHelper = $this->getHelper();
		$aApiParams = $oHelper->prepareUserUpdateParams( $aUserData );
		$oApiDataExtension = $this->getApiDataExtension();
		$oApiDataExtension->updateRequest( $aApiParams );
	}

	/**
	 * Sends update of user email to ExactTarget
	 * @param int $iUserId
	 * @param string $iUserEmail
	 */
	public function updateUserEmail( $iUserId, $iUserEmail ) {
		/* Subscriber list contains unique emails
		 * Assuming email may be new - try to create subscriber object using the email */
		$oCreateUserTask = $this->getCreateUserTask();
		$oCreateUserTask->createSubscriber( $iUserEmail );

		/* Update email in user data extension */
		$aUserData = [
			'user_id' => $iUserId,
			'user_email' => $iUserEmail
		];
		$oHelper = $this->getHelper();
		$aApiParams = $oHelper->prepareUserUpdateParams( $aUserData );
		$oApiDataExtension = $this->getApiDataExtension();
		$oApiDataExtension->updateRequest( $aApiParams );
	}

	/**
	 * Task for updating user_properties data in ExactTarget
	 * @param array $aUserData Selected fields from Wikia user table
	 * @param array $aUserProperties Array of Wikia user gloal properties ['property_name'=>'property_value']
	 */
	public function updateUserPropertiesData( $aUserData, $aUserProperties ) {
		$oHelper = $this->getHelper();
		$aApiParams = $oHelper->prepareUserPropertiesUpdateParams( $aUserData['user_id'], $aUserProperties );
		$oApiDataExtension = $this->getApiDataExtension();
		$oApiDataExtension->updateRequest( $aApiParams );
	}



	/**
	 * Returns an instance of ExactTargetCreateUserTask class
	 * @return ExactTargetCreateUserTask
	 */
	private function getCreateUserTask() {
		return new ExactTargetCreateUserTask();
	}

	/**
	 * Returns an instance of ExactTargetApiDataExtension class
	 * @return ExactTargetApiDataExtension
	 */
	private function getApiDataExtension() {
		return new ExactTargetApiDataExtension();
	}

	/**
	 * Returns an instance of ExactTargetUserTaskHelper class
	 * @return ExactTargetUserTaskHelper
	 */
	private function getHelper() {
		return new ExactTargetUserTaskHelper();
	}
}
