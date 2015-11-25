<?php

class TemplateTypesParser {
	/**
	 * @desc alters template raw text parser output based on template type
	 *
	 * @param string $text - template content
	 * @param Title $finalTitle - template title object
	 *
	 * @return bool
	 */
	public static function onFetchTemplateAndTitle( &$text, &$finalTitle ) {
		global $wgEnableTemplateTypesParsing, $wgArticleAsJson;

		wfProfileIn( __METHOD__ );

		if ( self::shouldTemplateBeParsed() ) {
			$type = self::getTemplateType( $finalTitle );

			switch ( $type ) {
				case AutomaticTemplateTypes::TEMPLATE_NAVBOX:
				case TemplateClassificationService::TEMPLATE_NAVBOX:
					$text = NavboxTemplate::handle();
					break;
				case TemplateClassificationService::TEMPLATE_FLAG:
					$text = NoticeTemplate::handleNoticeTemplate();
					break;
				case AutomaticTemplateTypes::TEMPLATE_REFERENCES:
				case TemplateClassificationService::TEMPLATE_REFERENCES:
					$text = ReferencesTemplate::handle();
					break;
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * @desc alters template parser output based on its arguments and template type
	 *
	 * @param Title $title
	 * @param PPNode_DOM $args
	 * @param PPFrame_DOM $frame
	 * @param string $outputText
	 *
	 * @return bool
	 */
	public static function onGetTemplateDom( $title, $args, $frame, &$outputText ) {
		global $wgEnableScrollboxTemplateParsing;
		wfProfileIn( __METHOD__ );

		if ( self::shouldTemplateBeParsed() && !is_null( $args ) ) {
			$type = self::getTemplateType( $title );

			if ( $type === AutomaticTemplateTypes::TEMPLATE_SCROLLBOX && $wgEnableScrollboxTemplateParsing ) {
				$outputText = ScrollboxTemplate::getLongestElement(
					TemplateArgsHelper::getTemplateArgs( $args, $frame )
				);
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * @desc return template type for a given template title object
	 *
	 * @param Title $title
	 *
	 * @return string
	 */
	private static function getTemplateType( $title ) {
		global $wgCityId;

		$type = ExternalTemplateTypesProvider::getInstance()
			->setTCS( new \TemplateClassificationService )
			->getTemplateTypeFromTitle( $wgCityId, $title );

		return $type;
	}

	/**
	 * @desc checks if template can be parsed
	 *
	 * @return bool
	 */
	private static function shouldTemplateBeParsed() {
		global $wgEnableTemplateTypesParsing, $wgArticleAsJson;

		return $wgEnableTemplateTypesParsing && $wgArticleAsJson;
	}
}
