<?php

namespace Wikia\ExactTarget;
class ExactTargetTaskProviderImpl implements ExactTargetTaskProvider {

	/**
	 * Returns an instance of ExactTargetWikiDataVerification class
	 * @return ExactTargetWikiDataVerification
	 */
	public function getWikiDataVerificationTask() {
		return new ExactTargetWikiDataVerificationTask();
	}

}
