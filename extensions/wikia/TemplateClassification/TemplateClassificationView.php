<?php

namespace Wikia\TemplateClassification;

use Swagger\Client\ApiException;

class View {

	const COMMAND_KEY = '⌘';
	const CONTROL_KEY = 'Ctrl';
	const HAS_SEEN_HINT = 'SeenHintTemplateClassificationModalEntryPoint';

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
		global $wgEnableTemplateDraftExt;

		if ( !$user->isLoggedIn() ) {
			return $fallbackMsg;
		}

		$templateType = '';

		// Fallback to infobox on template draft for not existent classification
		if ( !empty( $wgEnableTemplateDraftExt )
			&& \TemplateDraftHelper::isInfoboxDraftConversion( $title )
		) {
			$templateType = \TemplateClassificationService::TEMPLATE_INFOBOX;
		}

		if ( $templateType === '' ) {
			try {
				$templateType = ( new \UserTemplateClassificationService() )->getType( $wikiId, $title->getArticleID() );
			} catch ( ApiException $e ) {
				( new Logger() )->exception( $e );
				return $fallbackMsg;
			}
		}

		// Fallback to unknown for not existent classification
		if ( $templateType === '' ) {
			$templateType = \TemplateClassificationService::TEMPLATE_UNKNOWN;
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

		$editButton = false;
		if ( ( new Permissions() )->userCanChangeType( $user, $title ) ) {
			$editButton = true;
		}

		$hint = $this->prepareHint( $user, $title->getArticleID() );

		return \MustacheService::getInstance()->render(
			__DIR__ . '/templates/TemplateClassificationViewPageEntryPoint.mustache',
			[
				'templateTypeLabel' => $templateTypeLabel,
				'templateType' => $templateType,
				'templateTypeName' => $templateTypeMessage,
				'editButton' => $editButton,
				'hint' => $hint,
			]
		);
	}

	private function prepareHint( \User $user, $pageId ) {
		global $wgCityId;

		$hasSeen = $user->getGlobalPreference( self::HAS_SEEN_HINT, 0 );
		if ( !$hasSeen ) {

			$type = ( new \UserTemplateClassificationService() )
				->getType( $wgCityId, $pageId );

			if ( \RecognizedTemplatesProvider::isUnrecognized( $type ) ) {
				return [
					'mode' => 'welcome',
					'msg' => '', // Message generated in frontend as it contains html
					'trigger' => 'click',
					'hasSeen' => $hasSeen
				];

			}
		}
		$key = self::CONTROL_KEY;
		if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Mac' ) !== false ) {
			$key = self::COMMAND_KEY;
		}
		return [
			'mode' => 'key',
			'msg' => wfMessage( 'template-classification-open-modal-key-tip', $key )->plain(),
			'trigger' => 'hover',
			'hasSeen' => $hasSeen
		];
	}
}
