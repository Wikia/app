<?php
/**
 * TemplateClassificationMockApiController is just for mocking data from the real service.
 *
 * Will be removed once the service is deployed.
 */

class TemplateClassificationMockApiController extends WikiaApiController {

	public function getTemplateType() {
		$this->setVal( 'type', ( new TemplateClassificationMockService() )->getTemplateType() );
	}
}
