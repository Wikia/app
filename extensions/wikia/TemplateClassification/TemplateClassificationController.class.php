<?php
/**
 * A controller that supports functioning of front-end elements related to Template Classification.
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

class TemplateClassificationController extends WikiaController {

	/**
	 * Renders a set of radio inputs used to classify a template.
	 */
	public function getTemplateClassificationEditForm() {
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->overrideTemplate( 'editForm' );

		foreach ( TemplateClassification::$templateTypes as $type ) {
			$templateTypes[] = [
				'type' => $type,
				/**
				 * template-classification-type-infobox
				 * template-classification-type-navbox
				 * template-classification-type-quote
				 * template-classification-type-unclassified
				 */
				'name' => wfMessage( "template-classification-type-{$type}" )->escaped(),
				'description' => wfMessage( "template-classification-description-{$type}" )->escaped(),
			];
		}

		$this->setVal( 'templateTypes', $templateTypes );
	}
}
