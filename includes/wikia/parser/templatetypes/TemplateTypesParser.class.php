<?php

class TemplateTypesParser {
	const CLASS_CONTEXT_LINK = 'context-link';
	/**
	 * @desc change parser output according to template type
	 *
	 * @param string $text - template content
	 * @param Title $finalTitle - template title object
	 * @return bool
	 */
	public static function onFetchTemplateAndTitle( &$text, &$finalTitle ) {
		global $wgEnableTemplateTypesParsing, $wgArticleAsJson;

		wfProfileIn( __METHOD__ );

		if ( $wgEnableTemplateTypesParsing && $wgArticleAsJson ) {
			$text = self::handleTemplateType( $finalTitle );
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * @desc change template wikitext according to template type
	 *
	 * @param $templateTitle
	 * @param $templateWikitext
	 * @return bool
	 */
	public static function onBraceSubstitution( $templateTitle, &$templateWikitext ) {
		wfProfileIn( __METHOD__ );
		$title = Title::newFromText( $templateTitle, NS_TEMPLATE );

		if ( self::templateReadyToProcess( $templateWikitext ) && self::isValidTitle( $title ) ) {
			$templateWikitext = self::handleTemplateType( $title, $templateWikitext );
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * @desc fir given template title process it's content accordingly
	 *
	 * @param $title
	 * @param string $text
	 * @return string
	 */
	private static function handleTemplateType( $title, $text = '' ) {
		$type = self::getTemplateType( $title );

		switch ( $type ) {
			case AutomaticTemplateTypes::TEMPLATE_NAVBOX:
			case TemplateClassificationService::TEMPLATE_NAVBOX:
				$text = self::handleNavboxTemplate();
				break;
			case AutomaticTemplateTypes::TEMPLATE_REFERENCES:
			case TemplateClassificationService::TEMPLATE_REF:
				$text = self::handleReferencesTemplate();
				break;
			case AutomaticTemplateTypes::TEMPLATE_CONTEXT_LINK:
				$text = self::handleContextLinksTemplate( $text );
				break;
		}

		return $text;
	}

	/**
	 * @desc return template type for a given template title object
	 *
	 * @param $title
	 * @return string
	 */
	private static function getTemplateType( $title ) {
		global $wgCityId;
		$type = ( new ExternalTemplateTypesProvider( new \TemplateClassificationService ) )
			->getTemplateTypeFromTitle( $wgCityId, $title );

		return $type;
	}

	private static function templateReadyToProcess( $templateWikitext ) {
		global $wgEnableTemplateTypesParsing, $wgArticleAsJson;

		return $wgEnableTemplateTypesParsing
			&& $wgArticleAsJson
			&& !empty( $templateWikitext );
	}

	/**
	 * @desc sanitize context-link template content
	 *
	 * @param $wikitext
	 * @return string
	 */
	public static function handleContextLinksTemplate( $wikitext ) {
		$wikitext = self::sanitizeContextLinkWikitext( $wikitext );
		$wikitext = self::wrapContextLink( $wikitext );

		return $wikitext;
	}

	/**
	 * @desc remove all non-link and non-text elements of context-link wikitext
	 *
	 * @param $wikitext string context-link template wikitext
	 * @return string
	 */
	public static function sanitizeContextLinkWikitext( $wikitext ) {
		//remove any custom HTML tags
		$wikitext = strip_tags( $wikitext );
		//remove list and indent elements from the beginning of line
		$wikitext = preg_replace( '/^[:#* \n]+/', '', $wikitext );
		//remove all bold and italics from all of template content
		$wikitext = preg_replace( '/\'{2,}/', '', $wikitext );
		//remove all newlines from the middle of the template text.
		$wikitext = preg_replace( '/\n/', ' ', $wikitext );

		return $wikitext;
	}

	/**
	 * @desc wrap text of context-link in div with CLASS_CONTEXT_LINK class
	 * @param $wikitext string context-link template wikitext
	 * @return string
	 */
	private static function wrapContextLink( $wikitext ) {
		return sprintf('<div class="%s">%s</div>', self::CLASS_CONTEXT_LINK, $wikitext);
	}

	/**
	 * @desc check if template title got from Parser is valid
	 *
	 * @param $title Title
	 * @return bool
	 */
	private static function isValidTitle( $title ) {
		return $title && $title->exists();
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
