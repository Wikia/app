<?php

class TemplateDraftController extends WikiaController {

	/**
	 * Converts the content of the template according to the given type.
	 * @param Title $title
	 * @param string $content
	 * @param string $type One of types specified in the TemplateClassificationController
	 * @return string
	 * @throws MWException
	 */
	public function createDraftContent( Title $title, $content, $type ) {
		global $wgCityId, $wgUser;

		$newContent = '';

		if ( $type === TemplateClassificationService::TEMPLATE_INFOBOX ) {
			/**
			 * While we're at it we can mark the base template as an infobox
			 */
			$parentTitle = Title::newFromText( $title->getBaseText(), $title->getNamespace() );

			$tc = new UserTemplateClassificationService();
			try {
				$tc->classifyTemplate(
					$wgCityId,
					$parentTitle->getArticleID(),
					TemplateClassificationService::TEMPLATE_INFOBOX,
					$wgUser->getId()
				);

			} catch ( Swagger\Client\ApiException $e ) {
				// Do not worry if you're not able to classify the template.
			}

			$templateConverter = new TemplateConverter( $title );
			$newContent = $templateConverter->convertAsInfobox( $content );
			$newContent .= $templateConverter->generatePreviewSection( $content );
		}

		return $newContent;
	}

	/**
	 * Get the converted infobox markup of a given template.
	 *
	 * @requestParam string template The name of the template to convert.
	 */
	public function getInfoboxMarkup() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$templateName = $this->request->getVal( 'template' );
		$title = Title::newFromText( $templateName, NS_TEMPLATE );
		if ( !$title instanceof Title
			|| !$title->exists()
			|| !$title->inNamespace( NS_TEMPLATE )
		) {
			$this->response->setVal( 'error', wfMessage( 'templatedraft-invalid-template' )->escaped() );
			return;
		}

		$templateConverter = new TemplateConverter( $title );
		$templateDataExtractor = new TemplateDataExtractor( $title );
		$revision = Revision::newFromTitle( $title );
		$content = $revision->getText();
		$infoboxVariables = $templateDataExtractor->getTemplateVariables( $content );
		$infoboxContent = $templateConverter->convertAsInfobox( $content );

		$this->response->setValues( [
			'variables' => $infoboxVariables,
			'content' => $infoboxContent,
		] );
	}
}
