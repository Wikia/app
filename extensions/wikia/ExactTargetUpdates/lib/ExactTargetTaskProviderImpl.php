<?php

namespace Wikia\ExactTarget;
class ExactTargetTaskProviderImpl implements ExactTargetTaskProvider {

	/**
	/**
	 * Returns an instance of ExactTargetDeleteUserTask class
	 * @return ExactTargetDeleteUserTask
	 */
	public function getDeleteUserTask() {
		return new ExactTargetDeleteUserTask();
	}


	/**
	 * Returns an instance of ExactTargetCreateUserTask class
	 * @return ExactTargetCreateUserTask
	 */
	public function getCreateUserTask() {
		return new ExactTargetCreateUserTask();
	}

	/**
	 * Returns an instance of ExactTargetRetrieveUserTask class
	 * @return ExactTargetRetrieveUserTask
	 */
	public function getRetrieveUserTask() {
		return new ExactTargetRetrieveUserTask();
	}

	/**
	 * Returns an instance of ExactTargetUserDataVerification class
	 * @return ExactTargetUserDataVerificationTask
	 */
	public function getUserDataVerificationTask() {
		return new ExactTargetUserDataVerificationTask();
	}

	/**
	 * A simple getter for an object of an ExactTargetRetrieveWikiTask class
	 * @return ExactTargetRetrieveWikiTask
	 */
	public function getRetrieveWikiTask() {
		return new ExactTargetRetrieveWikiTask();
	}

	/**
	 * A simple getter for an object of an ExactTargetUpdateWikiTask class
	 * @return ExactTargetUpdateWikiTask
	 */
	public function getUpdateWikiHelper() {
		return new ExactTargetUpdateWikiTask();
	}

	/**
	 * Returns an instance of ExactTargetWikiDataVerification class
	 * @return ExactTargetWikiDataVerification
	 */
	public function getWikiDataVerificationTask() {
		return new ExactTargetWikiDataVerificationTask();
	}

}
