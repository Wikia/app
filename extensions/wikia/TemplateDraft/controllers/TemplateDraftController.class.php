<?php

class TemplateDraftController extends WikiaController {

	/**
	 * Converts the content of the template according to the given flags.
	 *
	 * @param $content
	 * @param $flags Array
	 * @return string
	 */
	public function createDraftContent( Title $title, $content, Array $flags ) {
		$flagsSum = array_sum( $flags );

		if ( TemplateClassificationController::TEMPLATE_INFOBOX & $flagsSum ) {
			// while we're at it we can mark the base template as an infobox
			$tc = new TemplateClassificationController();
			$tc->classifyTemplate( $title->getBaseText(), 'infobox', true );

			$templateConverter = new TemplateConverter( $title );
			$newContent = $templateConverter->convertAsInfobox( $content );
			$newContent .= $templateConverter->generatePreviewSection( $content );
		}

		return $newContent;
	}

}
