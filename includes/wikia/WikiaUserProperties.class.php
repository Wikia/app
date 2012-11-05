<?php
class WikiaUserProperties extends WikiaController {
	const EXCEPTION_USER_NOT_LOGGED_IN_CODE = 1;
	const MAIN_PAGE_NOTIFICATIONS_HIDDEN_PROP_NAME = 'RteMainPageNotificationHidden';

	public function getUserPropertyValue($propertyName, $defaultOption) {
		$results = new stdClass();

		if( !$this->wg->User->isLoggedIn() ) {
			throw new Exception('User is logged-out', self::EXCEPTION_USER_NOT_LOGGED_IN_CODE);
		}

		$results->value = $this->wg->User->getOption($propertyName, $defaultOption);
		$results->success = true;

		return $results;
	}

	public function dismissRTEMainPageNotice() {
		$this->wg->User->setOption($this->getRTEMainPageNoticePropertyName(), true);
		$this->wg->User->saveSettings();
	}

	protected function getRTEMainPageNoticePropertyName() {
		return self::MAIN_PAGE_NOTIFICATIONS_HIDDEN_PROP_NAME . '_' . $this->app->wg->CityId;
	}

	public function saveWikiaBarState($state) {
		$this->wg->User->setOption(WikiaBarController::WIKIA_BAR_STATE_OPTION_NAME, $state);
		$this->wg->User->saveSettings();
	}
}
