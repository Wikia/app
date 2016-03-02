<?php
namespace Wikia\ExactTarget;

use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetTask extends BaseTask {

	private $exactTargetApiProvider;

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
	 * A simple getter for an object of an ExactTargetWikiTaskHelper class
	 * @return ExactTargetWikiTaskHelper
	 */
	protected function getWikiHelper() {
		return new ExactTargetWikiTaskHelper();
	}

}
