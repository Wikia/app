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
	 * A simple getter for an object of ExactTargetUserHooksHelper class
	 * @return ExactTargetUserHooksHelper
	 */
	protected function getUserHooksHelper() {
		return new ExactTargetUserHooksHelper();
	}

	/**
	 * A simple getter for an object of an ExactTargetRetrieveWikiTask class
	 * @return ExactTargetRetrieveWikiTask
	 */
	protected function getRetrieveWikiTask() {
		return $this->getTaskProvider()->getWikiDataVerificationTask();
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
