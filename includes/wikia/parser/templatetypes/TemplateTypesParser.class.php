<?php

class TemplateTypesParser {
	const CLASS_CONTEXT_LINK = 'context-link';

	/**
	 * @desc alters template raw text parser output based on template type
	 *
	 * @param string $text - template content
	 * @param Title $finalTitle - template title object
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
					$text = self::handleNavboxTemplate();
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
	 * @param array $piece
	 * @param PPFrame_DOM $frame
	 * @param string $outputText
	 * @return bool
	 */
	public static function onStartBraceSubstitution( $piece, $frame, &$outputText ) {
		global $wgEnableTemplateTypesParsing, $wgArticleAsJson;
		wfProfileIn( __METHOD__ );

		$title = Title::newFromText( $frame->expand( $piece['title'] ), NS_TEMPLATE );

		if ( $wgEnableTemplateTypesParsing && $wgArticleAsJson && self::isValidTitle( $title ) ) {
			$type = self::getTemplateType( $title );

			if ( $type === AutomaticTemplateTypes::TEMPLATE_SCROLBOX ) {
				$outputText = trim( self::getTemplateArgsLongestVal( self::getTemplateArgs( $piece, $frame ) ) );
				return false;
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
	 * @return string
	 */
	private static function getTemplateType( $title ) {
		global $wgCityId;

		$type = ( new ExternalTemplateTypesProvider( new \TemplateClassificationService ) )
			->getTemplateTypeFromTitle( $wgCityId, $title );

		return $type;
	}

	/**
	 * @desc check if template should be processed
	 * @param $templateWikitext
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
		$wikitext = self::removeHeadings($wikitext);
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
	 * @param string $wikitext context-link template wikitext
	 * @return string
	 */
	private static function wrapContextLink( $wikitext ) {
		return sprintf( '<div class="%s">%s</div>', self::CLASS_CONTEXT_LINK, $wikitext );
	}

	/**
	 * @desc check if template title got from Parser is valid
	 *
	 * @param Title $title
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

	/**
	 * @desc gets array of template arguments values
	 *
	 * @param array $piece
	 * @param PPFrame_DOM $frame
	 * @return array
	 */
	private static function getTemplateArgs( $piece, $frame ) {
		$templateArgs = [];

		for ( $i = 0; $i < count( $piece['parts'] ); $i++ ) {
			$bits = $piece['parts']->item( $i )->splitArg();
			$templateArgs[] = $frame->expand( $bits['value'] );
		}

		return $templateArgs;
	}

	/**
	 * @desc gets the longest value from template arguments
	 *
	 * @param array $templateArgs
	 * @return string
	 */
	private static function getTemplateArgsLongestVal( $templateArgs ) {
		$lengths = array_map( 'strlen', $templateArgs );
		$maxLength = max( $lengths );
		$index = array_search( $maxLength, $lengths );

		return $templateArgs[$index];
	}
}
