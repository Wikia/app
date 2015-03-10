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
	 * Returns an instance of ExactTargetUserDataVerificator class
	 * @return ExactTargetUserDataVerificator
	 */
	protected function getUserDataVerificatorTask() {
		return new ExactTargetUserDataVerificatorTask();
	}

	/**
	 * A simple getter for an object of an ExactTargetWikiTaskHelper class
	 * @return ExactTargetWikiTaskHelper
	 */
	protected function getWikiHelper() {
		return new ExactTargetWikiTaskHelper();
	}

}
