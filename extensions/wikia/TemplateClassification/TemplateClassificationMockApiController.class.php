<?php

class TemplateClassificationMockApiController extends WikiaApiController {

	public function getTemplateType() {
		$randomRange = count( TemplateClassification::$templateTypes ) - 1;
		$this->setVal( 'type', TemplateClassification::$templateTypes[rand( 0, $randomRange )] );
	}
}
