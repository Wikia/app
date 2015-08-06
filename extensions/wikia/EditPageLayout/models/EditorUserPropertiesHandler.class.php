<?php

/**
 * UserProperties Handler for Editor
 */

class EditorUserPropertiesHandler extends WikiaUserPropertiesHandlerBase {

	const MAIN_PAGE_NOTIFICATIONS_HIDDEN_PROP_NAME = 'EditorMainPageNotificationHidden';

	public function dismissEditorMainPageNotice($params = null) {
		$results = new stdClass();

		if ($this->wg->ReadOnly) {
			$results->error = wfMsg('db-read-only-mode');
			$results->success = false;
		} else {
			$this->throwExceptionForAnons();

			$this->wg->User->setLocalPreference(MAIN_PAGE_NOTIFICATIONS_HIDDEN_PROP_NAME, true, $this->app->wg->CityId);
			$this->wg->User->saveSettings();
			$results->success = true;
		}
		return $results;
	}
    
	public function getEditorMainPageNoticePropertyForCurrentUser() {
		return $this->wg->User->getLocalPreference(MAIN_PAGE_NOTIFICATIONS_HIDDEN_PROP_NAME, $this->app->wg->CityId);
	}

}