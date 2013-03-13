<?php

abstract class MarketingToolboxModuleNonEditableService extends MarketingToolboxModuleService
{
	abstract public function getStructuredData($data);

	public function __construct($langCode, $sectionId, $verticalId) {
		parent::__construct( $langCode, $sectionId, $verticalId );
	}
}
