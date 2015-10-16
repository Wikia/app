<?php

namespace Wikia\TemplateClassification;

class View {

	/**
	 * Returns HTML with Template type.
	 * If a user is logged in it returns also an entry point for edition.
	 * @param \User $user
	 * @param string $fallbackMsg
	 * @return string
	 */
	public function renderEditableType( $articleId, $user, $fallbackMsg ) {
		$templateType = ( new \TemplateClassificationMockService() )->getTemplateType( $articleId );
		/**
		 * template-classification-type-unclassified
		 * template-classification-type-infobox
		 * template-classification-type-navbox
		 * template-classification-type-quote
		 */
		$templateName = wfMessage( "template-classification-type-{$templateType}" )->escaped();
		if ( $user->isLoggedIn() ) {
			$templateName .= $this->renderEditButton();
			return $templateName;
		} else {
			if ( $this->isTemplateClassified() ) {
				return $templateName;
			}
			return $fallbackMsg;
		}
	}

	/**
	 * Renders an entry point on a template's edit page.
	 *
	 * @param \User $user
	 * @return string
	 */
	public function renderEditPageEntryPoint( \User $user ) {
		$templateType = $this->renderTemplateType( $user );
		return \MustacheService::getInstance()->render(
			__DIR__ . '/templates/TemplateClassificationEditPageEntryPoint.mustache',
			[
				'header' => wfMessage( 'template-classification-type-header' ),
				'templateType' => $templateType,
			]
		);
	}

	/**
	 * Mock for frontend work
	 */
	private function isTemplateClassified() {
		return false;
	}

	private function renderEditButton() {
		return \Html::element( 'a', [ 'class' => 'template-classification-edit sprite-small edit', ], ' ' );
	}
}
