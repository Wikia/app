<?php

/**
 * UserProperties Handler for WikiaBar
 */

class WikiaBarUserPropertiesHandler extends WikiaUserPropertiesHandlerBase {
	/**
	 * @desc User WikiaBarDisplayState property shown value
	 */
	const WIKIA_BAR_SHOWN_STATE_VALUE = 'shown';

	/**
	 * @desc User WikiaBarDisplayState property hidden value
	 */
	const WIKIA_BAR_HIDDEN_STATE_VALUE = 'hidden';
	/**
	 * @desc User property name of field which has data about display state of WikiaBar
	 */
	const WIKIA_BAR_STATE_OPTION_NAME = 'WikiaBarDisplayState';

	/**
	 * @desc Handles AJAX request and changes wikia bar display state
	 */
	public function changeWikiaBarState($params) {
		$changeTo = (!empty($params['changeTo']) ? $params['changeTo'] : false);

		$results = new stdClass();

		if (!$changeTo || !in_array($changeTo, array(self::WIKIA_BAR_SHOWN_STATE_VALUE, self::WIKIA_BAR_HIDDEN_STATE_VALUE))) {
			$results->error = wfMsg('wikiabar-change-state-error');
			$results->success = false;
		} else {
			$this->savePropertyValue(self::WIKIA_BAR_STATE_OPTION_NAME, $changeTo);
			$results->wikiaBarState = $changeTo;
			$results->success = true;
		}

		return $results;
	}

	/**
	 * @desc Gets Wikia Bar display state from user_properties table. If it's not set will return default value WIKIA_BAR_SHOWN_STATE_VALUE
	 */
	public function getWikiaBarState($params) {
		$results = $this->getPropertyObject(
			array(
				'propertyName' => self::WIKIA_BAR_STATE_OPTION_NAME,
				'defaultOption' => self::WIKIA_BAR_SHOWN_STATE_VALUE
			)
		);

		return $results;
	}

}