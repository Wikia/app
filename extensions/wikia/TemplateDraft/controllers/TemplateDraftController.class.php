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

	public function markTemplateAsNotInfobox() {
		/**
		 * First, validate a request
		 */
		if ( !$this->wg->Title->userCan( 'templatedraft', $this->wg->User )
			|| !$this->isValidPostRequest()
		) {
			$this->response->setVal( 'status', false );
			return false;
		}

		/**
		 * Then check the pageId param
		 */
		$pageId = $this->getRequest()->getInt( 'pageId' );
		if ( $pageId === 0 ) {
			$this->response->setVal( 'status', false );
			return false;
		}

		/**
		 * Wikia::setProps unfortunately fails silently so if we get to this point
		 * we can set the response's status to true anyway...
		 */
		$this->response->setVal( 'status', true );

		Wikia::setProps( $pageId, [
			self::TEMPLATE_INFOBOX_PROP => 0,
		] );

		return true;
	}

	private function isValidPostRequest() {
		$editToken = $this->getRequest()->getParams()['editToken'];
		return $this->getRequest()->wasPosted()
			&& $this->wg->User->matchEditToken( $editToken );
	}
}
