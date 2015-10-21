<?php
/**
 * TemplateClassificationMockApiController is just for mocking data from the real service.
 *
 * Will be removed once the service is deployed.
 */

class TemplateClassificationMockApiController extends WikiaApiController {

	public function getTemplateType() {
		$articleId = $this->request->getInt( 'articleId' );
		$this->setVal( 'type', ( new TemplateClassificationMockService() )->getTemplateType( $articleId ) );
	}

	public function setTemplateType() {
		$articleId = $this->request->getInt( 'articleId' );
		$templateType = $this->request->getVal( 'templateType' );
	}
}
