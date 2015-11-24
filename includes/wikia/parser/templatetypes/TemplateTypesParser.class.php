<?php

class TemplateTypesParser {
	/**
<<<<<<< HEAD
	 * @desc alters template raw text parser output based on template type
=======
	 * @desc removes navbox template text from parser output
>>>>>>> dev
	 *
	 * @param string $text - template content
	 * @param Title $finalTitle - template title object
	 *
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
				case TemplateClassificationService::TEMPLATE_FLAG:
					$text = self::handleNoticeTemplate();
					break;
				case AutomaticTemplateTypes::TEMPLATE_REFERENCES:
				case TemplateClassificationService::TEMPLATE_REFERENCES:
					$text = self::handleReferencesTemplate();
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
			$templateArgs = TemplateArgsHelper::getTemplateArgs( $args, $frame );

			switch ( $type ) {
				case AutomaticTemplateTypes::TEMPLATE_SCROLBOX:
					$outputText = self::getTemplateArgsLongestVal( $templateArgs );
					break;
				case AutomaticTemplateTypes::TEMPLATE_QUOTE:
				case TemplateClassificationService::TEMPLATE_QUOTE:
					$outputText = QuoteTemplate::execute( TemplateArgsHelper::getTemplateArgs( $args, $frame ) );
					break;
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * @desc change template wikitext according to template type
	 *
	 * @param Title $templateTitle
	 * @param string $templateWikitext
	 *
	 * @return bool
	 */
	public static function onEndBraceSubstitution( $templateTitle, &$templateWikitext ) {
		wfProfileIn( __METHOD__ );

		$title = Title::newFromText( $templateTitle, NS_TEMPLATE );

		if ( self::templateShouldBeProcessed( $templateWikitext ) && self::isValidTitle( $title ) ) {
			$type = self::getTemplateType( $title );
			if ( $type == AutomaticTemplateTypes::TEMPLATE_CONTEXT_LINK ) {
				$templateWikitext = self::handleContextLinksTemplate( $templateWikitext );
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
	 * @desc check if template should be processed
	 *
	 * @param $templateWikitext
	 *
	 * @return bool
	 */
	private static function templateShouldBeProcessed( $templateWikitext ) {
		global $wgEnableTemplateTypesParsing, $wgArticleAsJson;

		return $wgEnableTemplateTypesParsing
			   && $wgArticleAsJson
			   && !empty( $templateWikitext );
	}

	/**
	 * @desc sanitize context-link template content
	 *
	 * @param $wikitext
	 *
	 * @return string
	 */
	private static function handleContextLinksTemplate( $wikitext ) {
		$wikitext = self::sanitizeContextLinkWikitext( $wikitext );
		$wikitext = self::wrapContextLink( $wikitext );

		return $wikitext;
	}

	/**
	 * @desc remove all non-link and non-text elements of context-link wikitext
	 *
	 * @param string $wikitext context-link template wikitext
	 *
	 * @return string
	 */
	public static function sanitizeContextLinkWikitext( $wikitext ) {
		//remove any custom HTML tags
		$wikitext = strip_tags( $wikitext );
		//remove list and indent elements from the beginning of line
		$wikitext = preg_replace( '/^[:#* \n]+/', '', $wikitext );
		//remove all bold and italics from all of template content
		$wikitext = preg_replace( '/\'{2,}/', '', $wikitext );
		//remove all headings from all of template content
		$wikitext = self::removeHeadings( $wikitext );
		//remove all newlines from the middle of the template text.
		$wikitext = preg_replace( '/\n/', ' ', $wikitext );

		return $wikitext;
	}

	private static function removeHeadings( $wikitext ) {
		for ( $i = 6; $i >= 1; --$i ) {
			$h = str_repeat( '=', $i );
			$wikitext = preg_replace( "/$h(.+)$h/m", '\\1', $wikitext );
		}

		return $wikitext;
	}

	/**
	 * @desc wrap text of context-link in div with CLASS_CONTEXT_LINK class
	 *
	 * @param string $wikitext context-link template wikitext
	 *
	 * @return string
	 */
	private static function wrapContextLink( $wikitext ) {
		return sprintf( '<div class="%s">%s</div>', AutomaticTemplateTypes::TEMPLATE_CONTEXT_LINK, $wikitext );
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

	/** @desc return skip rendering navbox template
	 *
	 * @return string
	 */
	private static function handleNavboxTemplate() {
		return '';
	}

	/**
	 * @desc return skip rendering notice template
	 *
	 * @return string
	 */
	private static function handleNoticeTemplate() {
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

	/**
	 * @desc gets the longest value from template arguments
	 *
	 * @param array $templateArgs
	 *
	 * @return string
	 */
	public static function getTemplateArgsLongestVal( $templateArgs ) {
		return array_reduce( $templateArgs, function ( $a, $b ) {
			return strlen( $a ) >= strlen( $b ) ? $a : $b;
		} );
	}
}
