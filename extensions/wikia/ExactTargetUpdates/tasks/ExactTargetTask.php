<?php
namespace Wikia\ExactTarget;

use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetTask extends BaseTask {

	/**
	 * Returns an instance of ExactTargetApiDataExtension class
	 * @return ExactTargetApiDataExtension
	 */
	protected function getApiDataExtension() {
		return new ExactTargetApiDataExtension();
	}

	/**
	 * Returns an instance of ExactTargetApiSubscriber class
	 * @return ExactTargetApiSubscriber
	 */
	protected function getApiSubscriber() {
		return new ExactTargetApiSubscriber();
	}
	/**

	 * Returns an instance of ExactTargetCreateUserTask class
	 * @return ExactTargetCreateUserTask
	 */
	protected function getCreateUserTask() {
		return new ExactTargetCreateUserTask();
	}

	/**
	/**
	 * Returns an instance of ExactTargetDeleteUserTask class
	 * @return ExactTargetDeleteUserTask
	 */
	protected function getDeleteUserTask() {
		return new ExactTargetDeleteUserTask();
	}

	/**
	 * Returns an instance of ExactTargetRetrieveUserHelper class
	 * @return ExactTargetRetrieveUserHelper
	 */
	protected function getRetrieveUserHelper() {
		return new ExactTargetRetrieveUserHelper();
	}

	/**
	 * Returns an instance of ExactTargetUserTaskHelper class
	 * @return ExactTargetUserTaskHelper
	 */
	protected function getUserHelper() {
		return new ExactTargetUserTaskHelper();
	}

	/**
	 * A simple getter for an object of ExactTargetUserHooksHelper class
	 * @return ExactTargetUserHooksHelper
	 */
	protected function getUserHooksHelper() {
		return new ExactTargetUserHooksHelper();
	}

	/**
	 * Returns an instance of ExactTargetUserDataVerification class
	 * @return ExactTargetUserDataVerification
	 */
	protected function getUserDataVerificationTask() {
		return new ExactTargetUserDataVerificationTask();
	}

	/**
	 * A simple getter for an object of an ExactTargetUpdateWikiTask class
	 * @return ExactTargetUpdateWikiTask
	 */
	protected function getUpdateWikiHelper() {
		return new ExactTargetUpdateWikiTask();
	}

	/**
	 * A simple getter for an object of an ExactTargetWikiTaskHelper class
	 * @return ExactTargetWikiTaskHelper
	 */
	protected function getWikiHelper() {
		return new ExactTargetWikiTaskHelper();
	}

}
