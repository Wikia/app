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

		if ( $wgEnableTemplateTypesParsing && $wgArticleAsJson ) {
			$type = self::getTemplateType( $finalTitle );

			switch ( $type ) {
				case AutomaticTemplateTypes::TEMPLATE_NAVBOX:
				case TemplateClassificationService::TEMPLATE_NAVBOX:
					$text = NavboxTemplate::handle();
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
		global $wgEnableTemplateTypesParsing, $wgArticleAsJson;
		wfProfileIn( __METHOD__ );

		if ( $wgEnableTemplateTypesParsing && $wgArticleAsJson && self::isValidTitle( $title ) ) {
			$type = self::getTemplateType( $title );

			if ( $type === AutomaticTemplateTypes::TEMPLATE_SCROLBOX ) {
				$outputText = ScrollboxTemplate::getTemplateArgsLongestVal(
					TemplateArgsHelper::getTemplateArgs( $args, $frame )
				);
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
<<<<<<< HEAD
	 * @desc change template wikitext according to template type
	 *
	 * @param string $templateTitle
	 * @param string $templateWikitext
	 *
	 * @return bool
	 */
	public static function onEndBraceSubstitution( $templateTitle, &$templateWikitext ) {
		wfProfileIn( __METHOD__ );

		if ( ContextLinkTemplate::templateShouldBeProcessed( $templateWikitext ) ) {
			$title = Title::newFromText( $templateTitle, NS_TEMPLATE );

			if ( self::isValidTitle( $title ) ) {
				$type = self::getTemplateType( $title );
				if ( $type == AutomaticTemplateTypes::TEMPLATE_CONTEXT_LINK ) {
					$templateWikitext = ContextLinkTemplate::handle( $templateWikitext );
				}
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
	 * @desc check if template title got from Parser is valid
	 *
	 * @param Title $title
	 *
	 * @return bool
	 */
	private static function isValidTitle( $title ) {
		return $title && $title->exists();
	}
}
