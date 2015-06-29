<?php

class WikiaUserPropertiesHandlerBase extends WikiaModel {
	const EXCEPTION_USER_NOT_LOGGED_IN_CODE = 1;
	const EXCEPTION_INVALID_PROPERTY_NAME = 2;

	protected function savePropertyValue($property, $value) {
		$this->throwExceptionForAnons();

		$this->wg->User->setGlobalAttribute($property, $value);
		$this->wg->User->saveSettings();
	}

	protected function getPropertyValue($propertyName, $defaultOption = null) {
		$value = $this->wg->User->getGlobalAttribute($propertyName);
		if (!$value) {
			$value = $defaultOption;
		}

		return $value;
	}

	protected function getPropertyObject($propertyName, $defaultOption = null) {
		$results = new stdClass();
		$results->success = true;
		$results->propertyValue = $this->getPropertyValue($propertyName, $defaultOption);
		return $results;
	}

	protected function throwExceptionForAnons() {
		if (!$this->wg->User->isLoggedIn()) {
			throw new Exception('User not logged-in', self::EXCEPTION_USER_NOT_LOGGED_IN_CODE);
		}
	}
}
