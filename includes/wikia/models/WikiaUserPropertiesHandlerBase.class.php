<?php

class WikiaUserPropertiesHandlerBase extends WikiaModel {
	const EXCEPTION_USER_NOT_LOGGED_IN_CODE = 1;
	const EXCEPTION_INVALID_PROPERTY_NAME = 2;

	protected function savePropertyValue($property, $value) {
		$this->throwExceptionForAnons();

		$this->wg->User->setOption($property, $value);
		$this->wg->User->saveSettings();
	}

	protected function getPropertyValue($propertyName, $defaultOption = null) {
		$results = stdClass();
		$results->success = true;
		$results->propertyValue = $this->wg->User->getOption($propertyName, $defaultOption);
		return $results;
	}

	protected function throwExceptionForAnons() {
		if (!$this->wg->User->isLoggedIn()) {
			throw new Exception('User not logged-in', self::EXCEPTION_USER_NOT_LOGGED_IN_CODE);
		}
	}
}
