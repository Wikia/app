<?php

namespace Wikia\TemplateClassification;

class View {

	/**
	 * Returns HTML with Template type.
	 * If a user is logged in it returns also an entry point for edition.
	 * @param int $articleId
	 * @param \User $user
	 * @param string $fallbackMsg
	 * @return string
	 */
	public function renderTemplateType( $articleId, $user, $fallbackMsg = '' ) {
		$templateType = lcfirst( ( new \TemplateClassificationMockService() )->getTemplateType( $articleId ) );
		/**
		 * template-classification-type-unclassified
		 * template-classification-type-infobox
		 * template-classification-type-navbox
		 * template-classification-type-quote
		 */
		$templateName = wfMessage(
			'template-classification-indicator',
			wfMessage( "template-classification-type-{$templateType}" )
		)->escaped();
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
	 * @param int $articleId
	 * @param \User $user
	 * @return string
	 */
	public function renderEditPageEntryPoint( $articleId, \User $user ) {
		$templateType = $this->renderTemplateType( $articleId, $user );
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
