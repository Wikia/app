<?php

class TemplateDraftController extends WikiaController {

	/**
	 * Converts the content of the template according to the given type.
	 * @param Title $title
	 * @param sting $content
	 * @param string $type One of types specified in the TemplateClassificationController
	 * @return string
	 * @throws MWException
	 */
	public function createDraftContent( Title $title, $content, $type ) {
		$newContent = '';

		if ( $type === TemplateClassificationController::TEMPLATE_INFOBOX ) {
			/**
			 * While we're at it we can mark the base template as an infobox
			 */
			$parentTitle = Title::newFromText( $title->getBaseText(), $title->getNamespace() );

			$tc = new TemplateClassificationController( $parentTitle );
			$tc->classifyTemplate( TemplateClassificationController::TEMPLATE_INFOBOX, true );

			$templateConverter = new TemplateConverter( $title );
			$newContent = $templateConverter->convertAsInfobox( $content );
			$newContent .= $templateConverter->generatePreviewSection( $content );
		}

		return $newContent;
	}

	/**
	 * Makes a negative recognition marking the template as a not-infobox one.
	 * @return bool
	 */
	public function markTemplateAsNotInfobox() {
		/**
		 * First, validate the request.
		 */
		$pageId = $this->getRequest()->getInt( 'pageId' );
		if ( !$this->isValidPostRequest() || $pageId === 0 ) {
			$this->response->setVal( 'status', false );
			return false;
		}

		/**
		 * Then classify the template as not-infobox
		 * (primary: unclassified, secondary: with logged data)
		 */
		$tc = new TemplateClassificationController( Title::newFromID( $pageId ) );
		$this->response->setVal(
			'status',
			$tc->classifyTemplate( TemplateClassificationController::TEMPLATE_INFOBOX, false )
		);
	}

	private function isValidPostRequest() {
		$editToken = $this->getRequest()->getParams()[ 'editToken' ];
		return $this->getRequest()->wasPosted()
			&& $this->wg->User->matchEditToken( $editToken );
	}
}
