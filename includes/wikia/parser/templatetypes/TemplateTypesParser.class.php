<?php

class TemplateTypesParser {
	const CLASS_CONTEXT_LINK = 'portable-context-link';
	/**
	 * @desc change parser output according to template type
	 *
	 * @param string $text - template content
	 * @param Title $finalTitle - template title object
	 * @return bool
	 */
	public static function onFetchTemplateAndTitle( &$text, &$finalTitle ) {
		global $wgEnableTemplateTypesParsing, $wgArticleAsJson, $wgCityId;

		wfProfileIn( __METHOD__ );

		if ( $wgEnableTemplateTypesParsing && $wgArticleAsJson ) {
			$type = ( new ExternalTemplateTypesProvider( new \TemplateClassificationService ) )
					->getTemplateTypeFromTitle( $wgCityId, $finalTitle );

			switch ( $type ) {
				case AutomaticTemplateTypes::TEMPLATE_NAVBOX:
				case TemplateClassificationService::TEMPLATE_NAVBOX:
					$text = self::handleNavboxTemplate();
					break;
				case AutomaticTemplateTypes::TEMPLATE_REFERENCES:
				case TemplateClassificationService::TEMPLATE_REF:
					$text = self::handleReferencesTemplate();
					break;
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * @desc change template wikitext according to template type
	 *
	 * @param $title
	 * @param $templateWikitext
	 * @return bool
	 */
	public static function onBraceSubstitution( $title, &$templateWikitext ) {
		global $wgEnableTemplateTypesParsing, $wgArticleAsJson, $wgCityId;

		wfProfileIn( __METHOD__ );

		if ( $wgEnableTemplateTypesParsing && $wgArticleAsJson && !empty( $templateWikitext ) ) {
			$type = ( new ExternalTemplateTypesProvider( new \TemplateClassificationService ) )
				->getTemplateTypeFromTitle( $wgCityId, $title );

			if ( $type == AutomaticTemplateTypes::TEMPLATE_CONTEXT_LINK ) {
				$templateWikitext = self::handleContextLinksTemplate( $templateWikitext );
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * @desc sanitize context-link template content - remove all non-link and non-text
	 * elements from context-link template output and wrap it in div with special class
	 *
	 * @param $templateWikitext
	 * @return string
	 */
	private static function handleContextLinksTemplate( $templateWikitext ) {
		//remove any custom HTML tags
		$templateWikitext = strip_tags( $templateWikitext );
		//remove list and indent elements from the beginning of line
		$templateWikitext = preg_replace( '/^[:#* \n]+/', '', $templateWikitext );
		//remove all bold and italics from all of template content
		$templateWikitext = preg_replace( '/\'{2,}/', '', $templateWikitext );
		//remove all newlines from the middle of the template text.
		$templateWikitext = preg_replace( '/\n/', ' ', $templateWikitext );
		//wrap text of context-link in specified class
		$templateWikitext = '<div class="' . self::CLASS_CONTEXT_LINK . '">' . $templateWikitext . '</div>';

		return $templateWikitext;
	}

	/**
	 * @desc return skip rendering navbox template
	 *
	 * @return string
	 */
	private static function handleNavboxTemplate() {
		return '';
	}

	/**
	 * @desc return simple <references /> parser tag
	 *
	 * @return string
	 */
	private static function handleReferencesTemplate() {
		return '<references />';
	}
}
