<?php
class WikiaUserPropertiesController extends WikiaController {
	const ERROR_USER_NOT_LOGGED_IN_CODE = 'User is logged-out';
	const ERROR_INVALID_PROPERTY_NAME = 'Invalid property name';
	const MAIN_PAGE_NOTIFICATIONS_HIDDEN_PROP_NAME = 'RteMainPageNotificationHidden';

	public function getUserPropertyValue() {
		$propertyName = $this->request->getVal('propertyName', false);
		$defaultOption = $this->request->getVal('defaultOption');

		$this->results = new stdClass();
		$this->results->success = false;

		if( !$this->wg->User->isLoggedIn() ) {
			$this->results->error = self::ERROR_USER_NOT_LOGGED_IN_CODE;
			return;
		}

		if( $propertyName === false ) {
			$this->results->error = self::ERROR_INVALID_PROPERTY_NAME;
			return;
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
			$this->wg->User->setOption($this->getRTEMainPageNoticePropertyName(), true);
			$this->wg->User->saveSettings();
			$this->results->success = true;
		}
	}

	public function getRTEMainPageNoticePropertyName() {
		return self::MAIN_PAGE_NOTIFICATIONS_HIDDEN_PROP_NAME . '_' . $this->app->wg->CityId;
	}

	public function saveWikiaBarState($state) {
		$this->wg->User->setOption(WikiaBarController::WIKIA_BAR_STATE_OPTION_NAME, $state);
		$this->wg->User->saveSettings();
	}
}
