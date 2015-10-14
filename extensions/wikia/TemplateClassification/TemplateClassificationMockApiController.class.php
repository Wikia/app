<?php
/**
 * TemplateClassificationMockApiController is just for mocking data from the real service.
 *
 * Will be removed once the service is deployed.
 */

class TemplateClassificationMockApiController extends WikiaApiController {

	public function getTemplateType() {
		$randomRange = count( TemplateClassification::$templateTypes ) - 1;
		$this->setVal( 'type', TemplateClassification::$templateTypes[rand( 0, $randomRange )] );
	}
}
