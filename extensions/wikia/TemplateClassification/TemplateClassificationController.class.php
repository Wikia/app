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

		foreach ( TemplateClassificationService::$templateTypes as $type ) {
			$templateTypes[] = [
				'type' => $type,
				/**
				 * template-classification-type-infobox
				 * template-classification-type-navbox
				 * template-classification-type-quote
				 * template-classification-type-unclassified
				 * template-classification-type-media
				 * template-classification-type-reference
				 * template-classification-type-navigation
				 * template-classification-type-nonarticle
				 * template-classification-type-design
				 * template-classification-type-unknown
				 * template-classification-type-data
				 */
				'name' => wfMessage( "template-classification-type-{$type}" )->plain(),
				/**
				 * template-classification-description-infobox
				 * template-classification-description-navbox
				 * template-classification-description-quote
				 * template-classification-description-media
				 * template-classification-description-unclassified
				 * template-classification-description-reference
				 * template-classification-description-navigation
				 * template-classification-description-nonarticle
				 * template-classification-description-design
				 * template-classification-description-unknown
				 * template-classification-description-data
				 */
				'description' => wfMessage( "template-classification-description-{$type}" )->plain(),
			];
		}

		$this->setVal( 'templateTypes', $templateTypes );
	}
}
