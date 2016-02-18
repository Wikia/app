<?php
/**
 * Provider interface for ExactTargetUpdate extension task objects.
 */

namespace Wikia\ExactTarget;

interface ExactTargetTaskProvider {

	/**
	 * Returns an instance of ExactTargetDeleteUserTask class
	 * @return ExactTargetDeleteUserTask
	 */
	public function getDeleteUserTask();

	/**
	 * Returns an instance of ExactTargetCreateUserTask class
	 * @return ExactTargetCreateUserTask
	 */
	public function getCreateUserTask();

	/**
	 * Returns an instance of ExactTargetRetrieveUserTask class
	 * @return ExactTargetRetrieveUserTask
	 */
	public function getRetrieveUserTask();

	/**
	 * Returns an instance of ExactTargetUserDataVerification class
	 * @return ExactTargetUserDataVerificationTask
	 */
	public function getUserDataVerificationTask();

	/**
	 * A simple getter for an object of an ExactTargetRetrieveWikiTask class
	 * @return ExactTargetRetrieveWikiTask
	 */
	public function getRetrieveWikiTask();


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
