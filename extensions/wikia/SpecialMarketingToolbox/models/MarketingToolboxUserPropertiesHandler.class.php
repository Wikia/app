<?php

/**
 * UserProperties Handler for Marketing Toolbox
 */

class MarketingToolboxUserPropertiesHandler extends WikiaUserPropertiesHandlerBase {
	const MARKETING_TOOLBOX_VERTICAL_PROPERTY_NAME = 'marketing-toolbox-vertical';
	const MARKETING_TOOLBOX_REGION_PROPERTY_NAME = 'marketing-toolbox-region';

	public function saveMarketingToolboxVertical($params) {
		$newVertical = (!empty($params[self::MARKETING_TOOLBOX_VERTICAL_PROPERTY_NAME]) ? $params[self::MARKETING_TOOLBOX_VERTICAL_PROPERTY_NAME] : false);
		$results = new stdClass();
		if (!$newVertical) {
			$results->success = false;
		} else {
			$this->savePropertyValue(self::MARKETING_TOOLBOX_VERTICAL_PROPERTY_NAME, $newVertical);
			$results->vertical = $newVertical;
			$results->success = true;
		}
		return $results;
	}

	public function saveMarketingToolboxRegion($params) {
		$newRegion = (!empty($params[self::MARKETING_TOOLBOX_REGION_PROPERTY_NAME]) ? $params[self::MARKETING_TOOLBOX_REGION_PROPERTY_NAME] : false);
		$results = new stdClass();
		if (!$newRegion) {
			$results->success = false;
		} else {
			$this->savePropertyValue(self::MARKETING_TOOLBOX_REGION_PROPERTY_NAME, $newRegion);
			$results->region = $newRegion;
			$results->success = true;
		}
		return $results;
	}

	public function getMarketingToolboxVertical() {
		return $this->getPropertyValue(self::MARKETING_TOOLBOX_VERTICAL_PROPERTY_NAME);
	}

	public function getMarketingToolboxRegion() {
		return $this->getPropertyValue(self::MARKETING_TOOLBOX_REGION_PROPERTY_NAME);
	}

}