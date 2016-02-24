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
		return new ExactTargetRetrieveWikiTask();
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

	/**
	 * Returns an instance of ExactTargetWikiDataVerification class
	 * @return ExactTargetWikiDataVerification
	 */
	protected function getWikiDataVerificationTask() {
		return new ExactTargetWikiDataVerificationTask();
	}

}
