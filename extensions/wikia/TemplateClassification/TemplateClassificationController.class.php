<?php

class TemplateClassificationController extends WikiaController {

	public function getTemplateClassificationEditForm() {
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->overrideTemplate( 'editForm' );

		$templateTypes = [
			[
				'type' => 'unclassified',
				'name' => wfMessage( 'template-classification-type-unclassified' )->escaped(),
			],
		];
		foreach ( TemplateClassification::$templateTypes as $type ) {
			$templateTypes[] = [
				'type' => $type,
				/**
				 * template-classification-type-infobox
				 * template-classification-type-navbox
				 * template-classification-type-quote
				 */
				'name' => wfMessage( "template-classification-type-{$type}" )->escaped(),
			];
		}

		$this->setVal( 'templateTypes', $templateTypes );
	}
}
