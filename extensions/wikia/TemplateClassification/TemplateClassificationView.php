<?php

namespace Wikia\TemplateClassification;

class View {

	/**
	 * Returns HTML with Template type.
	 * If a user is logged in it returns also an entry point for edition.
	 * @param int $wikiId
	 * @param \Title $title
	 * @param \User $user
	 * @param string $fallbackMsg
	 * @return string
	 */
	public function renderTemplateType( $wikiId, \Title $title, $user, $fallbackMsg = '', $templateTypeLabel = null ) {
		if ( !$user->isLoggedIn() && !$this->isTemplateClassified( $title ) ) {
			return $fallbackMsg;
		}

		$templateType = ( new \TemplateClassificationService() )->getType( $wikiId, $title->getArticleID() );
		// Fallback to unknown for not existent classification
		if ( $templateType === '' ) {
			$templateType = \TemplateClassification::TEMPLATE_UNKNOWN;
		}

		if ( $templateTypeLabel === null ) {
			$templateTypeLabel = wfMessage( 'template-classification-indicator' )->plain();
		}
		/**
		 * template-classification-type-infobox
		 * template-classification-type-navbox
		 * template-classification-type-quote
		 * template-classification-type-media
		 * template-classification-type-reference
		 * template-classification-type-navigation
		 * template-classification-type-nonarticle
		 * template-classification-type-design
		 * template-classification-type-unknown
		 * template-classification-type-data
		 */
		$templateTypeMessage = wfMessage( "template-classification-type-{$templateType}" )->plain();

		$editButton = flase;
		if ( ( new Permissions() )->userCanChangeType( $user, $title ) ) {
			$editButton = true;
		}

		return \MustacheService::getInstance()->render(
			__DIR__ . '/templates/TemplateClassificationViewPageEntryPoint.mustache',
			[
				'templateTypeLabel' => $templateTypeLabel,
				'templateType' => $templateTypeMessage,
				'editButton' => $editButton,
			]
		);
	}

	/**
	 * Renders an entry point on a template's edit page.
	 * @param \Title $title
	 * @param \User $user
	 * @return string
	 */
	public function renderEditPageEntryPoint( $wikiId, \Title $title, \User $user ) {
		$templateType = $this->renderTemplateType( $wikiId, $title, $user, '', '' );
		return \MustacheService::getInstance()->render(
			__DIR__ . '/templates/TemplateClassificationEditPageEntryPoint.mustache',
			[
				'header' => wfMessage( 'template-classification-type-header' ),
				'templateType' => $templateType,
			]
		);
	}

	private function isTemplateClassified( $title ) {
		global $wgCityId;
		$templateType = ( new \TemplateClassificationService() )->getType( $wgCityId, $title->getArticleID() );
		return $templateType !== \TemplateClassification::TEMPLATE_UNKNOWN && $templateType !== '';
	}

}
