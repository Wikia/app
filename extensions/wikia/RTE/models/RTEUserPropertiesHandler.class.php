<?php

/**
 * UserProperties Handler for RTE
 */

class RTEUserPropertiesHandler extends WikiaUserPropertiesHandlerBase {

	const MAIN_PAGE_NOTIFICATIONS_HIDDEN_PROP_NAME = 'RteMainPageNotificationHidden';

	public function dismissRTEMainPageNotice($params = null) {
		$results = new stdClass();

		if ($this->wg->ReadOnly) {
			$results->error = $this->wf->Msg('db-read-only-mode');
			$results->success = false;
		} else {
			$this->throwExceptionForAnons();

			$this->wg->User->setOption($this->getRTEMainPageNoticePropertyName(), true);
			$this->wg->User->saveSettings();
			$results->success = true;
		}
		return $results;
	}

	public function getUserPropertyValue($propertyName, $defaultOption = '') {
		$results = new stdClass();
		$results->success = false;
		$this->throwExceptionForAnons();

		if ($propertyName === false) {
			throw new Exception('Invalid property name', self::EXCEPTION_INVALID_PROPERTY_NAME);
		}

		$results->success = true;
		$results->value = $this->wg->User->getOption($propertyName, $defaultOption);
		return $results;
	}

	public function getRTEMainPageNoticePropertyName() {
		return self::MAIN_PAGE_NOTIFICATIONS_HIDDEN_PROP_NAME . '_' . $this->app->wg->CityId;
	}

}