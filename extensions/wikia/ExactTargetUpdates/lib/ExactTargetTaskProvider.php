<?php
/**
 * Provider interface for ExactTargetUpdate extension task objects.
 */

namespace Wikia\ExactTarget;

interface ExactTargetTaskProvider {

	/**
	 * Returns an instance of ExactTargetWikiDataVerification class
	 * @return ExactTargetWikiDataVerification
	 */
	public function getWikiDataVerificationTask();

}
