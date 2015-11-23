<?php

class TemplateTypesParser {
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
	 * @param Title $title
	 * @param array $args
	 * @param PPFrame_DOM $frame
	 * @param string $outputText
	 * @return bool
	 */
	public static function onGetTemplateDom( $title, $args, $frame, &$outputText ) {
		global $wgEnableTemplateTypesParsing, $wgArticleAsJson;
		wfProfileIn( __METHOD__ );

		if ( $wgEnableTemplateTypesParsing && $wgArticleAsJson && self::isValidTitle( $title ) ) {
			$type = self::getTemplateType( $title );

			if ( $type === AutomaticTemplateTypes::TEMPLATE_SCROLBOX ) {
				$templateArgs = self::getTemplateArgs($args, $frame);

				$outputText = self::getTemplateArgsLongestVal($templateArgs);
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @desc change template wikitext according to template type
	 *
	 * @param string $templateTitle
	 * @param string $templateWikitext
	 * @return bool
	 */
	public static function onEndBraceSubstitution( $templateTitle, &$templateWikitext ) {
		wfProfileIn( __METHOD__ );

		if ( self::templateShouldBeProcessed( $templateWikitext ) ) {
				$title = Title::newFromText( $templateTitle, NS_TEMPLATE );
				if ( self::isValidTitle( $title ) ) {
					$type = self::getTemplateType( $title );
					if ( $type == AutomaticTemplateTypes::TEMPLATE_CONTEXT_LINK ) {
						$templateWikitext = self::handleContextLinksTemplate( $templateWikitext );
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
		if ( !self::containNestedTemplates( $wikitext ) ) {
			$wikitext = self::sanitizeContextLinkWikitext( $wikitext );
			$wikitext = self::wrapContextLink( $wikitext );
		}

		return $wikitext;
	}

	/**
	 * @desc If curly brackets found, means that template contain some not parsed
	 * wikitext (e.g. was wrongly classified) and should not be changed!
	 *
	 * @param $wikitext
	 * @return bool
	 */
	private static function containNestedTemplates( $wikitext ) {
		return preg_match('/{{.+}}/', $wikitext);
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
		return sprintf( '<div class="%s">%s</div>', AutomaticTemplateTypes::TEMPLATE_CONTEXT_LINK, $wikitext );
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
	 * @param array $args
	 * @param PPFrame_DOM $frame
	 * @return array
	 */
	private static function getTemplateArgs( $args, $frame ) {
		$templateArgs = [];

		for ( $i = 0; $i < count( $args ); $i++ ) {
			$bits = $args->item( $i )->splitArg();
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
	public static function getTemplateArgsLongestVal( $templateArgs ) {
		return array_reduce( $templateArgs, function ( $a, $b ) { return strlen( $a ) >= strlen( $b ) ? $a : $b; } );
	}
}
