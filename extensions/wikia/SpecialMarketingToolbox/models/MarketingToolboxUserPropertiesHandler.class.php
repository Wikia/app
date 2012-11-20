<?php

/**
 * UserProperties Handler for Marketing Toolbox
 */

class MarketingToolboxUserPropertiesHandler extends WikiaUserPropertiesHandlerBase {
	const MARKETING_TOOLBOX_VERTICAL_PROPERTY_NAME = 'marketing-toolbox-vertical';
	const MARKETING_TOOLBOX_REGION_PROPERTY_NAME = 'marketing-toolbox-region';

	public function saveMarketingToolboxVertical($vertical) {
		return $this->savePropertyValue(self::MARKETING_TOOLBOX_VERTICAL_PROPERTY_NAME, $vertical);
	}

	public function saveMarketingToolboxRegion($region) {
		return $this->savePropertyValue(self::MARKETING_TOOLBOX_REGION_PROPERTY_NAME, $region);
	}

	public function getMarketingToolboxVertical() {
		return $this->getPropertyValue(self::MARKETING_TOOLBOX_VERTICAL_PROPERTY_NAME);
	}

	public function getMarketingToolboxRegion() {
		return $this->getPropertyValue(self::MARKETING_TOOLBOX_REGION_PROPERTY_NAME);
	}

}