<?php
namespace Wikia\ExactTarget;

use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Util\Assert;

class ExactTargetUserUpdate extends BaseTask {

	private $client;

	public function __construct( $client = null ) {
		$this->client = $client;
	}

	/**
	 * Update user or create if doesn't exist
	 * @param array $userData
	 * @param array $userProperties
	 * @return bool
	 * @throws \Exception
	 * @throws \Wikia\Util\AssertionException
	 */
	public function update( array $userData, array $userProperties ) {
		Assert::true( !empty( $userData[ 'user_id' ] ), 'User ID missing' );
		Assert::true( !empty( $userData[ 'user_email' ] ), 'User email missing' );

		/* Delete subscriber (email address) used by touched user */
		$this->getClient()->deleteSubscriber( $userData[ 'user_id' ] );

		/* Create Subscriber with new email */
		$this->getClient()->createSubscriber( $userData[ 'user_email' ] );

		/* Create User in external service */
		$this->getClient()->updateUser( $userData );

		/* Create User Properties DataExtension with new email
		 * TODO move create user properties functionality to client */
		$oldCreateTask = new ExactTargetCreateUserTask();
		$oldCreateTask->createUserProperties( $userData[ 'user_id' ], $userProperties );

		/* Verify data */
		$userDataVerificationTask = new ExactTargetUserDataVerificationTask();
		$userDataVerificationTask->taskId( $this->getTaskId() ); // Pass task ID to have all logs under one task
		$userDataVerificationResult = $userDataVerificationTask->verifyUsersData( [ $userData[ 'user_id' ] ] );

		return $userDataVerificationResult;
	}

	protected function getClient() {
		if ( !isset( $this->client ) ) {
			$this->client = new ExactTargetClient();
		}
		return $this->client;
	}
}
