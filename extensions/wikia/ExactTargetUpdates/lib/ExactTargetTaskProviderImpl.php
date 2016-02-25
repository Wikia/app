<?php

namespace Wikia\ExactTarget;
class ExactTargetTaskProviderImpl implements ExactTargetTaskProvider {

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
