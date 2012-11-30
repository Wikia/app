<?php
class WikiaUserPropertiesController extends WikiaController {
	const EXCEPTION_USER_NOT_LOGGED_IN_CODE = 1;
	const EXCEPTION_INVALID_PROPERTY_NAME = 2;
	const MAIN_PAGE_NOTIFICATIONS_HIDDEN_PROP_NAME = 'RteMainPageNotificationHidden';

	public function getUserPropertyValue() {
		$propertyName = $this->request->getVal('propertyName', false);
		$defaultOption = $this->request->getVal('defaultOption', '');

		$this->results = new stdClass();
		$this->results->success = false;
		$this->throwExceptionForAnons();

		if( $propertyName === false ) {
			throw new Exception('Invalid property name', self::EXCEPTION_INVALID_PROPERTY_NAME);
		}

		$this->results->success = true;
		$this->results->value = $this->wg->User->getOption($propertyName, $defaultOption);
	}

	public function dismissRTEMainPageNotice() {
		$this->results = new stdClass();
		$this->results->success = false;

		if( $this->wg->ReadOnly ) {
			$this->results->error = $this->wf->Msg('db-read-only-mode');
		} else {
			$this->throwExceptionForAnons();

			$this->wg->User->setOption($this->getRTEMainPageNoticePropertyName(), true);
			$this->wg->User->saveSettings();
			$this->results->success = true;
		}
	}

	public function getRTEMainPageNoticePropertyName() {
		return self::MAIN_PAGE_NOTIFICATIONS_HIDDEN_PROP_NAME . '_' . $this->app->wg->CityId;
	}

	public function saveWikiaBarState($state) {
		$this->throwExceptionForAnons();

		$this->wg->User->setOption(WikiaBarController::WIKIA_BAR_STATE_OPTION_NAME, $state);
		$this->wg->User->saveSettings();
	}

	protected function throwExceptionForAnons() {
		if( !$this->wg->User->isLoggedIn() ) {
			throw new Exception('User not logged-in', self::EXCEPTION_USER_NOT_LOGGED_IN_CODE);
		}
	}
}
