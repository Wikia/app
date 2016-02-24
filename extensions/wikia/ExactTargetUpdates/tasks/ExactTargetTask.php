<?php
namespace Wikia\ExactTarget;

use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetTask extends BaseTask {

	private $exactTargetApiProvider;
	private $exactTargetTaskProvider;

	public function setTaskProvider( ExactTargetTaskProvider $provider ) {
		$this->exactTargetTaskProvider = $provider;
	}

	public function getTaskProvider() {
		if (!isset($this->exactTargetTaskProvider)) {
			$this->exactTargetTaskProvider = new ExactTargetTaskProviderImpl();
		}

		return $this->exactTargetTaskProvider;
	}

	public function setApiProvider( ExactTargetApiProvider $provider ) {
		$this->exactTargetApiProvider = $provider;
	}

	public function getApiProvider() {
		if (!isset($this->exactTargetApiProvider)) {
			$this->exactTargetApiProvider = new ExactTargetApiProviderImpl();
		}

		return $this->exactTargetApiProvider;
	}

	/**
	 * Returns an instance of ExactTargetApiDataExtension class
	 * @return ExactTargetApiDataExtension
	 */
	protected function getApiDataExtension() {
		return $this->getApiProvider()->getApiDataExtension();
	}

	/**
	 * Returns an instance of ExactTargetApiSubscriber class
	 * @return ExactTargetApiSubscriber
	 */
	protected function getApiSubscriber() {
		return $this->getApiProvider()->getApiSubscriber();
	}

	/**
	 * Returns an instance of ExactTargetCreateUserTask class
	 * @return ExactTargetCreateUserTask
	 */
	protected function getCreateUserTask() {
		return $this->getTaskProvider()->getCreateUserTask();
	}

	/**
	/**
	 * Returns an instance of ExactTargetDeleteUserTask class
	 * @return ExactTargetDeleteUserTask
	 */
	protected function getDeleteUserTask() {
		return $this->getTaskProvider()->getDeleteUserTask();
	}

	/**
	 * Returns an instance of ExactTargetRetrieveUserTask class
	 * @return ExactTargetRetrieveUserTask
	 */
	protected function getRetrieveUserTask() {
		return $this->getTaskProvider()->getRetrieveUserTask();
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
	 * @return ExactTargetUserDataVerificationTask
	 */
	protected function getUserDataVerificationTask() {
		return $this->getTaskProvider()->getUserDataVerificationTask();
	}

	/**
	 * A simple getter for an object of an ExactTargetRetrieveWikiTask class
	 * @return ExactTargetRetrieveWikiTask
	 */
	protected function getRetrieveWikiTask() {
		return $this->getTaskProvider()->getUserDataVerificationTask();
	}


	/**
	 * A simple getter for an object of an ExactTargetUpdateWikiTask class
	 * @return ExactTargetUpdateWikiTask
	 */
	protected function getUpdateWikiHelper() {
		return $this->getTaskProvider()->getUpdateWikiHelper();
	}

	/**
	 * A simple getter for an object of an ExactTargetWikiTaskHelper class
	 * @return ExactTargetWikiTaskHelper
	 */
	protected function getWikiHelper() {
		return new ExactTargetWikiTaskHelper();
	}

	/**
	 * Returns an instance of ExactTargetWikiDataVerification class
	 * @return ExactTargetWikiDataVerification
	 */
	protected function getWikiDataVerificationTask() {
		return $this->getTaskProvider()->getWikiDataVerificationTask();
	}

}
