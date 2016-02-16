<?php
namespace Wikia\ExactTarget;

use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Util\Assert;

class ExactTargetCreateUser extends BaseTask {

	/** @var Client $client */
	private $client;

	public function __construct( $client = null ) {
		$this->client = $client;
	}

	public function create( array $aUserData, array $aUserProperties ) {
		Assert::true( !empty( $aUserData['user_id'] ), 'User ID missing' );
		Assert::true( !empty( $aUserData['user_email'] ), 'User email missing' );

		/* Delete subscriber (email address) used by touched user */
		$oDeleteUserTask = new ExactTargetDeleteUserTask();
		$oDeleteUserTask->taskId( $this->getTaskId() ); // Pass task ID to have all logs under one task
		$oDeleteUserTask->deleteSubscriber( $aUserData['user_id'] );

		/* Create Subscriber with new email */
		$oldCreateTask = new ExactTargetCreateUserTask();
		$oldCreateTask->createSubscriber( $aUserData['user_email'] );

		// Create User in external service
		$this->getClient()->createUser( $aUserData );

		/* Create User Properties DataExtension with new email */
		$oldCreateTask->createUserProperties( $aUserData['user_id'], $aUserProperties );

		/* Verify data */
		$oUserDataVerificationTask = new ExactTargetUserDataVerificationTask();
		$oUserDataVerificationTask->taskId( $this->getTaskId() ); // Pass task ID to have all logs under one task
		$bUserDataVerificationResult = $oUserDataVerificationTask->verifyUsersData( [ $aUserData['user_id'] ] );

		return 'OK';
	}

	protected function getClient() {
		if (!isset( $this->client ) ) {
			$this->client = new ExactTargetClient();
		}
		return $this->client;
	}
}
