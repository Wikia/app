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

	/**
	 * A simple getter for an object of an ExactTargetUpdateWikiTask class
	 * @return ExactTargetUpdateWikiTask
	 */
	public function getUpdateWikiHelper();

}
