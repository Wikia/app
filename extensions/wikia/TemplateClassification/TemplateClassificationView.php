<?php

namespace Wikia\TemplateClassification;

class View {

	/**
	 * Returns HTML with Template type and entry point for edit
	 * @param String $fallbackMsg
	 * @return String
	 */
	public function renderEditableType( $fallbackMsg ) {
		$user = $this->getContext()->getUser();
		$templateType = $this->getTemplateType();
		if ( $user->isLoggedIn() ) {
			$templateType .= $this->renderEditButton();
			return $templateType;
		} else {
			if ( $templateType !== 'Unclassified' ) {
				return $templateType;
			}
			return $fallbackMsg;
		}

	}

	private function getTemplateType() {
		// Mock for frontend work
		return wfMessage( 'oasis-page-header-subtitle-template-unclassified' )->escaped();
	}

	private function renderEditButton() {
		return Html::element( 'a', [ 'class' => 'template-classification-edit sprite-small edit', ], ' ' );
	}
}
