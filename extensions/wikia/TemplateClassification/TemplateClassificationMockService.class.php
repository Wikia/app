<?php
/**
 * Mock service class for TemplateClassification
 */

class TemplateClassificationMockService extends WikiaService {

	/**
	 * @return string
	 */
	public function getTemplateType() {
		$types = TemplateClassification::$templateTypes;
		return $types[array_rand( $types )];
	}
}
